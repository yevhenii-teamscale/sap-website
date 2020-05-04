<?php

namespace Model;

class SapOrders {

    protected $db;
    protected $db_api;
    protected $queries;


    public function __construct($db, $queries, $db_api = null)
    {
        $this->db = $db;
        $this->queries = $queries;
        $this->db_api = $db_api;
    }

    public function getDataFromSap($site_id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://10.0.0.5/site-api/sap-orders");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['site_id' => $site_id]));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        return json_decode($server_output, true);
    }

    public function insertDataToSap($data)
    {
        $stmt = $this->db->prepare($this->queries['truncateSapOrders']);
        $stmt->execute();

        foreach ($data as $item) {
            $stmt = $this->db->prepare($this->queries['insertToSaPDB']);
            $stmt->bindParam(1, $item['SAP Doc Num']);
            $stmt->bindParam(2, $item['Web Order Num']);
            $stmt->bindParam(3, $item['Customer Code']);
            $stmt->bindParam(4, $item['Customer Name']);
            $stmt->bindParam(5, $item['DocDate']);
            $stmt->bindParam(6, $item['Doc Time']);
            $stmt->bindParam(7, $item['Aging']);
            $stmt->bindParam(8, $item['SlpName']);
            $stmt->bindParam(9, $item['WhsName']);
            $stmt->bindParam(10, $item['GroupName']);
            $stmt->bindParam(11, $item['Printed']);
            $stmt->bindParam(12, $item['Shipping Address']);
            $stmt->bindParam(13, $item['Comments']);
            $stmt->bindParam(14, $item['LastReportUpdate']);
            $stmt->bindParam(15, $item['SAP source']);
            $stmt->execute();
        }
    }

    public function getSapOrders()
    {
        $stmt = $this->db->prepare($this->queries['selectSapOrders']);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}
