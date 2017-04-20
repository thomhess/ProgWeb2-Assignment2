<!-- Navbar -->
 

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">SuperNews</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="index.php">Home<span class="sr-only"></span></a></li>
        <?php
        if(empty($_SESSION['user_id'])) {
            echo '<li><a href="login.php">Login</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
            }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <?php
            if(!empty($_SESSION['user_id'])) {
                $user = $app->UserDetails($_SESSION['user_id']);
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $user->first_name . ' ' . $user->surname .'<span class="caret"></span></a>';
                echo '<ul class="dropdown-menu">';
                    echo '<li><a href="profile.php">View Profile</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                echo '</ul>';
                }
            ?>
        </li>
      </ul>
      <form class="navbar-form navbar-right" action="search.php" method="get">
        <div class="form-group">
          <input type="text" name="search" class="form-control" placeholder="Search for article" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>