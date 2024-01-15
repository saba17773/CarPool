<?php $this->layout("layout-base"); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="page-header">
                <h2>Register<span class="glyphicon glyphicon-user"></span></h2>
              
            </div>

            <form id="defaultForm" class="form-horizontal" method="post" action="./registering">
                <div class="form-group">
                    <label class="col-sm-3 control-label">อีเมลล์</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" id="email"/>
                        <input type="hidden" class="form-control" name="email_fake" id="email_fake"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">ชื่อ-นามสกุล</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">บริษัท</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="comp" name="comp"/></select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">แผนก</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="dep" name="dep"/></select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">เบอร์โทรแผนก</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="tel"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">เบอร์โทรส่วนตัว</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="telme"/>
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
                    },
                    different: {
                        field: 'email_fake',
                        message: 'E-mail ซ้ำ'
                    }
                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'กรุณาชื่อ-นามสกุล'
                    }
                }
            },
            dep: {
                validators: {
                    notEmpty: {
                        message: 'กรุณาเลือกแผนก'
                    }
                }
            },
            comp: {
                validators: {
                    notEmpty: {
                        message: 'กรุณาเลือกบริษัท'
                    }
                }
            },
            tel: {
                validators: {
                    notEmpty: {
                        message: 'กรุณากรอกเบอร์แผนก'
                    }
                }
            }
        }
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

});

</script>
