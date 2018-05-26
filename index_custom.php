<?php
/*
 * UniFi Voucher Service v1.0
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
            <p><img src="assets/img/logo.png" /></p>
            <h4><?php echo $uvs_subtitle ?></h4>
            <br/><br/>
            <form id="buttons">
               <div class="col-lg-8 col-md-4 col-sm-4 gallery1st print1weekfree">
                  <div class="row">
                     <div class="col-xs-4">
                        <label>Quota</label>
                        <select class="form-control" name="quota" id="quota">
                           <option value="1">One time (1 usage)</option>
                           <option value="2">Multi use (2 usages)</option>
                           <option value="3">Multi use (3 usages)</option>
                           <option value="4">Multi use (4 usages)</option>
                           <option value="5">Multi use (5 usages)</option>
                           <option value="6">Multi use (6 usages)</option>
                           <option value="7">Multi use (7 usages)</option>
                        </select>
                     </div>
                     <div class="col-xs-4">
                        <label>Expiration Time (Hours)</label>
                        <select class="form-control" name="expiration" id="expiration">
                           <option value="60">1 Hour</option>
                           <option value="360">6 Hours</option>
                           <option value="720">12 Hours</option>
                           <option value="1440">24 Hours</option>
                           <option value="2880">2 Days</option>
                           <option value="10080">7 Days</option>
                           <option value="44640">1 Month</option>
                        </select>
                     </div>
                     <div class="col-xs-4">
                        <label>Byte Quota (MB)</label>
                        <select class="form-control" name="bytequota" id="bytequota">
                           <option value="null">unlimited</option>
                           <option value="500">500 MB</option>
                           <option value="1000">1000 MB</option>
                           <option value="1500">1500 MB</option>
                           <option value="2000">2000 MB</option>
                           <option value="2500">2500 MB</option>
                           <option value="3000">3000 MB</option>
                        </select>
                     </div>
                  </div>
                  <br/>
                  <div class="row">
                     <div class="col-xs-6">
                        <label>Bandwidth Limit (Download in Kbps)</label>
                        <select class="form-control" name="downloadlimit" id="downloadlimit">
                           <option value="null">unlimited</option>
                           <option value="900">900 Kbps</option>
                           <option value="1800">1800 Kbps</option>
                           <option value="3600">3600 Kbps</option>
                           <option value="7200">7200 Kbps</option>
                           <option value="14400">14400 Kbps</option>
                           <option value="28800">28800 Kbps</option>
                        </select>
                     </div>
                     <div class="col-xs-6">
                        <label>Bandwidth Limit (Upload in Kbps)</label>
                        <select class="form-control" name="uploadlimit" id="uploadlimit">
                           <option value="null">unlimited</option>
                           <option value="450">450 Kbps</option>
                           <option value="900">900 Kbps</option>
                           <option value="1800">1800 Kbps</option>
                           <option value="3600">3600 Kbps</option>
                           <option value="7200">7200 Kbps</option>
                           <option value="14400">14400 Kbps</option>
                        </select>
                     </div>
                  </div>
                  <br/>
                  <div class="row">
                     <div class="col-xs-12">
                        <label>Note</label>
                        <select class="form-control" name="note" id="note">
                           <option value="Free Voucher">Free Voucher</option>
                           <option value="Fastpass Voucher">Fastpass Voucher</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 gallery1st print1dayfree" style="margin-top:35px;">
                  <button onCLick="senddata();" type="submit" name="1dayfree" id="1dayfree">
                     <div id="oben"><img src="assets/img/printing.png" id="1dayfreeimg" width="208px" class="img-responsive" /></div>
                     <div id="unten"><img src="assets/img/print_now.png" class="img-responsive" /></div>
                  </button>
               </div>
            </form>
         </div>
      </div>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script>
        function senddata() {
          var val1 = $('#note option:selected').val(); 
          var val2 = $('#uploadlimit option:selected').val(); 
          var val3 = $('#downloadlimit option:selected').val(); 
          var val6 = $('#bytequota option:selected').val(); 
          var val5 = $('#expiration option:selected').val(); 
          var val4 = $('#quota option:selected').val(); 
          $.ajax({url:'codes/custom-voucher.php?note='+val1+'&uploadlimit='+val2+'&downloadlimit='+val3+'&bytequota='+val4+'&expiration='+val5+'&quota='+val6 ,type:'GET' ,success:function(data){ $('.print1dayfree').html(data);}});
        }      
        $(document).ready(function() {
          $("#buttons").submit(function(e) {
            e.preventDefault();
              $("#1dayfree").attr("disabled", true);
              return true;
            });
        });
        $(document).ready(function() {
        $("#buttons").submit(function(e) {
          e.preventDefault();
            $("#note").attr("disabled", true);
            $("#uploadlimit").attr("disabled", true);
            $("#downloadlimit").attr("disabled", true);
            $("#bytequota").attr("disabled", true);
            $("#expiration").attr("disabled", true);
            $("#quota").attr("disabled", true);
            return true;
          });
        });
        $(document).ready(function() {
          $('#1dayfreeimg').hide();$("#1dayfree").click(function(){$("#1dayfreeimg").show(); });
        });
      </script>
   </body>
</html>
