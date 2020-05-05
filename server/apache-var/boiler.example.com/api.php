<?php
header("Content-Type:application/json");
require "functions.php";

if(!empty($_GET['status']))
{
    $name=$_GET['status'];
    $status = is_online($name);
    
    if(empty($status))
    {
        response(200,"no response",NULL);
    }
    else
    {
        response(200,"status found",$status);
    }
}
## Heart Beat from Omega
elseif(!empty($_GET['hb']))
{
    $name=$_GET['hb'];
    hb($name);
    response (200,"HB Recieved",$name);
    }  

else
{
    response(400,"Invalid Request",NULL);
}

function response($status,$status_message,$data)
{
    header("HTTP/1.1 ".$status);
    
    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;
    
    $json_response = json_encode($response);
    echo $json_response;
}

?>
