<?php
/*
router for get sap orders details
*/

use Slim\Http\Request;
use Slim\Http\Response;


$app->post('/sap-orders', function (Request $request,Response $response, $args) {

    $site_details = $request->getParsedBody();

    if (isset($site_details['site_id'])) {
        $site_id = filter_var($site_details['site_id'], FILTER_VALIDATE_INT);

        $site = new Model\Site_inventory($this->db, null, $this->queries);
        $db_id = $site->getDBIDbysite($site_id);

        $db_container = "db_api_" . $db_id;

        $db_info = new Model\SapOrders($this->db, $this->queries, $this->$db_container);

        $data = $db_info->getSapProducts($site_id);

        return $response->withJson($data);

    } else {

        return false;

    }

});

