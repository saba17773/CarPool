<?php

function RenderView($path,$data = null) {
	$templates = new League\Plates\Engine('./views');
	if (isset($data)) {
		return $templates->render($path,$data);
	} else {
		return $templates->render($path);
	}
}

function db(){
	$serverName = "xxxxxxxxxx";
    $uid = "xx";
    $pwd = 'xx';
    $dbname = "xx";

    $connectionInfo = array( "Database"=>"$dbname", 
        "UID"=>"$uid", "PWD"=>"$pwd",
        "CharacterSet" => "UTF-8",
        "ReturnDatesAsStrings"=>true,
        "MultipleActiveResultSets"=>true);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    return $conn;
}

function sendmail($email,$pwn) {
    // if ($sender === '') {
        $sender_mail = 'webadministrator@deestone.com';
    // } else {
    //     $sender_mail = $sender;
    // }

    $db = db();
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $sender_mail;
    $mail->FromName = $sender_mail;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($sender_mail, $sender_mail);
    // $mail->setFrom('webadministrator@deestone.com', $sender_mail);
    // $mail->addReplyTo($sender_mail);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "แจ้งรหัสผ่านการเข้าใช้งานโปรแกรม CarPool";
    
    $mail->Body    = "แจ้งรหัสผ่านการเข้าใช้งานโปรแกรม CarPool"."<br>"."รหัสผ่านคือ ".$pwn;
            
            if(!$mail->send()){
                /*echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";*/
                echo '<script>';
                echo 'alert("เกิดข้อผิดพลาด");'; 
                echo 'location.href="./forgetpassword"';
                echo '</script>';
            }else{

                $updateforget = sqlsrv_query(
                  $db,
                  "UPDATE UserMaster SET PassWord=? WHERE Email=?",
                  array($pwn,$email)
                );
                if ($updateforget) {
                    echo '<script>';
                    echo 'location.href="./alert-forget?no=1"';
                    echo '</script>';
                    echo "Message send successful !";
                }
                //echo "Message send successful !";
                //echo "<br>";
                
            }
}
function sendmailmanageruser($v,$id) {  
    $db = db();
    $sql = "SELECT T.NumberRequestID,T.Title,T.Start,T.StartingPoint,T.Finished,T.FromDate,T.ToDate,T.FromTime,T.ToTime,C.InternalCode
        FROM CarRequestTrans T
        LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
        WHERE T.NumberRequestID ='$id'";
    $stmt = sqlsrv_query($db,$sql);
    $obj = sqlsrv_fetch_object( $stmt);
    $start = $obj->InternalCode;
    $startpoint = $obj->StartingPoint;
    $finished = $obj->Finished;
    $fromdate = $obj->FromDate;
    $todate = $obj->ToDate;
    $fromtime = $obj->FromTime;
    $totime = $obj->ToTime;
    $title = $obj->Title;

    $sender_mail =  $_SESSION["loggedmail"];    
        
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $sender_mail;
    $mail->FromName = $sender_mail;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($sender_mail, $sender_mail);
    // $mail->setFrom('webadministrator@deestone.com', $sender_mail);
    // $mail->addReplyTo($sender_mail);

    $mail->addAddress($v);
    $mail->isHTML(true);  

    $mail->Subject =  "มีการร้องขออนุญาตใช้งานรถบริษัท";
    
    $mail->Body    ="<b>มีการร้องขออนุญาตใช้งานรถบริษัท</b>"."<br>".
                    "<b>จุดประสงค์การใช้รถ : </b>".$title."<br>".
                    "<b>ต้นทาง : </b>".$start."<br>".
                    "<b>จุดขึ้นรถ : </b>".$startpoint."<br>".
                    "<b>ปลายทาง : </b>".$finished."<br>".
                    "<b>วันที่ออกเดินทาง : </b>".$fromdate."<b> เวลา </b>".$fromtime."<br>".
                    "<b>วันที่เดินทางกลับ : </b>".$todate."<b> เวลา </b>".$totime."<br>".
                    "------------------------------------------------------------------"."<br>".
                    "<br>"."<b>ลิ้งค์ตรวจสอบ/อนุมัติ : </b>"."<a href='http://".getapplocation()."/approve-mg?requestid=$id&mail=$v'>เลือกที่นี่</a>".
                    "<br>"; 

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                $UpdateStatusSend = sqlsrv_query(
                    $db,
                    "UPDATE CarRequestTrans SET StatusID=? WHERE NumberRequestID =?",
                    array(6,$id)
                );
                echo 1;
                
            }


}
function sendmailmanagerapprove($id,$id_car,$comp,$mailmg) {
        
    $db = db();

    $sql = "SELECT T.NumberRequestID,T.Title,T.Start,T.StartingPoint,T.Finished,T.FromDate,T.ToDate,T.FromTime,T.ToTime,C.InternalCode,T.StatusID,T.CreateBy,U.Email
            FROM CarRequestTrans T
            LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
            LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
            WHERE T.NumberRequestID ='$id'";
        $stmt = sqlsrv_query($db,$sql);
        $obj = sqlsrv_fetch_object( $stmt);
            $start = $obj->InternalCode;
            $startpoint = $obj->StartingPoint;
            $finished = $obj->Finished;
            $fromdate = $obj->FromDate;
            $todate = $obj->ToDate;
            $fromtime = $obj->FromTime;
            $totime = $obj->ToTime;
            $title = $obj->Title;
            $status = $obj->StatusID;
            $careteby_mail = $obj->Email;
    if ($status!=6) {
        echo 2;
        exit();
    }
    
    /*$mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = false;                               
    $mail->Username = 'ea_webmaster@deestone.com';
    $mail->Password = "c,]'4^j";
    $mail->CharSet = "utf-8";
    $mail->Port = 2525; 

    $mail->From = $mailmg;
    $mail->FromName =  $mailmg;
    $mail->addAddress($careteby_mail);
    $mail->isHTML(true);  

    $mail->Subject =  "แจ้งการอนุมัติจากผู้จัดการ";
    
    $mail->Body="แจ้งการอนุมัติจากผู้จัดการ โปรแกรม CarPool"."<br>"."อนุมัติเรียบร้อยร้อยแล้ว";*/
    

    $sql = "SELECT U.Email,
                   U.PermissionID,
                   P.PermissionName,
                   P.CompanyID
            FROM UserMaster U
            LEFT JOIN Permission P ON U.PermissionID=P.PermissionID
            WHERE U.LevelID=4 
            AND P.CompanyID LIKE '%$comp%'
            AND U.Active=1";
    //$sql = "SELECT * FROM UserMaster WHERE LevelID IN ('2','4')";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->Email;
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $mailmg;
        $mail->FromName = $mailmg;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($mailmg, $mailmg);
        // $mail->setFrom('webadministrator@deestone.com', $mailmg);
        // $mail->addReplyTo($mailmg);

        $mail->addAddress($email);
        $mail->isHTML(true);  

        $mail->Subject = "มีการร้องขออนุญาตใช้งานรถบริษัท";
        $mail->Body = "<b>มีการร้องขออนุญาตใช้งานรถบริษัท</b>"."<br>".
                    "<b>จุดประสงค์การใช้รถ : </b>".$title."<br>".
                    "<b>ต้นทาง : </b>".$start."<br>".
                    "<b>จุดขึ้นรถ : </b>".$startpoint."<br>".
                    "<b>ปลายทาง : </b>".$finished."<br>".
                    "<b>วันที่ออกเดินทาง : </b>".$fromdate."<b> เวลา </b>".$fromtime."<br>".
                    "<b>วันที่เดินทางกลับ : </b>".$todate."<b> เวลา </b>".$totime."<br>".
                    "------------------------------------------------------------------"."<br>";

            if(!$mail->send()){
                echo 'Message could not be sent.';
                // echo 'Mailer Error: ' . $mail->ErrorInfo;
                // echo "<br>";
            }else{

                $UpdateStatus = sqlsrv_query(
                    $db,
                    "UPDATE CarRequestTrans SET StatusID=?,ApproveBy=?,ApproveDate=getdate() WHERE NumberRequestID=?",
                    array(2,$mailmg,$id)
                );
                /*if ($UpdateStatus) { 
                    echo 1;
                }else{
                    echo 0;
                }*/
                // echo 1;
                //echo "Message send successful !";
                
            }
    }
    echo 1;
}
function sendmailmanagernoapprove($id,$userby,$mailmg,$remark){
        
    $db = db();
    $sql = "SELECT T.NumberRequestID,T.Title,T.Start,T.StartingPoint,T.Finished,T.FromDate,T.ToDate,T.FromTime,T.ToTime,C.InternalCode,T.StatusID
            FROM CarRequestTrans T
            LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
            WHERE T.CarRequestID ='$id'";
        $stmt = sqlsrv_query($db,$sql);
        $obj = sqlsrv_fetch_object( $stmt);
            $start = $obj->InternalCode;
            $startpoint = $obj->StartingPoint;
            $finished = $obj->Finished;
            $fromdate = $obj->FromDate;
            $todate = $obj->ToDate;
            $fromtime = $obj->FromTime;
            $totime = $obj->ToTime;
            $title = $obj->Title;
            $status = $obj->StatusID;

    $sql = "SELECT * FROM UserMaster WHERE UserID ='$userby' ";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
   
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $mailmg;
        $mail->FromName = $mailmg;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($mailmg, $mailmg);
        // $mail->setFrom('webadministrator@deestone.com', $mailmg);
        // $mail->addReplyTo($mailmg);

        $mail->addAddress($email);
        $mail->isHTML(true);  

        /*$mail->Subject = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท";
        $mail->Body = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท</b>".
                      "<br>"."<b>ผลการอนุมัติ : </b>"."ไม่อนุมัติ".
                      "<br>"."<b>เหตุผล : </b>".$remark;*/

        $mail->Subject = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท";
        $mail->Body = "<b>แจ้งสถานะ การขออนุญาตใช้รถบริษัท</b>"."<br>".
                    "<b>จุดประสงค์การใช้รถ : </b>".$title."<br>".
                    "<b>ต้นทาง : </b>".$start."<br>".
                    "<b>จุดขึ้นรถ : </b>".$startpoint."<br>".
                    "<b>ปลายทาง : </b>".$finished."<br>".
                    "<b>วันที่ออกเดินทาง : </b>".$fromdate."<b> เวลา </b>".$fromtime."<br>".
                    "<b>วันที่เดินทางกลับ : </b>".$todate."<b> เวลา </b>".$totime."<br>".
                    "------------------------------------------------------------------"."<br>".
                    "<b>ผลการอนุมัติ : </b>"."<font color='red'>ไม่อนุมัติ</font>"."<br>".
                    "<b>เหตุผล : </b>".$remark."<br>";
                    

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
                $UpdateStatus = sqlsrv_query(
                    $db,
                    "UPDATE CarRequestTrans SET StatusID=?, Remark=?,ApproveBy=?,ApproveDate=getdate() WHERE NumberRequestID=?",
                    array(9,$remark,$mailmg,$id)
                );
                if ($UpdateStatus) {
                    echo "ดำเนินการสำเร็จ";  
                }else{
                    echo "Error";
                }
               
                //echo "Message send successful !";
                
            }
    }
}
function sendmailmanagernoapprovehr($id,$userby,$mailmg,$remark,$description,$startdate,$starttime,$enddate,$endtime){
        
    $db = db();
    $sql = "SELECT * FROM UserMaster WHERE UserID ='$userby' ";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
   
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $mailmg;
        $mail->FromName = $mailmg;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($mailmg, $mailmg);
        // $mail->setFrom('webadministrator@deestone.com', $mailmg);
        // $mail->addReplyTo($mailmg);
        $mail->addAddress($email);
        $mail->isHTML(true);  

        $mail->Subject = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท";
        $mail->Body = "<b>แจ้งสถานะ การขออนุญาตใช้รถบริษัท</b>".
                      "<b>วันที่ออกเดินทาง : </b>".$startdate."<b> เวลา </b>".$starttime."<br>".
                      "<b>วันที่เดินทางกลับ : </b>".$enddate."<b> เวลา </b>".$endtime."<br>".
                      "<br>"."<b>จุดประสงค์การใช้รถ : </b>".$description.
                      "<br>"."<b>เหตุผล : </b>".$remark;

                      "------------------------------------------------------------------"."<br>".
                      "<b>ผลการอนุมัติ : </b>"."<font color='red'>ไม่อนุมัติ</font>";

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
                $UpdateStatus = sqlsrv_query(
                    $db,
                    "UPDATE CarApproveTrans SET StatusID=? WHERE CarApproveID=?",
                    array(9,$id)
                );
                if ($UpdateStatus) {
                    echo "ดำเนินการสำเร็จ";  
                }else{
                    echo "Error";
                }
               
                //echo "Message send successful !";
                
            }
    }
}
function sendmailmanager_hr($v,$id,$id_request){
    $mail_user = $_SESSION["loggedmail"];    
    $db = db();
        $sql = "SELECT T.Seat,T.Remark,T.StartDate,T.EndDate,T.StartTime,T.EndTime,T.CarRequestID
            FROM CarApproveTrans T
            WHERE T.CarApproveID ='$id'";
        $stmt = sqlsrv_query($db,$sql);
        $obj = sqlsrv_fetch_object( $stmt);
        $seat = $obj->Seat;
        $title = $obj->Remark;
        $fromdate = $obj->StartDate;
        $todate = $obj->EndDate;
        $fromtime = $obj->StartTime;
        $totime = $obj->EndTime;
        $requestid = $obj->CarRequestID;

        $query = "SELECT TOP 1 CM.CompanyDescription,TC.Finished 
            FROM CarRequestTrans TC 
            LEFT JOIN CompanyMaster CM ON TC.Start=CM.CompanyID
            WHERE TC.CarRequestID IN ($requestid)";
        $stmtq = sqlsrv_query($db,$query);
        $objq = sqlsrv_fetch_object( $stmtq);
        $start = $objq->CompanyDescription;
        $finished = $objq->Finished;

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $mail_user;
        $mail->FromName = $mail_user;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($mail_user, $mail_user);
        // $mail->setFrom('webadministrator@deestone.com', $mail_user);
        // $mail->addReplyTo($mail_user);

        $mail->addAddress($v);
        $mail->isHTML(true);
      
        $mail->Subject  =  "ขออนุญาตใช้รถบริษัท";

        $txtremarktrans = str_replace("\n", "<br>\n", "$title"); 

        $txtboby = "";
        $txtboby .= "<style> table, tr, td { border-collapse: collapse; border: 1px solid black; padding: 5px;}</style>";
        $txtboby .= "<b><u>มีการร้องขออนุญาตใช้งานรถบริษัท</u></b><br><br>";
        $txtboby .= "<table>";
        $txtboby .= "<tr><td><b>ต้นทาง</b></td><td>".$start."</td></tr>";
        $txtboby .= "<tr><td><b>ปลายทาง</b></td><td>".$finished."</td></tr>";
        $txtboby .= "<tr><td><b>วันที่ออกเดินทาง</b></td><td>".date('d/m/Y', strtotime($fromdate))." เวลา : ".$fromtime."</td></tr>";
        $txtboby .= "<tr><td><b>วันที่เดินทางกลับ</b></td><td>".date('d/m/Y', strtotime($todate))." เวลา : ".$totime."</td></tr>";
        $txtboby .= "<tr><td><b>จำนวนผู้โดยสาร</b></td><td>".$seat." คน</td></tr>";
        $txtboby .= "<tr><td colspan='2'><b>จุดประสงค์การใช้รถ</b><br>".$txtremarktrans."</td></tr>";
        $txtboby .= "<tr><td><b>ลิ้งค์ตรวจสอบ</b></td><td><a href='http://".getapplocation()."/approve-mghr?id=$id&mail=$v'>เลือกที่นี่</a></td></tr>";
        $txtboby .= "</table>";

        $mail->Body = $txtboby;
        // $mail->Body = "<b>มีการร้องขออนุญาตใช้งานรถบริษัท</b>"."<br>".
        //             "<b>จุดประสงค์การใช้รถ : </b>".$title."<br>".
        //             "<b>จำนวนผู้โดยสาร : </b>".$seat." คน"."<br>".
        //             "<b>วันที่ออกเดินทาง : </b>".$fromdate."<b> เวลา </b>".$fromtime."<br>".
        //             "<b>วันที่เดินทางกลับ : </b>".$todate."<b> เวลา </b>".$totime."<br>".
        //             "------------------------------------------------------------------".
        //             "<br>"."<b>ลิ้งค์ตรวจสอบ : </b>"."<a href='http://".getapplocation()."/approve-mghr?id=$id&mail=$v'>เลือกที่นี่</a>".
        //              "<br>"."(กรณีอยู่ภายนอกบริษัท)"."<b>ลิ้งค์ตรวจสอบ/อนุมัติ : </b>"."<a href='http://203.146.217.77:81/carpool/approve-mghr?id=$id&mail=$v'>เลือกที่นี่</a>"; 

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                // echo "ดำเนินการส่งสำเร็จ !";
                $UpdateStatusCA = sqlsrv_query(
                            $db,
                            "UPDATE CarApproveTrans SET StatusID=? WHERE CarApproveID =?",
                            array(4,$id)
                        );
                $UpdateStatus = sqlsrv_query(
                    $db,
                    "UPDATE CarRequestTrans SET StatusID=? WHERE CarRequestID IN ($id_request)",
                    array(4)
                );
            
                if ($UpdateStatus) {
                    echo "ดำเนินการส่งสำเร็จ !";
                }else{
                    echo "ดำเนินการส่งล้มเหลว !";
                }
            } 
}

