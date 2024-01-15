<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>

<?php $this->layout("layout-base"); ?>
<style type="text/css">
    .alert {
    width:20%;
    height: 24%;
    position: absolute;
    left: 80%;
    top: 7.5%; 
    font-size: 75%; 
    }
</style>
<div id="dialogdetail"> 
         <div><h5>รายละเอียด</h5></div>
         <div>
            <table class="table table-striped table-hover" width="100%">
              <tbody>
                <tr>
                  <td width="25%"><h5><b>ต้นทาง</b></h5></td>
                  <td width="25%"><h5><p id="start"></p></h5></td>
                  <td width="25%"><h5><b>จุดขึ้นรถ</b></h5></td>
                  <td width="25%"><h5><p id="point"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>ปลายทาง</b></h5></td>
                  <td><h5><p id="finish"></p></h5></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><h5><b>วันที่ออกเดินทาง</b></h5></td>
                  <td><h5><p id="date_st"></p></h5></td>
                  <td><h5><b>เวลาเริ่ม</b></h5></td>
                  <td><h5><p id="time_st"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>วันที่เดินทางมาถึง</b></h5></td>
                  <td><h5><p id="date_en"></p></h5></td>
                  <td><h5><b>เวลาสิ้นสุด</b></h5></td>
                  <td><h5><p id="time_en"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>จำนวนผู้โดยสาร</b></h5></td>
                  <td><h5><p id="seatt"></p></h5></td>
                  <td><h5><b>ทะเบียนรถ</b></h5></td>
                  <td><h5><p id="carregis"></p></h5></td></td>
                </tr>
                <tr>
                  <td><h5><b>จุดประะสงค์การใช้รถ</b></h5></td>
                  <td colspan="3"><h5><p id="titlee"></p></h5></td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><h5><b>สถานะการอนุมัติ</b></h5></td>
                </tr>
                <tr>
                  <td><h5><b>สร้างโดย</b></h5></td>
                  <td><h5><p id="createbyy"></p></h5></td>
                  <td><h5><b>เจ้าหน้าที่ (HR&Admin)</b></h5></td>
                  <td><h5><p id="admin"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>อนุมัติโดย</b></h5></td>
                  <td><h5><p id="mgbyy"></p></h5></td>
                  <td><h5><b>ผู้จัดการ (HR&Admin)</b></h5></td>
                  <td><h5><p id=""></p></h5></td>
                </tr>
              </tbody>
            </table>
         </div>
</div>
<?php 
    $db=db();
    $sql = "SELECT * FROM  StatusMaster ORDER BY Sort ASC";
    $query = sqlsrv_query($db,$sql);
 ?>
  <div class="alert alert-dismissible alert-info ">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>สถานะ(Status)</strong> <br>
      <?php while($result = sqlsrv_fetch_object($query)){ ?>
      <?php echo $result->StatusName.' = '.$result->StatusDescription.'<br>';?>
      <?php } ?>
    </div>
<div class="container">
	<h3>รายการขออนุญาตใช้รถบริษัทฯ</h3>
	<button class="btn btn-primary" id="create">สร้างรายการ</button>
    <button class="btn btn-primary" id="edit">แก้ไขรายการ</button>   
    <button class="btn btn-primary" id="cancel">ยกเลิก</button>   
    <button class="btn btn-primary" id="print">Print</button> 
    <button class="btn btn-primary" id="print_ceo">แบบฟอร์มขออนุมัติใช้รถตู้</button>   
    <br><br>
    <div id="grid"></div>
</div>


