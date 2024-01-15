<?php  
	ob_start(); 
	require 'connect.php';
	$db = $conn;
	$id = $_GET["id"];
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
			      ,U.Name AS usercreate
			      ,DP.DepartmentDescription
			      ,T.CreateDate
			      ,T.ApproveBy
			      ,UM.Name AS mgapprove
			      ,T.ApproveDate
			      ,C.CarRegistration
			      ,C.CarTypeID
			      ,CT.CarTypeName
				  ,D.DriverName
				  ,D.Tel
				  ,T.Seat
				  -- ,CM.InternalCode
    		FROM CarApproveTrans T 
    		LEFT JOIN CarMaster C ON T.CarID=C.CarID
    		LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
    		LEFT JOIN DriverMaster D ON T.DriverID=D.DriverID
    		LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
    		LEFT JOIN DepartmentMaster DP ON U.Department=DP.DepartmentID
    		LEFT JOIN UserMaster UM ON T.ApproveBy=UM.Email
    		-- LEFT JOIN CarRequestTrans TT ON T.CarRequestID=TT.CarRequestID
    		-- LEFT JOIN CompanyMaster CM ON TT.Start=CM.CompanyID 
    		WHERE T.CarRequestID IN ('$id')";
    $stmt = sqlsrv_query($db,$sql);
    $obj = sqlsrv_fetch_object( $stmt);
?>
<!DOCTYPE html>
<html>
<head>
	<title>แบบฟอร์มขออนุมัติใช้รถตู้ กลุ่มบริษัท ดีสโตน</title>
</head>
<style type="text/css">
	h3 {
		font-family: "THSarabun";
		font-size: 20pt;
	}
	table, tr, td {
      font-family: "THSarabun";
      font-size: 17pt;
      padding: 5px;
      /*border-collapse: collapse;*/
      /*border: 1px solid black;*/
    }
    table{
    	border: 1px solid black;
    }
    table#noline,tr#noline,td#noline{
    	font-size: 17pt;
	    border: 0px solid black;
	    /*border-collapse: collapse;*/
	}
</style>

<?php  
	$month_arr=array(
	    "0"=>"",
	    "01"=>"มกราคม",
	    "02"=>"กุมภาพันธ์",
	    "03"=>"มีนาคม",
	    "04"=>"เมษายน",
	    "05"=>"พฤษภาคม",
	    "06"=>"มิถุนายน", 
	    "07"=>"กรกฎาคม",
	    "08"=>"สิงหาคม",
	    "09"=>"กันยายน",
	    "10"=>"ตุลาคม",
	    "11"=>"พฤศจิกายน",
	    "12"=>"ธันวาคม"                 
	);
?>