function sendmailmanager_hrcomplete($id,$id_request,$mailmg){
    
    $db = db();
        $sql = "SELECT T.StatusID,T.Remark,T.Seat,T.StartDate,T.EndDate,T.StartTime,T.EndTime
            FROM CarApproveTrans T
            WHERE T.CarApproveID ='$id'";
        $stmt = sqlsrv_query($db,$sql);
        $obj = sqlsrv_fetch_object( $stmt);
        $status = $obj->StatusID;
    if ($status!=4) {
        echo 2;
        exit();
    }  

    $sql = "SELECT   T.CarRequestID
                    ,T.CreateBy
                    ,U.Email
            FROM CarRequestTrans T
            LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $txtremarktrans = str_replace("\n", "<br>\n", "$obj->Remark"); 

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    // $mail->Body    = "<b>แจ้งสถานะการขอใช้รถบริษัท</b>"."<br>".
    //                 "<b>จุดประสงค์การใช้รถ : </b>".$txtremarktrans."<br>".
    //                 "<b>จำนวนผู้โดยสาร : </b>".$obj->Seat." คน"."<br>".
    //                 "<b>วันที่ออกเดินทาง : </b>".$obj->StartDate."<b> เวลา </b>".$obj->StartTime."<br>".
    //                 "<b>วันที่เดินทางกลับ : </b>".$obj->EndDate."<b> เวลา </b>".$obj->EndTime."<br>".
    //                 "------------------------------------------------------------------"."<br>".
    //                 "<br>"."<b>สถานะการร้องขอ  : </b>"."<font color='green'>อนุมัติ</font>".
    //                 "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
    $txtboby = "";
    $txtboby .= "<table>";
    $txtboby .= "<tr><td colspan='2'><b>แจ้งสถานะการขอใช้รถบริษัท</b></td></tr>";
    $txtboby .= "<tr><td colspan='2'><b>จุดประสงค์การใช้รถ</b></td></tr>";
    $txtboby .= "<tr><td colspan='2'>".$txtremarktrans."</td></tr>";
    $txtboby .= "<tr><td><b>จำนวนผู้โดยสาร</b></td><td>".$obj->Seat." คน</td></tr>";
    $txtboby .= "<tr><td><b>วันที่ออกเดินทาง</b></td><td>".date('d/m/Y', strtotime($obj->StartDate))."</td></tr>";
    $txtboby .= "<tr><td><b>วันที่เดินทางกลับ</b></td><td>".date('d/m/Y', strtotime($obj->EndDate))."</td></tr>";
    $txtboby .= "<tr><td><b>สถานะการร้องขอ</b></td><td><font color='green'>อนุมัติ</font></td></tr>";
    $txtboby .= "<tr><td><b>รายละเอียด</b></td><td><a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a></td></tr>";
    $txtboby .= "</table>";
    
    $mail->Body = $txtboby;

        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            echo "<br>";
        }else{
            $UpdateApproveBy = sqlsrv_query(
                $db,
                "UPDATE CarApproveTrans SET StatusID=?,ApproveBy=?,ApproveDate=getdate() WHERE CarApproveID=?",
                array(5,$mailmg,$id)
            );
            $UpdateStatus = sqlsrv_query(
                $db,
                "UPDATE CarRequestTrans SET StatusID=?, ApproveByAdmin=? WHERE CarRequestID IN($id_request)",
                array(5,$mailmg)
            );
            
            
        } 
    }
    //echo "ดำเนินการส่งสำเร็จ !";

    //sendadminhr
     $sql = "SELECT   T.CarRequestID
                    ,T.CreateByAdmin
                    ,U.Email
            FROM CarRequestTrans T
            LEFT JOIN UserMaster U ON T.CreateByAdmin=U.UserID
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    
    $mail->Body    ="<b>แจ้งสถานะการขอใช้รถบริษัท</b>".
                    "<br>"."<b>สถานะการร้องขอ  : </b>"."อนุมัติ".
                    "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
 

            if(!$mail->send()){
                echo 'Message could not be sent AdminHr.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
            } 
    }

    //sendmanageruser
     $sql = "SELECT   T.CarRequestID
                      ,T.ApproveBy
            FROM CarRequestTrans T
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->ApproveBy;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    
    $mail->Body    ="<b>แจ้งสถานะการขอใช้รถบริษัท</b>".
                    "<br>"."<b>สถานะการร้องขอ  : </b>"."อนุมัติ".
                    "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
 

            if(!$mail->send()){
                echo 'Message could not be sent AdminHr.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
            } 
    }
    echo 1;
    //echo "ดำเนินการส่งสำเร็จ !";
}

