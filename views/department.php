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
        <div><strong>Create Department</strong></div>
        <div>
            <form id="savedep" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">DepartmentID&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="depid" id="depid"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">DepartmentName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="depname" id="depname"/>
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
        <div><strong>Update Department</strong></div>
        <div>
            <form id="saveeditdep" class="form-horizontal">

            <table>  
                <!-- <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">DepartmentID&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="edepid" id="edepid"/>
                            </div>
                        </div>
                    </td>
                </tr> -->
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">DepartmentName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="edepid" id="edepid"/>
                            <input type="text" class="form-control" name="edepname" id="edepname"/>
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

<div class="container">
	<h3>จัดการแผนก</h3>

	<button class="btn btn-primary" id="adddep">เพิ่มแผนก</button>
    <button class="btn btn-primary" id="editdep">แก้ไขแผนก</button>   
    <br><br>
    <div id="grid"></div>
</div>

<script type="text/javascript">
	var theme_s = 'ui-redmond';
	var customer_source =
    {
        datatype: "json",
        url : './departmentmaster',
        datafields: [
            { name: 'DepartmentID', type: 'int' },
            { name: 'DepartmentDescription', type: 'string' }
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
            {text: 'DepartmentID',datafield: 'DepartmentID'},
            {text: 'DepartmentDescription',datafield: 'DepartmentDescription'}
            
        ]
    });

    $('#adddep').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savedep').trigger('reset');
    });

    $('#dialogadd').jqxWindow({
             width : 350,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedit').jqxWindow({
             width : 350,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#savedep').submit(function(e){
        e.preventDefault();

        var depid = $('#depid').val();
        var url = "./checkeddep?depid="+depid;
        $.get(url, function(data){
             if(data==1){
                   gotify("DepartmentID นี้ไม่สามารถใช้งานได้","danger")
              }
         });  

        if($.trim($('#depid').val())==''){
            gotify("กรุณากรอก DepartmentID","danger")
        }else if($.trim($('#depname').val())==''){
            gotify("กรุณากรอก DepartmentName","danger")
        }else{
            
            $.ajax({
                url : './adddep',
                type : 'post',
                data : {
                  depid : $('#depid').val(),
                  depname : $('#depname').val()
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

    $('#editdep').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            $('#saveeditdep').trigger('reset');
            $('#dialogedit').jqxWindow('open');
            $('#edepid').val(datarow.DepartmentID);
            $('#edepname').val(datarow.DepartmentDescription);

        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  

    });

    $('#saveeditdep').submit(function(e){
        e.preventDefault();
        if($.trim($('#edepname').val())==''){
            gotify("กรุณากรอก DepartmentName","danger")
        }else{ 
            
            $.ajax({
            url : './editdep',
            type : 'post',
            data : {
              depname : $('#edepname').val(),
              id : $('#edepid').val()
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