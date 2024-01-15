<?php 
	//groupPerrmission();

	//function groupPerrmission(){
	$app->get("/groupPerrmission",function(){

			$conn = db();

			$USERID = $_SESSION["loggedmenugroup"];

			
			$json = [];

			$menu = sqlsrv_fetch_object(sqlsrv_query(
				$conn,
				"SELECT M.MenuID 
				FROM GroupMenuMaster M
				WHERE M.GroupID = ?",
				[$USERID]
			))->MenuID;

			$m = sqlsrv_query(
				$conn,
				"SELECT * FROM MenuMaster WHERE MenuID IN ($menu)"
			);

			while ($f = sqlsrv_fetch_object($m)) {
				if ($f->MenuLink != "./menu") {
					$json[] = $f;
				}
				
			}

			echo json_encode($json);

	//}
	 });