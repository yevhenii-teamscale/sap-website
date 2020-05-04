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

}
