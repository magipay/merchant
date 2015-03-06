<?php

include_once("db_connect.php");
include_once("magipay.keys.php");

$callback_status = "";
 
if (isset($_POST["payment_details"])){

	$posted_data = json_decode($_POST["payment_details"], true);
	 
	//$paymentID 		= 	$posted_data["paymentID"];
	$uniqueID 		= 	mysqli_real_escape_string($db_conx, $posted_data["uniqueID"]);
	$invoiceID 		= 	mysqli_real_escape_string($db_conx, $posted_data["invoiceID"]);
	$boxID 			= 	(int)$posted_data["boxID"];
	//$userID 		= 	$posted_data["userID"];
	$amountXMG 		= 	$posted_data["amountXMG"];
	$amountUSD 		= 	(int)$posted_data["amountUSD"];
	$amountReceived = 	(float)$posted_data["amountReceived"];
	$payment_received = (int)$posted_data["payment_received"];
	$txID 			= 	mysqli_real_escape_string($db_conx, $posted_data["txID"]);
	$txDate 		= 	mysqli_real_escape_string($db_conx, $posted_data["txDate"]);
	
	$private_key	=	mysqli_real_escape_string($db_conx, $posted_data["private_key"]);
	//in_array($private_key, explode(",", MAGIPAY_KEYS)) && 
	echo "private key: ".$private_key;
	if (is_numeric($boxID) && is_numeric($amountReceived) && is_numeric($amountUSD) &&
		in_array($private_key, explode(",", MAGIPAY_PRIVATE_KEYS))){
	
		$sql = "INSERT INTO magiEpayments (uniqueID, invoiceID, boxID, amountUSD, amountReceived, payment_received, txID, txDate)
				VALUES ('".$uniqueID."', '".$invoiceID."', ".$boxID.", ".$amountUSD.", ".$amountReceived.", ".$payment_received.", ".$txID.", '".$txDate."')";
		$query = mysqli_query($db_conx, $sql);
			
		if($query)
			$callback_status = "Record updated";
		else
			$callback_status = "error: ".mysqli_error($db_conx);
		
		mysqli_close($db_conx);
	}
	
	
	
}else{
		$callback_status = "POST Only";
		
}	

echo $callback_status;
           
?>