<?php
        if(!isset($_SESSION))
        {
        session_start();
        }
	$db = mysqli_connect('<SERVER ADDR>', '<USER>', '<PASS>', '<DB>');



	if (isset($_POST["on"])) {
		$name = '1';
                $date = new DateTime();
                $dt = date_format($date,"Y/m/d H:i:s");

		mysqli_query($db, "INSERT INTO status (state, date) VALUES ('$name', '$dt')"); 
		$_SESSION['message'] = "BOILER Change State To ON"; 
		header('location: index.php');#
	}
        if (isset($_POST["off"])) {
                $name = '0';
                $date = new DateTime();
                $dt = date_format($date,"Y/m/d H:i:s");

                mysqli_query($db, "INSERT INTO status (state, date) VALUES ('$name', '$dt')");
                $_SESSION['message'] = "BOILER Changed State To OFF";
                header('location: index.php');
        }
