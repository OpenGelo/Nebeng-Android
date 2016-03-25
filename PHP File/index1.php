<?php
   session_start();
   if(isset($_SESSION['login_user']))
     header('location:index_user.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Irit Ongkos Transport</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="js/jquery-1.6.min.js"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Open_Sans_400.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
<script type="text/javascript" src="js/tms-0.3.js"></script>
<script type="text/javascript" src="js/tms_presets.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="js/FF-cash.js" type="text/javascript"></script>
<script type="text/javascript" src="js/index1.js"></script>

<!--css index1.php--!>
<link rel="stylesheet" href="css/index1.css" type="text/css" media="screen">


</head>
<body id="page1">
<!-- header -->
<div class="bg">
  <div class="main">
    <header>
      <div class="row-2">
        <nav>
          <ul class="menu">
            <li><a class="active" href="index.html">Beranda</a></li>
          </ul>
        </nav>
      </div>
      <div class="row-3">
        <div class="slider-wrapper">
          <div class="slider">
            <ul class="items">
              <li><img src="images/slider-img1.jpg" alt=""> </li>
              <li><img src="images/slider-img2.jpg" alt=""></li> 
            </ul>
            <a class="prev" href="#">prev</a> <a class="next" href="#">prev</a> </div>
        </div>
      </div>
    </header>
    
    
    <!-- content -->
    <section id="content">
      <div class="padding">
        <div class="box-bg margin-bot">
            *This website is still under construction. Nebeng and make nebeng features are not activated.
        </div>
        <div class="wrapper">
          <div class="col-3">
            <div class="indent">
              <h2>IOT</h2>
              <p class="color-4 p1" style="text-align:justify">IOT (Irit ongkos transport) merupakan aplikasi mobile android yang memfasilitasi masyarakat Universitas Indonesia (UI) untuk bisa berbagi kendaraan dengan tujuan tempat yang sama. Sistem ini hanya bisa digunakan oleh mereka yang resmi memiliki akun UI.</p>
              <div class="wrapper">
                <figure class="img-indent3"><img src="images/page1-img1.png" alt="" /></figure>
                <div class="extra-wrap">
                  <div class="indent2">App IOT versi 0.2 (25 Maret 2015)</div>
                </div>
              </div>
              <a class="button-2" href="http://green.ui.ac.id/nebeng/file/UIIOT_v02.apk">Unduh</a> </div>
          </div>
          <div class="col-2">
            <form action="check_web.php" method="post" id="form">
               <h3 style="text-align:center;color:#000000;">Login</h3>
        
               <fieldset>
                  <br>
                  <label for="name">Name:</label>
                  <input type="text" id="name" name="username" placeholder="Type your username" required="required">
          
                  <label for="mail">Password</label>
                  <input type="password" id="password" name="password" placeholder="Type your password" required="required">
         
               </fieldset>
               <button type="submit">Sign Up</button>
             </form>
           </div>
           <br><br>
           <h3 align="center" style="color:#000000;">Nebeng's Log:</h3>
           <div class = "container">
    	    <?php
               include('room_beri_tebengan.php');
               $user = $response[result];
               $div = "box1";
               foreach($user as $result)
               {
                   $warna = "";
                   if($result[kapasitas]==0)
                       $warna="merah";
                   echo "<br><a href=\"#\">";
                   echo "<div class=\"".$div." ".$warna."\">";
                   echo "<table id=\"nebeng\">";
                   echo "<tr><td>Nama</td><td>".":</td><td>".$result[nama]."</td>";
                   echo "<tr><td>Asal</td><td>".":</td><td>".$result[asal]."</td>";
                   echo "<tr><td>Tujuan</td><td>".":</td><td>".$result[tujuan]."</td>";
                   echo "</table>";
                   echo "</div></a>";
                   if($div=="box1")
                      $div = "box2";
                   else
                      $div = "box1";  
               }
            ?>
           </div>
        </div>
      </div>
    </section>
    
    
    
    <!-- footer -->
    <footer>
      <div class="row-top">
        <div class="row-padding">
          <div class="wrapper">
            <div class="col-1">
              <h4>Contact Person:</h4>
              <dl class="address">
                <!--<dt><span>Country:</span>USA</dt>-->
                <dd><span>Martin:</span>089679872670</dd>
                <dd><span>Suryo:</span>081278102985</dd>
                <dd><span>Sanadhi:</span>082299580644</dd>
                <!--<dd><span>Email:</span><a href="#">suryo.satrio@ui.ac.id</a></dd>-->
              </dl>
            </div>
            
            <div class="col-2">
      			<figure class="img-indent3"><img src="images/icon.png" alt="" /></figure>
                
            </div>
            <div class="col-3">
            	<figure class="img-indent3"><img src="images/UI.png" alt="" /></figure>
            </div>
          </div>
        </div>
      </div>
      <div class="row-bot">
        <div class="aligncenter">
          <p class="p0">Copyright &copy; <a href="#">IOT Developer Team</a> All Rights Reserved</p>
          
          <!-- {%FOOTER_LINK} -->
        </div>
      </div>
    </footer>
  </div>
</div>
<script type="text/javascript">Cufon.now();</script>
<script type="text/javascript">
$(function () {
    $('.slider')._TMS({
        prevBu: '.prev',
        nextBu: '.next',
        playBu: '.play',
        duration: 800,
        easing: 'easeOutQuad',
        preset: 'simpleFade',
        pagination: false,
        slideshow: 3000,
        numStatus: false,
        pauseOnHover: true,
        banners: true,
        waitBannerAnimation: false,
        bannerShow: function (banner) {
            banner.hide().fadeIn(500)
        },
        bannerHide: function (banner) {
            banner.show().fadeOut(500)
        }
    });
})
</script></body>
</html>