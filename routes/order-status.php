<?php
/*  
router for sending order details
*/

use Slim\Http\Request;
use Slim\Http\Response;


$app->post('/order-status', function ($request, $response, $args) {

    //get request parameters - site ID and Order ref
    $site_details = $request->getParsedBody();

    if(isset($site_details['site_id'])) {

        $site_id = filter_var($site_details['site_id'],FILTER_VALIDATE_INT);
        $order_reference = filter_var($site_details['order_reference'],FILTER_SANITIZE_STRING);
        
        //get site DB (USA)
        $db_info = new Model\Site_inventory($this->db, null, $this->queries);
        $db_id = $db_info->getDBIDbysite($site_id);
        //DB container
        $db_container = "db_api_" . $db_id;
        
        //get order data
        $order = new Model\Order_status($this->$db_container, $this->queries);
        
        $order_status = $order->getOrderStatus($order_reference);

        //Not working on server because the permission problems (The stream or file &quot;C:\inetpub\wwwroot\site-api\src/../logs/app_05_2019.log&quot; could not be opened: failed to open stream: Permission denied)
        //$this->logger->info("Route:/order-status; request: " . json_encode($site_details) . "; response: " . json_encode($order_status));
    
        return $response->withJson($order_status);
        //return $res->write($site_id);

    } else {

        return false;

    }

}); //$app->post(''

