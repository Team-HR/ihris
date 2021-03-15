    <style>
      @page {
        margin-top: 2cm;
        margin-bottom: 1cm;
        margin-left: 1cm;
        margin-right: 1cm;
      }

      .printOnly {
        display: none;
      }

      @media print {
        .printOnly {
          display: block;
        }

        .noprint {
          display: none;
          margin: none;
        }

        .centerPrint {
          margin: 0 auto;
          width: 100%;
        }
      }
    </style>
    <div class="noprint ui stackable menu" style="margin-top: 10px; ">
      <a title="Home" href="index.php" class="item" style="padding: 7px;">
        <img src="favicon.ico" style="width: 36px; height: 36px;" title="Integrated Human Resource System">
      </a>
      <a class="item" href="employeelist.v2.php"><i class="users icon"></i>Employee List</a>
      <a class="item" onclick="_calendar()"><i class="calendar outline icon"></i>Calendar</a>
      <div id="setup_dropdown" class="ui pointing dropdown link item">
        <i class="icon settings"></i>
        <span class="text">Setup</span>
        <i class="dropdown icon"></i>
        <div class="menu">
          <!-- <div class="header">Categories</div> -->
          <a href="plantilla.php" class="item"><i class="icon file alternate"></i> Permanent Plantilla</a>
          <!-- TODO -->
          <!-- <a href="casual_plantilla.php" class="item"><i class="icon file alternate"></i> Casual Plantilla</a> -->
          
          <a href="departmentsetup.php" class="item"><i class="icon building"></i> Departments</a>
          <a href="positionsetup.php" class="item"><i class="icon briefcase"></i> Positions</a>
          <a href="salary_adjustment.php" class="item"><i class="icon money check alternate"></i> Salary Schedule</a>
          <a href="qualification_standards.php" class="item"><i class="icon graduation cap"></i> Qualification Standards</a>
          <a href="signatories.php" class="item"><i class="icon pen fancy"></i> Signatories</a>
        </div>
      </div>

      <div id="reports_dropdown" class="ui pointing dropdown link item">
        <i class="icon print"></i>
        <span class="text">Reports</span>
        <i class="dropdown icon"></i>
        <div class="menu">
          <a href="plantilla_report.php" class="item"><i class="icon print"></i> Plantilla Report</a>
          <a href="plantilla_vacantpos.php" class="item"><i class="icon print"></i> Publications Report</a>
        </div>
      </div>
      <div id="Leave_dropdown" class="ui pointing dropdown link item">
        <i class="icon print"></i>
        <span class="text">Attendance/Leave Management</span>
        <i class="dropdown icon"></i>
        <div class="menu">
              <h4 class="ui header">Attendance Monitoring</h4>
                <a href="dtrManagement.php" class="item">DTR Monitoring</a>
                <a href="dtrSummary.php" class="item">DTR Summary</a>
                <a href="dtrnodtrList.php" class="item">No DTR List</a>
                <h4 class="ui header">Leave Management</h4>
                <a href="leaveManagement.php" class="item">Leave Logs</a>
          <!-- 
          <a href="plantilla_report.php" class="item"><i class="icon print"></i>Attendance Monitoring</a>
          <a href="plantilla_vacantpos.php" class="item"><i class="icon print"></i></a> -->
        </div>
      </div>

      <div class="right menu">
        <a title="Lead Deliver Nurture" href="ldn-resources" class="item" style="padding: 7px;">
          <img src="assets/ico/ldn.jpg" style="border-radius: 360px; width: 25px; height: 25px; margin-right: 5px;" title="Lead Deliver Nurture">
          LDN Resource Materials
        </a>
        <a class="ui item" href="logout.php"><i class="icon sign-out"></i> Logout</a>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        $('#setup_dropdown').dropdown({
          action: 'hide'
        });
        $('#reports_dropdown').dropdown({
          action: 'hide'
        });
        $('#Leave_dropdown').dropdown({
          action: 'hide'
        });

      });
    </script>
