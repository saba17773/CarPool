<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $id = $_GET["id"]; ?>
<?php $this->layout("layout-base"); ?>
<div class="container">

	<h3>E-mail Approve</h3>
	<table>
			<tr>
				<td>
					<h4>กรุณาเลือก E-mail ผู้อนุมัติ</h4> 
				</td>
			</tr>
			<tr>
				<td>
					<div id="checkEmailSend"></div>
				</td>
			</tr>
			<tr>
                <td>
                    <input  type="button" id='send4approve' value="Send" class="btn-primary">
                    <input  type="button" id='cancel' value="Cancel" class="btn-primary">
                </td>       
            </tr>
	</table>
</div>

<script type="text/javascript">

	$.getJSON( "./listmailmanager",function( data ) {
    $('#checkEmailSend').html("");
      $.each( data, function( key, val ){
          $('#checkEmailSend').append( "<label><input type='checkbox' class='ccEmail' name='cEmail[]' value='"+val.Email+"'> "+val.Email+"&nbsp;&nbsp;&nbsp;("+val.Name+")</label><br>" );
      });
  	});

  	$('#cancel').bind('click',function(){     
      window.location.href = './home';
  	});

  	$('#send4approve').click(function(e){
  		    e.preventDefault();
            $('#send4approve').prop('disabled',true);
            $('#cancel').prop('disabled',true);
            $('#send4approve').val('รอสักครู่...'); 
            var id = '<?php echo $id ?>';
            var vals = [];
            var vals_not = [];
              $(':checkbox:checked').each(function(i,v){
                vals[i] = $(this).val();
              });
              $(':checkbox').each(function(i,v){
                vals_not[i] = $(this).val();
              });
        
            $.ajax({
              url : './sendemail',
              type : 'post',
              data : {
                mail : vals,
                mail_not : vals_not,
                id : id

              },
              success : function(data) {
               // alert(data);
                if (data==1) {
                  swal({  title: "ดำเนินการส่งสำเร็จ",
                    imageUrl: "assets/sweetalert-master/example/images/hotmail-icon.png", 
                    timer: 3000,   
                    showConfirmButton: false},function(){   
                    location = "./home";
                  });
                 
                }else{
                  alert("error");
                  // console.log(data);
                }

              },
             
              error: function (data) {
                 swal("กรุณาเลือก E-mail !")
                 //alert('Please Click Checkbox');
                 $('#send4approve').prop('disabled',false);
                 $('#send4approve').val('Send'); 
                 $('#cancel').prop('disabled',false);
                 $('#cancel').val('Cancel'); 
              // console.log(data);
              }
            });
 
    });
</script>