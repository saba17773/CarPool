
<!DOCTYPE html>
<html>
<head>
<title>Carpool Calendar</title>
<meta charset='utf-8' />
<link href='./fullcalendar-scheduler/lib/fullcalendar.min.css' rel='stylesheet' />
<link href='./fullcalendar-scheduler/lib/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='./fullcalendar-scheduler/scheduler.min.css' rel='stylesheet' />

<script src='./fullcalendar-scheduler/lib/moment.min.js'></script>
<script src='./fullcalendar-scheduler/lib/jquery.min.js'></script>
<script src='./fullcalendar-scheduler/lib/fullcalendar.min.js'></script>
<script src='./fullcalendar-scheduler/scheduler.min.js'></script>

<script>

	$(function() { // document ready

		$('#calendar').fullCalendar({
			//now: '2016-09-19',
			now: new Date(),
			editable: false, // enable draggable events
			aspectRatio: 1.8,
			scrollTime: '00:00', // undo default 6am scrollTime
			header: {
				left: 'today prev,next',
				center: 'title',
				right: 'timelineDay,agendaWeek,month'
			},
			defaultView: 'timelineDay',
			views: {
				timelineThreeDays: {
					type: 'timeline',
					duration: { days: 3 }
				}
			},
			resourceLabelText: 'Cars',

			resources: { // you can also specify a plain string like 'json/resources.json'
				url: './fullcalendar-scheduler/demos/json/resources.php',
				error: function() {
					$('#script-warning').show();
				}
			},

			events: { // you can also specify a plain string like 'json/events.json'
				url: './fullcalendar-scheduler/demos/json/events.php',
				//url: 'json/events.json',
				error: function() {
					$('#script-warning').show();
				}
			},

			eventClick: function(calEvent, jsEvent, view) {
					//$('#calendar').fullCalendar('updateEvent', calEvent);
					// console.log(calEvent);
			        //alert('Event: ' + calEvent.title);
			        $('#myModal').show();
			        var start = moment(calEvent.start).format("dddd DD-MM-YYYY HH:mm");
			        var end = moment(calEvent.end).format("dddd DD-MM-YYYY HH:mm");
					document.getElementById("title_name").innerHTML = calEvent.title;
			        document.getElementById("start_name").innerHTML = start;
			        document.getElementById("end_name").innerHTML = end;
			        document.getElementById("car_name").innerHTML = calEvent.carname;
			        document.getElementById("car_type").innerHTML = calEvent.cartype;
			        document.getElementById("seat_name").innerHTML = calEvent.seatname+" คน";
			        document.getElementById("driver_name").innerHTML = calEvent.driver;
			        $('#request_id').val(calEvent.requestid);

			        var span = document.getElementsByClassName("close")[0];
			        span.onclick = function() {
					    $('#myModal').hide();
					}
			}
		});
		
		$('#print_detail').on('click',function(){
    		var page = '<?php echo getapplocation(); ?>';
            window.open('http://'+page+'/detail-complete-print.php?id='+$('#request_id').val(),'_blank');
	    });

	});

</script>

<style>

	body {
		margin: 0;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#script-warning {
		display: none;
		background: #eee;
		border-bottom: 1px solid #ddd;
		padding: 0 10px;
		line-height: 40px;
		text-align: center;
		font-weight: bold;
		font-size: 12px;
		color: red;
	}

	#loading {
		display: none;
		position: absolute;
		top: 10px;
		right: 10px;
	}

	#calendar {
		max-width: 900px;
		margin: 50px auto;
	}
	.car_list{
	  position: absolute;
	  float: left;
	  background: #ffffff;
	  margin: 15px;
	  padding: 20px;
	  border: 1px solid #cccccc;
	}
	/*body  {
        background-image: url("http://192.168.90.27:81/carpool/img/pattern.png");
    }*/
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
	    padding: 10px;
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
</head>
<body>

	<div id='script-warning'>
		This page should be running from a webserver, to allow fetching from the <code>json/</code> directory.
	</div>

	<div id='loading'>loading...</div>

	<div class="car_list">
		<p style="margin-bottom:10px;"><b>รายชื่อรถ</b></p>
		<table class="table table-condensed">

		<?php 
	        $db = db();
	        $sql = "SELECT 
               A.CarID
              ,A.CarRegistration
              ,A.CarTypeID
              ,A.CarColor
              ,A.CarStatus
              ,T.CarTypeName
            FROM CarMaster A
            LEFT JOIN CarTypeMaster T ON A.CarTypeID=T.CarTypeID";
	        $stmt = sqlsrv_query($db,$sql);
	        while( $obj = sqlsrv_fetch_object( $stmt)) {
      	?>
      	<tr>
      		<td>
      			<p align="center" style="background:<?php echo $obj->CarColor ?>; padding:10px; display:block;  margin:0 auto;">
				</p>
				<?php if ($obj->CarStatus==0) {
      				echo "<font color='red'>(งดจอง)</font>";
      			} ?>
      		</td>
      		<td>
      			<?php if ($obj->CarStatus==0) {
      				echo "<font color='red'>".$obj->CarRegistration."</font>";
      			}else{
      				echo $obj->CarRegistration."<br>"."(".$obj->CarTypeName.")";
      				} ?>
      		</td>
      	</tr>

      	<?php } ?>
			<!-- <tr>
				<td bgcolor="#FFD700" width="20"></td>
				<td>ฬฬ 999</td>
			</tr>
			<tr>
				<td bgcolor="#D02090" width="20"></td>
				<td>มย 11</td>
			</tr>
			<tr>
				<td bgcolor="#FF6347" width="20"></td>
				<td>จด 5555</td>
			</tr> -->
		</table>
	</div>

	<div id='calendar'></div>
	
	<!-- The Modal -->
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
	    <span class="close">×</span>
	    <h4>
	    	<input type="hidden" id="request_id" name="request_id">
			<button id="print_detail" style="background: #33CC66">
				<font size="3" style="color: white">
				ใบสั่งงาน
				</font>
			</button>  
	    </h4>
	    <table cellpadding="5">
	    	<tr>
	    		<td colspan="2">
	    			รายละเอียด
	    			<p id="title_name"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			วันที่/เวลา ออกเดินทาง
	    		</td>
	    		<td>
	    			<p id="start_name"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			วันที่/เวลา เดินทางมาถึง
	    		</td>
	    		<td>
	    			<p id="end_name"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			ประเภทรถ
	    		</td>
	    		<td>
	    			<p id="car_type"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			ทะเบียนรถรถ
	    		</td>
	    		<td>
	    			<p id="car_name"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			จำนวนผู้โดยสาร
	    		</td>
	    		<td>
	    			<p id="seat_name"></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			พนักงานขับรถ
	    		</td>
	    		<td>
	    			<p id="driver_name"></p>
	    		</td>
	    	</tr>
	    </table>
	  </div>

	</div>

</body>
</html>
