<?php $this->layout("layout-base"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Demo 2</title>
    <link href="./assets/themes/2/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="./assets/themes/2/js-image-slider.js" type="text/javascript"></script>
    <link href="./assets/generic.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="div1"><h2>Carpool</h2>
        
    </div>
    
    <div id="sliderFrame">
        <div id="slider">
            <a class="lazyImage" href="./assets/images/mini_logo.jpg" title="Welcome To Carpool" /></a>
            <a class="lazyImage" href="./assets/images/car/van1.jpg" title="จด 5555"></a>
            <a class="lazyImage" href="./assets/images/car/van2.jpg" title="มย 11"></a>
            <a class="lazyImage" href="./assets/images/car/pickup1.jpg" title="ฬฬ 999"></a>
        </div>
        <!--thumbnails-->
        <div id="thumbs">
            <div class="thumb">
                <div class="frame"><img src="./assets/images/mini_logo.jpg" /></div>
                <div class="thumb-content"><p>Carpool</p>รายชื่อรถทั้งหมด</div>
                <div style="clear:both;"></div>
            </div>
            <div class="thumb">
                <div class="frame"><img src="./assets/images/car/van1.jpg" /></div>
                <div class="thumb-content"><p>VAN</p>ทะเบียน จด 5555</div>
                <div style="clear:both;"></div>
            </div>
            <div class="thumb">
                <div class="frame"><img src="./assets/images/car/van2.jpg" /></div>
                <div class="thumb-content"><p>VAN</p>ทะเบียน มย 11</div>
                <div style="clear:both;"></div>
            </div>
            <div class="thumb">
                <div class="frame"><img src="./assets/images/car/pickup1.jpg" /></div>
                <div class="thumb-content"><p>PICK UP</p>ทะเบียน ฬฬ 999</div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <!--clear above float:left elements. It is required if above #slider is styled as float:left. -->
        <div style="clear:both;height:0;"></div>
    </div>

</body>
</html>
