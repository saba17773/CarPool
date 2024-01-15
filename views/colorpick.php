<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $this->layout("layout-base"); ?>
<link href="./assets/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<script src="./assets/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<style type="text/css">
/* Adjust feedback icon position */
#colorPickerForm .colorPickerContainer .form-control-feedback {
    right: -15px;
}

	/* The Modal (background) */
	.modal {
	    display: none; /* Hidden by default */
	    position: fixed; /* Stay in place */
	    z-index: 1; /* Sit on top */
	    padding-top: 100px; /* Location of the box */
	    left: 0;
	    top: 0;
	    width: 100%; /* Full width */
	    height: 100%; /* Full height */
	    overflow: auto; /* Enable scroll if needed */
	    background-color: rgb(0,0,0); /* Fallback color */
	    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	    background-color: #fefefe;
	    margin: auto;
	    padding: 20px;
	    border: 1px solid #888;
	    width: 50%;
	}

	/* The Close Button */
	.close {
	    color: #aaaaaa;
	    float: right;
	    font-size: 28px;
	    font-weight: bold;
	}

	.close:hover,
	.close:focus {
	    color: #000;
	    text-decoration: none;
	    cursor: pointer;
	}
</style>

<!-- dialog -->
<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
	    <span class="close">×</span>
	    <h4><p>รายละเอียด</p></h4>
	    <form id="colorPickerForm" class="form-horizontal" method="post" action="./addcolorcar" enctype="multipart/form-data">
	    	<div class="form-group">
		        <label class="col-xs-3 control-label">ป้ายทะเบียน</label>
		        <div class="col-xs-6 ">
		            <div class="input-group">
		                <!-- <input type="text" data-format="hex" class="form-control " name="idregis" id="idregis"/> -->
		                <h5><p id="idregis"></p></h5>
		            </div>
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="col-xs-3 control-label">Color</label>
		        <div class="col-xs-6 ">
		            <div class="input-group" id="colorPicker">
		            	<input type="hidden" name="id" id="id">
		                <input type="text" data-format="hex" class="form-control " name="cp8" id="cp8"/>
		            </div>
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="col-xs-3 control-label">Image</label>
		        <div class="col-xs-6 ">
		            <div class="input-group">
		               <input type="file" name="fileToUpload" id="fileToUpload">
		            </div>
		        </div>
		    </div>

		    <div class="form-group">
		        <div class="col-sm-9 col-sm-offset-3">
		            <button type="submit" class="btn btn-primary" name="savecolor" id="savecolor" >บันทึก</button>
		        </div>
		    </div>
		</form>
	  </div>

	</div>

<!-- <form id="colorPickerForm" class="form-horizontal" method="post" action="./addcolorcar">
    <div class="form-group">
        <label class="col-xs-3 control-label">Color</label>
        <div class="col-xs-6 ">
            <div class="input-group" id="colorPicker">
                <input type="text" data-format="hex" class="form-control " name="cp8" id="cp8"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <button type="submit" class="btn btn-primary" name="savecolor" id="savecolor" >บันทึก</button>
        </div>
    </div>
</form> -->


<div class="container">
	<h3>จัดการสีและภาพรถ</h3>
	<table class="table table-striped table-hover">

    <tr>
        <td style="text-align: center; width:30%;">
            <b>ป้ายทะเบียน</b>
        </td>
        <td style="text-align: center; width:20%;">
            <b>สี</b>
        </td>
        <td style="text-align: center; width:30%;">
        	ภาพรถ
        </td>
        <td style="text-align: center; width:20%;">
        	
        </td>
      </tr>

      <?php 
        $db = db();
        $sql = "SELECT *
                FROM  CarMaster";
        $stmt = sqlsrv_query($db,$sql);
        while( $obj = sqlsrv_fetch_object( $stmt)) {
      ?>
      <tbody>
      <tr>
        <td style="text-align: center; width:30%;">
        	<?php echo $obj->CarRegistration; ?>
        </td>
        <td style="text-align: center; width:20%;">
        	<!-- <?php echo $obj->CarColor; ?> -->
        	<p align="center" style="background:<?php echo $obj->CarColor ?>; padding:10px; display:block;  margin:0 auto;">
			</p>
        </td>
        <td style="text-align: center; width:30%;">
        	<?php if (isset($obj->CarFileName)) { ?>
        		<img height="100" width="200" src="./img/<?php echo $obj->CarFileName;?>">
        	
        	<?php }else{ ?>	
        		<img height="100" width="200" src="./img/noimg.GIF">
        	<?php } ?>
        	
        </td>
        <td style="text-align: center; width:20%;">

        	<button class="btn btn-default" Onclick="return update('<?php echo $obj->CarID; ?>','<?php echo $obj->CarColor; ?>','<?php echo $obj->CarRegistration; ?>')"> Update </button>
        </td>
      </tr>
      </tbody>
      <?php
        }
      ?>
    </table>
</div>
<!-- <form id="colorPickerForm" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Color</label>
        <div class="col-xs-6 colorPickerContainer">
            <div class="input-group" id="colorPicker">
                <input type="text" class="form-control" name="color" />
                <span class="input-group-addon" style="color: #fff">Pick a color</span>
            </div>
        </div>
    </div>
</form> -->

<script>
/*$(document).ready(function() {
    $('#colorPickerForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            color: {
                validators: {
                    color: {
                        message: 'The color code is not valid'
                    }
                }
            }
        }
    });

    $('#colorPicker')
        .colorpicker()
        .on('showPicker changeColor', function(e) {
            $('#colorPickerForm').formValidation('revalidateField', 'color');
        });
});*/
$(function() {
        $('#cp8').colorpicker({
            colorSelectors: {
               /* 'default': '#777777',
                'primary': '#337ab7',
                'success': '#5cb85c',
                'info': '#5bc0de',
                'warning': '#f0ad4e',
                'danger': '#d9534f'*/

                '#777777': '#777777',
                '#337ab7': '#337ab7',
                '#5cb85c': '#5cb85c',
                '#5bc0de': '#5bc0de',
                '#f0ad4e': '#f0ad4e',
                '#d9534f': '#d9534f'
            }
        });
    });
function update(id,colorcar,idregis) {
		$('#id').val(id);
        $('#cp8').val(colorcar);
        //$('#idregis').val(idregis);
        $('#myModal').show();
        document.getElementById("idregis").innerHTML = idregis;
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
		    $('#myModal').hide();
		}
}
</script>