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
        <div><strong>Create Company</strong></div>
        <div>
            <form id="savecomp" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">InternalCode&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="comp" id="comp"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">CompanyDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="compname" id="compname"/>
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
        <div><strong>Update Company</strong></div>
        <div>
            <form id="saveeditcomp" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">InternalCode&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="ecomp" id="ecomp"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">CompanyDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="ecompid" id="ecompid"/>
                            <input type="text" class="form-control" name="ecompname" id="ecompname"/>
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
	<h3>จัดการบริษัท</h3>

	<button class="btn btn-primary" id="adddep">เพิ่มบริษัท</button>
    <button class="btn btn-primary" id="editcomp">แก้ไขบริษัท</button>   
    <br><br>
    <div id="grid"></div>
</div>

<script type="text/javascript">
	var theme_s = 'ui-redmond';
	var customer_source =
    {
        datatype: "json",
        url : './companymaster',
        datafields: [
            { name: 'CompanyID', type: 'int' },
            { name: 'InternalCode', type: 'string' },
            { name: 'CompanyDescription', type: 'string' }
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
            {text: 'CompanyID',datafield: 'CompanyID'},
            {text: 'InternalCode',datafield: 'InternalCode'},
            {text: 'CompanyDescription',datafield: 'CompanyDescription'}
            
        ]
    });

    $('#adddep').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savedep').trigger('reset');
    });

    $('#dialogadd').jqxWindow({
             width : 400,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedit').jqxWindow({
             width : 400,
             height : 250,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#savecomp').submit(function(e){
        e.preventDefault(); 

        if($.trim($('#comp').val())==''){
            gotify("กรุณากรอก InternalCode","danger")
        }else if($.trim($('#compname').val())==''){
            gotify("กรุณากรอก CompanyDescription","danger")
        }else{
            
            $.ajax({
                url : './addcomp',
                type : 'post',
                data : {
                  comp : $('#comp').val(),
                  compname : $('#compname').val()
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

    $('#editcomp').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            $('#saveeditcomp').trigger('reset');
            $('#dialogedit').jqxWindow('open');
            $('#ecompid').val(datarow.CompanyID);
            $('#ecomp').val(datarow.InternalCode);
            $('#ecompname').val(datarow.CompanyDescription);

        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  

    });

    $('#saveeditdep').submit(function(e){
        e.preventDefault();
        if($.trim($('#ecomp').val())==''){
            gotify("กรุณากรอก InternalCode","danger")
        }else if($.trim($('#ecompname').val())==''){
            gotify("กรุณากรอก CompanyDescription","danger")
        }else{ 
            
            $.ajax({
            url : './editcomp',
            type : 'post',
            data : {
              ecomp : $('#ecomp').val(),
              ecompname : $('#ecompname').val(),
              ecompid : $('#ecompid').val
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