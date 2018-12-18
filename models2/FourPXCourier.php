<?php
include_once 'Courier.php';
include_once 'Helper.php';

class FourPXCourier extends Courier{
      private $API_KEY = "TESTC78C-7923-404C-82CF-CD881539123c";

      //Constructor with DB
      public function __construct($courier_name,$request_type,$db){
          $this->courier_code = $courier_name;
          $this->request_type = $request_type;
          $this->conn = $db;

      }

      public function getApiKey(){
          //create query
          $query = 'SELECT * FROM couriers WHERE code = :courier_code';
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':courier_code',$this->courier_code);
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          return $row['api_key'];
      }


        public function cleanDataRaw($data_raw){
           $clean_data_raw = "";
           switch ($this->request_type) {

             // Create Order api
             case 1:
               $clean_data_raw = [
               "branchId" => isset($data_raw->branchId)?cleanValue($data_raw->branchId):null,
               "branchKey" => isset($data_raw->branchKey)?cleanValue($data_raw->branchKey):null,
               "ShipperOrderNo"=> isset($data_raw->strOrderNo)?cleanValue($data_raw->strOrderNo):null,
               "ServiceTypeCode"=>isset($data_raw->strServiceTypeCode)?cleanValue($data_raw->strServiceTypeCode):null,
               "TerminalCode"=> isset($data_raw->strShopCode)?cleanValue($data_raw->strShopCode):null,
               "ConsignerName"=> isset($data_raw->strSenderName)?cleanValue($data_raw->strSenderName):null,
               "ConsignerMobile"=> isset($data_raw->strSenderMobile)?cleanValue($data_raw->strSenderMobile):null,
               "ConsignerProvinceName"=>isset($data_raw->strSenderProvinceName)?cleanValue($data_raw->strSenderProvinceName):null,
               "ConsignerCityName"=>isset($data_raw->strSenderCityName)?cleanValue($data_raw->strSenderCityName):null,
               "ConsignerAddress"=>isset($data_raw->strSenderAddress)?cleanValue($data_raw->strSenderAddress):null,
               "ConsignerPostCode"=> isset($data_raw->strSenderPostCode)?cleanValue($data_raw->strSenderPostCode):null,
               "ItemDeclareCurrency"=> isset($data_raw->strItemCurrency)?cleanValue($data_raw->strItemCurrency):null,
               "ConsigneeName"=> isset($data_raw->strReceiverName)?cleanValue($data_raw->strReceiverName):null,
               "CountryISO2"=>isset($data_raw->strCountryISO2)?cleanValue($data_raw->strCountryISO2):null,
               "Province"=> isset($data_raw->strReceiverProvince)?cleanValue($data_raw->strReceiverProvince):null,
               "City"=> isset($data_raw->strReceiverCity)?cleanValue($data_raw->strReceiverCity):null,
               "District"=> isset($data_raw->strReceiverDistrict)?cleanValue($data_raw->strReceiverDistrict):null,
               "ConsigneeStreetDoorNo"=> isset($data_raw->strReceiverDoorNo)?cleanValue($data_raw->strReceiverDoorNo):null,
               "ConsigneeMobile"=> isset($data_raw->strReceiverMobile)?cleanValue($data_raw->strReceiverMobile):null,
               "ConsigneeIDNumber"=>isset($data_raw->strReceiverIDNumber)?cleanValue($data_raw->strReceiverIDNumber):null,
               "ConsigneeIDFrontCopy"=>isset($data_raw->strReceiverIDFrontCopy)?cleanValue($data_raw->strReceiverIDFrontCopy):null,
               "ConsigneeIDBackCopy"=>isset($data_raw->strReceiverIDBackCopy)?cleanValue($data_raw->strReceiverIDBackCopy):null,
               "OrderWeight"=> isset($data_raw->strOrderWeight)?cleanValue($data_raw->strOrderWeight):null,
               "WeightUnit"=> isset($data_raw->strWeightUnit)?cleanValue($data_raw->strWeightUnit):null,
               "EndDeliveryType"=> isset($data_raw->strEndDelivertyType)?cleanValue($data_raw->strEndDelivertyType):null,
               "InsuranceTypeCode"=> isset($data_raw->strInsuranceTypeCode)?cleanValue($data_raw->strInsuranceTypeCode):null,
               "InsuranceExpense"=>isset($data_raw->numInsuranceExpense)?cleanValue($data_raw->numInsuranceExpense):null,
               "TraceSourceNumber"=> isset($data_raw->strTraceNumber)?cleanValue($data_raw->strTraceNumber):null,
               "Remarks"=>isset($data_raw->strRemarks)?cleanValue($data_raw->strRemarks):null,
               "ITEMS"=> $this->getItemsHelper($data_raw->items)
               ];
            break;

            // Trace Api
            case 2:
              $clean_data_raw = [
              "branchId" => isset($data_raw->branchId)?cleanValue($data_raw->branchId):null,
              "branchKey" => isset($data_raw->branchKey)?cleanValue($data_raw->branchKey):null,
              "ShipperOrderNo"=>isset($data_raw->strOrderNo)?cleanValue($data_raw->strOrderNo):null
              ];
              break;
            
            // Delete
            case 3:
              $clean_data_raw = [
                "ReferenceNumber"=>isset($data_raw->strOrderNo)?cleanValue($data_raw->strOrderNo):null
              ];
              break;   
            default:
              break;
           }
           return $clean_data_raw;
         }

         public function CallCourierAPI($data_arr){
           $data_arr = array(
             "Token"=> $this->getApiKey(),
             "Data"=> $data_arr
           );
           $data_string = json_encode($data_arr);
           $decoded_response = MakeHttpPost($this->getUrl(),$data_string);
           return $decoded_response;
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

         public function getTrackingListHelper($trackingList){
            $formated_list = array();
            foreach ($trackingList as $list_item) {
                $new_node=array();
                $new_node['location'] = isset($list_item->TrackLocation)?cleanValue($list_item->TrackLocation):null;
                $new_node['time'] = isset($list_item->TrackTime)?cleanValue($list_item->TrackTime):null;
                $new_node['status'] = translateStatus($list_item->TrackStatusCode);
                array_push($formated_list,$new_node);
            }
            return $formated_list;
        }

        public function makeResponseMsg($response){
          $code = $response->ResponseCode;
          $err_arr = $this->makeCodeMsg($code);
          $response_arr = [];
          switch ($this->request_type) {

            // Create Order Api
            case 1:
              $response_arr = array(
                  "orderNumber"=> isset($data_raw->strOrderNo)?$data_raw->strOrderNo:null,
                  "resMsg"=>$err_arr['text'],
                  "resCode"=>$err_arr['code'],
                  "TaxAmount"=>isset($response->TaxAmount)?$response->UnionOrderNumber:null,
                  "TaxCurrencyCode"=>isset($response->CurrencyCodeTax)?$response->CurrencyCodeTax:null
              );
              break;

            // Trace Api
            case 2:
              $response_arr = array(
                  "orderNumber"=> isset($response->Data->ShipperOrderNo)?$response->Data->ShipperOrderNo:null,
                  "resMsg"=>$err_arr['text'],
                  "resCode"=>$err_arr['code'],
                  "TrackingList"=>isset($response->Data->TrackingList)?$this->getTrackingListHelper($response->Data->TrackingList):null
              );
              break;

            case 3:
              $response_arr = array(
                  "orderNumber"=> isset($response->Data->ShipperOrderNo)?$response->Data->ShipperOrderNo:null,
                  "resMsg"=>$err_arr['text'],
                  "resCode"=>$err_arr['code']
              );
              break;      
            default:
              break;
          }
          return $response_arr;

        }

        private function getItemsHelper($arr_item){

           $list_items = array();
           foreach ($arr_item as $item) {
               $list_item = array(
                   "ItemSKU"=> isset($item->strItemSKU)?cleanValue($item->strItemSKU):null,
                   "ItemDeclareType"=> isset($item->strItemDeclareType)?cleanValue($item->strItemDeclareType):null,
                   "ItemName"=> isset($item->strItemName)?cleanValue($item->strItemName):null,
                   "Specifications"=> isset($item->strItemSpecifications)?cleanValue($item->strItemSpecifications):null,
                   "ItemQuantity"=> isset($item->numItemQuantity)?cleanValue($item->numItemQuantity):null,
                   "ItemBrand"=> isset($item->strItemBrand)?cleanValue($item->strItemBrand):null,
                   "ItemUnitPrice"=>isset($item->numItemUnitPrice)?cleanValue($item->numItemUnitPrice):null,
                   "PreferentialSign"=> isset($item->strIsDiscounted)?cleanValue($item->strIsDiscounted):null
               );

               array_push($list_items,$list_item);
           }
           return $list_items;
       }


}