function sendmailadmin_hrcomplete($a_id,$id_request,$mailmg){
    
    $db = db();
    
    $sql = "SELECT   T.CarRequestID
                    ,T.CreateBy
                    ,U.Email
            FROM CarRequestTrans T
            LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    
    $mail->Body    ="<b>แจ้งสถานะการขอใช้รถบริษัท</b>".
                    "<br>"."<b>สถานะการร้องขอ  : </b>"."อนุมัติ".
                    "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
 

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                $UpdateApproveBy = sqlsrv_query(
                    $db,
                    "UPDATE CarApproveTrans SET StatusID=?,ApproveBy=?,ApproveDate=getdate() WHERE CarApproveID=?",
                    array(5,$mailmg,$id)
                );
                $UpdateStatus = sqlsrv_query(
                    $db,
                    "UPDATE CarRequestTrans SET StatusID=?, ApproveByAdmin=? WHERE CarRequestID IN($id_request)",
                    array(5,$mailmg)
                );
                
                
            } 
    }
    //echo "ดำเนินการส่งสำเร็จ !";

    //sendadminhr
     $sql = "SELECT   T.CarRequestID
                    ,T.CreateByAdmin
                    ,U.Email
            FROM CarRequestTrans T
            LEFT JOIN UserMaster U ON T.CreateByAdmin=U.UserID
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->Email;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    
    $mail->Body    ="<b>แจ้งสถานะการขอใช้รถบริษัท</b>".
                    "<br>"."<b>สถานะการร้องขอ  : </b>"."อนุมัติ".
                    "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
 

            if(!$mail->send()){
                echo 'Message could not be sent AdminHr.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
            } 
    }

    //sendmanageruser
     $sql = "SELECT   T.CarRequestID
                      ,T.ApproveBy
            FROM CarRequestTrans T
            WHERE T.CarRequestID IN ($id_request)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email = $res->ApproveBy;
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailmg;
    $mail->FromName = $mailmg;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailmg, $mailmg);
    // $mail->setFrom('webadministrator@deestone.com', $mailmg);
    // $mail->addReplyTo($mailmg);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject =  "อนุมัติการขออนุญาตใช้รถบริษัท";
    
    $mail->Body    ="<b>แจ้งสถานะการขอใช้รถบริษัท</b>".
                    "<br>"."<b>สถานะการร้องขอ  : </b>"."อนุมัติ".
                    "<br>"."<b>รายละเอียด : </b>"."<a href='http://".getapplocation()."/detail-complete.php?id=$id'>เลือกที่นี่</a>"; 
 

            if(!$mail->send()){
                echo 'Message could not be sent AdminHr.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                
            } 
    }
    echo 1;
    //echo "ดำเนินการส่งสำเร็จ !";
}

