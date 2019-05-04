<header class="main-header " >
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>dashboard" class="logo" style="background-color:#ff3d00;padding:0px;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>UGM</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg " ><img src="<?php echo base_url(); ?>assets/images/lg.png" style="height:80px" ></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:#ff3d00">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <ul class="nav navbar-right">
        <strong> <div id="clockbox" style="text-align:center;font-size:15px;color:white;padding-right:30px;text-shadow: 1px 1px black;"></div></strong>
      </ul>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->

  <script type="text/javascript">
      tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

      function GetClock(){
      var d=new Date();
      var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
      var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

      if(nhour==0){ap=" AM";nhour=12;}
      else if(nhour<12){ap=" AM";}
      else if(nhour==12){ap=" PM";}
      else if(nhour>12){ap=" PM";nhour-=12;}

      if(nmin<=9) nmin="0"+nmin;
      if(nsec<=9) nsec="0"+nsec;

      document.getElementById('clockbox').innerHTML=""+tmonth[nmonth]+" "+ndate+", "+nyear+"<br> "+nhour+":"+nmin+":"+nsec+ap+"";
      }

      window.onload=function(){
      GetClock();
      setInterval(GetClock,1000);
      }
  </script>
