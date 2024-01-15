<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $this->layout("layout-base"); ?>
<?php
    $db=db();
    $loggedmail = $_SESSION['loggedmail'];
    $sql = "SELECT  TOP 1 UserID
      				,PassWord
      				,Email
                FROM  UserMaster WHERE Email='$loggedmail' ";
    $query = sqlsrv_query($db,$sql);
    while($result = sqlsrv_fetch_object($query))
	{
		
?>

	<div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="page-header">
                    <h2>การตั้งค่าบัญชีผู้ใช้ <span class="glyphicon glyphicon-lock"></span></h2>
                </div>
            
                <form id="identicalForm" class="form-horizontal" method="post" action="./update-account">
                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">อีเมลล์</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="email" 
                            value="<?php echo $result->Email;?>" readonly/>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><u>รหัสผ่าน</u></label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">ปัจจุบัน</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" name="oldpassword"/>
                            <input type="hidden" class="form-control" name="oldpass" 
                            value="<?php echo $result->PassWord;?>"/>
                        </div>
                    </div>
			    	
				    <div class="form-group">
				        <label class="col-xs-3 control-label">ใหม่</label>
				        <div class="col-xs-5">
				            <input type="password" class="form-control" name="password" />
				        </div>
				    </div>

				    <div class="form-group">
				        <label class="col-xs-3 control-label">ใหม่ อีกครั้ง</label>
				        <div class="col-xs-5">
				            <input type="password" class="form-control" name="confirmPassword" />
				        </div>
				    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary" name="signup" type="submit">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
//var Text_Pattern = "[a-z]{1,15}";
    $('#identicalForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        	oldpassword: {
                validators: {
                    identical: {
                        field: 'oldpass',
                        message: 'รหัสผ่านไม่ถูกต้อง'
                    }
                }
            },
        	password: {
                validators: {
                    notEmpty: {
                        message: 'กรุณากรอก'
                    }
                    /*regexp: {
                        regexp: Text_Pattern,
                        message: 'โปรดใช้ภาษา english'
                    }*/
                }
            },
            confirmPassword: {
                validators: {
                	notEmpty: {
                        message: 'กรุณากรอก'
                    },
                    identical: {
                        field: 'password',
                        message: 'รหัสผ่านไม่ตรงกัน'
                    }
                }
            }
        }
    });
});
</script>