<script type="text/javascript">
	var theme_s = 'ui-redmond';
	var customer_source =
    {
        datatype: "json",
        url : './cartrans',
        datafields: [
            { name: 'CarRequestID', type: 'int' },
            { name: 'NumberRequestID', type: 'string'},
            { name: 'FromDate', type: 'date' },
            { name: 'ToDate', type: 'date' },
            { name: 'FromTime', type: 'time'},
            { name: 'ToTime', type: 'time'},
            { name: 'Seat', type: 'int'},
            { name: 'Start', type: 'string'},
            { name: 'InternalCode', type: 'string'},
            { name: 'StartingPoint', type: 'string'},
            { name: 'Finished', type: 'string'},
            { name: 'Title', type: 'string'},
            { name: 'StatusID', type: 'int'},
            { name: 'CreateBy', type: 'int'},
            { name: 'Name', type: 'string'},
            { name: 'StatusName', type: 'string'},
            { name: 'NameMg', type: 'string'},
            { name: 'NameAd', type: 'string'},
            { name: 'CarRegistration', type: 'string'}

        ]
    };

    var customer_adapter = new $.jqx.dataAdapter(customer_source);

    $("#grid").jqxGrid(
    {
        width: '100%',
        source: customer_adapter,
        columnsresize: true,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        theme : theme_s,
        columns: [
            {text: 'วันที่ใช้รถ',datafield: 'FromDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถออก',datafield: 'FromTime',width: 80},
            {text: 'ใช้รถถึงวันที่',datafield: 'ToDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถกลับ',datafield: 'ToTime',width: 80},
            {text: 'จุดประสงค์การใช้รถ',datafield: 'Title',width: 200},
            {text: 'จำนวนผู้โดยสาร',datafield: 'Seat',width: 100},
            {text: 'ต้นทาง',datafield: 'InternalCode',width: 120},
            {text: 'ปลายทาง',datafield: 'Finished',width: 120},
            {text: 'จุดขึ้นรถ',datafield: 'StartingPoint',width: 120},
            {text: 'Status',datafield: 'StatusName',filtertype: 'checkedlist',width: 80},
            {text: 'CreateBy',datafield: 'Name',width: 80}
            
        ]
    });   

    $('#create').on('click',function(){
    	window.location.assign('./')
    });

    $('#edit').on('click',function(){
        //gotify("กรุณารอสักครู่ อยู่ระหว่างการแก้ไขครับ !","warning")
    	var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
        var userid = '<?php echo $_SESSION["loggeduserid"]; ?>';

        if (datarow.StatusID!=1 && datarow.StatusID!=6 && datarow.StatusID!=9) {
            gotify("ไม่สามารถแก้ไขรายการได้","danger")
        }else{

            if (datarow) {
                if (datarow.CreateBy!=userid) {
                    gotify("ไม่สามารถแก้ไขรายการของผู้ใช้คนอื่นได้","danger")
                }else{
                    window.location.assign('./home-update?myParam='+datarow.NumberRequestID)
                }
        	
        	}else{
        		gotify("กรุณาเลือกรายการ","danger")
        	}

        }
    });

    $('#cancel').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
        var userid = '<?php echo $_SESSION["loggeduserid"]; ?>';
        if (datarow) {
            if (datarow.CreateBy!=userid) {
                gotify("ไม่สามารถยกเลิกรายการของผู้ใช้คนอื่นได้","danger")
            }else{
                //window.location.assign('./home-update?myParam='+datarow.NumberRequestID)
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url : './usercancel',
                        type : 'post',
                        data : {
                          id : datarow.NumberRequestID,
                          id_car : datarow.CarRequestID,
                          status : datarow.StatusID
                        },
                        success : function(data){
                            alert(data);
                            /*gotify("บันทึกสำเร็จ","success")
                            $('#grid').jqxGrid('updatebounddata');*/
                          
                        }
                    });
                }
            }
        
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        }
    });

    /*$('#grid').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#grid").jqxGrid('getrowdata', boundIndex);
        $('#dialogdetail').jqxWindow('open');
        document.getElementById("start").innerHTML = datarow.InternalCode;
        document.getElementById("finish").innerHTML = datarow.Finished;
        if (datarow.StartingPoint!="") {
            document.getElementById("point").innerHTML = datarow.StartingPoint;
        }else{
            document.getElementById("point").innerHTML = "-";    
        }
       
    
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [day, month, year].join('/');
            }
            //alert(formatDate('Sun May 11,2014'));
        document.getElementById("date_st").innerHTML = formatDate(datarow.ToDate);
        document.getElementById("date_en").innerHTML = formatDate(datarow.FromDate);
        document.getElementById("time_st").innerHTML = datarow.FromTime;
        document.getElementById("time_en").innerHTML = datarow.ToTime;
        document.getElementById("seatt").innerHTML = datarow.Seat+" คน";
        document.getElementById("titlee").innerHTML = datarow.Title;
        document.getElementById("createbyy").innerHTML = datarow.Name;
        document.getElementById("mgbyy").innerHTML = datarow.NameMg;
        document.getElementById("admin").innerHTML = datarow.NameAd;
        document.getElementById("carregis").innerHTML = datarow.CarRegistration;
    });*/
    $('#dialogdetail').jqxWindow({
             //maxWidth: 1000,
             width : 700,
             height : 600,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    var page = '<?php echo getapplocation(); ?>';
    $('#print').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
        var userid = '<?php echo $_SESSION["loggeduserid"]; ?>';
        if (datarow) {
            if (datarow.StatusID!=5) {
                gotify("ไม่สามารถดูรายการได้","danger")
            }else{
                // window.location.assign('http://'+page+'/detail-complete-print.php?id='+datarow.CarRequestID);    
                window.open('http://'+page+'/detail-complete-print.php?id='+datarow.CarRequestID,'_blank');
            }
        
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        }
    });

    $('#print_ceo').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
        if (datarow) {
            if (datarow.StatusID!=5) {
                gotify("ไม่สามารถดูรายการได้","danger")
            }else{ 
                window.open('http://'+page+'/detail-ceo.php?id='+datarow.CarRequestID,'_blank');
            }
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        }
    });

</script>
