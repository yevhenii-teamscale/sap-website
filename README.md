# API for the new sites

#### REST API application based on Slim Framework 3

### URLs:
USA: http://67.23.63.117/site-api/

ISRAEL: http://192.115.202.221/site-api/

### Routes:

/site-inventory - Get all products with quantity

request:
```
{
	"site_id":1,
}
```
response:
```
[
    {
        "ItemCode": "ba1",
        "InStock": "-1.000000"
    },
    {
        "ItemCode": "ba2",
        "InStock": "-7.000000"
    },
    {
        "ItemCode": "ba3",
        "InStock": "-1.000000"
    }
...
]
```


/site-api/site-inventory/check_inventory - check if all products in order exists

request:
```
{
"products": [

   {
        "ItemCode": "A18s",
        "Qty": "5"
    },
    {
        "ItemCode": "b112",
        "Qty": "1"
    },
    {
        "ItemCode": "B186",
        "Qty": "1"
    }
],
"CountrySAP":"ISR"
}

```

"CountrySAP":"ISR" or "US"

response:

true or false

/order-status - Get details of the order - only for US

request:
```
{
	"site_id":1,
	"order_reference":406272
}
```
response:
```
[
    {
        "DocNum": "178552",
        "Entry Date": "2019-11-19 00:00:00.000",
        "Card Name": "Andrew Read",
        "Printed": "Y",
        "Shipped from warehouse?": "C",
        "TrackNo": "120367887051",
        "Shipping Type": "Fedex – Ground"
    }
]
```



