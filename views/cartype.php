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
        <div><strong>Create CarType</strong></div>
        <div>
            <form id="savecar" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">CarTypeName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="cartypename" id="cartypename"/>
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
        <div><strong>Update CarType</strong></div>
        <div>
            <form id="saveeditcar" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">CarTypeName&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" id="idcartype">
                            <input type="text" class="form-control" name="ecartypename" id="ecartypename"/>
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
	<h3>จัดการชนิดรถ</h3>

	<button class="btn btn-primary" id="addcar">เพิ่มชนิดรถ</button>
    <button class="btn btn-primary" id="editcar">แก้ไขชนิดรถ</button>   
    <br><br>
    <div id="grid"></div>
</div>



<script type="text/javascript">
var theme_s = 'ui-redmond';
var customer_source =
    {
        datatype: "json",
        url : './cartypemaster',
        datafields: [
            { name: 'CarTypeID', type: 'int' },
            { name: 'CarTypeName', type: 'string' }
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
            {text: 'CarTypeName',datafield: 'CarTypeName'}
            
        ]
    });


    $('#addcar').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savecar').trigger('reset');
    });

    $('#dialogadd').jqxWindow({
             width : 350,
             height : 200,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedit').jqxWindow({
             width : 350,
             height : 200,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#savecar').submit(function(e){
        e.preventDefault();

        if($.trim($('#cartypename').val())==''){
            gotify("กรุณากรอก CarTypeName","danger")
        }else{
            
            $.ajax({
                url : './addcartype',
                type : 'post',
                data : {
                  cartypename : $('#cartypename').val()
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
            $('#saveeditcar').trigger('reset');
            $('#dialogedit').jqxWindow('open');
            $('#ecartypename').val(datarow.CarTypeName);
            $('#idcartype').val(datarow.CarTypeID);
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  

    });

    $('#saveeditcar').submit(function(e){
        e.preventDefault();
        if($.trim($('#ecartypename').val())==''){
            gotify("กรุณากรอก CarTypeName","danger")
        }else{ 
            
            $.ajax({
            url : './editcartype',
            type : 'post',
            data : {
              ecartypename : $('#ecartypename').val(),
              id : $('#idcartype').val()
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