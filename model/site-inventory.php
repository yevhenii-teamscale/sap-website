<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/13/2018
 * Time: 12:00 PM
 */

namespace Model;

//products inventory class
class Site_inventory {

    protected $db;
    protected $db_api;
    protected $queries;

    function __construct($db, $db_api = null, $queries){
        $this->db = $db;
        $this->db_api = $db_api;
        $this->queries = $queries;
    }

     /**
     * Returns all products of the site
     *
     * @param [type] $site_id
     * @return void - array of products or false
     */
    public function getInventory($site_id) {

        //get groups by site_id
        $groups = $this->getGroupIDsBySite($site_id);

        $products = [];
        //$i = 0;

        $getProductsOfGroupQuery = "SELECT T0.ItemCode, T1.OnHand as InStock
        FROM OITM T0
        INNER JOIN OITW T1 ON T0.ItemCode = T1.ItemCode
        WHERE T1.WhsCode = '01'";
        // AND T0.ItmsGrpCod = ?

        if($site_id != 3) { //Not EU sites

            $getProductsOfGroupQuery .= " AND (";

            for ($i=1; $i <= count($groups); $i++) {

                if ($i == 1) {

                    $getProductsOfGroupQuery .= " T0.ItmsGrpCod = ?";

                } elseif ($i > 1 && $i <= count($groups)) {

                    $getProductsOfGroupQuery .= " OR T0.ItmsGrpCod = ?";

                } //if ($i == 1) {

            } //for ($i=1; $i <= count($groups); $i++) {

            $getProductsOfGroupQuery .= ")";
        } //if($site_id != 3) { 

        /* foreach($this->getProductsOfGroup($group) as $product) {
            $products[$i] = $product;
            $i++;
        } */

       try {

            $db = $this->db_api;
            $stmt = $db->prepare($getProductsOfGroupQuery);

            if($site_id == 3) { 
                $stmt->execute();
            } else {
                $stmt->execute($groups);
            }

            $products  = $stmt->fetchAll();
            
        } catch (PDOException $e) {

           return $e->getMessage();
            
        }

        $db = null;
        
        if(!empty($products)) {

            //add addition product
            /* $addition_product = [];
            $addition_product['ItemCode'] = "Sm16";
            $addition_product['InStock'] = 999;
            $products[] = $addition_product; */

         //ADD products ONLY for USA sites
         if ($site_id == 1 && $_SERVER['SERVER_NAME'] == "67.23.63.117") {

                $i = 0;

                $addition_product = [];

                //additional products array for usa sites
                $itemCodes = ["Sm16","R5","R21","R2","R3","R6","R11","R9","R12","R8","R7","R10","R13"];

                foreach ($itemCodes as $itemCode) {
                    $addition_product[$i]['ItemCode'] = $itemCode;
                    $addition_product[$i]['InStock'] = 999;
                    $i++;
                }
                
                $new_products = array_merge($products, $addition_product);

                return $new_products;

            } else {

                return $products;

            }

        }

        return false; 

    } //getInventory

    /**
     * Compares product quantities form request and from DB, if quantity of one of the products in DB is less then in request -> return false
     *
     * @param [type] $products - array of products for request, include itemCode and quantity
     * @return void - true - if all the products in Stock or false if not
     */
    public function checkInventory($products){

        //amount of different products
        $products_count = count($products);

        $products_codes = [];

        // array of a product itemCodes
        foreach ($products as $product) {

            $products_codes[] = filter_var($product['ItemCode'] ,FILTER_SANITIZE_STRING);
        }
        //creating the query with where option for all products
        //$query = "SELECT T0.ItemCode, T0.OnHand FROM OITM AS T0 WHERE T0.ItemCode = ?";
        $query = $this->queries['checkInventory'];

        if($products_count > 1){
             
            for ($i=1; $i < $products_count; $i++) {
                $query .= " OR T0.ItemCode = ?";
            }

        }

        $db = $this->db_api;
        $stmt = $db->prepare($query);
        $stmt->execute($products_codes);

        //array of the products with on-hand quantity from DB 
        $inventory_results = $stmt->fetchAll();
        $db = null;

        //compare product quantities form request and from DB, if one of them is less then on request -> return false
        $result = true;
        $products_quantity_comparison = 0;

        for ($i=0; $i < $products_count; $i++) {

            if(isset($inventory_results[$i]['OnHand'])){

                if(($inventory_results[$i]['OnHand'] >= $products[$i]['Qty'])){

                    $products_quantity_comparison++;
    
                } 

            } else{

                $products_quantity_comparison = 0;
                break;
            }
        
        }

        if($products_quantity_comparison < $products_count){
            $result = false;
        }

        //return $products_quantity_comparison;
        //return $products_count;
        return $result;

    } //public function checkInventory

    /** Returns JSON products model (ItemCode) and inventory of specific group
     * @param $group_id
     * @return mixed
     */
   /*  private function getProductsOfGroup($group_id) {

        try {

            $db = $this->db_api;
            $stmt = $db->prepare($this->queries['getProductsOfGroup']);
            $stmt->execute([$group_id]);

            $results = $stmt->fetchAll();
            //$db = null;

            if($results){

                return $results;

            }

        } catch (PDOException $e) {

            return $e->getMessage();
            
        }

        return false;

    } //getProductsOfGroup */

    /**
     * returns groups of specific site
     *
     * @param [type] $site_id
     * @return void - array of the groups or false 
     */
    private function getGroupIDsBySite($site_id) {

         try{

            $db = $this->db;
            $stmt = $db->prepare($this->queries['getGroupIDsBySite']);
            $stmt->execute([$site_id]);

            $results = $stmt->fetchAll();

            $db = null;

            $groups = [];

            if($results){
                foreach($results as $result){
                    $groups[] = $result['GroupID'];
                }

                return $groups;
            }

        } catch (PDOException $e) {

            return $e->getMessage();
            
        } //try{

        return false;

    }//getGroupIDsBySite


    /**
     * Returns DB by Site ID
     *
     * @param [type] $site_id
     * @return void - false or DB ID
     */
    public function getDBIDbysite($site_id) {

        try { 

            $db = $this->db;

            $stmt = $db->prepare($this->queries['getDBIDbysite']);
            $stmt->execute([$site_id]);

            $results = $stmt->fetchAll();
            $database_id = $results[0]['DatabaseID'];

            return $database_id;

        } catch (PDOException $e) {

            return $e->getMessage();
            
        } //try{

        return false;

    } //public function getDBIDbysite($site_id)

    /**
     * Returns DB by Site ID
     *
     * @param [type] $site_id
     * @return void - false or DB ID
     */
    public function getDBIDbyCountry($country_sap) {

        try { 

            $db = $this->db;

            $stmt = $db->prepare($this->queries['getDBIDbyCountry']);
            $stmt->execute([$country_sap]);

            $results = $stmt->fetchAll();
            $database_id = $results;

            return $database_id;

        } catch (PDOException $e) {

            return $e->getMessage();
            
        } //try{

            return false;

    } //public function getDBIDbyCountry($country_sap){

}