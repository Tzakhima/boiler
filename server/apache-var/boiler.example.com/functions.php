
<?php  
function is_online() {
    include ('server.php');
    $db = mysqli_connect('<SERVER ADDR>', '<USER>', '<PASS>', '<DB>');
    global $row;
    global $value;
    $record = mysqli_query($db, "SELECT state FROM status ORDER BY state_id DESC LIMIT 1");
    $row = mysqli_fetch_assoc($record);
    $value = $row['state'];
  

if($value == "1" )
{
$color = "green";
}
else
{
$color = "red";
}
return $color;
mysqli_close($db);
}

function last_value() {
    include ('server.php');
    global $value;
    $data = mysqli_query($db, "SELECT state FROM status ORDER BY state_id DESC LIMIT 1");
    while ($row = mysqli_fetch_assoc($data)) {
        $value = $row["state"];}
if ($value == "1")
{
$name = "off";
}
else
{
$name = "on";
}
return $name;
}


function date_on() {
    include ('server.php');
    global $value;
    $data = mysqli_query($db, "SELECT MAX(date) FROM status WHERE `state` = '1'");
    while ($row = mysqli_fetch_assoc($data)) {
        $value = $row["MAX(date)"];}
return $value;
}


function diff() {
    include ('server.php');
    global $value;
    $data = mysqli_query($db, "select timediff((select MAX(date) from status),(SELECT MAX(date) FROM status WHERE `state` = '1')) AS diff");
    while ($row = mysqli_fetch_assoc($data)) {
        $value = $row["diff"];}
return $value;
}


function hb($name) {
    include ('server.php');

    global $value;
    $date = new DateTime();
    $dt = date_format($date,"Y/m/d H:i:s");

    $data = mysqli_query($db, "UPDATE hb SET date = '$dt'");

return $value;
}

function hb_diff() {
    include ('server.php');

    global $value;
    $date = new DateTime();
    $dt = date_format($date,"Y/m/d H:i:s");

    $data = mysqli_query($db, "SELECT MAX(date) FROM hb WHERE `hb` = '1'");
    while ($row = mysqli_fetch_assoc($data)) {
        $value = $row["MAX(date)"];}

    $UcurrTime = strtotime($dt);
    $Udbtime = strtotime($value);
    $diff = $UcurrTime - $Udbtime;
    
    if ($diff > 10)
    {
       return ("disabled");
    }
    else 
    {
       return (Null);
    }   
}
?>
