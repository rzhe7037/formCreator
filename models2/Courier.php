<?php
abstract class Courier{
    //DB stuff
    protected $conn;
    protected $courier_table = 'couriers';
    protected $courier_code;
    protected $request_type;

    //Constructor with DB
    public function __construct($courier_name,$request_type,$db){
        $this->courier_code = $courier_name;
        $this->request_type = $request_type;
        $this->conn = $db;
    }
    abstract public function cleanDataRaw($data_raw);
    abstract public function makeCodeMsg($response);
    abstract public function CallCourierAPI($reqbody);

    public function getUrl(){
        //create query
        $query = 'SELECT * FROM api_urls WHERE courier_code = :courier_code && request_type = :request_type';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind Param
        $stmt->bindParam(':courier_code',$this->courier_code);
        $stmt->bindParam(':request_type',$this->request_type);

        //Execute query
        $stmt->execute();

        $api_url = $stmt->fetch(PDO::FETCH_ASSOC);

        return $api_url['request_url'];
    }



}
