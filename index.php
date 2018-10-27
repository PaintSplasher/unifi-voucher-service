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
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1dayfree">
               <button onCLick="$.ajax({url:'codes/1-day-free.php',type:'GET',success:function(data){$('.print1dayfree').html(data);}});" type="submit" name="1dayfree" id="1dayfree">               
               <div id="oben"><img src="assets/img/printing.png" id="1dayfreeimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-day-free.png" class="img-responsive" /></div>
               </button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1weekfree">
               <button onCLick="$.ajax({url: 'codes/1-week-free.php', type: 'GET', success: function(data){$('.print1weekfree').html(data);}});" type="submit" name="1weekfree" id="1weekfree">
               <div id="oben"><img src="assets/img/printing.png" id="1weekfreeimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-week-free.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1monthfree">
               <button onCLick="$.ajax({url: 'codes/1-month-free.php', type: 'GET', success: function(data){$('.print1monthfree').html(data);}});" type="submit" name="1monthfree" id="1monthfree">
               <div id="oben"><img src="assets/img/printing.png" id="1monthfreeimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-month-free.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1daypay">
               <button onCLick="$.ajax({url: 'codes/1-day-fastpass.php', type: 'GET', success: function(data){$('.print1daypay').html(data);}});" type="submit" name="1daypay" id="1daypay">
               <div id="oben"><img src="assets/img/printing.png" id="1daypayimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-day-pay.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1weekpay">
               <button onCLick="$.ajax({url: 'codes/1-week-fastpass.php', type: 'GET', success: function(data){$('.print1weekpay').html(data);}});" type="submit" name="1weekpay" id="1weekpay">
               <div id="oben"><img src="assets/img/printing.png" id="1weekpayimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-week-pay.png" class="img-responsive" /></div>
               </button>			
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 gallery2nd print1monthpay">
               <button onCLick="$.ajax({url: 'codes/1-month-fastpass.php', type: 'GET', success: function(data){$('.print1monthpay').html(data);}});" type="submit" name="1monthpay" id="1monthpay">
               <div id="oben"><img src="assets/img/printing.png" id="1monthpayimg" width="208px" class="img-responsive" /></div><div id="unten"><img src="assets/img/1-month-pay.png" class="img-responsive" /></div>
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
            $("#1dayfree").attr("disabled", true);
            $("#1weekfree").attr("disabled", true);
            $("#1monthfree").attr("disabled", true);
            $("#1daypay").attr("disabled", true);
            $("#1weekpay").attr("disabled", true);
            $("#1monthpay").attr("disabled", true);
            return true;
          });
      });

      $(document).ready(function() {
        $('#1dayfreeimg').hide();$("#1dayfree").click(function(){$("#1dayfreeimg").show(); });
        $('#1weekfreeimg').hide();$("#1weekfree").click(function(){$("#1weekfreeimg").show(); });
        $('#1monthfreeimg').hide();$("#1monthfree").click(function(){$("#1monthfreeimg").show(); });
        $('#1daypayimg').hide();$("#1daypay").click(function(){$("#1daypayimg").show(); });
        $('#1weekpayimg').hide();$("#1weekpay").click(function(){$("#1weekpayimg").show(); });
        $('#1monthpayimg').hide();$("#1monthpay").click(function(){$("#1monthpayimg").show(); }); 
      });
      </script>
   </body>
</html>