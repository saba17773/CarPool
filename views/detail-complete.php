<?php 
	//ob_start(); 
	$serverName = "xxxxxxxxxx";
	$uid = "xx";
	$pwd = 'xx';
	$dbname = "xx";


	$connectionInfo = array( 
		"Database"=>"$dbname", 
		"UID"=>"$uid", 
		"PWD"=>"$pwd",
		"CharacterSet" => "UTF-8",
		"ReturnDatesAsStrings"=>true,
		"MultipleActiveResultSets"=>true);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

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
				  ,T.Seat
    		FROM CarApproveTrans T 
    		LEFT JOIN CarMaster C ON T.CarID=C.CarID
    		LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
    		LEFT JOIN DriverMaster D ON T.DriverID=D.DriverID
    		WHERE T.CarApproveID =1";
    $stmt = sqlsrv_query($db,$sql);
    $obj = sqlsrv_fetch_object( $stmt);
?>
<style type="text/css">
tr {
    height: 30px;
}
</style>
<div class="container">
    <h3><b>ใบขออนุญาตใช้รถบริษัท / สำหรับผู้ใช้งาน</b></h3>
    <table width="100%">
        <tr>
            <td align="right" colspan="6">
                <b>วันที่</b> <?php echo $obj->CreateDate; ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <b>ต้องการใช้วันที่</b> <?php echo $obj->StartDate; ?>
            </td>
            <td width="25%">
                <b>เวลารถออก</b> <?php echo $obj->StartTime; ?>
            </td>
            <td width="25%">
                <b>วันที่เดินทางถึง</b> <?php echo $obj->EndDate; ?>
            </td>
            <td width="25%">
                <b>เวลารถกลับ</b> <?php echo $obj->EndTime; ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <b>ชื่อพนักงานขับรถ</b> <?php echo $obj->DriverName; ?>
            </td>
            <td width="25%">
                <b>ประเภทรถ</b> <?php echo $obj->CarTypeName; ?>
            </td>
            <td width="25%">
                <b>ทะเบียนรถ</b> <?php echo $obj->CarRegistration; ?>
            </td>
            <td width="25%">
                <b>จำนวนผู้โดยสาร</b> <?php echo $obj->Seat; ?>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <b>รายระเอียดการใช้รถ</b> <?php echo $obj->Remark; ?>
            </td>
        </tr>
    </table>
</div>

<?php
require('./mpdf60/mpdf.php'); 
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th','A4'); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html);
$pdf->Output();
?>