<?php
/**
 * A simple example of REST server code
 *
 * This example take the REST quest and return a json array
 *     {
 *         "reslut" : TRUE or FALSE
 *         "message" : Echo what the user put in from URL, body and header
 *     }
 * 
 * @category demo/sample code
 * @author   Chen Lin <clin@one-k.com>
 */

//debug only
/*
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );
*/
include "restObj.class.php";

$obj = new restObj();

// get the method, GET, POST, PUT, or DELETE 
$obj -> getMethod();

// get the vars from URL: var1/value1/var2/value2
$obj -> getRequestVars();

// get a value from the header: "WSKEY: asdfjklpoiuqwer"
$obj -> getKey();

// get the requested body, in json format
$obj -> getJsonBody();

// process and get result
$obj -> setResult();

// message from the server, just echos in this demo
$obj -> setMessage();

//print out the result
$obj -> output();