<?php

namespace Model;

class SapOrders {

    protected $db;
    protected $db_api;
    protected $queries;

    // all saps
    public $saps = [
        [
            'sap_name' => 'Sap Israel',
            'site_id' => 1,
            'sap_url' => 'http://10.0.0.5/site-api/sap-orders'
        ],
        [
            'sap_name' => 'Sap USA',
            'site_id' => 1,
            'sap_url' => 'http://67.23.63.117/site-api/sap-orders'
        ],
        [
            'sap_name' => 'Sap USA',
            'site_id' => 2,
            'sap_url' => 'http://67.23.63.117/site-api/sap-orders'
        ],
        [
            'sap_name' => 'Sap USA',
            'site_id' => 3,
            'sap_url' => 'http://67.23.63.117/site-api/sap-orders'
        ],
    ];


    /**
     * SapOrders constructor.
     *
     * @param      $db
     * @param      $queries
     * @param null $db_api
     */
    public function __construct($db, $queries, $db_api = null)
    {
        $this->db = $db;
        $this->queries = $queries;
        $this->db_api = $db_api;
    }


    /**
     * make request to SAP
     * return the array with data
     * @param $url
     * @param $site_id
     * @return mixed
     */
    public function getDataFromSap($url, $site_id)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url . '?site_id=' . $site_id,
            CURLOPT_USERAGENT => 'Server',
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($ch);

        curl_close($ch);

        return json_decode($resp, true);
    }

    /**
     * truncate the "sap_orders" table
     */
    public function truncateTable()
    {
        $stmt = $this->db->prepare($this->queries['truncateSapOrders']);
        $stmt->execute();
    }

    /**
     * insert data to SAP Orders table
     * @param $data
     */
    public function insertDataToSapOrdersTable($data)
    {
        foreach ($data as $item) {
            $stmt = $this->db->prepare($this->queries['insertToSapDB']);
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
            $stmt->bindParam(16, $item['InvntSttus']);
            $stmt->execute();
        }
    }

    /**
     * return all data from sap_orders table
     * @return mixed
     */
    public function getSapOrders()
    {
        $stmt = $this->db->prepare($this->queries['selectSapOrders']);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
