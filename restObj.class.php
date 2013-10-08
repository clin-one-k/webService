<?php
/**
 * A simple class / code example of REST server code
 *
 * This example take the REST quest and return a json array
 *     {
 *         "reslut" : TRUE or FALSE
  *         "message" : Echo what the user put in from URL, body and header
 *     }
 * @category demo/sample code
 * @author   Chen Lin <clin@one-k.com>
 */

class restObj {

    // GET, POST, PUT, or DELETE
    private $method;

    // a variable from the header; for example: "WSKEY: THISISKEY"
    private $key;

    // variables from the URL; for example /name1/value1/name2/value2
    private $request_vars;

    // variables fromt the request body; in this example it is in json format
    private $json_body;

    // message to return; in this case, it is just echos back
    private $messag;

    // just a value to return; in this case, jsut TRUE or FALSE
    private $process_result;


    function __construct(){
      $this->key = "NO_KEY_WAS_GIVEN";
      $this->request_vars = array();
      $this->message = "NO_MESSAGE";
    }

    // get request methods
    public function getMethod(){
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * get vars from URL
     * code example:
     *     curl_init ( "http://Localhost/rest.php/VAR1/VALUE1/VAR2/VALUE2" );
     */
    public function getRequestVars(){
        $this->request_vars=explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    }

    /**
     * get key value from header
     * code example:
     *     curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
     *         "Content-Type: text/xml",
     *         "WSKEY: KEY_VALUE_HERE"  
     *     ));
    */
    public function getKey(){
        $tempArray = getallheaders();
        if ( isset( $tempArray["WSKEY"]) ){
            $this->key = $tempArray["WSKEY"];
        }
    }

    /**
     * get the json from request body
     * code example:
     *     $body=array(
     *         "name"=>$name,
     *         "value"=>$value
     *     );
     *     curl_setopt ( $curl, CURLOPT_POSTFIELDS, json_encode($body));
     */
    public function getJsonBody(){
        $fp =fopen('php://input', 'r');
        $rawData = stream_get_contents($fp);
        $this->json_body = json_decode($rawData);
    }
    
    /**
     * just dummy process
     * if the value is a even number, return FALSE
     * else return TRUE;
     */
    public function setResult(){
        $value=$this->json_body->value;
        if (($value %2)==0){
            $this->result="FALSE";
        }else{
            $this->result="TRUE";
        }
    }

    /**
     * combine the vars and echo back
     */
    public function setMessage(){
        $message = "Your request is to change ".$this->json_body->name;
        $message.= " to ".$this->json_body->value; 
        $message.= "<br/>Your key is: ".$this->key;
        $message.= "<br/>You request method is: ".$this->method;
        $message.= "<br/>Your URL vars is ".implode(",",$this->request_vars);
        $message.= "<br/>Your request result: ".$this->result;
        $this->message = $message;
    }
    /*
     * echo out the result
     */
    public function output(){
        $ary=array(
          "result" => $this->result,
          "message" => $this->message
        );
        echo json_encode($ary);
    }
}