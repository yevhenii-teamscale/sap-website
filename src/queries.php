<?php

return [
    "insertToSaPDB" => "INSERT INTO sap_orders (
                        DocNum,
                        NumatCard,
                        CardCode,
                        CardName,
                        DocDate,
                        DocTime,
                        Aging,
                        SlpName,  
                        WhsName,  
                        GroupName,
                        printed,  
                        Address,  
                        Comments, 
                        LastReportUpdate, 
                        SapSource
                        )
                        VALUES ?"
];
