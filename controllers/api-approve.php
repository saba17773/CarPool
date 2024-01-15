<?php 
	$app->post("/mgapprove",function(){
		$id 	= $_POST["id"];
		$id_car = $_POST["id_car"];
		$comp   = $_POST["comp"];
		$mailmg = $_POST["mailmg"];
		sendmailmanagerapprove($id,$id_car,$comp,$mailmg);
		
	});
	$app->post("/mgnoapprove",function(){
		$id 	= $_POST["id"];
		$mailmg = $_POST["mailmg"];
		$userby = $_POST["userby"];
		$remark = $_POST["remark"];
		sendmailmanagernoapprove($id,$userby,$mailmg,$remark);
	});
	$app->post("/mghrapprove",function(){
		$id = $_POST["id"];
		$id_request = $_POST["id_request"];
		$mailmg = $_POST["mailmg"];
		sendmailmanager_hrcomplete($id,$id_request,$mailmg);
		
		
	});
	$app->post("/mgnoapprovehr",function(){
		$id 			= $_POST["id"];
		$mailmg 		= $_POST["mailmg"];
		$userby 		= $_POST["userby"];
		$remark 		= $_POST["remark"];
		$description 	= $_POST["description"];
		$startdate 		= $_POST["startdate"];
		$starttime 		= $_POST["starttime"];
		$enddate 		= $_POST["enddate"];
		$endtime 		= $_POST["endtime"];
		sendmailmanagernoapprovehr($id,$userby,$mailmg,$remark,$description,$startdate,$starttime,$enddate,$endtime);
	});