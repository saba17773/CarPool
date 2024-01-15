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

<div class="container">
	<h3>MenuGroup</h3>

	<button class="btn btn-primary" id="addgroup">เพิ่มเมนูใช้งาน</button>
    <button class="btn btn-primary" id="editgroup">แก้ไขเมนูใช้งาน</button>   
    <br><br>
        <div id="grid"></div>
</div>

<div id="dialogmenu">
        <div><strong>กำหนดเมนูใช้งาน</strong></div>
        <div>
             <div id="gridmenu"></div>
        </div>
</div>

<div id="dialogadd">
        <div><strong>Create MenuGroup</strong></div>
        <div>
            <form id="savegroup" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">GroupDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="groupname" id="groupname"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">MenuDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                    <div class="col-sm-12">

                    <?php 
                        $db = db();
                        $sql = "SELECT * FROM  MenuMaster";
                        $stmt = sqlsrv_query($db,$sql);
                        while( $obj = sqlsrv_fetch_object( $stmt)) {
                            echo '<input type="checkbox" class="comp" value="'.$obj->MenuID.'">'. '&nbsp;&nbsp;'.$obj->MenuName."<br>";
                        }
                    ?>
                    
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
        <div><strong>Update MenuGroup</strong></div>
        <div>
            <form id="saveeditgroup" class="form-horizontal">

            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">GroupDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="hidden" name="eidgroup" id="eidgroup">
                            <input type="text" class="form-control" name="egroupname" id="egroupname"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">MenuDescription&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                    <div class="col-sm-12">

                    <?php 
                        $db = db();
                        $sql = "SELECT * FROM  MenuMaster";
                        $stmt = sqlsrv_query($db,$sql);
                        while( $obj = sqlsrv_fetch_object( $stmt)) {
                            echo '<input type="checkbox" class="ecomp" value="'.$obj->MenuID.'">'. '&nbsp;&nbsp;'.$obj->MenuName."<br>";
                        }
                    ?>
                    
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

<script type="text/javascript">
    var theme_s = 'ui-redmond';
    var customer_source =
    {
        datatype: "json",
        url : './menumaster',
        datafields: [
            { name: 'GroupID', type: 'int' },
            { name: 'GroupDescription', type: 'string' },
            { name: 'MenuID', type: 'string' }
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
            {text: 'GroupID',datafield: 'GroupID'},
            {text: 'GroupDescription',datafield: 'GroupDescription'},
            {text: 'MenuID',datafield: 'MenuID'}
            
        ]
    });

    //gridmenu
    var menu_source =
    {
        datatype: "json",
        url : './menudescripmaster',
        datafields: [
            { name: 'MenuID', type: 'int' },
            { name: 'MenuName', type: 'string' },
            { name: 'MenuLink', type: 'string' }
        ]
    };

    var menu_adapter = new $.jqx.dataAdapter(menu_source);

    $("#gridmenu").jqxGrid(
    {
        width: '99.5%',
        height: '98.5%',
        source: menu_adapter,  
        theme : theme_s,
        columns: [
            {text: 'MenuID',datafield: 'MenuID'},
            {text: 'MenuName',datafield: 'MenuName'},
            {text: 'MenuLink',datafield: 'MenuLink'}
            
        ]
    });

    $('#addgroup').on('click',function(){
        $('#dialogadd').jqxWindow('open');
        $('#savegroup').trigger('reset');
    });

    $('#dialogadd').jqxWindow({
             width : 400,
             height : 400,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedit').jqxWindow({
             width : 400,
             height : 400,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $("#dialogmenu").jqxWindow({
        height: 355,
        width: 320,
        theme: theme_s,
        position: { x: 1000, y: 100 }
       // closeButtonSize: 20
    });

    $('#savegroup').submit(function(e){
        e.preventDefault();

        var comp_checked = [];
        var e= 0;
        $('.comp:checked').each(function(){
                comp_checked[e++] = $(this).val();
        });

        if($.trim($('#groupname').val())==''){
            gotify("กรุณากรอก GroupDescription","danger")
        }else{
            //alert(comp_checked);
            $.ajax({
                url : './addgroup',
                type : 'post',
                data : {
                  groupname : $('#groupname').val(),
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

    $('#editgroup').on('click',function(){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

        if (datarow) {
            
            $('#saveeditgroup').trigger('reset');
            var str = datarow.MenuID;
                var array = str.split(',');
                if (str!='') {
                    var obj = array;
                    $.each( obj, function( key, value ) {
                      $('input[type=checkbox][value='+value+']').prop('checked','true');
                    });
                }
            $('#dialogedit').jqxWindow('open');
            $('#egroupname').val(datarow.GroupDescription);
            $('#eidgroup').val(datarow.GroupID);  
        }else{
            gotify("กรุณาเลือกรายการ","danger")
        };  
    });

    $('#saveeditgroup').submit(function(e){
        e.preventDefault();
        var ecomp_checked = [];
        var e= 0;
        $('.ecomp:checked').each(function(){
                ecomp_checked[e++] = $(this).val();
        });

        if($.trim($('#egroupname').val())==''){
            gotify("กรุณากรอก GroupDescription","danger")
        }else{ 
            
            $.ajax({
            url : './editgroup',
            type : 'post',
            data : {
              egroupname : $('#egroupname').val(),
              id : $('#eidgroup').val(),
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
