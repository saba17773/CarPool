<!DOCTYPE html>
<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="jquery.bxslider.js"></script>
<!-- bxSlider CSS file -->
<link href="jquery.bxslider.css" rel="stylesheet" />
	<title>Slide</title>
</head>
<body>
<ul class="bxslider">
  <li><img src="./images/1.jpg" /></li>
  <li><img src="./images/2.jpg" /></li>
  <li><img src="./images/3.jpg" /></li>
  <li><img src="./images/4.jpg" /></li>
</ul>
</body>
</html>
<script type="text/javascript">
	/*$(document).ready(function(){
	  $('.bxslider').bxSlider();
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