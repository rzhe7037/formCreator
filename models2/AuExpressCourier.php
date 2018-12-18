<?php
include_once 'Courier.php';
include_once 'Helper.php';

class AuExpressCourier extends Courier{
  public $getTokenUrl = "http://auth.auexpress.com/api/token";
  private $Token = "";
  private $memberId = 2742;
  private $password = "A09062742";

    //Constructor with DB
    public function __construct($courier_name,$request_type,$db){
        $this->courier_code = $courier_name;
        $this->request_type = $request_type;
        $this->conn = $db;
    }

    public function fetchToken(){
      $requestBody = [
        "MemberId" => $this->memberId,
        "Password" => $this->password
      ];
      $requestBody = json_encode($requestBody);
      $response = MakeHttpPost($this->getTokenUrl,$requestBody);
      $this->Token = $response->Token;
      return;
    }

    public function cleanDataRaw($data_raw){
      $clean_data_raw = [];
      switch ($this->request_type) {
        // Create Order api
        case 1:
          $items = isset($data_raw->items)?$data_raw->items:null;
          $clean_data_raw = array(array(
            "OrderId" => isset($data_raw->strOrderNo)?cleanValue($data_raw->strOrderNo):null,
            "MemberId" => $this->memberId,
            "BrandID" => 1,
            "SenderName" => isset($data_raw->strSenderName)?cleanValue($data_raw->strSenderName):null,
            "SenderPhone" => isset($data_raw->strSenderMobile)?cleanValue($data_raw->strSenderMobile):null,
            "ReceiverName" => isset($data_raw->strReceiverName )?cleanValue($data_raw->strReceiverName ):null,
            "ReceiverPhone" => isset($data_raw->strReceiverMobile)?cleanValue($data_raw->strReceiverMobile):null,
            "ReceiverProvince" => isset($data_raw->strReceiverProvince)?cleanValue($data_raw->strReceiverProvince):null,
            "ReceiverCity" => isset($data_raw->strReceiverCity)?cleanValue($data_raw->strReceiverCity):null,
            "ReceiverAddr1" => isset($data_raw->strReceiverDoorNo)?cleanValue($data_raw->strReceiverDoorNo):null,
            "ShipmentContent" => $this->translateItemList($items)
          ));
          break;
        // Trace api  
        case 2:
            $clean_data_raw = [
            "branchId" => isset($data_raw->branchId)?cleanValue($data_raw->branchId):null,
            "branchKey" => isset($data_raw->branchKey)?cleanValue($data_raw->branchKey):null,
            "ShipperOrderNo"=>isset($data_raw->strOrderNo)?cleanValue($data_raw->strOrderNo):null
            ];
          break;
        default:
          break;
      }

      return $clean_data_raw;
    }

    private function translateItemList($data_items){
      $items_description = "";
      foreach ($data_items as $item) {
        $items_description = $items_description.$item->strItemBrand.'-'.$item->strItemName.$item->strItemSpecifications.'*'.$item->numItemQuantity.";";
      }
      return $items_description;
    }

    public function CallCourierAPI($data_arr){
      switch ($this->request_type) {
        // Create Order api
        case 1:
          $this->fetchToken();
          $url = $this->getUrl();
          $data_arr = json_encode($data_arr);
          $token = $this->Token;
          $response = MakeHttpPostWithBearerToken($url,$data_arr,$token);
          return $response;
        // Trace api
        case 2:
          $this->fetchToken();
          $url = $this->getUrl();
          $orderId = $data_arr["ShipperOrderNo"];
          $token = $this->Token;
          $response = MakeHttpGetWithBearerToken($url,$orderId,$token);
          return $response;
      }
    }

    public function makeCodeMsg($code){
        //create query
        $query = 'SELECT * FROM error_messages WHERE courier_code = :courier_code && request_type = :request_type && code = :code';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':courier_code',$this->courier_code);
        $stmt->bindParam(':request_type',$this->request_type);
        $stmt->bindParam(':code',$code);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //create returning oject
            $res_arr = array(
                'text'=>$row['res_msg'],
                'code'=>$row['res_code']
            );
        }
        else
        {
            //create returning oject
            $res_arr = array(
                'text'=>'error! contact XXXX-XXX-XXX',
                'code'=>'ERR99999'
            );
        }
       return $res_arr;
    }

    public function makeResponseMsg($response){
      $code = $response->Code;
      $err_arr = $this->makeCodeMsg($code);
      $response_arr = [];
      switch ($this->request_type) {
        // Create Order api
        case 1:
          $response_arr = array(
              "orderNumber"=> isset($data_raw->strOrderNo)?$data_raw->strOrderNo:null,
              "resMsg"=>$err_arr['text'],
              "resCode"=>$err_arr['code'],
              "TaxAmount"=>isset($response->TaxAmount)?$response->UnionOrderNumber:null,
              "TaxCurrencyCode"=>isset($response->CurrencyCodeTax)?$response->CurrencyCodeTax:null
          );
          break;
        // Trace api
        case 2:
        $response_arr = array(
            "orderNumber"=> isset($response->OrderId)?$response->OrderId:null,
            "resMsg"=>$err_arr['text'],
            "resCode"=>$err_arr['code'],
            "TrackingList" => isset($response->TrackList)?$this->getTrackingListHelper($response->TrackList):null,
        );
          break;
        default:
          break;
      }
      return $response_arr;
    }

    private function getTrackingListHelper($trackingList){
       $formated_list = array();
       foreach ($trackingList as $list_item) {
           $new_node=array();
           $new_node['location'] = isset($list_item->Location)?cleanValue($list_item->Location):null;
           $new_node['time'] = isset($list_item->StatusTime)?cleanValue($list_item->StatusTime):null;
           $new_node['status'] = isset($list_item->StatusDetail)?cleanValue($list_item->StatusDetail):null;
           array_push($formated_list,$new_node);
       }
       return $formated_list;
   }
}
