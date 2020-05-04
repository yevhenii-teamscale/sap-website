<?php
/* 
model for Order status, query in settings file 
*/
namespace Model;

class Order_status
{
    protected $db;
    protected $queries;

    public function __construct($db, $queries)
    {
        $this->db = $db;
        $this->queries = $queries;
    }

    //return order information by order ref
    public function getOrderStatus($order_ref){

        $db = $this->db;
        $stmt = $db->prepare($this->queries['getOrderStatus']);
        $stmt->execute([$order_ref]);

        //array of the products with on-hand quantity from DB
        $order_data = $stmt->fetchAll();
        $db = null;

        if(!empty($order_data)){

            return  $order_data;

        } else {

            return false;
        }

    } //public function getShippingData($order_number){
}