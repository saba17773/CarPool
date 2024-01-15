<?php $this->layout("layout-base"); ?>


	
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="page-header">
                    <h2>For get your password ? <span class="glyphicon glyphicon-lock"></span></h2>
                </div>

                <form id="defaultForm" class="form-horizontal" method="post" action="./forget">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="email"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary" name="signup" type="submit">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
 
    $('#defaultForm').formValidation({
        message: 'This value is not valid',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'กรุณากรอก e-mail'
                    },
                    emailAddress: {
                        message: 'รูปแบบ e-mail ไม่ถูกต้อง'
                    }
                }
            }
        }
    });
});
</script>