function sendmailregister($email_u,$name,$tel,$telme,$comp,$dep) {
       
    $db = db();
    $sql = "SELECT U.Email
                  ,U.LevelID
            FROM UserMaster U
            WHERE U.LevelID= 4";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
    $email_hr = $res->Email;
   
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $email_u;
        $mail->FromName = $email_u;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($email_u, $email_u);
        // $mail->setFrom('webadministrator@deestone.com', $email_u);
        // $mail->addReplyTo($email_u);

        $mail->addAddress($email_hr);
        $mail->isHTML(true);  

        $mail->Subject = "แจ้งการร้องขอ Username ใช้งานระบบ CarPool";
        $mail->Body = "<b>E-mail : </b>".$email_u."<br>".
                      "<b>ชื่อนามสกุล : </b>".$name."<br>".
                      "<b>บริษัท : </b>".$comp."<br>".
                      "<b>แผนก : </b>".$dep."<br>".
                      "<b>เบอร์โทรแผนก : </b>".$tel."<br>".
                      "<b>เบอร์โทรส่วนตัว : </b>".$telme."<br>".
                      "<b>อนุมัติการใช้งาน : </b>"."<a href='http://".getapplocation()."/hr-approve-register?email=$email_u'>คลิ๊กที่นี่</a>";

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{

                echo '<script>';
                echo 'alert("สมัครเรียบร้อย รอการอนุมัติการเข้าใช้งานจาก HR");'; 
                //echo 'window.close();';
                echo 'location.href="./login"';
                echo '</script>';
               
                //echo "Message send successful !";
                
            }
    }
}

