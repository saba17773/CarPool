<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $this->layout("layout-base"); ?>
<style> 
        input[type=checkbox]
        {
            -ms-transform: scale(1.2); /* IE */
            -webkit-transform: scale(1.2); /* Safari and Chrome */ 
            padding: 10px;
        }
        tr {
            height: 50px;
        }
        #settings-panel
        {
            background-color: #fff;
            padding: 20px;
            display: inline-block;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            position: relative;
        }
        .settings-section
        {
            background-color: #f7f7f7;
            height: 45px;
            width: 500px;
            border: 1px solid #b4b7bc;
            border-bottom-width: 0px;
        }
        .settings-section-top
        {
            border-bottom-width: 0px;
            -moz-border-radius-topleft: 10px;
            -webkit-border-top-left-radius: 10px;
            border-top-left-radius: 10px;
            -moz-border-radius-topright: 10px;
            -webkit-border-top-right-radius: 10px;
            border-top-right-radius: 10px;            
        }
        .sections-section-bottom
        {
            border-bottom-width: 1px;
            -moz-border-radius-bottomleft: 10px;
            -webkit-border-bottom-left-radius: 10px;
            border-bottom-left-radius: 10px;
            -moz-border-radius-bottomright: 10px;
            -webkit-border-bottom-right-radius: 10px;
            border-bottom-right-radius: 10px;            
        }
        .sections-top-shadow
        {
            width: 500px;
            height: 1px;
            position: absolute;
            top: 21px;
            left: 21px;
            height: 30px;
            border-top: 1px solid #e4e4e4;
            -moz-border-radius-topleft: 10px;
            -webkit-border-top-left-radius: 10px;
            border-top-left-radius: 10px;
            -moz-border-radius-topright: 10px;
            -webkit-border-top-right-radius: 10px;
            border-top-right-radius: 10px;  
        }
        .settings-label
        {
            font-weight: bold;
            font-family: Sans-Serif;
            font-size: 14px;
            margin-left: 14px;
            margin-top: 15px;
            float: left;
        }
        .settings-melody
        {
            color: #385487;
            font-family: Sans-Serif;
            font-size: 14px;
            display: inline-block;
            margin-top: 7px;
        }
        .settings-setter
        {
            float: right;
            margin-right: 14px;
            margin-top: 8px;
        }
        .events-container
        {
            margin-left: 20px;
        }
        #theme
        {
            margin-left: 20px;
            margin-bottom: 20px;
        }
</style>

<div id="dialogadd">
        <div><strong>Create Car</strong></div>
        <div>
            <form id="savecar" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ทะเบียนรถ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="carregis" id="carregis"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ที่นั่ง&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="number" class="form-control" name="seat" id="seat"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ที่นั่ง</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ชนิดรถ</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" name="cartype" id="cartype" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">บริษัท</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                       <label class="control-label">
                        <input type="checkbox" name="dsl" id="dsl" checked>DSL&nbsp;&nbsp;
                        <input type="checkbox" name="drb" id="drb" checked>DRB&nbsp;&nbsp;
                        <input type="checkbox" name="dsi" id="dsi" checked>DSI&nbsp;&nbsp;
                        <input type="checkbox" name="svo" id="svo" checked>SVO&nbsp;&nbsp;
                        <input type="checkbox" name="str" id="str" checked>STR&nbsp;&nbsp;
                        </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">สถานะใช้งาน</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <!-- <div id="switch"></div> -->
                            <input type="radio" name="switch" value="1" checked> ON &nbsp;&nbsp;
                            <input type="radio" name="switch" value="0"> OFF
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                <td colspan="2" align="right">
                    <br>
                    <button  type="submit" class="btn btn-primary" id="saveadd">Save</button>
                    <button  type="reset"  class="btn btn-default" id="canceladd">Cancel</button>
                </td>
            </tr>
            </table>
            </form>
        </div>
</div>

<div id="dialogedit">
        <div><strong>Update Car</strong></div>
        <div>
            <form id="savecaredit" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ทะเบียนรถ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" id="ecarid">
                            <input type="text" class="form-control" name="ecarregis" id="ecarregis"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ที่นั่ง&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="number" class="form-control" name="eseat" id="eseat"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ที่นั่ง</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ชนิดรถ</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" name="ecartype" id="ecartype" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">บริษัท</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                       <label class="control-label">
                        <input type="checkbox" name="edsl" id="edsl">DSL&nbsp;&nbsp;
                        <input type="checkbox" name="edrb" id="edrb">DRB&nbsp;&nbsp;
                        <input type="checkbox" name="edsi" id="edsi">DSI&nbsp;&nbsp;
                        <input type="checkbox" name="esvo" id="esvo">SVO&nbsp;&nbsp;
                        <input type="checkbox" name="estr" id="estr">STR&nbsp;&nbsp;
                        </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">สถานะใช้งาน</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <!-- <div id="eswitch"></div> -->
                            <input type="radio" name="eswitch" value="1" checked> ON &nbsp;&nbsp;
                            <input type="radio" name="eswitch" value="0"> OFF
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                <td colspan="2" align="right">
                    <br>
                    <button  type="submit" class="btn btn-primary" id="saveedit">Save</button>
                    <button  type="reset"  class="btn btn-default" id="canceledit">Cancel</button>
                </td>
            </tr>
            </table>
            </form>
        </div>
