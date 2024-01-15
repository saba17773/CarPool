<?php $this->layout("layout-base-defalut"); ?>
<?php 
  if (!isset($_GET["id"])) {
    echo "no params";
    exit();
  }
?>
<?php 
	$db = db();
	$id = $_GET["id"];
	$mailmg = $_GET["mail"];
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
				  ,T.StatusID
    		FROM CarApproveTrans T 
    		LEFT JOIN CarMaster C ON T.CarID=C.CarID
    		LEFT JOIN CarTypeMaster CT ON C.CarTypeID=CT.CarTypeID
    		LEFT JOIN DriverMaster D ON T.DriverID=D.DriverID
    		WHERE T.CarApproveID ='$id'";
    $stmt = sqlsrv_query($db,$sql);
    $obj = sqlsrv_fetch_object( $stmt);
?>
<?php 
if ($obj->StatusID!=4) { 
?>
<div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4>Warning!</h4>
  <p>รายการนี้ได้ดำเนินการอนุมัติไปแล้ว</p>
</div>
<?php
}
?>
<style type="text/css">
	 tr {
            height: 30px;
        }

</style>
<div class="container">
	<h3><b>ใบขออนุญาตใช้รถบริษัท / สำหรับฝ่ายทรัพยากรบุคคล</b></h3>
	<table width="100%">
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
        $startdate=date_create($obj->StartDate);
        echo date_format($startdate,"d/m/Y");  
        ?>
			</td>
			<td width="25%">
				<b>เวลารถออก</b> <?php echo $obj->StartTime; ?>
			</td>
			<td width="25%">
				<b>วันที่เดินทางถึง</b> 
        <?php 
        $EndDate=date_create($obj->EndDate);
        echo date_format($EndDate,"d/m/Y");  
        ?>
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
				<b>จำนวนผู้โดยสาร</b> <?php echo $obj->Seat; ?> คน
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<b>รายละเอียดการใช้รถ</b> <br>
        <?php
        $txtremarktrans= str_replace("\n", "<br>\n", $obj->Remark); 
        echo $txtremarktrans;
        ?>
        <input type='hidden' id='description_remark' value='<?php echo $obj->Remark; ?>' >
			</td>
		</tr>
		<tr>
			<td colspan="6" align="center">
				<button class="btn btn-success" id="approve" style="width:100px;">อนุมัติ</button>
    			<button class="btn btn-danger"  id="noapprove" style="width:100px;">ไม่อนุมัติ</button>
			</td>
		</tr>
	</table>
</div>

<div id="dialogremark">
        <div><strong>Remark</strong></div>
        <div>
        <form id="remark" class="form-horizontal">
                <div class="col-sm-12">
                    <label>โปรดกรอกเหตุผล</label>
                    <textarea class="form-control" name="txtremark" id="txtremark" rows="4" cols="70"></textarea>
                </div>
                <div class="col-sm-12">
				  <hr>
				</div>
            	<div class="col-sm-12" align="right">
                    <button  type="submit" class="btn btn-primary" id="saveremark">Save</button>
                </div>
        </form>
        </div>
</div>

<div id="myModal" class="modal">
    <br><br><br>
    <center class="container">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">แจ้งสถานะการอนุมัติ</h3>
      </div>
      <div class="panel-body">
        การอนุมัติคำร้องประสบความสำเร็จ! 
      </div>
    </div>
    </center>
</div>

<div id="myModal_No" class="modal">
    <br><br><br>
    <center class="container">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title">แจ้งสถานะการไม่อนุมัติ</h3>
      </div>
      <div class="panel-body">
        การไม่อนุมัติคำร้องประสบความสำเร็จ! 
      </div>
    </div>
    </center>
</div>

<div id="myModal_Chk" class="modal">
    <br><br><br>
    <center class="container">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">แจ้งสถานะการอนุมัติ</h3>
      </div>
      <div class="panel-body">
        ไม่สามารถอนุมัติรายการนี้ได้  เนื่องจากมีการอนุมัติไปแล้ว!
      </div>
    </div>
    </center>
</div>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    
  var statusid = '<?php echo $obj->StatusID; ?>';

  if (statusid!=4) {
    $('#approve').hide();
    $('#noapprove').hide();
  }

	$('#approve').on('click',function(){
			$('#approve').prop('disabled',true);
			$('#noapprove').prop('disabled',true);
            $('#approve').val('รอสักครู่...'); 
            var id = '<?php echo $obj->CarApproveID; ?>';
            var id_request = '<?php echo $obj->CarRequestID; ?>';
            var mailmg = '<?php echo $mailmg; ?>';

            $.ajax({
                url : './mghrapprove',
                type : 'post',
                data : {
                  id : id,
                  id_request : id_request,
                  mailmg : mailmg
                },
                success : function(data){
                    if (data==1) {
                        $('#myModal').show();
                        // function CloseWindowsInTime(t){
                        //   t = t*1000;
                        //   setTimeout("window.close()",t);
                        //   }
                        // CloseWindowsInTime(5); 
                        setTimeout(function(){
                            window.open('', '_self', '');
                            window.close();
                        }, 3000);
                    }else if(data==2){
                        $('#myModal_Chk').show();
                        // function CloseWindowsInTime(t){
                        //   t = t*1000;
                        //   setTimeout("window.close()",t);
                        //   }
                        // CloseWindowsInTime(5); 
                        setTimeout(function(){
                            window.open('', '_self', '');
                            window.close();
                        }, 3000);
                    }
                }
            });
	});

	var theme_r = 'ui-redmond';	
	$('#dialogremark').jqxWindow({
             width : 500,
             height : 280,
             autoOpen : false,
             isModal : true,
             theme : theme_r      
    });

	$('#noapprove').on('click',function(){
		$('#dialogremark').jqxWindow('open');
	});

	$('#remark').submit(function(e){
        e.preventDefault();
       	var userby      = '<?php echo $obj->CreateBy; ?>';
       	var mailmg      = '<?php echo $mailmg; ?>';
       	var id          = '<?php echo $obj->CarApproveID; ?>';
        var startdate   = '<?php echo $obj->StartDate; ?>';
        var starttime   = '<?php echo $obj->StartTime; ?>';
        var enddate     = '<?php echo $obj->EndDate; ?>';
        var endtime     = '<?php echo $obj->EndTime; ?>';
        if($.trim($('#txtremark').val())==''){
            gotify("กรุณากรอกเหตุผล","danger")
        }else{
        	$('#dialogremark').jqxWindow('close');
        	$.ajax({
                url : './mgnoapprovehr',
                type : 'post',
                data : {
                  id          : id,
                  mailmg      : mailmg,
                  userby      : userby,
                  remark      : $('#txtremark').val(),
                  description : $('#description_remark').val(),
                  startdate   : startdate,
                  starttime   : starttime,
                  enddate     : enddate,
                  endtime     : endtime
                },
                success : function(data){
                    $('#myModal_No').show();
                      function CloseWindowsInTime(t){
                        t = t*1000;
                        setTimeout("window.close()",t);
                        }
                      CloseWindowsInTime(5); 
                }
            });
        }
  });

	});
</script>