function sendmailregister_active($email,$pw) {
    $mailit = 'it_ea@deestone.com';
    $db = db();
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  
    $mail->SMTPAuth = true;  
    $mail->SMTPSecure = "ssl";                             
    $mail->Username = 'webadministrator@deestone.com';
    // $mail->Password = 'E.D.ev53team9341';
    $mail->Password = 'W@dmIn$02587';
    $mail->CharSet = "utf-8";
    $mail->Port = 465; 
    $mail->SMTPOptions = array( 
        'ssl' => array( 
            'verify_peer' => false, 
            'verify_peer_name' => false, 
            'allow_self_signed' => true 
        ) 
    );
    $mail->From = $mailit;
    $mail->FromName = $mailit;
    $mail->Sender = 'webadministrator@deestone.com';
    // $mail->setFrom($mailit, $mailit);
    // $mail->setFrom('webadministrator@deestone.com', $mailit);
    // $mail->addReplyTo($mailit);

    $mail->addAddress($email);
    $mail->isHTML(true);  

    $mail->Subject = "แจ้งสถานะ การขอใช้งานระบบ CarPool";
    $mail->Body = "<b>แจ้งสถานะ : </b>สามารถเข้าใช้งานระบบ CarPool ได้แล้ว"."<br>".
                  "<b>Email : </b>".$email."<br>".
                  "<b>Password : </b>".$pw."<br>".
                  "<b>ลิงค์เข้าใช้งาน : </b>"."<a href='http://".getapplocation()."'>คลิ๊กที่นี่</a>";

    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        echo "<br>";
    }else{
        $UpdatePasswordUser = sqlsrv_query(
                  $db,
                  "UPDATE UserMaster SET Password=? WHERE Email=?",
                  array($pw,$email)
        );
        if ($UpdatePasswordUser) {
            echo '<script>';
            echo 'alert("Active User Succesful!");'; 
            echo 'window.close();';
            echo '</script>';

        }else{
            echo '<script>';
            echo 'alert("Active Error!");'; 
            echo '</script>';
        }
        //echo "Message send successful !";
        
    }

}

