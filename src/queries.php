<?php

return [
    //queries of /site-inventory
    "getDBIDbysite" => "SELECT DatabaseID FROM siteidtodb WHERE SiteID = ?",
    "getGroupIDsBySite" => "SELECT GroupID FROM SiteIDtoGroupID WHERE SiteID = ?",
    "getProductsOfGroup" => "SELECT T0.ItemCode, T1.OnHand as InStock
        FROM OITM T0
        INNER JOIN OITW T1 ON T0.ItemCode = T1.ItemCode
        WHERE T0.ItmsGrpCod = ? AND T1.WhsCode = '01'",
    "getDBIDbyCountry" => "SELECT DatabaseID FROM dbidtocountry WHERE Country = ?",
    //end of queries of site-inventory
    ///site-inventory/check_inventory
    "checkInventory" => "SELECT T0.ItemCode, T0.OnHand FROM OITM AS T0 WHERE T0.ItemCode = ?",
    //http://67.23.63.117/site-api/order-status
    "getOrderStatus" => "SELECT distinct TOP 3 T0.[DocNum], T0.[DocDate] AS 'Entry Date', T0.[CardName] AS 'Card Name', T0.[Printed], T0.[InvntSttus] AS 'Shipped from warehouse?', T2.TrackNo, T3.TrnspName AS 'Shipping Type'
                            FROM OINV T0
                            INNER JOIN INV1 T1 ON T0.DocEntry = T1.DocEntry
                            LEFT JOIN ODLN T2 ON T1.[TrgetEntry] = T2.DocEntry
                            LEFT JOIN OSHP T3 ON T2.TrnspCode = T3.TrnspCode
                            WHERE T0.[NumAtCard]= ?",
    // sap orders
    "sapOrders" => "
            SELECT distinct 
            T0.[DocNum] AS 'SAP Doc Num', 
            T0.NumatCard AS 'Web Order Num',
            T0.[CardCode] AS 'Customer Code', 
            T0.[CardName] AS 'Customer Name', 
            T0.[DocDate], 
            T0.DocTime AS 'Doc Time', 
            DATEDIFF(DD, T0.[DocDate], GetDate()) AS 'Aging' ,
            T3.[SlpName], 
            T4.[WhsName], 
            T5.[GroupName] AS 'Group Name', 
            t0.printed AS 'Printed', 
            T0.Address2 AS 'Shipping Address', 
            T0.Comments, GetDate() as 'LastReportUpdate', 
            ? AS 'SAP source' 
            FROM OINV T0
            LEFT JOIN INV1 T2 ON T0.DocEntry = T2.DocEntry
            LEFT JOIN OSLP T3 ON T0.SlpCode = T3.SlpCode
            LEFT JOIN OWHS T4 ON T0.Filler = T4.WhsCode
            LEFT JOIN OCRD T6 ON T0.CardCode = T6.CardCode
            LEFT JOIN OCRG T5 ON T6.GroupCode = T5.GroupCode
            WHERE
            DATEPART(YEAR,t0.DocDate) > '2019' AND
            T0.isIns='Y' AND T0.CANCELED = 'N' AND T0.InvntSttus = 'O'
            GROUP BY
            T0.[DocNum],
            T0.[DocDate], 
            T0.[DocDueDate],  
            T0.[CardCode], 
            T0.[CardName],
            T3.[SlpName], 
            T4.[WhsName], 
            T5.[GroupName],
            T0.[DocStatus],t0.printed, 
            T0.NumatCard, 
            T0.DocTime, 
            T0.Address2, 
            T0.Comments",
];
