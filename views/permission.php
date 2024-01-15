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
        <div><strong>Create Permission</strong></div>
        <div>
            <form id="savepermission" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">PermissionName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="pername" id="pername"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Company&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                	<td>
                	<label class="control-label">
                	<?php 
	                    $db = db();
	                    $sql = "SELECT * FROM  CompanyMaster";
	                    $stmt = sqlsrv_query($db,$sql);
	                    while( $obj = sqlsrv_fetch_object( $stmt)) {
	                        echo '<input type="checkbox" class="comp" value="'.$obj->CompanyID.'">'.$obj->InternalCode."&nbsp;&nbsp;&nbsp;";
	                    }
	                ?>
	                </label>
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
        <div><strong>Update Permission</strong></div>
        <div>
            <form id="saveeditpermission" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">PermissionName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" id="idper">
                            <input type="text" class="form-control" name="epername" id="epername"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Company&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                	<td>
                	<label class="control-label">
                	<?php 
	                    $db = db();
	                    $sql = "SELECT * FROM  CompanyMaster";
	                    $stmt = sqlsrv_query($db,$sql);
	                    while( $obj = sqlsrv_fetch_object( $stmt)) {
	                        echo '<input type="checkbox" class="ecomp" value="'.$obj->CompanyID.'">'.$obj->InternalCode."&nbsp;&nbsp;&nbsp;";
	                    }
	                ?>
	                </label>
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

<div id="dialogcomp">
        <div><strong>CompanyDescription</strong></div>
        <div>
             <div id="gridcomp"></div>
        </div>
</div>

<div class="container">
	<h3>กำหนดสิทธิ์การจัดการ</h3>

	<button class="btn btn-primary" id="addper">เพิ่มสิทธิ์การจัดการ</button>
    <button class="btn btn-primary" id="editper">แก้ไขสิทธิ์การจัดการ</button>   
    <br><br>
    <div id="grid"></div>
</div>

<script type="text/javascript">
	var theme_s = 'ui-redmond';
	var customer_source =
    {
        datatype: "json",
        url : './permissionmaster',
        datafields: [
            { name: 'PermissionID', type: 'int' },
            { name: 'PermissionName', type: 'string' },
            { name: 'CompanyID', type: 'string' }
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
            {text: 'PermissionID',datafield: 'PermissionID'},
            {text: 'PermissionName',datafield: 'PermissionName'},
            {text: 'CompanyID',datafield: 'CompanyID'}
            
        ]
    });

    //gridcomp
    var comp_source =
    {
        datatype: "json",
        url : './companymaster',
        datafields: [
            { name: 'CompanyID', type: 'int' },
            { name: 'InternalCode', type: 'string' },
            { name: 'CompanyDescription', type: 'string' }
        ]
    };

    var comp_adapter = new $.jqx.dataAdapter(comp_source);

    $("#gridcomp").jqxGrid(
    {
        width: '99.5%',
        height: '90.5%',
        source: comp_adapter,  
        theme : theme_s,
        columns: [
            {text: 'CompanyID',datafield: 'CompanyID',width:80},
            {text: 'InternalCode',datafield: 'InternalCode',width:100},
            {text: 'CompanyDescription',datafield: 'CompanyDescription'}
            
        ]
    });
    
    $('#dialogadd').jqxWindow({
             width : 420,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#dialogedit').jqxWindow({
             width : 420,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $("#dialogcomp").jqxWindow({
        height: 227,
        width: 450,
        theme: theme_s,
        position: { x: 880, y: 100 }
       // closeButtonSize: 20
    });

    $('#addper').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savepermission').trigger('reset');
    });

    $('#savepermission').submit(function(e){
        e.preventDefault();

        var comp_checked = [];
        var e= 0;
        $('.comp:checked').each(function(){
                comp_checked[e++] = $(this).val();
        });

        if($.trim($('#pername').val())==''){
            gotify("กรุณากรอก PermissionName","danger")
        }else{
            //alert(comp_checked);
            $.ajax({
                url : './addper',
                type : 'post',
                data : {
                  pername : $('#pername').val(),
                  comp : comp_checked
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


    $('#editper').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            
            $('#saveeditpermission').trigger('reset');
            var str = datarow.CompanyID;
                var array = str.split(',');
                if (str!='') {
                    var obj = array;
                    $.each( obj, function( key, value ) {
                      $('input[type=checkbox][value='+value+']').prop('checked','true');
                    });
                }
            $('#dialogedit').jqxWindow('open');
            $('#epername').val(datarow.PermissionName);
            $('#idper').val(datarow.PermissionID);	
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  
    });

    $('#saveeditpermission').submit(function(e){
        e.preventDefault();
        var ecomp_checked = [];
        var e= 0;
        $('.ecomp:checked').each(function(){
                ecomp_checked[e++] = $(this).val();
        });

        if($.trim($('#epername').val())==''){
            gotify("กรุณากรอก PermissionName","danger")
        }else{ 
            
            $.ajax({
            url : './editper',
            type : 'post',
            data : {
              epername : $('#epername').val(),
              id : $('#idper').val(),
              ecomp : ecomp_checked
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