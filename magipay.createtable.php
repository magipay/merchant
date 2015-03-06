<?php
//Please run this file to create tables that will be use for magipay transactions. 
//Ex. https://your_domain_name.com/Magipay/magipay.createtable.php

include_once("db_connect.php");

$create_magiEpayments = "CREATE TABLE IF NOT EXISTS magiEpayments (
            paymentID int(11) unsigned NOT NULL AUTO_INCREMENT,
			uniqueID VARCHAR(50) NOT NULL,
			invoiceID VARCHAR(50) NOT NULL,
			boxID int(11) unsigned NOT NULL DEFAULT '0',
			userID varchar(50) NOT NULL DEFAULT '',
			amountXMG double(20,8) NOT NULL DEFAULT '0.00000000',
			amountUSD double(20,8) NOT NULL DEFAULT '0.00000000',
			amountReceived double(20,8) NOT NULL DEFAULT '0.00000000',
			payment_received BOOLEAN DEFAULT false,
			txID VARCHAR(50) NOT NULL,
			txDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (paymentID)
             )";
			
$query = mysqli_query($db_conx, $create_magiEpayments);
if ($query === TRUE) {
	echo "<h3>magiEpayments TABLE CREATED </h3>"; 
} else {
	echo "<h3>magiEpayments NOT TABLE CREATED </h3>"; 
}

?>