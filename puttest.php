<?php
/*
 * a REST caller sample using PUT
 */

ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );

$name="noname";
$value="0";
if(isset($_POST["name"])){
	$name=$_POST["name"];
}
if(isset($_POST["value"])){
	$value=$_POST["value"];
}
$body=array(
	"name"=>$name,
	"value"=>$value
);

$curl = curl_init ( "http://Localhost/ws/rest.php" );
curl_setopt ( $curl, CURLOPT_HEADER, true );
curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt ( $curl, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
    "Content-Type: text/xml"
    )
);

// run crul
$response = curl_exec ( $curl );
$status = curl_getinfo ($curl);
if($status['http_code']=="401"){
	//failed
	$message="failed";
}else{
	$r=get_http_body($response);
	$result=$r->result;
	$message=$r->message;
	;  
}
// remove the header and just get the body
function get_http_body ($response){
    if(($pos=strpos($response,"{"))!==false) { 
        $body=substr($response,$pos);
        $j=json_decode($body);
        return $j;
    } else{
    	return $response;
    }
}
?>
<html>
<body>
  <form action="#" method="POST">
   I want to change the value of <input type="text" name="name" value="<?php echo $name;?>">
   to <input type="text" name="value" value="<?php echo $value?>">.
   <button type="submit">Try to Change</button>
 </form>
 <p><?php echo $message?></p>
</body>
</html>  