function sendmailcancel($record,$remark){
        
    $db = db();
    $mailf = $_SESSION["loggedmail"];
    $sql = "SELECT T.CreateBy,U.Email,T.Seat,T.FromDate,T.FromTime,T.ToDate,T.ToTime
            FROM CarRequestTrans T
            LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
            WHERE T.CarRequestID IN ($record)";
    $rs = sqlsrv_query($db,$sql);
    while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->Email;
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'idc.deestone.com';  
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = "ssl";                             
        $mail->Username = 'webadministrator@deestone.com';
        // $mail->Password = 'E.D.ev53team9341';
        $mail->Password = 'W@dmIn$02587';
        $mail->CharSet = "utf-8";
        $mail->Port = 465; 
        $mail->SMTPOptions = array( 
            'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
            ) 
        );
        $mail->From = $mailf;
        $mail->FromName = $mailf;
        $mail->Sender = 'webadministrator@deestone.com';
        // $mail->setFrom($mailf, $mailf);
        // $mail->setFrom('webadministrator@deestone.com', $mailf);
        // $mail->addReplyTo($mailf);

        $mail->addAddress($email);
        $mail->isHTML(true);  

        $mail->Subject = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท";
        $mail->Body = "<b>แจ้งสถานะ การขออนุญาตใช้รถบริษัท</b>".
                    "<br>"."<b>ผลการอนุมัติ : </b>"."<font color='red'>ไม่อนุมัติ</font>".
                    "<br>"."<b>จำนวนผู้โดยสาร : </b>".$res->Seat." คน<br>".
                    "<b>วันที่ออกเดินทาง : </b>".date('d/m/Y', strtotime($res->FromDate))."<b> เวลา </b>".
                    $res->FromTime."<br>".
                    "<b>วันที่เดินทางกลับ : </b>".date('d/m/Y', strtotime($res->ToDate))."<b> เวลา </b>".
                    $res->ToTime."<br>".
                    "------------------------------------------------------------------".
                    "<br>"."<b>เหตุผล : </b>".$remark;

            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                echo "<br>";
            }else{
                echo "1";
                // echo "Message send successful !";
                
            }
    }
    //echo "ดำเนินการส่งสำเร็จ";
    //sendmanageruser
    // $mailf = $_SESSION["loggedmail"];
    // $sql = "SELECT T.ApproveBy
    //         FROM CarRequestTrans T
    //         WHERE T.CarRequestID IN ($record)";
    // $rs = sqlsrv_query($db,$sql);
    // while ($res = sqlsrv_fetch_object($rs)) {
    // $email = $res->ApproveBy;
   
    //     $mail = new PHPMailer;
    //     $mail->isSMTP();
    //     $mail->Host = 'idc.deestone.com';  
    //     $mail->SMTPAuth = false;                               
    //     $mail->Username = 'ea_webmaster@deestone.com';
    //     $mail->Password = "c,]'4^j";
    //     $mail->CharSet = "utf-8";
    //     $mail->Port = 2525; 

    //     $mail->From = $mailf;
    //     $mail->FromName = $mailf;
    //     $mail->addAddress($email);
    //     $mail->isHTML(true);  

    //     $mail->Subject = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท";
    //     $mail->Body = "แจ้งสถานะ การขออนุญาตใช้รถบริษัท</b>".
    //                   "<br>"."<b>ผลการอนุมัติ : </b>"."ไม่อนุมัติ".
    //                   "<br>"."<b>เหตุผล : </b>".$remark;

    //         if(!$mail->send()){
    //             echo 'Message could not be sent.';
    //             echo 'Mailer Error: ' . $mail->ErrorInfo;
    //             echo "<br>";
    //         }else{
    //             //echo "1";
    //             //echo "Message send successful !";
                
    //         }
    // }
    // echo "ดำเนินการส่งสำเร็จ";
}

