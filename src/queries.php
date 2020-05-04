<?php

return [
    "insertToSaPDB" => "INSERT INTO sap_orders 
                (DocNum,NumatCard,CardCode,CardName,DocDate,DocTime,Aging,SlpName,WhsName,GroupName,Printed,Address,Comments,LastReportUpdate,SapSource)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    "selectSapOrders" => "SELECT * FROM sap_orders",
    "truncateSapOrders" => "TRUNCATE TABLE sap_orders",
];
