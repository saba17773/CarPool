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
			      ,T.CreateDate
			      ,T.ApproveBy
			      ,T.ApproveDate
			      ,C.CarRegistration
			      ,C.CarTypeID
			      ,CT.CarTypeName
				  ,D.DriverName
				  ,D.Tel
				  ,T.Seat
    		FROM CarApproveTrans T 
    		LEFT JOIN CarMaster C ON T.CarID=C.CarID
    		LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
    		LEFT JOIN DriverMaster D ON T.DriverID=D.DriverID
    		WHERE  T.CarRequestID LIKE '%$id%'";
    $stmt = sqlsrv_query($db,$sql);
    $obj = sqlsrv_fetch_object( $stmt);

    
?>
<html>
<head>
	<title>Carpool</title>
</head>
<style>
	table {
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
}

td, tr {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 10px;
}



</style>
<body>
<div class="container">
	<h2 align="center" style="background-color:#018EC3;"><b>ใบขออนุญาตใช้รถบริษัท / สำหรับผู้ใช้งาน</b></h2> 
	<table>
		<tr>
			<td align="right" colspan="6">
				<b>วันที่</b> 
				<?php
					$date=date_create($obj->CreateDate);
					echo date_format($date,"d/m/Y");
				?>
			</td>
		</tr>
		<tr>
			<td width="25%">
				<b>ต้องการใช้วันที่</b>
				<?php
					$date=date_create($obj->StartDate);
					echo date_format($date,"d/m/Y");
				?>
			</td>
			<td width="25%">
				<b>เวลารถออก</b> 
				<?php echo substr($obj->StartTime,0,-3); ?>
			</td>
			<td width="25%">
				<b>วันที่เดินทางถึง</b>
				<?php
					$date=date_create($obj->EndDate);
					echo date_format($date,"d/m/Y");
				?>
			</td>
			<td width="25%">
				<b>เวลารถกลับ</b> 
				<?php echo substr($obj->EndTime,0,-3); ?>
			</td>
		</tr>
		<tr>
			<td>
				<b>ประเภทรถ</b> <?php echo $obj->CarTypeName; ?>
			</td>
			<td>
				<b>ทะเบียนรถ</b> <?php echo $obj->CarRegistration; ?>
			</td>
			<td colspan="2">
				<b>จำนวนผู้โดยสาร</b> <?php echo $obj->Seat; ?> คน
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>ชื่อพนักงานขับรถ</b> <?php echo $obj->DriverName; ?>
			</td>
			<td colspan="2">
				<b>เบอร์ติดต่อ</b> <?php echo $obj->Tel; ?>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<b>รายละเอียดการใช้รถ</b> <br>
				<?php //echo $obj->Remark; 
				$txtremarktrans= str_replace("\n", "<br>\n", "$obj->Remark"); 
				echo $txtremarktrans;
				?>
			</td>
		</tr>
		
		<?php 
			$sql = "SELECT T.CreateBy
						   ,U.Name 
						   ,U.Tel
						   ,T.UserAllow
						   ,T.UserAllowPhone
					FROM CarRequestTrans T
					LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
					WHERE T.CarRequestID IN ($obj->CarRequestID)";
			$rs = sqlsrv_query($db,$sql);
		    while ($res = sqlsrv_fetch_object($rs)) {
		    
		?>	
		<tr>
			<td colspan="2">
				<b>รายชื่อผู้ขอ</b> <?php echo $res->Name; ?> <br>
				<b>เบอร์ติดต่อ</b> <?php echo $res->Tel; ?>	
			</td>
			<td colspan="2">
			<b>กรณีขอให้</b>
			<?php if ($res->UserAllow!="") {
			echo $res->UserAllow."<br>"."<b>"."เบอร์ติดต่อ "."</b>".$res->UserAllowPhone;
			}else{
				echo "-";
			} ?>
			</td>
		</tr>
		<?php }
		 ?>
	</table>
</div>
</body>
</html>
<?php
require('./mpdf60/mpdf.php'); 
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th','A5-L'); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html);
$pdf->Output();
?>