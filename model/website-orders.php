<?php

namespace Model;

use GuzzleHttp\Client;

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
    public function getDataFromWebsite($url)
    {
        $client = new Client();
        $response = $client->get($url);

        return json_decode($response->getBody(), true);
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
        $date = date('Y-m-d H:i:s');
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
            $stmt->bindParam(11, $date);
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
