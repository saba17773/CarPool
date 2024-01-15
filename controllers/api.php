<?php 
	$app->post("/addreserve-car",function(){
        $db = db();
        $start = $_POST["start"];
        $station = $_POST["station"];
        $end = $_POST["end"];
        $startDate = $_POST["startDate"];
        $startTime = $_POST["startTime"];
        $endDate = $_POST["endDate"];
        $endTime = $_POST["endTime"];
        $people = $_POST["people"];
        $title = $_POST["title"];
        $userallow = $_POST["tranfer_n"];
        $userallowP = $_POST["tranfer_t"];
        $userid = $_SESSION["loggeduserid"]; 
        $numberid = substr(date('YmdHis'), 2).round(microtime(true) * 1000);  
    $st = DateTime::createFromFormat("d/m/Y", $startDate);
    $ed = DateTime::createFromFormat("d/m/Y", $endDate);
    $startDate = $st->format("Y-m-d");
    $endDate = $ed->format("Y-m-d");
    
        $InsertTrans = sqlsrv_query(
            $db,
            "INSERT INTO CarRequestTrans(NumberRequestID,FromDate,ToDate,FromTime,ToTime,Seat,Start,StartingPoint,Finished,Title,StatusID,CreateBy,CreatDate,UserAllow,UserAllowPhone) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,getdate(),?,?)",
            array($numberid,$startDate,$endDate,$startTime,$endTime,$people,$start,$station,$end,$title,1,$userid,$userallow,$userallowP)
        );
            if ($InsertTrans) {
                //echo '<script>';
                //echo 'location.href="./alert-forget?no=4&id='.$numberid.'"';
                //echo '</script>';
                //
                if(isset($_FILES["filUpload"]["name"])){
                        for($i=0;$i<count($_FILES["filUpload"]["name"]);$i++)
                        {
                            if($_FILES["filUpload"]["name"][$i] != "")
                            {   
                    
                    $file = strtolower($_FILES["filUpload"]["name"][$i]);
                    $type= strrchr($file,".");
                    
                    $nf = substr(date('Ymd_His'), 0).round(microtime(true) * 1000);  
                    $newfilenameDes= $userid."_".$nf.$type;
                    
                    if(move_uploaded_file($_FILES["filUpload"]["tmp_name"][$i],"upload/".$newfilenameDes)){
                        $InsertFileNCR = sqlsrv_query(
                        $db,
                        "INSERT INTO DataFile(TransID,FileName,Type) VALUES(?,?,?)",
                        array($numberid,$newfilenameDes,'1')
                        );
                        echo '<script>';
                        echo 'location.href="./alert-forget?no=4&id='.$numberid.'"';
                        echo '</script>';
                    }else{
                        
                        echo "Upload Fail!";
                    }
                            }
                        }
                            
                }else{
                        echo '<script>';
                        echo 'location.href="./alert-forget?no=4&id='.$numberid.'"';
                        echo '</script>';
                }
            }else{
                echo '<script>';
                echo 'location.href="./alert-forget?no=3"';
                echo '</script>';
            }
    });

    $app->post("/sendemail",function(){
        $mail = $_POST["mail"];
        $mail_not = $_POST["mail_not"];
        $id = $_POST["id"];

        foreach ($mail as $v) {
             
            if (in_array($v,$mail)) {
                //echo $v.$id;
                sendmailmanageruser($v,$id);
                // echo $v;
            }
            
        }

    });

    $app->post("/sendemail_hr",function(){
        $db = db();
        $mail = $_POST["mail"];
        $mail_not = $_POST["mail_not"];
        $id = $_POST["id_approve"];
        $id_request = $_POST["id_request"];
        // echo $id_request;
        // exit();
        foreach ($mail_not as $v) {
             
            if (in_array($v,$mail)) {
              
                // $UpdateStatusCA = sqlsrv_query(
                //     $db,
                //     "UPDATE CarApproveTrans SET StatusID=? WHERE CarApproveID =?",
                //     array(4,$id)
                // );
                // $UpdateStatus = sqlsrv_query(
                //     $db,
                //     "UPDATE CarRequestTrans SET StatusID=? WHERE CarRequestID IN ($id_request)",
                //     array(4)
                // );
                // if ($UpdateStatus) {
                    //echo "OK";
                    sendmailmanager_hr($v,$id,$id_request);

                        
                // }else{
                //     echo "Error";
                // }
               
            }
            
        }

    });

    $app->post("/updatereserve-car",function(){
        
        //var_dump($_FILES["fileUpload"]["name"]);
        //exit();

        $db = db();
        $id = $_POST["id"];
        $start = $_POST["start"];
        $station = $_POST["station"];
        $end = $_POST["end"];
        $startDate = $_POST["startDate"];
        $startTime = $_POST["startTime"];
        $endDate = $_POST["endDate"];
        $endTime = $_POST["endTime"];
        $people = $_POST["people"];
        $title = $_POST["title"];
        $userid = $_SESSION["loggeduserid"]; 
        $userallow = $_POST["tranfer_n"];
        $userallowP = $_POST["tranfer_t"];
    $st = DateTime::createFromFormat("d/m/Y", $startDate);
    $ed = DateTime::createFromFormat("d/m/Y", $endDate);
    $startDate = $st->format("Y-m-d");
    $endDate = $ed->format("Y-m-d");

        if (isset($_POST["way"])) {
            $station = $_POST["station"];
        }else{
            $station = NULL;
        }

        if (isset($_POST["tranfer"])) {
            $userallow = $_POST["tranfer_n"];
            $userallowP = $_POST["tranfer_t"];
        }else{
            $userallow = NULL;
            $userallowP = NULL;
        }

        $UpdateTrans = sqlsrv_query(
            $db,
            "UPDATE CarRequestTrans SET FromDate=?,ToDate=?,FromTime=?,ToTime=?,Seat=?,Start=?,StartingPoint=?,Finished=?,Title=?,CreateBy=?,CreatDate=getdate(),UserAllow=?,UserAllowPhone=? WHERE NumberRequestID=?",
            array($startDate,$endDate,$startTime,$endTime,$people,$start,$station,$end,$title,$userid,$userallow,$userallowP,$id)
        );
            if ($UpdateTrans) {
                /*echo '<script>';
                echo 'location.href="./alert-forget?no=4&id='.$id.'"';
                echo '</script>';*/

                if(isset($_FILES["fileUpload"]["name"])){
                        for($i=0;$i<count($_FILES["fileUpload"]["name"]);$i++)
                        {
                            if($_FILES["fileUpload"]["name"][$i] != "")
                            {   
                    
                    $file = strtolower($_FILES["fileUpload"]["name"][$i]);
                    $type= strrchr($file,".");
                    
                    $nf = substr(date('Ymd_His'), 0).round(microtime(true) * 1000);  
                    $newfilenameDes= $userid."_".$nf.$type;
                    
                    if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"][$i],"upload/".$newfilenameDes)){
                        $InsertFileNCR = sqlsrv_query(
                        $db,
                        "INSERT INTO DataFile(TransID,FileName,Type) VALUES(?,?,?)",
                        array($id,$newfilenameDes,'1')
                        );
                        echo '<script>';
                        echo 'location.href="./alert-forget?no=4&id='.$id.'"';
                        echo '</script>';
                    }else{
                        
                        echo "Upload Fail!";
                    }
                            }
                        }
                            
                }else{
                        echo '<script>';
                        echo 'location.href="./alert-forget?no=4&id='.$id.'"';
                        echo '</script>';
                }
            }else{
                echo '<script>';
                echo 'location.href="./alert-forget?no=3"';
                echo '</script>';
            }
    });

    $app->post("/carapprovetans",function(){
        $db = db();

        $userid = $_SESSION["loggeduserid"];
        $carid = $_POST["carid"]; 
        $carname = $_POST["carname"]; 
        $driverid = $_POST["driverid"]; 
        $drivername = $_POST["drivername"]; 
        $datestart = $_POST["datestart"]; 
        $dateend = $_POST["dateend"]; 
        $startTime = $_POST["startTime"]; 
        $endTime = $_POST["endTime"]; 
        $txtremark = $_POST["txtremark"]; 
        $seat = $_POST["seat"];
        $st = DateTime::createFromFormat("d/m/Y", $datestart);
        $ed = DateTime::createFromFormat("d/m/Y", $dateend);
        $datestart = $st->format("Y-m-d");
        $dateend = $ed->format("Y-m-d");

        $sql = "SELECT * FROM CarApproveTrans 
                WHERE CarID=? 
                AND ? between StartDate AND EndDate 
                AND ? between StartTime AND EndTime";
        $params = array($carid,$datestart,$startTime);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == true) {
            $obj = sqlsrv_fetch_object($query);
            echo "11";
            exit();
        }
        
        function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
        $records  = convertforin(implode(',',$_POST["record"]));
        
        $InsertApproveTrans = sqlsrv_query(
                $db,
                "INSERT INTO CarApproveTrans(CarRequestID,CarID,DriverID,Seat,StartDate,EndDate,StartTime,EndTime,Remark,CreateBy,CreateDate,StatusID) VALUES(?,?,?,?,?,?,?,?,?,?,getdate(),?)",
                array($records,$carid,$driverid,$seat,$datestart,$dateend,$startTime,$endTime,$txtremark,$userid,3)
        );
        if ($InsertApproveTrans) {
            $UpdateStatus = sqlsrv_query(
              $db,
              "UPDATE CarRequestTrans SET StatusID=?,CreateByAdmin=?,CarID=? WHERE CarRequestID IN ($records)",
              array(3,$_SESSION["loggeduserid"],$carid)
            );
            if ($UpdateStatus) {
                echo "1";
            }else{
                echo "0";
            }
        }else{
            echo "0";
        }

    });
    

    $app->post("/update-account",function(){
        $db = db();
        $email = $_POST["email"];
        $confirmPassword = $_POST["confirmPassword"];

        $UpdatePass = sqlsrv_query(
          $db,
          "UPDATE UserMaster SET PassWord=? WHERE Email=?",
          array($confirmPassword,$email)
        );
        if ($UpdatePass) {
            echo '<script>';
            echo 'location.href="./alert-forget?no=2"';
            echo '</script>';
        }else{
            echo '<script>';
            echo 'location.href="./alert-forget?no=3"';
            echo '</script>';
        }
       
    });
    $app->post("/adduser",function(){
        $db = db();

        $employee = $_POST["employee"];
        $email    = $_POST["email"];
        $password = $_POST["password"]; 
        $name     = $_POST["name"];
        $dep      = $_POST["dep"];
        $comp     = $_POST["comp"];
        $level    = $_POST["level"];
        $tel      = $_POST["tel"];
        $telme    = $_POST["telme"];
        $per      = $_POST["per"];
        $group    = $_POST["group"];
        $status   = $_POST["status"];
        //echo print_r($_POST);
        //exit();
        
        $InsertUser = sqlsrv_query(
                  $db,
                  "INSERT INTO UserMaster(EMPID,USERACTIVE,Email,Password,Name,Company,Department,LevelID,Tel,telMe,PermissionID,MenuGroup,Active) VALUES(?,1,?,?,?,?,?,?,?,?,?,?,1)",
                  array($employee,$email,$password,$name,$comp,$dep,$level,$tel,$telme,$per,$group,$status)
                );
            if ($InsertUser) {
                echo "1";

                // $InsertLogUser = sqlsrv_query(
                //     $db,
                //     "INSERT INTO [EA_APP].[dbo].[TB_USER_APP] (EMP_CODE,USER_NAME,HOST_NAME,PROJECT_NAME,CREATE_DATE)
                //     VALUES (?,?,?,?,getdate())",
                //     [
                //       $employee,
                //       $email,
                //       gethostbyaddr($_SERVER['REMOTE_ADDR']),
                //       'Car Pool'
                //     ]
                // );

            }else{
                echo "0";
            }

    });

    $app->post("/edituser",function(){
        $db = db();
        
        $employee = $_POST["euser_employee"];
        $email    = $_POST["email"];
        $password = $_POST["password"];
        $name     = $_POST["name"];
        $dep      = $_POST["dep"];
        $comp      = $_POST["comp"];
        $level    = $_POST["level"];
        $tel      = $_POST["tel"];
        $telme    = $_POST["telme"];
        $per    = $_POST["per"];
        $group  = $_POST["group"];
        $status = $_POST["status"];
        $userid = $_POST["userid"];

        $UpdateUser = sqlsrv_query(
                  $db,
                  "UPDATE UserMaster SET EMPID=?,Email=?,Password=?,Name=?,Department=?,Company=?,LevelID=?,Tel=?,TelMe=?, PermissionID=?, MenuGroup=?, Active=?, USERACTIVE=? WHERE  UserID=? ",
                  array($employee,$email,$password,$name,$dep,$comp,$level,$tel,$telme,$per,$group,$status,$status,$userid)
                );
            if ($UpdateUser) {
                echo "1";

                if ($status==1) {
                    // $InsertLogUser = sqlsrv_query(
                    //     $db,
                    //     "INSERT INTO [EA_APP].[dbo].[TB_USER_APP] (EMP_CODE,USER_NAME,HOST_NAME,PROJECT_NAME,CREATE_DATE)
                    //     VALUES (?,?,?,?,getdate())",
                    //     [
                    //       $employee,
                    //       $email,
                    //       gethostbyaddr($_SERVER['REMOTE_ADDR']),
                    //       'Car Pool'
                    //     ]
                    // );
                }else{
                    // $DeleteLogUser = sqlsrv_query(
                    //     $db,
                    //     "UPDATE [EA_APP].[dbo].[TB_USER_APP]
                    //     SET UPDATE_DATE = getdate(), STATUS = ?
                    //     WHERE EMP_CODE = ? AND  USER_NAME= ? AND PROJECT_NAME = ?",
                    //     // "DELETE FROM [EA_APP].[dbo].[TB_USER_APP] WHERE EMP_CODE = ? AND  USER_NAME= ? AND PROJECT_NAME = ?",
                    //     [
                    //         0,
                    //         $employee,
                    //         $email,
                    //         'Car Pool'
                    //     ]
                    // );
                }

            }else{
                echo "0";
            }

    });
    
    $app->post("/addcartype",function(){
        $db = db();
        $cartypename = $_POST["cartypename"];

        $InsertCarType = sqlsrv_query(
                  $db,
                  "INSERT INTO CarTypeMaster(CarTypeName) VALUES(?)",
                  array($cartypename)
        );
            if ($InsertCarType) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/editcartype",function(){
        $db = db();
        $cartypename = $_POST["ecartypename"];
        $id = $_POST["id"];

        $UpdateCarType = sqlsrv_query(
                  $db,
                  "UPDATE CarTypeMaster SET CarTypeName=? WHERE CarTypeID=?",
                  array($cartypename,$id)
        );
            if ($UpdateCarType) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/addcarmaster",function(){
        $db = db();
        $licenseplate = $_POST["licenseplate"];
        $seat = $_POST["seat"];
        $cartype = $_POST["cartype"];
        $status = $_POST["status"];
        $dsl = $_POST["dsl"];
        $drb = $_POST["drb"];
        $dsi = $_POST["dsi"];
        $svo = $_POST["svo"];
        $str = $_POST["str"];

        $InsertCarMaster = sqlsrv_query(
                  $db,
                  "INSERT INTO CarMaster(CarRegistration,Seat,CarTypeID,DSL,DRB,DSI,SVO,STR,CarStatus,CarColor) VALUES(?,?,?,?,?,?,?,?,?,?)",
                  array($licenseplate,$seat,$cartype,$dsl,$drb,$dsi,$svo,$str,$status,'#777777')
        );
            if ($InsertCarMaster) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/editcarmaster",function(){
        $db = db();
        $id = $_POST["idcar"];
        $licenseplate = $_POST["licenseplate"];
        $seat = $_POST["seat"];
        $type = $_POST["type"];
        $status = $_POST["status"]; 
        $dsl = $_POST["dsl"];
        $drb = $_POST["drb"];
        $dsi = $_POST["dsi"];
        $svo = $_POST["svo"];
        $str = $_POST["str"];
    
        $UpdateCarMaster = sqlsrv_query(
                  $db,
                  "UPDATE CarMaster SET CarRegistration=?
                                        ,Seat=?
                                        ,CarTypeID=?
                                        ,DSL=?
                                        ,DRB=?
                                        ,DSI=?
                                        ,SVO=?
                                        ,STR=?
                                        ,CarStatus=? WHERE CarID=?",
                  array($licenseplate,$seat,$type,$dsl,$drb,$dsi,$svo,$str,$status,$id)
        );
            if ($UpdateCarMaster) {
                echo "1";
            }else{
                echo "0";
            }
    }); 

    $app->post("/adddrivermaster",function(){
        $db = db();
        $driver = $_POST["driver"];
        $tel = $_POST["tel"];
        $comp = $_POST["comp"];

        $InsertDriverMaster = sqlsrv_query(
                  $db,
                  "INSERT INTO DriverMaster(DriverName,Tel,CompanyID) VALUES(?,?,?)",
                  array($driver,$tel,$comp)
        );
            if ($InsertDriverMaster) {
                echo "1";
            }else{
                echo "0";
            }
    });

    $app->post("/editdrivermaster",function(){
        $db = db();
        $id = $_POST["id"];
        $driver = $_POST["driver"];
        $tel = $_POST["tel"];
        $comp = $_POST["comp"];

        $UpdateDriverMaster = sqlsrv_query(
                  $db,
                  "UPDATE DriverMaster SET DriverName=?,Tel=?,CompanyID=? WHERE DriverID=?",
                  array($driver,$tel,$comp,$id)
        );
            if ($UpdateDriverMaster) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/adddep",function(){
        $db = db();
        $depid = $_POST["depid"];
        $depname = $_POST["depname"];

        $InsertDepartmentMaster = sqlsrv_query(
                  $db,
                  "INSERT INTO DepartmentMaster(DepartmentID,DepartmentDescription) VALUES(?,?)",
                  array($depid,$depname)
        );
            if ($InsertDepartmentMaster) {
                echo "1";
            }else{
                echo "0";
            }
    });

    $app->post("/editdep",function(){
        $db = db();
        $id = $_POST["id"];
        $depname = $_POST["depname"];

        $UpdateDepartmentMaster = sqlsrv_query(
                  $db,
                  "UPDATE DepartmentMaster SET DepartmentDescription=? WHERE DepartmentID=?",
                  array($depname,$id)
        );
            if ($UpdateDepartmentMaster) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/addcomp",function(){
        $db = db();
        $comp = $_POST["comp"];
        $compname = $_POST["compname"];

        $InsertCompanyMaster = sqlsrv_query(
                  $db,
                  "INSERT INTO CompanyMaster(InternalCode,CompanyDescription) VALUES(?,?)",
                  array($comp,$compname)
        );
            if ($InsertCompanyMaster) {
                echo "1";
            }else{
                echo "0";
            }
    });

    $app->post("/editcomp",function(){
        $db = db();
        $ecompid = $_POST["ecompid"];
        $ecomp = $_POST["ecomp"];
        $ecompname = $_POST["ecompname"];

        $UpdateCompanyMaster = sqlsrv_query(
                  $db,
                  "UPDATE CompanyMaster SET InternalCode=?,CompanyDescription=? WHERE CompanyID=?",
                  array($ecomp,$ecompname,$ecompid)
        );
            if ($UpdateCompanyMaster) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/addper",function(){
        $db = db();
        $pername = $_POST["pername"];
        function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
        $comp  = convertforin(implode(',',$_POST["comp"]));

        $InsertPermission = sqlsrv_query(
                  $db,
                  "INSERT INTO Permission(PermissionName,CompanyID) VALUES(?,?)",
                  array($pername,$comp)
        );
            if ($InsertPermission) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/editper",function(){
        $db = db();
        $id = $_POST["id"];
        $pername = $_POST["epername"];
        function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
        $comp  = convertforin(implode(',',$_POST["ecomp"]));

        $UpdatePermission = sqlsrv_query(
                  $db,
                  "UPDATE Permission SET PermissionName=?,CompanyID=? WHERE PermissionID=?",
                  array($pername,$comp,$id)
        );
            if ($UpdatePermission) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/addgroup",function(){
        $db = db();
        $groupname = $_POST["groupname"];
        function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
        $comp  = convertforin(implode(',',$_POST["comp"]));

        $InsertMENU = sqlsrv_query(
                  $db,
                  "INSERT INTO GroupMenuMaster(GroupDescription,MenuID) VALUES(?,?)",
                  array($groupname,$comp)
        );
            if ($InsertMENU) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/editgroup",function(){
        $db = db();
        $id = $_POST["id"];
        $egroupname = $_POST["egroupname"];
        function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
        $comp  = convertforin(implode(',',$_POST["ecomp"]));

        $UpdateMeNU = sqlsrv_query(
                  $db,
                  "UPDATE GroupMenuMaster SET GroupDescription=?,MenuID=? WHERE GroupID=?",
                  array($egroupname,$comp,$id)
        );
            if ($UpdateMeNU) {
                echo "1";
            }else{
                echo "0";
            }

    });

    $app->post("/usercancel",function(){
        $db = db();
        $id = $_POST["id"];
        $idcar = $_POST["id_car"];
        $status = $_POST["status"];

        $sql = "SELECT * FROM CarApproveTrans 
                WHERE CarRequestID LIKE '%$idcar%'";
            $rs = sqlsrv_query($db,$sql);
            while ($res = sqlsrv_fetch_object($rs)) {
            $carappid = $res->CarApproveID;
            $carrequestid = $res->CarRequestID;
        }

        if ($status==1) {
            //echo "create";
            $UpdateCancel = sqlsrv_query(
                  $db,
                  "UPDATE CarRequestTrans SET StatusID=? WHERE NumberRequestID=?",
                  array(10,$id)
            );
            if ($UpdateCancel) {
                echo "Cancel Success!";
            }
        }else if ($status==2) {
            //echo "confirm";
            $UpdateCancel = sqlsrv_query(
                  $db,
                  "UPDATE CarRequestTrans SET StatusID=? WHERE NumberRequestID=?",
                  array(10,$id)
            );
            $carappid="no";
            sendmailcancel_user($status,$carappid,$id);
        }else if ($status==3 || $status==4 || $status==5) {
            //echo "approve";
            $a1 = (explode(",",$carrequestid));
            $a2 = array($idcar);
            $result = array_diff($a1, $a2);
            
            function convertforin($str){
                $strploblem = "";
                $a =explode(',', $str);
                foreach ($a as $value) {
                    if($strploblem===""){
                        $strploblem.=$value;
                    }else{
                        $strploblem.=",".$value;
                    }
                }
                return $strploblem;
            }
            $complete  = convertforin(implode(',',$result));

            if ($complete=='') {
                $DeleteCancel = sqlsrv_query(
                      $db,
                      "DELETE FROM CarApproveTrans WHERE CarApproveID=?",
                      array($carappid)
                );
                $UpdateCancel = sqlsrv_query(
                      $db,
                      "UPDATE CarRequestTrans SET StatusID=? WHERE NumberRequestID=?",
                      array(10,$id)
                );
                if ($UpdateCancel&&$UpdateCanceld) {
                    echo "Success";
                }else{
                    echo "Error";
                }
            }else{
                $UpdateCancel = sqlsrv_query(
                      $db,
                      "UPDATE CarRequestTrans SET StatusID=? WHERE NumberRequestID=?",
                      array(10,$id)
                );
                $UpdateCanceld = sqlsrv_query(
                      $db,
                      "UPDATE CarApproveTrans SET CarRequestID=? 
                      WHERE CarRequestID LIKE '%$carrequestid%'",
                      array($complete)
                );
                if ($UpdateCancel&&$UpdateCanceld) {
                    echo "Success";
                }else{
                    echo "Error";
                }
                
            }
            sendmailcancel_user($status,$carappid,$id);
        }else if ($status>=9) {
            echo "Cancel";
        }

        exit();
        
    });

    $app->post("/updatehradminmanage",function(){
        $db = db();
        
        $e_seat = $_POST["e_seat"];
        $sum_row = $_POST["sum_row"];
        $requestid = $_POST["requestid"];
        $a_id = $_POST["a_id"];
       
        $ecarid = $_POST["ecarid"];
        $edriverid = $_POST["edriverid"];
        $edatestart = $_POST["edatestart"];
        $edateend = $_POST["edateend"];
        $estartTime = $_POST["estartTime"];
        $eendTime = $_POST["eendTime"];
        $etxtremark = $_POST["etxtremark"];
        $st = DateTime::createFromFormat("d/m/Y", $edatestart);
        $ed = DateTime::createFromFormat("d/m/Y", $edateend);
        $edatestart = $st->format("Y-m-d");
        $edateend = $ed->format("Y-m-d");
        
        $sum_final = ($e_seat+$sum_row); 
        $send_click = $_POST['send_click'];

        $sql = "SELECT * FROM CarApproveTrans WHERE CarApproveID ='$a_id' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $chk_car = $res->CarID;
        }
        if ($chk_car!=$ecarid) {
            $sql = "SELECT * FROM CarApproveTrans 
            WHERE ? between StartDate AND EndDate AND CarID = ?";
            $params = array($edatestart,$ecarid);
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $query = sqlsrv_query($db,$sql,$params,$options);
            $has =  sqlsrv_has_rows($query);
            if ($has == true) {
                $obj = sqlsrv_fetch_object($query);
                echo "11";
                exit();
            }
        }
       

        if ($_POST["XD"]=='ON') {
        
            $UpdateHrManage = sqlsrv_query(
                      $db,
                      "UPDATE CarApproveTrans SET CarRequestID=?,CarID=?,DriverID=?,Seat=?,Remark=?,StartDate=?,EndDate=?,StartTime=?,EndTime=? WHERE CarApproveID=?",
                      array($requestid,$ecarid,$edriverid,$sum_final,$etxtremark,$edatestart,$edateend,$estartTime,$eendTime,$a_id)
            );
                if ($UpdateHrManage) {
                    if (isset($_POST["record2"])) {
                        function convertforin($str){
                                $strploblem = "";
                                $a =explode(',', $str);
                                foreach ($a as $value) {
                                    if($strploblem===""){
                                        $strploblem.=$value;
                                    }else{
                                        $strploblem.=",".$value;
                                    }
                                }
                                return $strploblem;
                            }
                        $record2  = convertforin(implode(',',$_POST["record2"]));
                        //echo $_POST["record2"];
                        $UpdateStatusManage = sqlsrv_query(
                          $db,
                          "UPDATE CarRequestTrans SET StatusID=?,CarID=? WHERE CarRequestID IN ($record2)",
                          array(3,$ecarid)
                        );
                        if ($UpdateStatusManage) {
                            //echo "1";
                            if ($send_click==1) {
                                $sql = "SELECT CarRequestID WHERE CarApproveTrans = '$a_id'";
                                $stmt = sqlsrv_query($db,$sql);
                                $obj = sqlsrv_fetch_object( $stmt);
                                $id_request = $obj->CarRequestID;
                                $mailmg = $_SESSION["loggedmail"];
                                sendmailadmin_hrcomplete($a_id,$id_request,$mailmg);
                            }else{
                                echo "1";
                            }
                            
                        }else{
                            echo "00";
                        }
                    }else{
                        echo "1";
                    }
                    
                }else{
                    echo "0";
                }

        }else{
            $sum_final = ($_POST["e_seat"]-$_POST["sum_row3"]); 
            //echo $sum_final;
            //exit();
            $UpdateHrManage = sqlsrv_query(
                      $db,
                      "UPDATE CarApproveTrans SET CarRequestID=?,CarID=?,DriverID=?,Seat=?,Remark=?,StartDate=?,EndDate=?,StartTime=?,EndTime=? WHERE CarApproveID=?",
                      array($requestid,$ecarid,$edriverid,$sum_final,$etxtremark,$edatestart,$edateend,$estartTime,$eendTime,$a_id)
            );
                if ($UpdateHrManage) {
                     
                    if (isset($_POST["record3"])) {

                        $c_id = (explode(",",$_POST["c_id"]));
                        $array1 = $c_id;
                        $array2 = $_POST["record3"];
                        $result = array_diff($array1, $array2);
                       
                        function convertforin($str){
                                $strploblem = "";
                                $a =explode(',', $str);
                                foreach ($a as $value) {
                                    if($strploblem===""){
                                        $strploblem.=$value;
                                    }else{
                                        $strploblem.=",".$value;
                                    }
                                }
                                return $strploblem;
                            }
                        $record  = convertforin(implode(',',$array2));
                        $records  = convertforin(implode(',',$result));
                        //print_r($record);
                        //exit();
                        $UpdateStatusManage = sqlsrv_query(
                          $db,
                          "UPDATE CarRequestTrans SET StatusID=?,CarID=? WHERE CarRequestID IN ($record)",
                          array(2,$ecarid)
                        );
                        if ($UpdateStatusManage) {
                            if ($UpdateStatusManage) {
                                $UpdateStatusRemove = sqlsrv_query(
                                  $db,
                                  "UPDATE CarApproveTrans SET CarRequestID=? WHERE CarApproveID = ?",
                                  array($records,$a_id)
                                );
                                if ($UpdateStatusRemove) {
                                    //echo "1";
                                    if ($send_click==1) {
                                        $sql = "SELECT CarRequestID WHERE CarApproveTrans = '$a_id'";
                                        $stmt = sqlsrv_query($db,$sql);
                                        $obj = sqlsrv_fetch_object( $stmt);
                                        $id_request = $obj->CarRequestID;
                                        $mailmg = $_SESSION["loggedmail"];
                                        sendmailadmin_hrcomplete($a_id,$id_request,$mailmg);
                                    }else{
                                        echo "1";
                                    }
                                }else{
                                    echo "000";
                                }
                            }
                        }else{
                            echo "00";
                        }
                    }else{
                        echo "1";
                    }
                    
                }else{
                    echo "0";
                }
        }
    

    });
    
    $app->post("/cancel",function(){
        $db = db();
      
        function convertforin($str){
            $strploblem = "";
            $a =explode(',', $str);
            foreach ($a as $value) {
                if($strploblem===""){
                    $strploblem.=$value;
                }else{
                    $strploblem.=",".$value;
                }
            }
            return $strploblem;
        }
        $record  = convertforin(implode(',',$_POST["id_req"]));
        $remark = $_POST["remark"];
        $UpdateStatusManage = sqlsrv_query(
              $db,
              "UPDATE CarRequestTrans SET StatusID=?,Remark=? WHERE CarRequestID IN ($record)",
              array(9,$remark)
        );
        if ($UpdateStatusManage) {
            // echo "Cancel Successful";
            sendmailcancel($record,$remark);
        }else{
            echo "Error";
        }

    });

    $app->post("/canceled_all",function(){
        $db = db();
        $id_request = $_POST["id_req"];
        $id_car = $_POST["id_car"];
        $status = $_POST["status"];
        //echo $id_request;
        //exit();
        if ($status==4) {

            $UpdateStatusManage = sqlsrv_query(
                      $db,
                      "UPDATE CarRequestTrans SET StatusID=? WHERE CarRequestID IN ($id_request)",
                      array(3)
            );
                if ($UpdateStatusManage) {
                    $UpdateStatusCA = sqlsrv_query(
                          $db,
                          "UPDATE CarApproveTrans SET StatusID=? WHERE CarApproveID =?",
                          array(3,$id_car)
                    );
                    if ($UpdateStatusCA) {
                        echo "1";
                    }else{
                        echo "00";
                    }
                }else{
                    echo "0";
                }
        }else{
           
            $UpdateStatusManage = sqlsrv_query(
                      $db,
                      "UPDATE CarRequestTrans SET StatusID=? WHERE CarRequestID IN ($id_request)",
                      array(2)
            );
                if ($UpdateStatusManage) {
                    //echo "1";
                    $DeleteManage = sqlsrv_query(
                          $db,
                          "DELETE FROM CarApproveTrans WHERE CarApproveID =?",
                          array($id_car)
                    );
                        if ($DeleteManage) {
                            echo "1";
                        }else{
                            echo "00";
                        }
                }else{
                    echo "0";
                }
        }

    });

    $app->get("/deletefile",function(){
        $db = db();
        $File               = $_REQUEST['file'];
        $filetarget         = "upload/".$File;
        $flgDelete  = unlink($filetarget);
        $sql = "DELETE FROM DataFile  WHERE  FileName = ?";
        $params = array($File);
        $query = sqlsrv_query($db,$sql,$params);
        echo "File Deleted";
    });

    $app->post("/addcolorcar",function(){
        $db = db();
        $id = $_POST["id"];
        $color = $_POST["cp8"];
        
        $UpdateColorCar = sqlsrv_query(
                      $db,
                      "UPDATE CarMaster SET CarColor=? WHERE CarID =?",
                      array($color,$id)
            );
        if ($UpdateColorCar) {
            //echo "Success!";

                if($_FILES["fileToUpload"]["name"]!= ""){
                    
                    $file = strtolower($_FILES["fileToUpload"]["name"]);
                    $type= strrchr($file,".");                    
                    $newfilenameDes= $id.$type;

                    $images = $_FILES["fileToUpload"]["tmp_name"];
                    $new_images = $id."normal".$_FILES["fileToUpload"]["name"];
                    
                    copy($_FILES["fileToUpload"]["tmp_name"],"img/".$new_images);
                    $height=400; 
                    $size=GetimageSize($images);
                    $width=round($height*$size[0]/$size[1]);
                    $images_orig = ImageCreateFromJPEG($images);
                    $photoX = ImagesX($images_orig);
                    $photoY = ImagesY($images_orig);
                    $images_fin = ImageCreateTrueColor($width, $height);
                    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
                    ImageJPEG($images_fin,"img/".$newfilenameDes);
                    ImageDestroy($images_orig);
                    ImageDestroy($images_fin);       
                    
                    $UpdatePicCar = sqlsrv_query(
                              $db,
                              "UPDATE CarMaster SET CarFileName=? WHERE CarID =?",
                              array($newfilenameDes,$id)
                        );
                    if ($UpdatePicCar) {
                        echo '<script>';
                        echo 'alert("ดำเนินการสำเร็จ!");';
                        echo 'location.href="./colorpick"';
                        echo '</script>';
                    }
                                        
                }else{
                    echo '<script>';
                    echo 'alert("ดำเนินการสำเร็จ!");';
                    echo 'location.href="./colorpick"';
                    echo '</script>';
                }
            
        }else{
            echo '<script>';
            echo 'alert("เกิดผิดพลาด!");';
            echo 'location.href="./colorpick"';
            echo '</script>';
        }
    }); 

    $app->post("/updatehradminmanage_request",function(){
        $db = db();
        
        $Ra_id              = $_POST["Ra_id"];
        $Retxtremark        = $_POST["Retxtremark"];
        $Re_seat            = $_POST["Re_seat"];
        $record_requestID   = $_POST["record_requestID"];
        $RestartTime        = $_POST["RestartTime"];
        $ReendTime          = $_POST["ReendTime"];
        $Recarid            = $_POST["Recarid"];
        // $Redatestart        = $_POST["Redatestart"];
        $Redriverid         = $_POST["Redriverid"];
        
        
        $sql = "SELECT * FROM CarApproveTrans WHERE CarApproveID ='$Ra_id' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $chk_car = $res->CarID;
        $chk_startdate = $res->StartDate;
        }
        if ($chk_car!=$Recarid) {
            $sql = "SELECT * FROM CarApproveTrans 
            WHERE ? between StartDate AND EndDate AND CarID = ?";
            $params = array($chk_startdate,$Recarid);
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $query = sqlsrv_query($db,$sql,$params,$options);
            $has =  sqlsrv_has_rows($query);
            if ($has) {
                echo "11";
                exit();
            }
        }
        
        // echo "1";
        
        $UpdateHrManage = sqlsrv_query(
          $db,
          "UPDATE CarApproveTrans SET CarRequestID=?,CarID=?,DriverID=?,Seat=?,Remark=?,StartTime=?,EndTime=?,StatusID=? WHERE CarApproveID=?",
          array($record_requestID,$Recarid,$Redriverid,$Re_seat,$Retxtremark,$RestartTime,$ReendTime,3,$Ra_id)
        );
            
            if ($UpdateHrManage) {
                //if (isset($record_requestID)) {
                    
                    // function convertforin($str){
                    //     $strploblem = "";
                    //     $a =explode(',', $str);
                    //     foreach ($a as $value) {
                    //         if($strploblem===""){
                    //             $strploblem.=$value;
                    //         }else{
                    //             $strploblem.=",".$value;
                    //         }
                    //     }
                    //     return $strploblem;
                    // }

                    // $record  = convertforin(implode(',',$record_requestID));
                    // echo $record;
                    $UpdateCarRequestTrans = sqlsrv_query(
                      $db,
                      "UPDATE CarRequestTrans SET StatusID=?,CarID=? WHERE CarRequestID IN ($record_requestID)",
                      array(3,$Recarid)
                    );
                    if ($UpdateCarRequestTrans) {
                        // $sql = "SELECT CarRequestID WHERE CarApproveTrans = '$Ra_id'";
                        // $stmt = sqlsrv_query($db,$sql);
                        // $obj = sqlsrv_fetch_object( $stmt);
                        // $id_request = $obj->CarRequestID;
                        // $mailmg = $_SESSION["loggedmail"];
                        // sendmailadmin_hrcomplete($Ra_id,$id_request,$mailmg);
                        // sendmailmanager_hr();
                        echo "1";
                    }else{
                        echo "00";
                    }
                // }else{
                //     echo "1";
                // }
                
            }else{
                echo "0";
            }

        
    

    });