</div>

<div class="container">
	<h3>จัดการรถ</h3>

	<button class="btn btn-primary" id="addcar">เพิ่มรถ</button>
    <button class="btn btn-primary" id="editcar">แก้ไขรถ</button>   
    <br><br>
    <div id="grid"></div>
</div>

<script type="text/javascript">
var theme_r = 'ui-redmond';	
var theme_s = 'ui-start';
var theme_b = 'black';

var customer_source =
    {
        datatype: "json",
        url : './carmaster',
        datafields: [
            { name: 'CarID', type: 'int' },
            { name: 'CarRegistration', type: 'string' },
            { name: 'Seat', type: 'int' },
            { name: 'CarTypeID', type: 'int' },
            { name: 'CarTypeName', type: 'string'},
            { name: 'CarStatus', type: 'int' },
            { name: 'DSL', type: 'bool' },
            { name: 'DRB', type: 'int' },
            { name: 'DSI', type: 'int' },
            { name: 'SVO', type: 'int' },
            { name: 'STR', type: 'int' }

        ]
    };

    var customer_adapter = new $.jqx.dataAdapter(customer_source);

    $("#grid").jqxGrid(
    {
        width: '50%',
        source: customer_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        theme : theme_r,
        columns: [
            {text: 'CarRegistration',datafield: 'CarRegistration'},
            {text: 'Seat',datafield: 'Seat'},
            {text: 'CarType',datafield: 'CarTypeName'},
            { text: 'DSL', datafield: 'DSL', columntype: 'checkbox',cellsalign: 'center', align: 'center',width:40},
            { text: 'DRB', datafield: 'DRB', columntype: 'checkbox',cellsalign: 'center', align: 'center',width:40},
            { text: 'DSI', datafield: 'DSI', columntype: 'checkbox',cellsalign: 'center', align: 'center',width:40},
            { text: 'SVO', datafield: 'SVO', columntype: 'checkbox',cellsalign: 'center', align: 'center',width:40},
            { text: 'STR', datafield: 'STR', columntype: 'checkbox',cellsalign: 'center', align: 'center',width:40},
            {text: 'CarStatus',datafield:  'CarStatus' , width:70, filterable: false,
                    cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                        var status;
                           if (value =="1") {
                              status =  "<div style='padding: 5px; background:#00BB00 ; color:#FFFFFF;'> เปิดใช้งาน </div>";
                           }else if(value =="0"){
                              status =  "<div style='padding: 5px; background:#FF0000 ; color:#FFFFFF;'> ปิดใช้งาน </div>";
                           }
                           return status;
                    }
            }
            
        ]
    });   
            


    $('#dialogadd').jqxWindow({
             width : 400,
             height : 450,
             autoOpen : false,
             isModal : true,
             theme : theme_r      
    });
    $('#dialogedit').jqxWindow({
             width : 400,
             height : 450,
             autoOpen : false,
             isModal : true,
             theme : theme_r      
    });
    /*$('#dialogadd').on('close', function (event) {
        location.reload();
    });*/
    $('#addcar').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savecar').trigger('reset');
    });

    $('#savecar').submit(function(e){
        e.preventDefault();
        
        if ($('input[name=switch]:checked').val()==1) {
            status = 1;
        }else{
            status = 0;
        }

        if ($('input[name=dsl]').is(':checked') == true){
            dsl = '1';
        }else if ($('input[name=dsl]').is(':checked') == false){ 
            dsl = '0';    
        }
        if ($('input[name=drb]').is(':checked') == true){
            drb = '1';
        }else if ($('input[name=drb]').is(':checked') == false){ 
            drb = '0';    
        }
        if ($('input[name=dsi]').is(':checked') == true){
            dsi = '1';
        }else if ($('input[name=dsi]').is(':checked') == false){ 
            dsi = '0';    
        }
        if ($('input[name=svo]').is(':checked') == true){
            svo = '1';
        }else if ($('input[name=svo]').is(':checked') == false){ 
            svo = '0';    
        }
        if ($('input[name=str]').is(':checked') == true){
            str = '1';
        }else if ($('input[name=str]').is(':checked') == false){ 
            str = '0';    
        }
        if($.trim($('#carregis').val())==''){
            gotify("กรุณากรอก ทะเบียนรถ","danger")
        }else if($.trim($('#seat').val())==''){
            gotify("กรุณากรอก จำนวนที่นั่ง","danger")
        }else if($.trim($('#cartype').val())==''){
            gotify("กรุณาเลือก ชนิดรถ","danger")
        }else{
            $.ajax({
                url : './addcarmaster',
                type : 'post',
                data : {
                  licenseplate : $('#carregis').val(),
                  seat        : $('#seat').val(),
                  cartype     : $('#cartype').val(),
                  dsl : dsl,
                  drb : drb,
                  dsi : dsi,
                  svo : svo,
                  str : str,
                  status : status
                },
                success : function(data){
                    //alert(data);
                    gotify("บันทึกสำเร็จ","success")
                    $('#dialogadd').jqxWindow('close');
                    $('#grid').jqxGrid('updatebounddata');
                  
                }
            });

        }

    });

    $('#editcar').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            $('#dialogedit').jqxWindow('open');
            $('#savecaredit').trigger('reset');
            
            if (datarow.DSL==1){
                $('input[name=edsl]').prop('checked' , true);
            }else{
                $('input[name=edsl]').prop('checked' , false);
            }
            if (datarow.DRB==1){
                $('input[name=edrb]').prop('checked' , true);
            }else{
                $('input[name=edrb]').prop('checked' , false);
            }
            if (datarow.DSI==1){
                $('input[name=edsi]').prop('checked' , true);
            }else{
                $('input[name=edsi]').prop('checked' , false);
            }
            if (datarow.SVO==1){
                $('input[name=esvo]').prop('checked' , true);
            }else{
                $('input[name=esvo]').prop('checked' , false);
            }
            if (datarow.STR==1){
                $('input[name=estr]').prop('checked' , true);
            }else{
                $('input[name=estr]').prop('checked' , false);
            }

            $('#ecarid').val(datarow.CarID);
            $('#ecarregis').val(datarow.CarRegistration);
            $('#eseat').val(datarow.Seat);

            //var status = datarow.CarStatus;
            var active = datarow.CarStatus;
            
            if (active==1) {
                $("input[name=eswitch][value='1']").prop('checked' , true);
            }else{
                $("input[name=eswitch][value='0']").prop('checked' , true);
            }

            /*$('.jqx-switchbutton').on('checked', function (event) {
                $('#eswitch').jqxSwitchButton({theme:theme_b});
            });
            $('.jqx-switchbutton').on('unchecked', function (event) {
                $('#eswitch').jqxSwitchButton({theme:theme_s});
            });*/

            
            $.getJSON("./cartypemaster", function(data) {
                $('#ecartype').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#ecartype').append("<option value='" + val.CarTypeID+ "'>" + val.CarTypeName + "</option>");
                    $('#ecartype').val(datarow.CarTypeID);
                });
            });

        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  
    });

    $('#savecaredit').submit(function(e){
        e.preventDefault();

        if ($('input[name=eswitch]:checked').val()==1) {
            estatus = 1;
        }else{
            estatus = 0;
        }

        if ($('input[name=edsl]').is(':checked') == true){
            dsl = '1';
        }else if ($('input[name=edsl]').is(':checked') == false){ 
            dsl = '0';    
        }
        if ($('input[name=edrb]').is(':checked') == true){
            drb = '1';
        }else if ($('input[name=edrb]').is(':checked') == false){ 
            drb = '0';    
        }
        if ($('input[name=edsi]').is(':checked') == true){
            dsi = '1';
        }else if ($('input[name=edsi]').is(':checked') == false){ 
            dsi = '0';    
        }
        if ($('input[name=esvo]').is(':checked') == true){
            svo = '1';
        }else if ($('input[name=esvo]').is(':checked') == false){ 
            svo = '0';    
        }
        if ($('input[name=estr]').is(':checked') == true){
            str = '1';
        }else if ($('input[name=estr]').is(':checked') == false){ 
            str = '0';    
        }

        if($.trim($('#ecarregis').val())==''){
            gotify("กรุณากรอก ทะเบียนรถ","danger")
        }else if($.trim($('#eseat').val())==''){
            gotify("กรุณากรอก ที่นั่ง","danger")
        }else if($.trim($('#ecartype').val())==''){
            gotify("กรุณาเลือก ชนิดรถ","danger")
        }else{
            $.ajax({
            url : './editcarmaster',
            type : 'post',
            data : {
              idcar : $('#ecarid').val(),
              licenseplate : $('#ecarregis').val(),
              seat : $('#eseat').val(),
              type : $('#ecartype').val(),
              dsl : dsl,
              drb : drb,
              dsi : dsi,
              svo : svo,
              str : str,
              status : estatus
            },
            success : function(data){
                //alert(data);
                gotify("บันทึกสำเร็จ","success")
                $('#dialogedit').jqxWindow('close');
                $('#grid').jqxGrid('updatebounddata');
              
            }
            });

        }
    });

    $.getJSON("./cartypemaster", function(data) {
            $('#cartype').html("<option value=''>- Select -</option>");
            $.each(data, function(key, val) {
                $('#cartype').append("<option value='" + val.CarTypeID+ "'>" + val.CarTypeName + "</option>");
                $('#cartype').val();
            });
        });
</script>