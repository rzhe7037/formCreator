<?php
        function cleanValue($value){
            return isset($value)?htmlspecialchars(strip_tags($value)):null;
        }
         function translateStatus($code){
            switch ($code) {
                case 'PU':
                    return "The goods have been taken from the sender";
                case 'CL':
                    return "Site collection";
                case 'AO':
                    return "arrived oversea warehouse";
                case 'OC':
                    return "operation complete";
                case 'LO':
                    return "leave oversea warehouse";
                case 'FT':
                    return "departure";
                case 'FL':
                    return "arrived";
                case 'TRM':
                    return "Being sent to customs clearance port";
                case 'CCE':
                    return "clearance port complete";
                case 'OK':
                    return "Delivery Complete";
                case 'CP':
                    return "await";
                case 'CCMC':
                    return "product lost";
                case 'CCSD':
                    return "The goods have been destroyed";
                case 'HC':
                    return "Customs fastener";
                case 'IDCS':
                    return "ID card information collection";
                case 'IS':
                    return "Handed over domestic delivery service provider";
                case 'PL':
                    return "Internal operation of the operation center";
                case 'PO':
                    return "Overseas warehouse made orders";
                case 'RT':
                    return "The goods have been returned to the place of delivery";
                case 'SD':
                    return "Damaged goods";
                case 'SH':
                    return "Temporary deduction of goods";
                case 'PTW':
                    return "The parcel is taken from the airport and transferred to the customs supervision warehouse.";
                case 'WA':
                    return "Waiting to arrange a flight";
                case 'WT':
                    return "Waiting for a transfer";
                case "WD":
                    return "Waiting for customs clearance";
                default:
                    return "unkown status";
        }
      }
      /* Make http post request*/
       function MakeHttpPost($url, $requestBody){

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Content-Length: ' . strlen($requestBody)));

        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }

        curl_close($curl);
        $decoded_response = json_decode($curl_response);

        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        return $decoded_response;

      }


      /* Make http post request with bearer token*/
       function MakeHttpPostWithBearerToken($url, $data_arr,$Token){
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data_arr);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','Authorization: Bearer '.$Token ));
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

          $curl_response = curl_exec($curl);
          if ($curl_response === false) {
              $info = curl_getinfo($curl);
              die('error occured during curl exec. Additioanl info: ' . var_export($info));
          }

          curl_close($curl);
          $decoded_response = json_decode($curl_response);

          if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
              die('error occured: ' . $decoded->response->errormessage);
          }
          return $decoded_response;

      }

      function MakeHttpGetWithBearerToken($url,$orderId,$Token){
         $curl = curl_init($url.$orderId);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','Authorization: Bearer '.$Token ));
         $curl_response = curl_exec($curl);
         if ($curl_response === false) {
             $info = curl_getinfo($curl);
             die('error occured during curl exec. Additioanl info: ' . var_export($info));
         }

         curl_close($curl);
         $decoded_response = json_decode($curl_response);

         if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
             die('error occured: ' . $decoded->response->errormessage);
         }
         return $decoded_response;
     }
