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
tr {
    height: 50px;
}
</style>

<div id="dialogadd">
        <div><strong>Create Driver</strong></div>
        <div>
            <form id="savedriver" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ชื่อพนักงานขับรถ&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="driver" id="driver"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">เบอร์โทร</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="tel" id="tel"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Company</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" name="comp" id="comp" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                <td colspan="2" align="right">
                    <br>
                    <button  type="submit" class="btn btn-primary" id="savedriver">Save</button>
                    <button  type="reset"  class="btn btn-default" id="canceldriver">Cancel</button>
                </td>
                </tr>
            </table>

            </form>
        </div>
</div>

<div id="dialogedit">
        <div><strong>Create Driver</strong></div>
        <div>
            <form id="saveeditdriver" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">ชื่อพนักงานขับรถ&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <input type="text" class="form-control" name="edriver" id="edriver"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">เบอร์โทร</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="etel" id="etel"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Company</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" name="ecomp" id="ecomp" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                <td colspan="2" align="right">
                    <br>
                    <button  type="submit" class="btn btn-primary" id="savedriveredit">Save</button>
                    <button  type="reset"  class="btn btn-default" id="canceldriveredit">Cancel</button>
                </td>
                </tr>
            </table>

            </form>
        </div>
</div>

<div class="container">
	<h3>จัดการพนักงานขับรถ</h3>

	<button class="btn btn-primary" id="adddriver">เพิ่มพนักงานขับรถ</button>
    <button class="btn btn-primary" id="editdriver">แก้ไขพนักงานขับรถ</button>   
    <br><br>
    <div id="grid"></div>
</div>

<script type="text/javascript">
var theme_s = 'ui-redmond';
var customer_source =
    {
        datatype: "json",
        url : './drivermaster',
        datafields: [
            { name: 'DriverID', type: 'int' },
            { name: 'DriverName', type: 'string' },
            { name: 'Tel', type: 'string' },
            { name: 'CompanyID', type: 'string'}

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
        theme : theme_s,
        columns: [
            {text: 'DriverName',datafield: 'DriverName'},
            {text: 'Tel',datafield: 'Tel',width:150},
            {text: 'Company',datafield: 'CompanyID',width:150}
        ]
    });   

    $('#dialogadd').jqxWindow({
             width : 350,
             height : 300,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedit').jqxWindow({
             width : 350,
             height : 300,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#adddriver').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savedriver').trigger('reset');

        $.getJSON("./companymaster", function(data) {
            $('#comp').html("<option value=''>- Select -</option>");
            $.each(data, function(key, val) {
                $('#comp').append("<option value='" + val.InternalCode+ "'>" + val.InternalCode + "</option>");
                $('#cartype').val();
            });
        });

    });

    $('#savedriver').submit(function(e){
        e.preventDefault();

        if($.trim($('#driver').val())==''){
            gotify("กรุณากรอก ชื่อพนักงานขับรถ","danger")
        }else if($.trim($('#tel').val())==''){
            gotify("กรุณากรอก เบอร์โทรศัพท์","danger")
        }else if($.trim($('#comp').val())==''){
            gotify("กรุณาเลือก บริษัท","danger")
        }else{

            $.ajax({
                url : './adddrivermaster',
                type : 'post',
                data : {
                  driver : $('#driver').val(),
                  tel        : $('#tel').val(),
                  comp     : $('#comp').val()
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

    $('#editdriver').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            $('#dialogedit').jqxWindow('open');
            $('#saveeditdriver').trigger('reset');
            $('#id').val(datarow.DriverID);
            $('#edriver').val(datarow.DriverName);
            $('#etel').val(datarow.Tel);
            
            $.getJSON("./companymaster", function(data) {
                $('#ecomp').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#ecomp').append("<option value='" + val.InternalCode+ "'>" + val.InternalCode + "</option>");
                    $('#ecomp').val(datarow.CompanyID);
                });
            });

        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  
    });

    $('#saveeditdriver').submit(function(e){
        e.preventDefault();

        if($.trim($('#edriver').val())==''){
            gotify("กรุณากรอก ชื่อพนักงานขับรถ","danger")
        }else if($.trim($('#etel').val())==''){
            gotify("กรุณากรอก เบอร์โทรศัพท์","danger")
        }else if($.trim($('#ecomp').val())==''){
            gotify("กรุณาเลือก บริษัท","danger")
        }else{

            $.ajax({
            url : './editdrivermaster',
            type : 'post',
            data : {
              driver : $('#edriver').val(),
              tel : $('#etel').val(),
              comp : $('#ecomp').val(),
              id : $('#id').val()
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
</script>