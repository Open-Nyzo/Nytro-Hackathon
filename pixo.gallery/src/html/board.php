<?php 

require __DIR__ . '/vendor/autoload.php';

require "inc/config.inc.php";
require 'inc/pixo.class.php';


$pixo = new Pixo($CONFIG);
$square_size=15; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pixo - Tradeable Pixels NFT on NYZO!</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="favicon.png" rel="icon">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">  

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets2/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets2/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets2/vendor/venobox/venobox.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets2/css/style.css" rel="stylesheet">

	<style>
	
	#grid {
	  min-width: 1108px;
	  width: auto;
	}
	
	.hidden{
	  display:none;
	}
	
	.row2 {
	  display: block;
	  clear: left;
	  height: <?=($square_size) ?>px;
	  padding: 0px;
	  margin: 0;
	}
	
  {
    border: 0;
  }
  
	
	.square{
		display: block;
		float:left;
		height: <?=$square_size ?>px;
		width: <?=$square_size ?>px;
		background-color: #ddd;
		line-height: 1;
		box-sizing: content-box;
		color:#000;
		padding:0;
		margin: 0;
		border: 0;
		font-size: <?=(1.8*$square_size)/30 ?>em; /* 2x */
	}
	
	.clickable{
	  cursor: pointer;
      box-shadow: inset 0 0 3px #000;
      animation:blinking 5s infinite;
    }
    
    @keyframes blinking{
        0%{     box-shadow: inset 0 0 5px 0px #F00; border-color: #F00   }
        33%{    box-shadow: inset 0 0 5px 0px #0F0; border-color: #0F0   }
        66%{    box-shadow: inset 0 0 5px 0px #00F; border-color: #00F   }
        100%{   box-shadow: inset 0 0 5px 0px #F00; border-color: #F00   }
    }

	
	.bborder > div > .square{
	   border: 1px solid #aaa;
	}
	.bborder {
	
	}
	
	.bborder > .row2{
	   height: <?=($square_size+2) ?>px;
	}
	
	.big-square{
	  font-size: 3em;
	  height: 50px; 
	  width: 50px;
	  
	}
	
	
	


.ico-fade
{
  -webkit-animation: icofont-fade 1s infinite steps(8);
  animation: icofont-fade 1s infinite steps(8);
  display: inline-block;
}	
	
@keyframes icofont-fade
{
  0%
  {
    border: 1px solid #aaa;
  }

  100%
  {
    border: 1px solid #F00;
}
}

@-webkit-keyframes icofont-fade
{
  0%
  {
    border: 1px solid #aaa;
  }
  100%
  {
    border: 1px solid #F00;
  }
}
	
	</style>
  
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="/">PIXO</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- a href="index.html" class="logo mr-auto"><img src="assets2/img/logo.png" alt="" class="img-fluid"></a -->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="/">Home</a></li>
          <li><a href="#challenge">Challenge</a></li>
          <li><a href="#faq">FAQ</a></li>


        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->  
  
  
  
  
<main id="main" style="margin-top:50px;">
    <section id="draw" class="draw">
        <div class="container" style="overflow:auto;">
            <div class="row">
                <div class="col-md-3">
                    &nbsp; <span id="user_count">?</span> users are online
                </div>
                <div class="col-md-3">
                    <button id="toggle_grid" class="btn">Toggle borders</button>
                </div>
                <div class="col-md-6">
                    <input id="address_input" style="width:100%" placeholder="Search for an address or a pixel">
                </div>
                
            </div>
            <div id="grid" class="bborder" style="border:1px dashed gray;">
                <?php for($line=0;$line<=63;$line ++){ ?>
                    <div class='row2'>
                        <?php for($col=0;$col<=63;$col ++){ ?>
                            <div class="square" id="square_<?=$col ?>_<?=$line ?>" style="background-color:#FFF" address="" onclick="squareClicked(this)" color=""></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Click on a pixel to see its properties and available actions.<br><br>
                    To change the color of a pixel you own, use the color wheel to select a color, click on the prefilled tx button of that pixel, and then copy and send this transaction, and your pixel will have its color changed.<br/>
                    <b>NOTE: You can only change the color of a Pixel YOU OWN</b> - Since we did not drop any pixel yet, no one can play - yet! Be patient and stay tuned for the drop!
                </div>
                <div class="col-md-3">
                    <div id="colorpicker"></div>
                    <input id="color" value="#123456">
                </div>
                <div class="col-md-3">
                    <br>&nbsp;<br>
                    prefilled nyzo tx:<br>
                    <input id="prefilled_tx" placeholder="prefilled nyzo tx">
                    <button onclick="copy('prefilled_tx')" class="btn">copy</button>
                </div>
            </div>
            <div>
                
                
                
                <table class="table  table-responsive-sm">
                <thead>
                    <tr>
                        <th>pixel</th>
                        <th>Color</th>
                        <th>address</th>
                        <th>prefilled tx</th>
                    </tr>
                </thead>
                <tbody id="query_table">
                </tbody>
            </table>
            </div>
        </div>
    </section>


     <!-- ======= challenge Section ======= -->
  <section id="challenge" class=" section-bg">
      <div class="container">
        <div class="row text-center">
			  <div class="col-12">
				<h3 style="margin-top:20px;">Challenge</h3>
					<p style="text-align: center">
					  Challenges will be announced later on, stay tuned!<br />
					</p>
			   
				<div class="row mt-2">
				  <div class="col-lg-6 col-md-6 icon-box">
					<div class="icon"><i class="icofont-unique-idea icofont-2x"></i></div>
					<h4 class="title">Challenge sponsors</h4>
					<p class="description">Sponsor? Get in touch!</p>
				  </div>
				  <div class="col-lg-6 col-md-6 icon-box">
					<div class="icon"><i class="icofont-badge icofont-2x"></i></div>
					<h4 class="title">Challenge prize</h4>
					<p class="description">Surprise</p>
				  </div>

				</div> 
			  </div>
 
        </div>
         </div>
  </section><!-- End challenge Section -->
   



    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Pixo is just born, and is willing to bring some freshness and disruption. This section will be fed with your most itching concerns.</p>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-12 col-md-12 foo-ter-contact text-center">
             <h3>We have many items on our roadmap and are open to suggests!</h3>
          </div>  
        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">
      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span>PIXO.Gallery</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/baker-free-onepage-bootstrap-theme/ -->
          Base design by <a href="https://bootstrapmade.com/" target="_blank" rel="nofollow" style="color:#fff">BootstrapMade</a>
        </div>
      </div>
     <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="https://twitter.com/idenary_com" target="_blank" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="https://discord.gg/FV2wUyg" rel="nofollow" target="_blank" class=""><i class="bx bxl-discord"></i></a>
        <a href="https://github.com/Idenary/"  target="_blank" class=""><i class="bx bxl-github"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets2/vendor/jquery/jquery.min.js"></script>
  <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets2/vendor/jquery.easing/jquery.easing.min.js"></script>
  <!-- script src="assets2/vendor/php-email-form/validate.js"></script -->
  <script src="assets2/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets2/vendor/counterup/counterup.min.js"></script>
  <script src="assets2/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets2/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets2/vendor/venobox/venobox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets2/js/main.js"></script>
  
  <!-- nyzostrings -->
  <script src="assets/bundle.js"></script>
  
  
  <!-- colorwheel -->
  <script type="text/javascript" src="farbtastic/farbtastic.js"></script>
  <link rel="stylesheet" href="farbtastic/farbtastic.css" type="text/css" />


<!-- script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script -->
<script>
    var width = <?=$square_size ?>;
    var height = width;
    var board = "64"; 
    var reload = true;
    var ws = null;
    var last_address = "";
    
    function set_board(new_board){
        reload = false;
        ws.close();
        board = new_board;
        start_ws();
    }
  
    function paint(pixel, color, address){
        square = $("#square_"+pixel);
        square.css('background-color', "#"+color);
        square.attr("address", address);
        square.attr("color", color);
        /*if((address.startsWith(last_address) && last_address != "" )|| pixel == last_address){
            square.addClass("clickable")
        }else{
            square.removeClass("clickable")
        }*/
        
    }
  
    function init_board(data){
        for (line=0;line <= 63;line++){
            for (col=0;col <= 63;col++){
                paint(col+"_"+line, "FFF", "");
            };
        };
        data.forEach(function(square){
            paint(square["pixel"], square["color"], square["address"]);
        });
        addressInputHandler(null);
    };
  
    function update_user_count(count){
        $("#user_count").html(count);
    }
  
    function update_global_closeness(closeness){
        $("#global_closeness").html(closeness);
    }
  
    function send(action, data){
        console.log(data);
        ws.send(JSON.stringify({Action: action, Data: data}));
    }
  
    function start_ws(){
        url = "wss://pixo.gallery/wss/board"
        ws = new WebSocket(url);

        ws.onopen = function(){send("Register", board); reload = true};
        ws.onclose = function(){if(reload){setTimeout(function(){document.location.reload(true);}, 5000)}};
        ws.onmessage = function (evt) {
            message = JSON.parse(evt.data);
            console.log(message);
            event = message["Event"];
            data = message["Data"];

            if(event == "Init"){
                init_board(data);

            }else if(event == "Paint"){
                paint(data["id"], data["color"], data["address"]);

            }else if(event == "UserCount"){
                update_user_count(data);
            }
            else if(event == "GlobalCloseness"){
                update_global_closeness(data);
            }
        };
    };
    
    function createTx(id){
        
        $("#prefilled_tx").val(nyzoStringEncoder.encode(nyzoStringPrefilledData($("#color").val().substring(1)+"0000000000000000000000000000000000000000000000000000000000", "ND:nPIXO64:"+id+":color", 1)));
    }
    
    
    function addressInputHandler(e) {
        $(".square").removeClass("clickable")
        
        last_address = $("#address_input").val();
        $("#query_table").empty();
        $("[address^='"+last_address+"'], #square_"+last_address).each( function(){
            $(this).addClass("clickable");
            $("#query_table").append("<tr><td>"+$(this).attr("id").substring(7)+"</td><td>"+$(this).attr("color")+"</td><td>"+$(this).attr("address")+"</td><td><button class='btn' onclick='createTx(\""+$(this).attr("id").substring(7)+"\");copy(\"prefilled_tx\")'>get and copy tx</button></td></tr>");
        } );
        
    }
    
    function squareClicked(el){
        e = $("#"+el.id);
        $("#address_input").val(el.id.substring(7));
        addressInputHandler(null);
    }
    
    function copy(id){
        var copyTextarea = document.querySelector("#"+id);
        copyTextarea.focus();
        copyTextarea.select();
        document.execCommand('copy');
    }
    
    
    $(function(){
    
        $("#toggle_grid").click(function(){
            $("#grid").toggleClass("bborder");
        });
        
        document.getElementById("address_input").addEventListener('input', addressInputHandler);
        document.getElementById("address_input").addEventListener('propertychange', addressInputHandler);
        
        addressInputHandler(null);
        start_ws();
        $('#colorpicker').farbtastic('#color');
        
        
          
        
    });
 
</script>
</body>
</html>
