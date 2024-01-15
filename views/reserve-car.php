<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $this->layout("layout-base"); ?>

  <script type="text/javascript" src="./assets/jonthornton/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="./assets/jonthornton/jquery.timepicker.css" />

  <script type="text/javascript" src="./assets/jonthornton/lib/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="./assets/jonthornton/lib/bootstrap-datepicker.css" />


<div class="container orange">
<div class="well col-lg-8">
    <div class="modal-header">
        <h4 class="modal-title"><b>แบบฟอร์มการจองรถ</b></h4>
    </div>

    <form id="bookcar" class="form-horizontal" method="post" action="./addreserve-car"  enctype="multipart/form-data">
    <label></label>

        <div class="form-group">
            <label class="col-sm-3 control-label">กรณีขอให้ผู้อื่น</label>
            <div class="col-sm-6">
            <div class="radio">
                <label>
                    <input type="checkbox" name="tranfer" id="tranfer" value="1" />คลิ๊ก
                </label>
            </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" id="txttranfer">ชื่อ-นามสกุล</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="tranfer_n" id="tranfer_n" placeholder="กรุณากรอก" onkeyup="myFunctionname()"/><span id="textalert"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" id="txttranfert">เบอร์โทร</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="tranfer_t" id="tranfer_t" placeholder="กรุณากรอก" onkeyup="myFunctiontel()"/><span id="textalertt"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ต้นทาง</label>
            <div class="col-sm-5">
                <select class="form-control" id="start" name="start" onclick="myFunctionStart()"/></select>
                <span id="textalert_start"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">กรณีไม่ได้ขึ้นจากต้นทาง</label>
            <div class="col-sm-6">
            <div class="radio">
                <label>
                    <input type="checkbox" name="way" id="way" value="1" />คลิ๊ก
                </label>
            </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" id="txtstart">จุดขึ้นรถ</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="station" id="station" placeholder="กรุณากรอก" onkeyup="myFunctiontxtStart()"/>
                <span id="textalert_station"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ปลายทาง</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="end" id="end" placeholder="กรุณากรอก" onkeyup="myFunctiontxtEnd()"/>
                <span id="textalert_end"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>

        <div class="form-group">
        <label class="col-xs-3 control-label">วันที่ออกเดินทาง</label>
        <div class="col-xs-4 dateContainer">
            <div class="input-group input-append date" id="startDatePicker" onclick="myFunctionclickStart()">
                <input type="text" class="form-control" name="startDate" id="startDate"/>
                <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <span id="textalert_sdate"><font size="2">กรุณากรอก</font></span>
            <span id="textalert_fsdate"><font size="2">กรุณาเช็ครูปแบบ</font></span>
        </div>
            <label class="col-xs-2 control-label">เวลาเริ่ม</label>
            <div class="col-xs-2">
                <input type="text" class="form-control" name="startTime" id="startTime"  onkeyup="myFunctionclickStartDate()" onclick="myFunctionclickStartDate()"/>
                <span id="textalert_stime"><font size="2">กรุณากรอก</font></span>
                <span id="textalert_fstime"><font size="2">กรุณาเช็ครูปแบบ</font></span>
            </div>
        </div>

        
        <div class="form-group">
        <label class="col-xs-3 control-label">วันที่เดินทางถึง</label>
        <div class="col-xs-4 dateContainer">
            <!-- <div class="input-group input-append date" id="endDatePicker"> -->
            <div class="input-group input-append date">
                <input type="text" class="form-control" name="endDate" id="endDate" readonly />
                <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <span id="textalert_edate"><font size="2">กรุณากรอก</font></span>
            <span id="textalert_fedate"><font size="2">กรุณาเช็ครูปแบบ</font></span>
        </div>
            <label class="col-xs-2 control-label">เวลาสิ้นสุด</label>
            <div class="col-xs-2">
                <input type="text" class="form-control" name="endTime" id="endTime"/>
                <span id="textalert_etime"><font size="2">กรุณากรอก</font></span>
                <span id="textalert_fetime"><font size="2">กรุณาเช็ครูปแบบ</font></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">จำนวนผู้โดยสาร</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="people" id="people" placeholder="0" onclick="myFunctiontxtpeople()" onkeyup="myFunctiontxtpeople()"/>
                <span id="textalert_people"><font size="2">กรุณากรอก</font></span>
            </div>
            <label class="col-sm-1 control-label">คน</label>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">จุดประสงค์การใช้รถ</label>
            <div class="col-sm-8">
                <textarea class="form-control" name="title" id="title" onkeyup="myFunctiontxttitle()"></textarea>
                <span id="textalert_title"><font size="2">กรุณากรอก</font></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">กรณีแนบไฟล์</label>
            <div class="col-sm-8">
                <input name="filUpload" id="filUpload" type="button" class="btn" value="+" ><br>
                <div class="well"><span id="mySpan"></span></div>
            </div>
        </div>

        <div class="modal-footer">
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" class="btn btn-warning" name="signup" id="signup">ยืนยันการจอง</button>
            </div>
        </div>
        </div>

    </form>

