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

<!-- dialog employee -->
<div id="modal_employee">
    <div><strong>Employee</strong></div>
    <div id="grid_empployee"></div>
</div>
<div id="dialogadd">
        <div><strong>Create User</strong></div>
        <div>
            <form id="saveuser" class="form-horizontal">

            <table> 
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Employee</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" name="user_employee" id="user_employee" class="form-control" required style="width: 200px;" readonly="ture">
                            <button class="btn btn-primary" id="btn_employee" type="button">
                              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            </button>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Email</label>
                            </div>
                        </div>
                    </td>
                    <td>
                    	<div class="form-group">
                    		<div class="col-sm-12">
	                        <input type="text" class="form-control" name="email" id="email"/>
                    		</div>
                    	</div>
                    </td>
                    <td>
                    	<div class="form-group">
                    		<div class="col-sm-12">
                        	<label class="control-label">&nbsp;&nbsp;&nbsp;Password&nbsp;&nbsp;&nbsp;</label>
                    		</div>
                    	</div>
                    </td>
                    <td>
                    	<div class="form-group">
                    		<div class="col-sm-12">
	                        <input type="password" class="form-control" name="password" id="password"/>
                    		</div>
                    	</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Name</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" name="name" id="name"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Level</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="level" name="level" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Department</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <select class="form-control" name="dep" id="dep"></select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Company</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="comp" name="comp" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Tel</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <input type="text" class="form-control" name="tel" id="tel"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Phone</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <input type="text" class="form-control" name="telme" id="telme"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Permission</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="per" name="per" /></select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">MenuGroup</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="group" name="group" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Status</label>
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
                <td colspan="4" align="center">
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
        <div><strong>Update User</strong></div>
        <div>
            <form id="saveedituser" class="form-horizontal">
            <table>  
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Employee</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="hidden" name="userid" id="userid">
                            <input type="text" name="euser_employee" id="euser_employee" class="form-control" required style="width: 200px;" readonly="ture">
                            <button class="btn btn-primary" id="ebtn_employee" type="button">
                              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            </button>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Email</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="eemail"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Password&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input type="password" class="form-control" id="epassword"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Name</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="ename"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Level</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="elevel" name="elevel" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Department</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <select class="form-control" name="edep" id="edep"></select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Company</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="ecomp" name="ecomp" /></select>
                            </div>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Tel</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="etel"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;Phone</label>
                            </div>
                        </div>
                    </td>
                    <td>
                       <div class="form-group">
                            <div class="col-sm-12" >
                            <input type="text" class="form-control" name="etelme" id="etelme"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Permission</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="eper" name="eper" /></select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">MenuGroup</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12" >
                            <select class="form-control" id="egroup" name="egroup" /></select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label class="control-label">Status</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                               <!--  <div id="eswitch"></div> -->
                            <input type="radio" name="eswitch" value="1"> ON &nbsp;&nbsp;
                            <input type="radio" name="eswitch" value="0"> OFF
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                <td colspan="4" align="center">
                    <br>
                    <button  type="submit" class="btn btn-primary" id="editsave">Save</button>
                    <button  type="reset"  class="btn btn-default" id="canceledit">Cancel</button>
                </td>
            </tr>
            </table>
            </form>
        </div>
</div>

<div class="container">
	<h3>จัดการผู้ใช้งาน</h3>

	<button class="btn btn-primary" id="adduser">เพิ่มผู้ใช้งาน</button>
    <button class="btn btn-primary" id="edituser">แก้ไขผู้ใช้งาน</button>   
    <br><br>
    <div id="grid"></div>
</div>


