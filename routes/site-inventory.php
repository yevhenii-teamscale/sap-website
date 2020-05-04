<?php
/*  Router for site-inventory API */
use Slim\Http\Request;
use Slim\Http\Response;


// Test Routes
/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Route:/" . $args['name']);

     // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
}); */

//default function
$app->get('/[{site_id}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    $site_id = $args['site_id'];

    //find db by site id
    $products = new Model\Site_inventory($this->db, null, $this->queries);
    $db_id = $products->getDBIDbysite($site_id);

    $db_container = "db_api_" . $db_id;

    $actual_products = new Model\Site_inventory($this->db, $this->$db_container, $this->queries);

    $result = $actual_products->getInventory($site_id);

    return $response->withJson($result);

    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
});


// site-inventory API routes

 $app->group('/site-inventory', function($app) {
//returns inventory information of the specific site by site ID
    $app->post('', function ($request, $response, $args) {

        //get request parameters
        $site_details = $request->getParsedBody();

        if(isset($site_details['site_id'])) {

            $site_id = filter_var($site_details['site_id'],FILTER_VALIDATE_INT);
            
            $products = new Model\Site_inventory($this->db, null, $this->queries);
            $db_id = $products->getDBIDbysite($site_id);

            $db_container = "db_api_" . $db_id;
        
            $actual_products = new Model\Site_inventory($this->db, $this->$db_container, $this->queries);
        
            $inventory = $actual_products->getInventory($site_id);
        
            return $response->withJson($inventory);
            //return $res->write($site_id);

        } else {

            return false;

        }

    }); //$app->post(''

    //checks if order`s products of specific country(company) are in stock, if even one of the is not return false
    $app->post('/check_inventory', function (Request $request, Response $response, array $args) {

        //get request parameters
        $product_details = $request->getParsedBody();

        if(isset($product_details['products']) && isset($product_details['CountrySAP'])){

            $order_products = $product_details['products']; //array of products

            $country_sap = filter_var($product_details['CountrySAP'],FILTER_SANITIZE_STRING); //Country

            $products = new Model\Site_inventory($this->db, null, $this->queries);

            $db_id = $products->getDBIDbyCountry($country_sap);

            //check if results received
            if(!empty($db_id)) {

                $db_container = "db_api_" . $db_id[0]['DatabaseID'];

                $actual_products = new Model\Site_inventory($this->db, $this->$db_container, $this->queries);

                $inventory_comparison = $actual_products->checkInventory($order_products);
        
                return  $response->withJSON($inventory_comparison);

            } else {

                return  $response->write("Country is undefined!"); 

            }
        

        } else {

            return false;

        }

    }); //$app->post('/check_inventory'

}); //$app->group('/site-inventory', function($app) {