</div>
</div>

<script>
    $('#tranfer_n').hide();
    $('#txttranfer').hide();
    $('#tranfer_t').hide();
    $('#txttranfert').hide();
    $('#textalert').hide();
    $('#textalertt').hide();
    $('#txtstart').hide();
    $('#station').hide();
    $('#textalert_start').hide();
    $('#textalert_station').hide();
    $('#textalert_end').hide();
    $('#textalert_sdate').hide();
    $('#textalert_edate').hide();
    $('#textalert_stime').hide();
    $('#textalert_etime').hide();
    $('#textalert_fsdate').hide();
    $('#textalert_fedate').hide();
    $('#textalert_fstime').hide();
    $('#textalert_fetime').hide();
    $('#textalert_people').hide();
    $('#textalert_title').hide();
$('#bookcar').submit(function(e){
    var TIME_PATTERN = /^((2[0-3])|([01][0-9])):[0-5][0-9]$/;
    var DATE_PATTERN = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
    
        from_date = $('#startDate').val();
        to_date = $('#endDate').val();
        var fromdate = from_date.split('/');
        from_date = new Date();
        from_date.setFullYear(fromdate[2],fromdate[1]-1,fromdate[0]);
        var todate = to_date.split('/');
        to_date = new Date();
        to_date.setFullYear(todate[2],todate[1]-1,todate[0]);

        var startTime = $('#startTime').val();
        var endTime   = $('#endTime').val();
        
        var startHour    = parseInt(startTime.split(':')[0], 10),
            startMinutes = parseInt(startTime.split(':')[1], 10),
            endHour      = parseInt(endTime.split(':')[0], 10),
            endMinutes   = parseInt(endTime.split(':')[1], 10);

    if ($("input[name=tranfer]:checked").val() == 1 && $('#tranfer_n').val() == '') {
            $('#textalert').show().css('color','#FF0033');
            $('#tranfer_n').css('border','#FF0033 1px solid');
            $('#textalertt').show().css('color','#FF0033');
            $('#tranfer_t').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#start').val()=='') {
            $('#textalert_start').show().css('color','#FF0033');
            $('#start').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($("input[name=way]:checked").val() == 1 && $('#station').val() == '') {
            $('#textalert_station').show().css('color','#FF0033');
            $('#station').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#end').val() == '') {
            $('#textalert_end').show().css('color','#FF0033');
            $('#end').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#startDate').val() == '') {
            $('#textalert_fsdate').hide();
            $('#textalert_sdate').show().css('color','#FF0033'); 
            $('#startDate').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#startTime').val() == '') {
            $('#textalert_fstime').hide()
            $('#textalert_stime').show().css('color','#FF0033');
            $('#startTime').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#endDate').val() == '') {
            $('#textalert_fedate').hide();
            $('#textalert_edate').show().css('color','#FF0033');
            $('#endDate').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#endTime').val() == '') {
            $('#textalert_fetime').hide();
            $('#textalert_etime').show().css('color','#FF0033');
            $('#endTime').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if (DATE_PATTERN.test($('#startDate').val())===false){
            $('#textalert_sdate').hide();
            $('#textalert_fsdate').show().css('color','#FF0033  ');
            $('#startDate').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if (TIME_PATTERN.test($('#startTime').val())===false){
            $('#textalert_stime').hide();
            $('#textalert_fstime').show().css('color','#FF0033  ');
            $('#startTime').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if (DATE_PATTERN.test($('#endDate').val())===false){
            $('#textalert_edate').hide();
            $('#textalert_fedate').show().css('color','#FF0033  ');
            $('#endDate').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if (TIME_PATTERN.test($('#endTime').val())===false){
            $('#textalert_etime').hide();
            $('#textalert_fetime').show().css('color','#FF0033  ');
            $('#endTime').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#people').val() == '') {
            $('#textalert_people').show().css('color','#FF0033  ');
            $('#people').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if ($('#title').val() == '') {
            $('#textalert_title').show().css('color','#FF0033  ');
            $('#title').css('border','#FF0033 1px solid');
            e.preventDefault();
    }else if (from_date > to_date ) {
            swal({
              title: "กรุณาเช็ควันเดินทาง !",
              text: "วันที่ออกเดินทาง ต้องน้อยกว่า วันที่เดินทางถึง !",
              imageUrl: "assets/sweetalert-master/example/images/calendar-clock.png"
            });
            e.preventDefault();
    }else if (from_date.getTime() == to_date.getTime()) {
                if (endHour < startHour || (endHour == startHour && endMinutes < startMinutes)) {
                        swal({
                          title: "กรุณาเช็คเวลาเดินทาง !",
                          text: "วันที่ออกเดินทาง ต้องน้อยกว่า วันที่เดินทางถึง !",
                          imageUrl: "assets/sweetalert-master/example/images/calendar-clock.png"
                        });
                        e.preventDefault();
                }
        //e.preventDefault();
    }else{
            $('#textalert_sdate').hide();
            $('#textalert_fsdate').hide();
            $('#startDate').css('border','#E6E6FA 1px solid');
            $('#textalert_stime').hide();
            $('#textalert_fstime').hide();
            $('#startTime').css('border','#E6E6FA 1px solid');
            $('#textalert_edate').hide();
            $('#textalert_fedate').hide();
            $('#endDate').css('border','#E6E6FA 1px solid');
            $('#textalert_etime').hide();
            $('#textalert_fetime').hide();
            $('#endTime').css('border','#E6E6FA 1px solid');
            e.preventDefault();
    }
    
});
    function myFunctionclickStart(){
        $('#endDate').val($('#startDate').val());
    }
    function myFunctionclickStartDate(){
        $('#endDate').val($('#startDate').val());
    }
    function myFunctionname() {
        if ($.trim($('#tranfer_n').val())!='') {
            $('#tranfer_n').css('border','#E6E6FA 1px solid');
            $('#textalert').hide();
        }
    }
    function myFunctiontel() {
        if ($.trim($('#tranfer_t').val())!='') {
            $('#tranfer_t').css('border','#E6E6FA 1px solid');
            $('#textalertt').hide();
        }
    }
    function myFunctionStart() {
        if ($.trim($('#start').val())!='') {
            $('#start').css('border','#E6E6FA 1px solid');
            $('#textalert_start').hide();
        }
    }
    function myFunctiontxtStart(){
        if ($.trim($('#station').val())!='') {
            $('#station').css('border','#E6E6FA 1px solid');
            $('#textalert_station').hide();
        }
    }
    function myFunctiontxtEnd(){
        if ($.trim($('#end').val())!='') {
            $('#end').css('border','#E6E6FA 1px solid');
            $('#textalert_end').hide();
        }
    }
    function myFunctiontxtpeople(){
        if ($.trim($('#people').val())!='') {
            $('#people').css('border','#E6E6FA 1px solid');
            $('#textalert_people').hide();
        }
    }
    function myFunctiontxttitle(){
        if ($.trim($('#title').val())!='') {
            $('#title').css('border','#E6E6FA 1px solid');
            $('#textalert_title').hide();
        }
    }

    $(function() {
        $('#startTime').timepicker({ 'timeFormat': 'H:i' });
        $('#endTime').timepicker({ 'timeFormat': 'H:i' });
        $('#startDatePicker').datepicker({
                format: 'dd/mm/yyyy'
        });
        $('#endDatePicker').datepicker({
                format: 'dd/mm/yyyy'
        });
    });

    $("input[name=tranfer]").bind('click', function() {
            if ($("input[name=tranfer]:checked").val() == 1) {
                $('#tranfer_n').val('');
                $('#tranfer_t').val('');
                $('#tranfer_n').show();
                $('#txttranfer').show();
                $('#tranfer_t').show();
                $('#txttranfert').show();

            }else{
                $('#tranfer_n').hide();
                $('#txttranfer').hide();
                $('#tranfer_t').hide();
                $('#txttranfert').hide();
                $('#textalert').hide();
                
            }   
    });
    $("input[name=way]").bind('click', function() {
            if ($("input[name=way]:checked").val() == 1) {
                $('#station').val('');
                $('#station').show();
                $('#txtstart').show();
            }else{
                $('#station').hide();
                $('#txtstart').hide();
            }
            
    });

    var num =1;
    $('#filUpload').bind('click',function(){
           var add ="add"+num;
           var add1 ="add1"+num;
           var br1 = "br1"+num;
     
           $('#mySpan').append("<button id='"+add+"' onclick='removeEle("+add+','+add1+','+br1+ ")' type='button' class='btn'>-</button><input type='file' name='filUpload[]' id='"+add1+"'><br id='"+br1+"'>");
            num++;

    });
    function removeEle(divid,_divid){
        $(divid).remove(); 
        $(_divid).remove(); 
    }

$.getJSON("./companymaster", function(data) {
    $('#start').html("<option value=''>- กรุณาเลือก -</option>");
    $.each(data, function(key, val) {
        $('#start').append("<option value='" + val.CompanyID+ "'>" + val.InternalCode + "</option>");
        $('#start').val();
    });
});

</script>