<script type="text/javascript">
//$('selected').multipleSelect();
    jQuery(document).ready(function($) {

        var theme_s = 'ui-redmond';
    	var customer_source =
        {
            datatype: "json",
            url : './usermaster',
            datafields: [
                { name: 'UserID', type: 'int' },
                { name: 'Password', type: 'string' },
                { name: 'Email', type: 'string' },
                { name: 'Name', type: 'string' },
                { name: 'Company', type: 'int' },
                { name: 'InternalCode', type: 'string' },
                { name: 'Department', type: 'string' },
                { name: 'DepartmentDescription',type: 'string'},
                { name: 'LevelID', type: 'int' },
                { name: 'LevelDescription', type: 'string' },
                { name: 'Tel', type: 'string'},
                { name: 'TelMe', type: 'string'},
                { name: 'PermissionID', type: 'int'},
                { name: 'PermissionName', type: 'string'},
                { name: 'MenuGroup', type: 'int'},
                { name: 'Active', type: 'int'},
                { name: 'GroupDescription', type: 'string'},
                { name: 'EMPID', type: 'string'}
            ]
        };

        var customer_adapter = new $.jqx.dataAdapter(customer_source);

        $("#grid").jqxGrid(
        {
            width: '100%',
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
                {text: 'Email',datafield: 'Email',width:200},
                // {text: 'Password',datafield: 'Password',width:70}, 
                {text: 'Name',datafield: 'Name',width:150},
                {text: 'Level',datafield: 'LevelDescription',width:140,filtertype: 'checkedlist'},
                {text: 'Department',datafield: 'DepartmentDescription',width:150,filtertype: 'checkedlist'},
                {text: 'Company',datafield: 'InternalCode',width:80,filtertype: 'checkedlist'},
                {text: 'Tel',datafield: 'Tel',width:50},
                {text: 'Phone',datafield: 'TelMe',width:100},
                {text: 'Permission',datafield: 'PermissionName',filtertype: 'checkedlist'},
                {text: 'GroupMenu',datafield: 'GroupDescription',filtertype: 'checkedlist'},
                //{text: 'Active',datafield: 'Active',width:50}
                {text: 'Active',datafield:  'Active' , width:55, filterable: false,
                    cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                        var status;
                           if (value ==1) {
                               status =  "<div style='padding: 5px; background:#00BB00 ; color:#ffffff;'>ON</div>";
                           }else{
                               status =  "<div style='padding: 5px; background:#EE0000 ; color:#ffffff;'>OFF</div>";
                           }
                        
                           return status;
                    }
                }
                
            ]
        });	

        $('#adduser').on('click',function(){
        	$('#dialogadd').jqxWindow('open');
            $('#saveuser').trigger('reset');
            $('#per').hide();
            //$('#group').hide();
            $.getJSON("./levelmaster", function(data) {
                $('#level').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#level').append("<option value='" + val.LevelID+ "'>" + val.LevelDescription + "</option>");
                    $('#level').val();
                });
            });
            $.getJSON("./departmentmaster", function(data) {
                $('#dep').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#dep').append("<option value='" + val.DepartmentID+ "'>" + val.DepartmentDescription + "</option>");
                    $('#dep').val();
                });
            });
            $.getJSON("./companymaster", function(data) {
                $('#comp').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#comp').append("<option value='" + val.CompanyID+ "'>" + val.InternalCode + "</option>");
                    $('#comp').val();
                });
            });
            $.getJSON("./permissionmaster", function(data) {
                $('#per').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#per').append("<option value='" + val.PermissionID+ "'>" + val.PermissionName + "</option>");
                    $('#per').val();
                });
            });
            $.getJSON("./menugroupmaster", function(data) {
                $('#group').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#group').append("<option value='" + val.GroupID+ "'>" + val.GroupDescription + "</option>");
                    $('#group').val();
                });
            });
            
            $("select[name=level]").bind('click', function() {
                if ($("select[name=level]").val() == 4) {
                    $('#per').show();
                    //$('#group').show();
                }else{
                    $('#per').hide();
                    //$('#group').hide();
                }
                            
            });
            var theme_u = 'ui-start';
            var theme_b = 'black';
            /*var status = 1;
                if (status==1) {
                    $('#switch').jqxSwitchButton({ height: 27, width: 81, checked: true, theme:theme_u });
                }else{
                    $('#switch').jqxSwitchButton({ height: 27, width: 81, checked: false, theme:theme_b });
                }

                $('.jqx-switchbutton').on('checked', function (event) {
                    //$('#events').text('OFF');
                    $('#switch').jqxSwitchButton({theme:theme_b});
                });
                $('.jqx-switchbutton').on('unchecked', function (event) {
                    //$('#events').text('ON');
                    $('#switch').jqxSwitchButton({theme:theme_u});
                });*/

        });

        $('#dialogadd').jqxWindow({
                 width : 640,
                 height : 500,
                 autoOpen : false,
                 isModal : true,
                 theme : theme_s      
        });
        $('#dialogedit').jqxWindow({
                 width : 640,
                 height : 500,
                 autoOpen : false,
                 isModal : true,
                 theme : theme_s      
        });

        $('#modal_employee').jqxWindow({
                width : 900,
                maxWidth: 900,
                height : 500,
                autoOpen : false,
                isModal : true,
                theme : theme_s      
        });

        $('#saveuser').submit(function(e){
    	    e.preventDefault();
            
            var chkemail =/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;        
            
            /*if ($('#switch').val()==1) {
                status = 1;
            }else{
                status = 0;
            }*/

            if ($('input[name=switch]:checked').val()==1) {
                status = 1;
            }else{
                status = 0;
            }

            var email = $('#email').val();
            var url = "./checkeduser?email="+email;
            $.get(url, function(data){
                
                // if(data==1){
                //     gotify("Email นี้ไม่สามารถใช้งานได้","danger")
                if($.trim($('#email').val())==''){
                    gotify("กรุณากรอก Email","danger")
                }else if (chkemail.test($('#email').val())===false){
                    gotify("กรุณาเช็ครูปแบบ Email","danger")
                }else if($.trim($('#password').val())==''){
                    gotify("กรุณากรอก Password","danger")
                }else if($.trim($('#name').val())==''){
                    gotify("กรุณากรอก Name","danger")
                 }else if($.trim($('#level').val())==''){
                    gotify("กรุณาเลือก Level","danger")
                }else if($.trim($('#dep').val())==''){
                    gotify("กรุณาเลือก Department","danger")
                }else if($.trim($('#comp').val())==''){
                    gotify("กรุณาเลือก Company","danger")    
                }else if($.trim($('#tel').val())==''){
                    gotify("กรุณากรอก Tel","danger")
                }else if($.trim($('#level').val())==4 && $.trim($('#per').val())==''){
                    gotify("กรุณาเลือก Permission","danger")
                }else if($.trim($('#level').val())==4 && $.trim($('#group').val())==''){
                    gotify("กรุณาเลือก MenuGroup","danger")
                }else{
                    if(data==1){
                        alert("แจ้งเตือน Email นี้ถูกใช้งานแล้ว");
                    }
                //alert(status);
                  $.ajax({
                    url : './adduser',
                    type : 'post',
                    data : {
                      employee : $('#user_employee').val(), 
                      email : $('#email').val(),
                      password : $('#password').val(),
                      name : $('#name').val(),
                      dep : $('#dep').val(),
                      comp : $('#comp').val(),
                      level : $('#level').val(),
                      tel : $('#tel').val(),
                      telme : $('#telme').val(),
                      per : $('#per').val(),
                      group : $('#group').val(),
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

            

      	});
        
        $('#edituser').on('click',function(){
            $('#eper').hide();
            //$('#egroup').hide();
            var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
            var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);

            if (datarow) {
            $('#saveedituser').trigger('reset');
            $('#dialogedit').jqxWindow('open');
            $('#euser_employee').val(datarow.EMPID);
            $('#eusername').val(datarow.Username);
            $('#epassword').val(datarow.Password);
            $('#eemail').val(datarow.Email);
            $('#ename').val(datarow.Name);
            //$('#edep').val(datarow.Department);
            $('#etel').val(datarow.Tel);
            $('#etelme').val(datarow.TelMe);
            $('#userid').val(datarow.UserID);

            $.getJSON("./levelmaster", function(data) {
                $('#elevel').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#elevel').append("<option value='" + val.LevelID+ "'>" + val.LevelDescription + "</option>");
                    $('#elevel').val(datarow.LevelID);
                });
            });
            $.getJSON("./departmentmaster", function(data) {
                $('#edep').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#edep').append("<option value='" + val.DepartmentID+ "'>" + val.DepartmentDescription + "</option>");
                    $('#edep').val(datarow.Department);
                });
            });
            $.getJSON("./companymaster", function(data) {
                $('#ecomp').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#ecomp').append("<option value='" + val.CompanyID+ "'>" + val.InternalCode + "</option>");
                    $('#ecomp').val(datarow.Company);
                });
            });
            $.getJSON("./permissionmaster", function(data) {
                $('#eper').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#eper').append("<option value='" + val.PermissionID+ "'>" + val.PermissionName + "</option>");
                    $('#eper').val(datarow.PermissionID);
                });
            });
            $.getJSON("./menugroupmaster", function(data) {
                $('#egroup').html("<option value=''>- Select -</option>");
                $.each(data, function(key, val) {
                    $('#egroup').append("<option value='" + val.GroupID+ "'>" + val.GroupDescription + "</option>");
                    $('#egroup').val(datarow.MenuGroup);
                });
            });

            //$("select[name=elevel]").bind('click', function() {
                if (datarow.LevelID == 4) {
                    $('#eper').show();
                    //$('#egroup').show();
                }else{
                    $('#eper').hide();
                    //$('#egroup').hide();
                }
                            
            //});
            $("select[name=elevel]").bind('click', function() {
                if ($("select[name=elevel]").val() == 4) {
                    $('#eper').show();
                    //$('#egroup').show();
                }else{
                    $('#eper').hide();
                    //$('#egroup').hide();
                }
                            
            });
            var theme_u = 'ui-start';
            var theme_b = 'black';
            var active = datarow.Active;
                
                if (active==1) {
                    $("input[name=eswitch][value='1']").prop('checked' , true);
                }else{
                    $("input[name=eswitch][value='0']").prop('checked' , true);
                }

               /* $('.jqx-switchbutton').on('checked', function (event) {
                    $('#eswitch').jqxSwitchButton({theme:theme_b});
                });
                $('.jqx-switchbutton').on('unchecked', function (event) {
                    $('#eswitch').jqxSwitchButton({theme:theme_u});
                });*/

            }else{
                gotify("กรุณาเลือกรายการ","danger")
            };    
        });

        $('#saveedituser').submit(function(e){
            e.preventDefault();

            var chkemail =/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;        

            if ($('input[name=eswitch]:checked').val()==1) {
                estatus = 1;
            }else{
                estatus = 0;
            }
            //alert(active);
            // console.log($('#userid').val());
            if($.trim($('#eemail').val())==''){
                gotify("กรุณากรอก Email","danger")
            }else if (chkemail.test($('#eemail').val())===false){
                gotify("กรุณาเช็ครูปแบบ Email","danger")
            }else if($.trim($('#epassword').val())==''){
                gotify("กรุณากรอก Password","danger") 
            }else if($.trim($('#ename').val())==''){
                gotify("กรุณากรอก Name","danger")
            }else if($.trim($('#elevel').val())==''){
                gotify("กรุณาเลือก Level","danger")
            }else if($.trim($('#edep').val())==''){
                gotify("กรุณาเลือก Department","danger")
            }else if($.trim($('#ecomp').val())==''){
                gotify("กรุณาเลือก Company","danger")     
            }else if($.trim($('#etel').val())==''){
                gotify("กรุณากรอก Tel","danger")
            }else if($.trim($('#elevel').val())==4 && $.trim($('#eper').val())==''){
                gotify("กรุณาเลือก Permission","danger")
            }else if($.trim($('#elevel').val())==4 && $.trim($('#egroup').val())==''){
                gotify("กรุณาเลือก MenuGroup","danger")
            }else{  
                //alert(status);
                $.ajax({
                url : './edituser',
                type : 'post',
                data : {
                  euser_employee : $('#euser_employee').val(),  
                  email : $('#eemail').val(),
                  password : $('#epassword').val(),             
                  name : $('#ename').val(),
                  dep : $('#edep').val(),
                  comp : $('#ecomp').val(),
                  level : $('#elevel').val(),
                  tel : $('#etel').val(),
                  telme : $('#etelme').val(),
                  per : $('#eper').val(),
                  group : $('#egroup').val(),
                  status : estatus,
                  userid : $('#userid').val()
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

        $('#btn_employee').on('click', function () {
            $('#modal_employee').jqxWindow('open');
            load_gridemployee();
            return false;
        });

        $('#ebtn_employee').on('click', function () {
            $('#modal_employee').jqxWindow('open');
            load_gridemployee();
            return false;
        });

        $("#grid_empployee").on('rowdoubleclick', function(event) {
            var args = event.args;
            var row = $("#grid_empployee").jqxGrid('getrowdata', args.rowindex);
            // add
            $('#user_employee').val(row.CODEMPID);
            $('#name').val(row.EMPNAME +' '+ row.EMPLASTNAME);
            $('#email').val(row.EMAIL);
            // edit
            $('#euser_employee').val(row.CODEMPID);
            $('#ename').val(row.EMPNAME +' '+ row.EMPLASTNAME);
            $('#eemail').val(row.EMAIL);

            $('#modal_employee').jqxWindow('close');
        });

    });
    
    function load_gridemployee(){

        var dataAdapter = new $.jqx.dataAdapter({
        datatype: "json",
        datafields: [
        { name: 'CODEMPID', type: 'string' },
        { name: 'EMPNAME', type: 'string' },
        { name: 'EMPLASTNAME', type: 'string' },
        { name: 'DEPARTMENTNAME', type: 'string' },
        { name: 'DIVISIONNAME', type: 'string' },
        { name: 'COMPANYNAME', type: 'string' },
        { name: 'EMAIL', type: 'string' },
        { name: 'DIVISIONID', type: 'string' },
        { name: 'DEPARTMENTCODE', type: 'string' }
        ],
          url: './usermaster/employee',
        });

        return $("#grid_empployee").jqxGrid({
            width: '100%',
            source: dataAdapter,
            autoheight: true,
            pageSize: 10,
            altrows: true,
            pageable: true,
            sortable: true,
            filterable: true,
            showfilterrow: true,
            columnsresize: true,
            theme: 'default',
            columns: [
              {text: 'EmployeeCode',datafield: 'CODEMPID',width:110},
              {text: 'Firstname',datafield: 'EMPNAME',width:110},
              {text: 'Lastname',datafield: 'EMPLASTNAME',width:110},
              {text: 'Section',datafield: 'DIVISIONNAME',width:100},
              {text: 'Department',datafield: 'DEPARTMENTNAME',width:100},
              {text: 'Company',datafield: 'COMPANYNAME',width:100},
              {text: 'E-mail',datafield: 'EMAIL'}

            ]
        });
    }

</script>