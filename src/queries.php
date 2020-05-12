<?php

return [
    "insertToSapDB" => "INSERT INTO sap_orders 
                (DocNum,NumatCard,CardCode,CardName,DocDate,DocTime,Aging,SlpName,WhsName,GroupName,Printed,Address,Comments,LastReportUpdate,SapSource,InvntSttus)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    "insertToWebsiteDB" => "INSERT INTO website_orders 
                (order_id,customer,status,total,sap_status,date_added,website,country,address,payment_method,last_updated)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)",
    "selectSapOrders" => "SELECT * FROM sap_orders",
    "selectWebsiteOrders" => "SELECT * FROM website_orders",
    "truncateSapOrders" => "TRUNCATE TABLE sap_orders",
    "truncateWebsiteOrders" => "TRUNCATE TABLE website_orders",
    "selectWebsites" => "SELECT name, url FROM websites",
    "selectWebsiteByName" => "SELECT name, url FROM websites WHERE name = ?",
];
