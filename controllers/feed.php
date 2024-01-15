<?php 
    $app->post("/checklogin",function(){

        $db = db();
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $sql = "SELECT * FROM UserMaster WHERE Email = ? AND Password = ? AND Active=1";
        $params = array($username,$password);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);

        if ($has == true) {
            $obj = sqlsrv_fetch_object($query);
            $_SESSION["loggeduserid"]   = $obj->UserID;
            $_SESSION["loggedpassword"] = $obj->Password;
            $_SESSION["loggedmail"] = $obj->Email;
            $_SESSION["loggeddep"] = $obj->Department;
            $_SESSION["loggedcomp"] = $obj->Company;
            $_SESSION["loggedpermission"] = $obj->PermissionID;
            $_SESSION["loggedmenugroup"] = $obj->MenuGroup;
            $_SESSION["loggedlevel"] = $obj->LevelID;
            $_SESSION["loggedempid"] = $obj->EMPID;
           //echo "1";
            $employee = $obj->EMPID;
            $getdate = date("Y-m-d H:i:s");
            $computername = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $remark = $_SERVER['HTTP_USER_AGENT'];

            $updatelogin = sqlsrv_query($db,"UPDATE UserMaster SET Lastlogin = Getdate() WHERE Email = ?", array($username));
            
            $insertloginlogs = sqlsrv_query($db,"INSERT INTO [WEB_CENTER].[dbo].[LoginLogs] 
                (EmployeeID,ComputerName,Username,LoginDevice,LoginDate,ProjectID,Remark) VALUES(?,?,?,?,?,?,?)", 
                array($employee,$computername,$username,1,$getdate,8,$remark));
            
            // $InsertlogApp = sqlsrv_query($db,
            //     "INSERT INTO [EA_APP].[dbo].[TB_LOG_APP] (EMP_CODE,USER_NAME,HOST_NAME,LOGIN_DATE,PROJECT_NAME)
            //     VALUES (?,?,?,?,?)",
            //     array(
            //         $employee,
            //         $username,
            //         $computername,
            //         date('Y-m-d H:i:s'),
            //         'Car Pool'
            //     )
            // );

            echo '<script>';
            echo 'location.href="./home"';
            echo '</script>';
        }else{
            //echo "0";
            echo '<script>';
            echo 'alert("กรุณาเช็คชื่อผู้ใช้งานและรหัสผ่าน");'; 
            echo 'location.href="./login"';
            echo '</script>';
        }

    });

    $app->get("/checkeduser",function(){
        $db = db();
        $email = trim($_GET["email"]);
        
        $sql = "SELECT * FROM UserMaster WHERE Email=?";
        $params = array($email);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == true) {
            $obj = sqlsrv_fetch_object($query);
            echo "1";
        }else{
            echo "0";
        }   

    });

    $app->get("/checkedcar",function(){
        $db = db();
        $carid = trim($_GET["carid"]);
        
        $sql = "SELECT * FROM CarMaster WHERE CarID=$carid";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $seat = $res->Seat;
        }
        if ($seat) {
            echo $seat;
        }else{
            echo "0";
        }   

    });

    $app->get("/checkedcarregis",function(){
        $db = db();
        $carid = trim($_GET["carid"]);
        $st_date = $_GET["st_date"];

        $st = DateTime::createFromFormat("d/m/Y", $st_date);
        $st_date = $st->format("Y-m-d");
        /*echo print_r($_GET);
        exit();*/
        $sql = "SELECT * FROM CarApproveTrans 
        WHERE ? between StartDate AND EndDate AND CarID = ?";
        $params = array($st_date,$carid);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == true) {
            $obj = sqlsrv_fetch_object($query);
            echo "1";
        }else{
            echo "0";
        } 

    });

    $app->get("/checkeddep",function(){
        $db = db();
        $depid = trim($_GET["depid"]);
        
        $sql = "SELECT * FROM DepartmentMaster WHERE DepartmentID=?";
        $params = array($depid);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == true) {
            $obj = sqlsrv_fetch_object($query);
            echo "1";
        }else{
            echo "0";
        }   

    });

    $app->post("/registering",function(){
        $db = db();
        $email = trim($_POST["email"]);
        //$email =  'harit_j@deestone.com';
        //sendmailregister($email);
        $name = $_POST["name"];
        $dep = $_POST["dep"];
        $comp = $_POST["comp"];
        $tel = $_POST["tel"];
        $telme = $_POST["telme"];

        
        $sql = "SELECT * FROM UserMaster WHERE Email=?";
        $params = array($email);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == false) {
            $InsertRegister = sqlsrv_query(
                  $db,
                  "INSERT INTO UserMaster(Email,Name,Company,Department,LevelID,Tel,TelMe,Active,MenuGroup) VALUES(?,?,?,?,?,?,?,?,?)",
                  array($email,$name,$comp,$dep,2,$tel,$telme,0,2)
            );
            if ($InsertRegister) {
                $sql = "SELECT U.Email,U.Name,U.Company,U.Department,U.Tel,U.TelMe,C.InternalCode,D.DepartmentDescription
                        FROM UserMaster U 
                        LEFT JOIN CompanyMaster C ON U.Company=C.CompanyID
                        LEFT JOIN DepartmentMaster D ON U.Department=D.DepartmentID
                        WHERE U.Email='$email'";
                $stmt = sqlsrv_query($db,$sql);
                $obj = sqlsrv_fetch_object( $stmt);
                $email_u = $obj->Email;
                $name = $obj->Name;
                $tel = $obj->Tel;
                $telme = $obj->TelMe;
                $comp =  $obj->InternalCode;
                $dep = $obj->DepartmentDescription;
                sendmailregister($email_u,$name,$tel,$telme,$comp,$dep);
            }else{
              echo "Insert Error";
            }
        }else{
            //echo "Email นี้มีผู้ใช้แล้ว";
            echo '<script>';
            echo 'alert("Email นี้มีผู้ใช้แล้ว");';
            echo 'location.href="./login"';
            echo '</script>';
        } 
        

    });
    
    $app->post("/forget",function(){

        $db = db();
        $email = $_POST["email"];
        //$pwn = "1234";
        $sql = "SELECT * FROM UserMaster WHERE Email = ? AND Active=1";
        $params = array($email);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $query = sqlsrv_query($db,$sql,$params,$options);
        $has =  sqlsrv_has_rows($query);
        if ($has == true) {
            
        
            $alpha = "abcdefghijklmnopqrstuvwxyz";
            $alpha_upper = strtoupper($alpha);
            $numeric = "0123456789";
            $special = ".-+=_,!@$#*%<>[]{}";
            $chars = "";
         
            if (isset($_POST['length'])){
                if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
                    $chars .= $alpha;
                 
                if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
                    $chars .= $alpha_upper;
                 
                if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
                    $chars .= $numeric;
                 
                if (isset($_POST['special']) && $_POST['special'] == 'on')
                    $chars .= $special;
                 
                $length = $_POST['length'];
            }else{
                $chars = $alpha . $alpha_upper . $numeric;
                $length = 9;
            }
             
            $len = strlen($chars);
            $pw = '';
             
            for ($i=0;$i<$length;$i++)
                    $pw .= substr($chars, rand(0, $len-1), 1);
             
            // the finished password
            $pwn = str_shuffle($pw);
            //echo "e-mail =>>".$email."<br>";
            //echo "password  =>>".$pw;
            sendmail($email,$pwn);
        
        }else{

            $sql = "SELECT * FROM UserMaster WHERE Email = ? AND Active=0";
            $params = array($email);
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $query = sqlsrv_query($db,$sql,$params,$options);
            $has_noactive =  sqlsrv_has_rows($query);
            if($has_noactive == true){
                echo '<script>';
                echo 'alert("Email นี้ยังไม่ได้รับการอนุมัติจาก HR");';
                echo 'location.href="./login"';
                echo '</script>';
            }
            echo '<script>';
            echo 'alert("Email นี้ยังไม่ได้สมัครใช้งาน");';
            echo 'location.href="./register"';
            echo '</script>';
        } 
        

    });

    $app->get("/permissionmaster",function(){
        $db = db();
        $sql = "SELECT * FROM Permission";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/menugroupmaster",function(){
        $db = db();
        $sql = "SELECT * FROM GroupMenuMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/menudescripmaster",function(){
        $db = db();
        $sql = "SELECT * FROM MenuMaster ORDER BY MenuID ASC";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/companymaster",function(){
        $db = db();
        $sql = "SELECT * FROM CompanyMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/departmentmaster",function(){
        $db = db();
        $sql = "SELECT * FROM DepartmentMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/levelmaster",function(){
        $db = db();
        $sql = "SELECT * FROM LevelMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/cartypemaster",function(){
        $db = db();
        $sql = "SELECT * FROM CarTypeMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/permissionmaster",function(){
        $db = db();
        $sql = "SELECT * FROM Permission";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/menumaster",function(){
        $db = db();
        $sql = "SELECT * FROM GroupMenuMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/statusmaster",function(){
        $db = db();
        $sql = "SELECT * FROM StatusMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/carmaster_manage",function(){
        $db = db();
        $comp = $_SESSION["loggedcomp"];
          if ($comp==1) {
            $company = 'DSL';
          }else if($comp==2) {
            $company = 'DRB';
          }else if($comp==3) {
            $company = 'DSI';
          }else if($comp==4) {
            $company = 'SVO';
          }else if($comp==5) {
            $company = 'STR';
          }
        $sql = "SELECT C.CarID
                      ,C.CarRegistration
                      ,C.Seat
                      ,C.CarTypeID
                      ,CT.CarTypeName
                      ,C.DSL
                      ,C.DRB
                      ,C.DSI
                      ,C.SVO
                      ,C.STR
                      ,C.CarStatus  FROM CarMaster C
                      LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
                      WHERE $company=1 AND CarStatus=1";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/carmaster",function(){
        $db = db();
        $sql = "SELECT C.CarID
                      ,C.CarRegistration
                      ,C.Seat
                      ,C.CarTypeID
                      ,CT.CarTypeName
                      ,C.DSL
                      ,C.DRB
                      ,C.DSI
                      ,C.SVO
                      ,C.STR
                      ,C.CarStatus  FROM CarMaster C
                      LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/drivermaster",function(){
        $db = db();
        $sql = "SELECT * FROM DriverMaster";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });  

    $app->get("/listmailmanager",function(){
        $db = db();
        $seesion_dep = $_SESSION["loggeddep"];
        $sql = "SELECT * FROM UserMaster WHERE LevelID=3 AND Department='$seesion_dep' AND Active=1";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/listmailmanager_hr",function(){
        $db = db();
        $sql = "SELECT * FROM UserMaster WHERE LevelID=3 AND Department ='DE006' AND Active=1";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/usermaster",function(){
        $db = db();
        $sql = "SELECT U.UserID
                      ,U.Password
                      ,U.Email
                      ,U.Name
                      ,U.Company
                      ,U.Department
                      ,D.DepartmentDescription
                      ,U.Tel
                      ,U.TelMe
                      ,U.LevelID
                      ,U.PermissionID
                      ,U.MenuGroup
                      ,U.Active
                      ,L.LevelDescription
                      ,C.InternalCode
                      ,P.PermissionName
                      ,G.GroupDescription
                      ,U.EMPID
                FROM UserMaster U
                LEFT JOIN LevelMaster L ON U.LevelID=L.LevelID
                LEFT JOIN DepartmentMaster D ON U.Department=D.DepartmentID
                LEFT JOIN CompanyMaster C ON U.Company=C.CompanyID
                LEFT JOIN Permission P ON U.PermissionID=P.PermissionID
                LEFT JOIN GroupMenuMaster G ON U.MenuGroup=G.GroupID";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/usermaster/employee",function(){
        $db = db();
        $sql = "SELECT 
        E.CODEMPID, E.EMPNAME, E.EMPLASTNAME, S.DIVISIONID, E.DEPARTMENTCODE ,D.DEPARTMENTNAME,S.DIVISIONNAME,E.COMPANYNAME,T.EMAIL
        from [HRTRAINING].[dbo].[EMPLOYEE] E
        LEFT JOIN [HRTRAINING].[dbo].[DEPARTMENT] D ON E.DEPARTMENTCODE=D.DEPARTMENTCODE
        LEFT JOIN [HRTRAINING].[dbo].[DIVISION] S ON E.DIVISIONCODE=S.DIVISIONCODE
        LEFT JOIN [HRTRAINING].[dbo].[TEMPLOY1] T ON E.CODEMPID=T.CODEMPID
        where E.STATUS <> 9 
        -- and T.EMAIL IS NOT NULL 
        -- and T.EMAIL != 'dummy@tjs.co.th'
        group by E.CODEMPID, E.EMPNAME, E.EMPLASTNAME, S.DIVISIONID, E.DEPARTMENTCODE,D.DEPARTMENTNAME,S.DIVISIONNAME,E.COMPANYNAME,T.EMAIL";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    });

    $app->get("/cartrans",function(){
        $db = db();
        $userid = $_SESSION["loggeduserid"];
        $level = $_SESSION["loggedlevel"];

        if ($level==4) {
            $sql = "SELECT T.CarRequestID
                      ,T.NumberRequestID
                      ,T.FromDate
                      ,T.ToDate
                      ,T.FromTime
                      ,T.ToTime
                      ,T.Seat
                      ,T.Start
                      ,T.Finished
                      ,T.Title
                      ,T.StartingPoint
                      ,T.StatusID
                      ,T.ApproveBy
                      ,T.ApproveDate
                      ,T.CreateBy
                      ,T.CreatDate
                      ,U.Name
                      ,U.Company
                      ,S.StatusName
                      ,UE.Name[NameMg]
                      ,UA.Name[NameAd]
                      ,C.InternalCode
                      ,T.CarID
                      ,CR.CarRegistration
                FROM CarRequestTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                LEFT JOIN UserMaster UE ON T.ApproveBy=UE.Email
                LEFT JOIN UserMaster UA ON T.CreateByAdmin=UA.UserID
                LEFT JOIN StatusMaster S ON T.StatusID=S.StatusID
                LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
                LEFT JOIN CarMaster CR ON T.CarID=CR.CarID 
                WHERE S.StatusID <> 10
                ORDER BY T.FromDate DESC";
        }else{
            $sql = "SELECT T.CarRequestID
                      ,T.NumberRequestID
                      ,T.FromDate
                      ,T.ToDate
                      ,T.FromTime
                      ,T.ToTime
                      ,T.Seat
                      ,T.Start
                      ,T.Finished
                      ,T.Title
                      ,T.StartingPoint
                      ,T.StatusID
                      ,T.ApproveBy
                      ,T.ApproveDate
                      ,T.CreateBy
                      ,T.CreatDate
                      ,U.Name
                      ,U.Company
                      ,S.StatusName
                      ,UE.Name[NameMg]
                      ,UA.Name[NameAd]
                      ,C.InternalCode
                      ,T.CarID
                      ,CR.CarRegistration
                FROM CarRequestTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                LEFT JOIN UserMaster UE ON T.ApproveBy=UE.Email
                LEFT JOIN UserMaster UA ON T.CreateByAdmin=UA.UserID
                LEFT JOIN StatusMaster S ON T.StatusID=S.StatusID
                LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
                LEFT JOIN CarMaster CR ON T.CarID=CR.CarID 
                WHERE CreateBy = $userid
                AND S.StatusID <> 10
                ORDER BY T.FromDate DESC";
        }
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/cartransmanaget",function(){
        $db = db();
        $car_reqid = $_GET["car_reqid"];
        $permission = $_SESSION["loggedpermission"];
        $query = "SELECT * FROM Permission 
                  WHERE PermissionID=$permission";
        $stmt = sqlsrv_query($db,$query);
        $obj = sqlsrv_fetch_object($stmt);
        $per = $obj->CompanyID;

        $sql = "SELECT T.CarRequestID
                      ,T.NumberRequestID
                      ,T.FromDate
                      ,T.ToDate
                      ,T.FromTime
                      ,T.ToTime
                      ,T.Seat
                      ,T.Start
                      ,T.Finished
                      ,T.Title
                      ,T.StartingPoint
                      ,T.StatusID
                      ,T.ApproveBy
                      ,T.ApproveDate
                      ,T.CreateBy
                      ,T.CreatDate
                      ,U.Name
                      ,S.StatusName
                      ,UE.Name[NameMg]
                FROM CarRequestTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                LEFT JOIN UserMaster UE ON T.ApproveBy=UE.Email
                LEFT JOIN StatusMaster S ON T.StatusID=S.StatusID
                WHERE T.StatusID=3  AND U.Company IN ($per)  AND CarRequestID IN ($car_reqid)
                ORDER BY FromDate ASC";
            /*     WHERE U.Company IN ($per)*/
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/cartransmanage",function(){
        $db = db();

        $permission = $_SESSION["loggedpermission"];
        $query = "SELECT * FROM Permission 
                  WHERE PermissionID=$permission";
        $stmt = sqlsrv_query($db,$query);
        $obj = sqlsrv_fetch_object($stmt);
        $per = $obj->CompanyID;

        $sql = "SELECT T.CarRequestID
                      ,T.NumberRequestID
                      ,T.FromDate
                      ,T.ToDate
                      ,T.FromTime
                      ,T.ToTime
                      ,T.Seat
                      ,T.Start
                      ,T.Finished
                      ,T.Title
                      ,T.StartingPoint
                      ,T.StatusID
                      ,T.ApproveBy
                      ,T.ApproveDate
                      ,T.CreateBy
                      ,T.CreatDate
                      ,U.Name
                      ,S.StatusName
                      ,UE.Name[NameMg]
                      ,C.InternalCode
                FROM CarRequestTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                LEFT JOIN UserMaster UE ON T.ApproveBy=UE.Email
                LEFT JOIN StatusMaster S ON T.StatusID=S.StatusID
                LEFT JOIN CompanyMaster C  ON T.Start=C.CompanyID
                WHERE T.StatusID=2  AND U.Company IN ($per)
                ORDER BY FromDate DESC";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 

    $app->get("/cartransmanaged",function(){
        $db = db();
        $create_id = $_SESSION["loggeduserid"];
        $permission = $_SESSION["loggedpermission"];
        $query = "SELECT * FROM Permission 
                  WHERE PermissionID=$permission";
        $stmt = sqlsrv_query($db,$query);
        $obj = sqlsrv_fetch_object($stmt);
        $per = $obj->CompanyID;

        $sql = "SELECT T.CarApproveID
                      ,T.CarRequestID
                      ,T.CarID
                      ,T.DriverID
                      ,T.Remark
                      ,T.StartDate
                      ,T.EndDate
                      ,T.StartTime
                      ,T.EndTime
                      ,T.CreateBy
                      ,T.CreateDate
                      ,T.ApproveBy
                      ,T.ApproveDate
                      ,T.Seat
                      ,C.CarRegistration
                      ,C.Seat[SeatCar]
                      ,C.CarTypeID
                      ,CT.CarTypeName
                      ,D.DriverName
                      ,T.StatusID
                      ,ST.StatusName
                FROM CarApproveTrans T
                LEFT JOIN CarMaster C ON T.CarID=C.CarID
                LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
                LEFT JOIN DriverMaster D ON T.DriverID=D.DriverID
                LEFT JOIN StatusMaster ST ON T.StatusID=ST.StatusID
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                WHERE U.Company IN ($per)
                ORDER BY T.StartDate DESC";
                //WHERE T.CreateBy = $create_id";
            $result=sqlsrv_query($db,$sql);
            $rows = array();
            while($res = sqlsrv_fetch_object($result)) {
                $rows[] = $res;
            }
            echo json_encode($rows);
    }); 
    
    $app->get("/linkfilemy",function(){
        $db = db();
        $idfile = $_GET['no'];
        $sql = "SELECT * FROM DataFile WHERE TransID = ? AND Type=1"; 
        $params = array($idfile);
        $query = sqlsrv_query($db,$sql,$params);

        $json = array();

        while($res = sqlsrv_fetch_object($query)) {
            $json[]  = $res;
    }

    echo json_encode($json);
    });

    $app->get("/linkfile",function(){
        $db = db();
        $idfile = $_GET['no'];
        $sql = "SELECT * FROM DataFile WHERE TransID IN ($idfile)"; 
        
        $query = sqlsrv_query($db,$sql);

        $json = array();

        while($res = sqlsrv_fetch_object($query)) {
            $json[]  = $res;
        }

    echo json_encode($json);
    });