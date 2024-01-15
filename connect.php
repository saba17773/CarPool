<?php

	$serverName = "xxxxxxxxxx";
	$uid = "sa";
	$pwd = 'Pa$$w0rd';
	$dbname = "CarPool_dev";
	/*$serverName = "demo\develop";
	$uid = "sa";
	$pwd = "c,]'4^j";
	$dbname = "ClaimTire";*/


	$connectionInfo = array( 
		"Database"=>"$dbname", 
		"UID"=>"$uid", 
		"PWD"=>"$pwd" ,
		"CharacterSet" => "UTF-8",
		"ReturnDatesAsStrings"=>true,
		"MultipleActiveResultSets"=>true);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
?>