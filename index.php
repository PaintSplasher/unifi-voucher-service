<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/
require_once ('uvs_config.php');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="assets/img/favicon.ico">
      <title><?php echo $uvs_title ?></title>
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/css/style.min.css" rel="stylesheet">
      <link href="assets/css/font-awesome.min.css" rel="stylesheet">
   </head>
   <body>
      <section id="works"></section>
      <div class="container">
         <div class="row centered mt mb">
            <span class="shutdown_btn"><a href="shutdown.php"><img src="assets/img/shutdown.png" /></a></span>
            <p><a href="index_custom.php"><img src="assets/img/logo.png" /></a></p>
						<h4><?php echo $uvs_subtitle ?></h4>
            <form id="buttons">
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1day1device">
               <button onCLick="$.ajax({url:'codes/1-1.php',type:'GET',success:function(data){$('.print1day1device').html(data);}});" type="submit" name="1day1device" id="1day1device">               
               <div id="oben"><img src="assets/img/printing.png" id="1day1deviceimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-1.png" class="img-responsive" /></div>
               </button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1week1device">
               <button onCLick="$.ajax({url: 'codes/7-1.php', type: 'GET', success: function(data){$('.print1week1device').html(data);}});" type="submit" name="1week1device" id="1week1device">
               <div id="oben"><img src="assets/img/printing.png" id="1week1deviceimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/7-1.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1month1device">
               <button onCLick="$.ajax({url: 'codes/31-1.php', type: 'GET', success: function(data){$('.print1month1device').html(data);}});" type="submit" name="1month1device" id="1month1device">
               <div id="oben"><img src="assets/img/printing.png" id="1month1deviceimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-month-free.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1day2devices">
               <button onCLick="$.ajax({url: 'codes/1-2.php', type: 'GET', success: function(data){$('.print1day2devices').html(data);}});" type="submit" name="1day2devices" id="1day2devices">
               <div id="oben"><img src="assets/img/printing.png" id="1day2devicesimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-2.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1week2devices">
               <button onCLick="$.ajax({url: 'codes/7-2.php', type: 'GET', success: function(data){$('.print1week2devices').html(data);}});" type="submit" name="1week2devices" id="1week2devices">
               <div id="oben"><img src="assets/img/printing.png" id="1week2devicesimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/7-2.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1month2devices">
               <button onCLick="$.ajax({url: 'codes/31-2.php', type: 'GET', success: function(data){$('.print1month2devices').html(data);}});" type="submit" name="1month2devices" id="1month2devices">
               <div id="oben"><img src="assets/img/printing.png" id="1month2devicesimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/31-2.png" class="img-responsive" /></div>
               </button>			
						</div>
            </form>
         </div>
      </div>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script>
      $(document).ready(function() {
        $("#buttons").submit(function(e) {
          e.preventDefault();
            $("#1day1device").attr("disabled", true);
            $("#1week1device").attr("disabled", true);
            $("#1month1device").attr("disabled", true);
            $("#1day2devices").attr("disabled", true);
            $("#1week2devices").attr("disabled", true);
            $("#1month2devices").attr("disabled", true);
            return true;
          });
      });

      $(document).ready(function() {
        $('#1day1deviceimg').hide();$("#1day1device").click(function(){$("#1day1deviceimg").show(); });
        $('#1week1deviceimg').hide();$("#1week1device").click(function(){$("#1week1deviceimg").show(); });
        $('#1month1deviceimg').hide();$("#1month1device").click(function(){$("#1month1deviceimg").show(); });
        $('#1day2devicesimg').hide();$("#1day2devices").click(function(){$("#1day2devicesimg").show(); });
        $('#1week2devicesimg').hide();$("#1week2devices").click(function(){$("#1week2devicesimg").show(); });
        $('#1month2devicesimg').hide();$("#1month2devices").click(function(){$("#1month2devicesimg").show(); }); 
      });
      </script>
   </body>
</html>
