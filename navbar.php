    <style>

    @page {
      margin-top: 2cm;
      margin-bottom: 1cm;
      margin-left: 1cm;
      margin-right: 1cm;
    }
    .printOnly {
      display : none;
    }
    @media print{
/*        tr{
          width: 50%;
        }
        table,tr,th,td{
          font-size: 8px;
        }*/
       .printOnly {
         display : block;
        }
      .noprint {display:none; margin: none;}
      .centerPrint {margin: 0 auto; width: 100%;}
    }
    
  </style>
  <div class="noprint ui stackable menu mini" style="margin-top: 10px; ">
    <a title="Home" href="index.php" class="item" style="padding: 7px;">
      <!-- <img src="assets/ico/favicon.ico" style="width: 25px; height: 25px;"> -->
      <img src="favicon.ico" style="width: 36px; height: 36px;" title="Integrated Human Resource System"> 
     </a>
    <!-- <a class="item" href="employeelist.php"><i class="users icon"></i>Employee List</a> -->
    <a class="item" href="employeelist.v2.php"><i class="users icon"></i>Employee List</a>
    <a class="item" href="departmentsetup.php"><i class="building outline icon"></i>Departments</a>
    <a class="item" href="positionsetup.php"><i class="briefcase icon"></i>Positions</a>
    <!-- <a class="item" href="accountsetup.php"><i class="user icon"></i>Account Setup</a> -->
    <a class="item" onclick="_calendar()"><i class="calendar outline icon"></i>Calendar</a>
    <div class="right menu">
    <a title="Lead Deliver Nurture" href="ldn-resources" class="item" style="padding: 7px;">
      <!-- <img src="assets/ico/favicon.ico" style="width: 25px; height: 25px;"> -->
      <img src="assets/ico/ldn.jpg" style="border-radius: 360px; width: 25px; height: 25px; margin-right: 5px;" title="Lead Deliver Nurture">
       LDN Resource Materials
     </a>
      <a class="ui item" href="logout.php"><i class="icon sign-out"></i> Logout</a>
    </div>
  </div>

