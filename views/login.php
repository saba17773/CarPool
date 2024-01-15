<?php $this->layout("layout-base"); ?>
<head>
    <title></title>

<script src="./assets/slide/jquery.bxslider.js"></script>
<link href="./assets/slide/jquery.bxslider.css" rel="stylesheet" />

</head>

<body>

<div align="center">
<!-- <div class="btn-panel">
    <button class="btn btn-default" data-backdrop="static" data-toggle="modal" data-target="#myModal">ลงชื่อเข้าใช้งานระบบ</button>
</div> -->
<h3><b>ระบบจองรถออนไลน์(TEST)</b></h3>
</div>
<hr> 

<center>
<div class="content" style="max-width:700px" >  

    <ul class="bxslider">

<?php 
    $db = db();
    $sql = "SELECT *
            FROM  CarMaster
            WHERE CarFileName IS NOT NULL";
    $stmt = sqlsrv_query($db,$sql);
    while( $obj = sqlsrv_fetch_object( $stmt)) {
?>
      <li><img src="./img/<?php echo $obj->CarFileName;?>"></li>

<?php
    }
?>
      <!-- <li><img src="./assets/slide/images/car/van1.jpg" /></li>
      <li><img src="./assets/slide/images/car/van2.jpg" /></li>
      <li><img src="./assets/slide/images/car/pickup1.jpg" /></li> -->
     
    </ul>
</body>    

</div>
</center>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b>ลงชื่อเข้าใช้งานระบบ</b></h4>
    </div>
     <br> 
    <form id="defaultForm" class="form-horizontal" method="post" action="./checklogin">
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">E-mail</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" id="username"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password" id="password"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="./forgetpassword" class="btn btn-link">ลืมรหัสผ่าน</a>
                            <button type="submit" class="btn btn-primary" name="signup" value="Sign up">เข้าใช้งาน</button>
                        </div>
                    </div>
                    <div class="footer">
                      <center>
                        <a href="./register" class="btn btn-link"><b>สมัครใช้งาน</b></a>
                        <p>Contact information : <a href="mailto:it_ea@deestone.com">
                        IT_EA@deestone.com</a> Tel : 171(SVO)</p>
                        <p>Copyright © 2016 EA Team @ Deestone Co., Ltd</p>
                      </center>
                    </div>
                    </div>
                    
                </form>
      </div>
    </div>
  </div>
</div>

<?php 
if(isset($_GET["a"])) {
    $haveclick = $_GET["a"];
}else{
    $haveclick = 0;
}
?>

<script type="text/javascript">
    var haveclick = '<?php echo $haveclick ?>';

    //alert(haveclick);
    if (haveclick==1) {
        $('#myModal').modal('show');
    }else{
	   $('#myModal').modal('hide');
    }

	$('#defaultForm').formValidation({
        message: 'This value is not valid',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    emailAddress: {
                        message: 'กรุณาเช็ครูปแบบอีเมลล์'
                    },
                    notEmpty: {
                        message: 'กรุณากรอกอีเมลล์'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'กรุณากรอกรหัสผ่าน'
                    }
                }
            }
        }
    });
/*
    $('#defaultForm').formValidation().on('submit', function(e) {
      if (e.isDefaultPrevented()) {
          
      } else {
      $.ajax({
        url : './checklogin',
        type : 'post',
        data : {
          username : $('#username').val(),
          password : $('#password').val()
        },
        success : function(data){
            //alert(data);
            $('#username').val('');
            $('#password').val('');
            if (data==1) {
              //alert('1');
              location ="./";   
            }else if(data==0){
              alert('กรุณาเช็คชื่อผู้ใช้งานและรหัสผ่าน');
            }
        },
        error : function(data){
            $('#username').val('');
            $('#password').val('');
            alert(data);
        }
      });
    }

  });*/
    $('.bxslider').bxSlider({
        mode: 'horizontal',
        infiniteLoop: true,
        auto: true,
        autoStart: true,
        autoDirection: 'next',
        autoHover: true,
        pause: 3000,
        autoControls: false,
        pager: true,
        pagerType: 'full',
        controls: true,
        captions: true,
        speed: 500
    });

</script>