function sendmailcancel_user($status,$carappid,$id){
    $db = db();
    $mailf = $_SESSION["loggedmail"];
    if ($status==2) {
        //echo "confirm";
        $sql = "SELECT ApproveBy
                FROM CarRequestTrans 
                WHERE NumberRequestID='$id' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->ApproveBy;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);

            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }else{
                    echo "Cancel Success !";      
                }
        }

    }else if ($status==3) {
        //echo "approve";
        $sql = "SELECT ApproveBy
                FROM CarRequestTrans 
                WHERE NumberRequestID='$id' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->ApproveBy;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);

            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }
        }
        $sql = "SELECT T.CreateBy,U.Email
                FROM CarApproveTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                WHERE T.CarApproveID='$carappid' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->Email;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);

            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }
        }
        echo "Cancel Success!";
    }else if ($status==4 || $status==5) {
        //echo "wait complete";
        $sql = "SELECT ApproveBy
                FROM CarRequestTrans 
                WHERE NumberRequestID='$id' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->ApproveBy;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);

            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }
        }
        $sql = "SELECT T.CreateBy,U.Email
                FROM CarApproveTrans T
                LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
                WHERE T.CarApproveID='$carappid' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->Email;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);

            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }
        }
        $sql = "SELECT ApproveBy
                FROM CarApproveTrans
                WHERE CarApproveID='$carappid' ";
        $rs = sqlsrv_query($db,$sql);
        while ($res = sqlsrv_fetch_object($rs)) {
        $email = $res->ApproveBy;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'idc.deestone.com';  
            $mail->SMTPAuth = true;  
            $mail->SMTPSecure = "ssl";                             
            $mail->Username = 'webadministrator@deestone.com';
            // $mail->Password = 'E.D.ev53team9341';
            $mail->Password = 'W@dmIn$02587';
            $mail->CharSet = "utf-8";
            $mail->Port = 465; 
            $mail->SMTPOptions = array( 
                'ssl' => array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            );
            $mail->From = $mailf;
            $mail->FromName = $mailf;
            $mail->Sender = 'webadministrator@deestone.com';
            // $mail->setFrom($mailf, $mailf);
            // $mail->setFrom('webadministrator@deestone.com', $mailf);
            // $mail->addReplyTo($mailf);
        
            $mail->addAddress($email);
            $mail->isHTML(true);  

            $mail->Subject = "แจ้งสถานะ การขอยกเลิกใช้รถบริษัท";
            $mail->Body = "แจ้งสถานะ การขอยกเลิกช้รถบริษัท</b>";

                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "<br>";
                }
        }
        echo "Cancel Success!";
    }
}

function getapplocation()
{
    return "43.225.140.94:8003";
}