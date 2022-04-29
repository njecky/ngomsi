
<body>
		 	 <div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">pro sidebar</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="../images/admin/<?= $userinfo['photo']?>"alt="<?= $userinfo['photo']?>">
        </div>
        <div class="user-info">
          <span class="user-name">
            <strong><?= $userinfo['nom']?></strong>
          </span>
          <span class="user-role"><?= $userinfo['role']?></span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          <li class="sidebar-dropdown">
            <a href="dashboard.php">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
              <span class="badge badge-pill badge-warning">New</span>
            </a>
          </li><br><br><br>
          <li class="sidebar-dropdown">
            <a href="view/sportifs.php">
              <i class="fa fa-shopping-cart"></i>
              <span>Liste des sportifs</span>
              <span class="badge badge-pill badge-danger">3</span>
            </a>
          </li>
          <li class="sidebar-dropdown"><br><br><br>
            <a href="index.php?dashboard=liste sportif">
              <i class="fa fa-chart-line"></i>
              <span>Afficher des sportifs</span>
            </a>
          </li>
          <li class="sidebar-dropdown"><br><br><br>
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Afficher les sports</span>
            </a>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="../index.php">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="edit.php">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="deconnection.php">
        <i class="fa fa-power-off glyphicon glyphicon-scissors"></i>
      </a>
    </div>
  </nav>