<body>
	<h3 align="center"><u>แบบฟอร์มขออนุมัติใช้รถตู้ กลุ่มบริษัท ดีสโตน</u></h3>
	<table width="100%" id="noline">
		<tr id="noline">
			<td id="noline" width="50%"></td>
			<td id="noline" width="50%" align="right">
				วันที่ 
				<u>
				<?php 
					$date=date_create($obj->CreateDate);
					echo date_format($date,"d"); 
				?>
				</u>
				เดือน 
				<u>
				<?php 
					$date=date_create($obj->CreateDate);
					$m = date_format($date,"m");
					echo $month_arr[$m];
				?>
				</u>
				พ.ศ.
				<u>
				<?php 
					$date=date_create($obj->CreateDate);
					echo date_format($date,"Y")+543; 
				?>
				</u>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="50%" colspan="2">
				ชื่อผู้ขอใช้รถ <u> <?php echo $obj->usercreate; ?> </u>
			</td>
			<td width="50%" colspan="2">
				แผนก <u> <?php echo $obj->DepartmentDescription; ?> </u>
			</td> 
		</tr>
		<tr>
			<td width="35%">
				ต้องการใช้รถวันที่ 
				<u>
				<?php 
					$date=date_create($obj->StartDate);
					echo date_format($date,"d/m/Y"); 
				?>
				</u>
			</td>
			<td width="25%">
				เวลารถออก
				<u> <?php echo substr($obj->StartTime,0,-3); ?> </u>
			</td>
			<td width="25%">
				เวลารถกลับ 
				<u> <?php echo substr($obj->EndTime,0,-3); ?> </u>
			</td>
			<td width="15%"></td>
		</tr>
		<tr>
			<td colspan="4">
				จุดประสงค์ที่ต้องการใช้รถ
				<u> 
				<?php 
					$txtremarktrans= str_replace("\n", "<br>\n", "$obj->Remark"); 
					echo $txtremarktrans;
				?> 
				</u>
			</td>
		</tr>
		<tr>
			<td>
				จำนวนผู้โดยสาร 
				<u> <?php echo $obj->Seat; ?> </u>
				คน
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<table width="100%" id="noline">
					<tr id="noline">
						<td id="noline" colspan="4">
							ลงชื่อผู้ขอ <u> <?php echo $obj->usercreate; ?> </u>
						</td>
					</tr>
					<tr id="noline">
						<td id="noline" colspan="4">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							วันที่ 
							<u>
								<?php 
									$date=date_create($obj->StartDate);
									echo date_format($date,"d/m/Y"); 
								?>
							</u>
						</td>
					</tr>
					<tr id="noline">
						<td id="noline" width="50%" colspan="2">
							ผู้ตรวจสอบ
							&nbsp;
							<u> <?php echo $obj->mgapprove; ?> </u>
							&nbsp;
							ผู้จัดการฝ่าย
						</td>
						<td id="noline" width="25%">
							ผู้พิจารณา
						</td>
						<td id="noline" width="25%" align="right">
							ผู้อำนวยการฝ่าย
						</td>
					</tr>
					<tr id="noline">
						<td id="noline">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							วันที่
							<u>
								<?php 
									$date=date_create($obj->ApproveDate);
									echo date_format($date,"d/m/Y"); 
								?>
							</u>
						</td>
						<td id="noline"></td>
						<td id="noline">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							วันที่......./......./.......
						</td>
						<td id="noline"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table width="100%">
		<tr>
			<td colspan="3">
				ความเห็นประธานเจ้าหน้าที่บริหาร
			</td>
		</tr>
		<tr>
			<td width="5%"></td>
			<td width="30%">
				<?php echo "<img src='/img/boxfalse.png' width='2%' height='15px'>"; ?>
				อนุมัติ
			</td>
			<td width="15%"></td>
			<td width="50%"></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
				<?php echo "<img src='/img/boxfalse.png' width='2%' height='15px'>"; ?>
				ไม่อนุมัติ .........................................
			</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2">
				<br>
				ลงชื่อ .........................................
				<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				ประธานเจ้าหน้าที่บริหาร
				<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				วันที่......./......./.......
			</td>
		</tr>
	</table>

	<table width="100%">
		<tr>
			<td colspan="2">
				<u>สำหรับฝ่ายทรัพยากรบุคคลและธุรการ</u>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				พนักงานขับรถชื่อ
				<u> <?php echo $obj->DriverName; ?> </u>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				ผู้อนุมัติให้นำรถ &nbsp;&nbsp;<u> <?php echo $obj->CarTypeName; ?> </u>&nbsp;&nbsp;
				หมายเลขทะเบียน &nbsp;&nbsp;<u> <?php echo $obj->CarRegistration; ?> </u>&nbsp;&nbsp;
				ไปสถานที่ที่ระบุไว้ตามใบขอใช้รถได้
			</td>
		</tr>
		<tr>
			<td width="50%"></td>
			<td width="50%">
				<table width="100%" id="noline">
					<tr id="noline">
						<td id="noline">
							ลงชื่อผู้อนุมัติ
							&nbsp;
							<u> <?php echo $obj->mgapprove; ?> </u>
							&nbsp;
							หน.ส่วน/ผจก.ฝ่าย
							<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;
							วันที่ 
							<u>
								<?php 
									$date=date_create($obj->ApproveDate);
									echo date_format($date,"d/m/Y"); 
								?>
							</u>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>
</html>
<?php
require('./mpdf/mpdf/mpdf.php'); 
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th','A4', 0, '', 5, 5, 5, 5);
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html);
$pdf->Output();
?>