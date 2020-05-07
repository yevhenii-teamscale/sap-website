<?php

namespace Model;

class WebsiteOrders {

    protected $db;
    protected $db_api;
    protected $queries;

    // list of websites
    public $websites = [
        [
            'name' => 'Tresor Rare',
            'url' => 'https://tresor-rare.com/index.php?route=papi/bi_api',
        ],
    ];


    /**
     * WebsiteOrders constructor.
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
     * make request to websites
     * return the array with data
     *
     * @param $url
     * @return mixed
     */
    public function getDataFromSap($url)
    {
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['site_id' => $site_id]));
//
//        // Receive server response ...
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $server_output = curl_exec($ch);
//
//        curl_close($ch);
//
//        return json_decode($server_output, true);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Server',
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($ch);

        curl_close($ch);

        return json_decode($resp, true);
    }

    /**
     * truncate the "website_orders" table
     */
    public function truncateTable()
    {
        $stmt = $this->db->prepare($this->queries['truncateWebsiteOrders']);
        $stmt->execute();
    }

    /**
     * insert data to 'website_orders' table
     *
     * @param $data
     */
    public function insertDataToWebsiteOrdersTable(array $data)
    {
        foreach ($data as $item) {
            $stmt = $this->db->prepare($this->queries['insertToWebsiteDB']);
            $stmt->bindParam(1, $item['order_id']);
            $stmt->bindParam(2, $item['customer']);
            $stmt->bindParam(3, $item['status']);
            $stmt->bindParam(4, $item['total']);
            $stmt->bindParam(5, $item['sap_status']);
            $stmt->bindParam(6, $item['date_added']);
            $stmt->bindParam(7, $item['website']);
            $stmt->bindParam(8, $item['country']);
            $stmt->bindParam(9, $item['address']);
            $stmt->bindParam(10, $item['payment_method']);
            $stmt->execute();
        }
    }

    /**
     * return all data from website_orders table
     *
     * @return mixed
     */
    public function getWebsiteOrders()
    {
        $stmt = $this->db->prepare($this->queries['selectWebsiteOrders']);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
