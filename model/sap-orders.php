<?php

namespace Model;

class SapOrders {

    protected $db;
    protected $db_api;
    protected $queries;

    protected $site_name = [
        1 => 'Sap Israel',
        2 => 'Sap Miami',
        3 => 'Sap Holland',
        4 => 'Sap UK',
    ];

    function __construct($db, $queries, $db_api = null)
    {
        $this->db = $db;
        $this->queries = $queries;
        $this->db_api = $db_api;
    }

    public function getSapProducts($site_id)
    {
        $db = $this->db_api;
        $stmt = $db->prepare($this->queries['sapOrders']);
        $stmt->execute([$this->site_name[$site_id]]);

        $order_data = $stmt->fetchAll();

        if (!empty($order_data)) {

            return $order_data;

        } else {

            return false;
        }
    }
}
