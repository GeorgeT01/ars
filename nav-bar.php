<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link <?php if($page == "search"){echo "active";} ?>" href="index.php"><i class="fa fa-search"></i> Search</a>
      <a class="nav-item nav-link <?php if($page == "contact"){echo "active";} ?>" href="contact-us.php">Contact Us</a>
      <a class="nav-item nav-link <?php if($page == "about"){echo "active";} ?>" href="#">About</a>
    </div>
        <div class="navbar-nav ml-auto">
<?php if (isset($_SESSION['logged_in']) === true) { ?>
    <a class="nav-item nav-link text-light" href="#"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?></a>
<div class="btn-group">

  <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">
  <i class="fas fa-caret-down"></i>
  </a>
  <div class="dropdown-menu" style="left: auto; right: 25%;">
    <a class="dropdown-item <?php if($page == "reservation"){echo "active";} ?>" href="MyReservation.php">My Reservation</a>
    <a class="dropdown-item <?php if($page == "profile"){echo "active";} ?>" href="profile.php"><i class="fas fa-user"></i> Profile</a>
    <a class="dropdown-item <?php if($page == "privacy"){echo "active";} ?>" href="privacy.php"><i class="fas fa-lock"></i> Privacy</a>
    <a class="dropdown-item <?php if($page == "help"){echo "active";} ?>" href="help.php"><i class="fas fa-question-circle fa-1x"></i> Help</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
  </div>
</div>
<?php } else{?>
      <a class="nav-item nav-link <?php if($page == "login"){echo "active";} ?>" href="login.php"><i class="fa fa-sign-in-alt"></i> Login</a>
      <a class="nav-item nav-link <?php if($page == "signup"){echo "active";} ?>" href="sign-up.php">
        <i class="fa fa-user-plus"></i> Sign up</a>

<?php }?>

    </div>
  </div>
</nav>