<?php $this->layout("layout-base-defalut"); ?>
<?php 
  if (!isset($_GET["requestid"])) {
    echo "no params";
    exit();
  }
?>
<?php 
		$db = db();
		$id = $_GET["requestid"];
		$mailmg = $_GET["mail"];
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
                      ,U.Department
                      ,U.Company
                      ,D.DepartmentDescription
                      ,C.InternalCode
        		FROM CarRequestTrans T 
        		LEFT JOIN UserMaster U ON T.CreateBy=U.UserID
        		LEFT JOIN DepartmentMaster D ON U.Department=D.DepartmentID 
            LEFT JOIN CompanyMaster C ON T.Start=C.CompanyID
        		WHERE NumberRequestID='$id'";
        $stmt = sqlsrv_query($db,$sql);
        $obj = sqlsrv_fetch_object( $stmt);
        

?>

<?php 
if ($obj->StatusID!=6) { 
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
	<h3><b>ใบขออนุญาตใช้รถบริษัท</b></h3>
	<table width="100%">
		<tr>
			<td align="right" colspan="6">
				<b>วันที่</b> <?php echo $obj->CreatDate; ?>
			</td>
		</tr>
		<tr>
			<td width="25%">
				<b>ชื่อผู้ใช้รถ</b> <?php echo $obj->Name; ?>
			</td>
			<td width="25%">
				<b>แผนก</b> <?php echo $obj->DepartmentDescription; ?>
			</td>
		</tr>
		<tr>
			<td width="25%">
				<b>ต้องการใช้วันที่</b> <?php echo $obj->FromDate; ?>
			</td>
			<td width="25%">
				<b>เวลารถออก</b> <?php echo $obj->FromTime; ?>
			</td>
			<td width="25%">
				<b>วันที่เดินทางถึง</b> <?php echo $obj->ToDate; ?>
			</td>
			<td width="25%">
				<b>เวลารถกลับ</b> <?php echo $obj->ToTime; ?>
			</td>
		</tr>
		<tr>
			<td>
				<b>สถานที่จาก</b> <?php echo $obj->InternalCode; ?>
			</td>
      <td>
        <b>จุดขึ้นรถ</b> <?php echo $obj->StartingPoint; ?>
      </td>
			<td  colspan="3">
				<b>ถึงปลายทาง</b> <?php echo $obj->Finished; ?>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<b>จุดประสงค์การใช้รถในครั้งนี้เพื่อ</b> <?php echo $obj->Title; ?>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<b>จำนวนผู้โดยสาร</b> <?php echo $obj->Seat; ?> คน
			</td>
		</tr>
    <tr>
      <td colspan="6">
        <b>ไฟล์แนบ<?php echo $obj->Start; ?></b> 
        <p id ="linkmy"></p>
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

<div id="myModal_Chk_Cannot" class="modal">
    <br><br><br>
    <center class="container">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title">แจ้งสถานะการอนุมัติ</h3>
      </div>
      <div class="panel-body">
        ไม่สามารถอนุมัติรายการนี้ได้  ระบบขัดข้อง
        <p id="txt_cannot"></p>
      </div>
    </div>
    </center>
</div>

<script type="text/javascript">
var statusid = '<?php echo $obj->StatusID; ?>';
if (statusid!=6) {
  $('#approve').hide();
  $('#noapprove').hide();
}
	$('#approve').on('click',function(){
			$('#approve').prop('disabled',true);
			$('#noapprove').prop('disabled',true);
      $('#approve').val('รอสักครู่...'); 
			var id = '<?php echo $obj->NumberRequestID; ?>';
      var id_car = '<?php echo $obj->CarRequestID; ?>';
      var comp = '<?php echo $obj->Start; ?>';
			var mailmg = '<?php echo $mailmg; ?>';
      var status_chk = '<?php echo $obj->StatusID; ?>';
      
            $.ajax({
                url : './mgapprove',
                type : 'post',
                data : {
                  id : id,
                  id_car : id_car,
                  comp : comp,
                  mailmg : mailmg
                },
                success : function(data){
                  // alert(data);
                  // console.log(data);
                     if (data==1) {
                        $('#myModal').show();
                        function CloseWindowsInTime(t){
                          t = t*1000;
                          setTimeout("window.close()",t);
                          }
                        CloseWindowsInTime(5); 
                     }else if(data==2){
                        $('#myModal_Chk').show();
                        function CloseWindowsInTime(t){
                          t = t*1000;
                          setTimeout("window.close()",t);
                          }
                        CloseWindowsInTime(5); 
                     }else{
                        $('#myModal_Chk_Cannot').show();
                        // $('#txt_cannot').text(data);
                        function CloseWindowsInTime(t){
                          t = t*1000;
                          setTimeout("window.close()",t);
                          }
                        CloseWindowsInTime(5); 
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
        var id = '<?php echo $obj->CarRequestID; ?>';
        var mailmg = '<?php echo $mailmg; ?>';
        var userby = '<?php echo $obj->CreateBy; ?>';

        if($.trim($('#txtremark').val())==''){
            gotify("กรุณากรอกเหตุผล","danger")
        }else{
          $('#dialogremark').jqxWindow('close');
        	$.ajax({
                url : './mgnoapprove',
                type : 'post',
                data : {
                  id     : id,
                  mailmg : mailmg,
                  userby : userby,
                  remark : $('#txtremark').val()
                },
                success : function(data){
                     //alert(data);
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

  $.getJSON('./linkfilemy?no=<?php echo $obj->NumberRequestID;?>&ran='+Math.random()*99999)
    .done(function(data){
      var i=1;
      $.each(data, function( k, v ) {
        var filename = v.FileName;
        
              $('#linkmy').append("<a target='_blank' href='upload/" + v.FileName + "'>" + v.FileName + "</a><br>");
              i++;
          }); 
    });
</script>