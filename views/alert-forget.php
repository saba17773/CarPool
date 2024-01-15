<?php $this->layout("layout-base"); ?>
<?php 
    $no = $_GET["no"];
   /* if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }*/
?>
<script type="text/javascript">
   var no = '<?php echo $no ?>';
   var requestid = '<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>';
    if (no==1) {
        //swal("ดำเนินการสำเร็จ", "กรุณาเช็ครหัสผ่านที่ e-mail !", "success")
        //swal({   title: "รหัสผ่านถูกส่งไปยัง e-mail ของคุณแล้ว",   text: "กด OK เพื่อเข้าสู่หน้าระบบ",   imageUrl: "assets/sweetalert-master/example/images/hotmail-icon.png" });
        swal({  title: "รหัสผ่านถูกส่งไปยัง e-mail ของคุณแล้ว",   
                text: "กด ตกลง เพื่อเข้าสู่ระบบ",
                imageUrl: "assets/sweetalert-master/example/images/hotmail-icon.png", 
                //showCancelButton: true,
                confirmButtonColor: "#33CCFF",
                confirmButtonText: "ตกลง",
                closeOnConfirm: false
            },function(isConfirm){   
            if (isConfirm) {  
                location = "./login";
            } 
        });     
    }else if(no==2){
        swal({  title: "คุณได้ทำการเปลี่ยนแปลงรหัสผ่านแล้ว",
                text: "กด ตกลง เพื่อเข้าสู่ระบบใหม่ หรือ ยกเลิก เพื่ออยู่ในระบบ",
                imageUrl: "assets/sweetalert-master/example/images/change.png",  
                showCancelButton: true,
                closeOnConfirm: false, 
                cancelButtonText: "ยกเลิก",
                confirmButtonText: "ตกลง",
                confirmButtonColor: "#33CCFF",  
                showLoaderOnConfirm: true, 
            }, function(isConfirm){   
            if (isConfirm) {  
                location = "./logout";
            }else{
                location = "./";
            } 
        });  
    }else if(no==3){
        swal({  title: "เกิดข้อผิดพลาด",
                text: "กรุณาติดต่อ IT-EA",
                imageUrl: "assets/sweetalert-master/example/images/error.png",  
                confirmButtonColor: "#BB0000",
                confirmButtonText: "ตกลง",
                closeOnConfirm: false
            },function(isConfirm){   
            if (isConfirm) {  
                //location = "./login";
                window.history.back();
            } 
        }); 
    }else if(no==4){
        swal({  title: "ดำเนินการสำเร็จ",
                imageUrl: "assets/sweetalert-master/example/images/success.png",  
                timer: 3000,   showConfirmButton: false
                },function(){   
                location = "./list-email?id="+requestid;
            });
    }else if(no==5){
        swal({  title: "สมัครใช้งานสำเร็จ",
                text: "สถานะ รอการอนุมัติจาก HR",
                imageUrl: "assets/sweetalert-master/example/images/success.png",  
                //confirmButtonColor: "#33CCFF",
                confirmButtonText: "ตกลง",
                closeOnConfirm: false
                },function(isConfirm){   
                if (isConfirm) {  
                    location = "./login";
                } 
            });
    }

</script>