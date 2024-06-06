
<?php
include ('includes/header.php');
?>


<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">K</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="clients.php">Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="techs.php">Technicians</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">Accounts</a>
        </li>
        <?php 
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is logged in, hide Sign In and Register links, show Log Out link
            ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Log Out</a>
            </li>
            <?php
        } else {
            // User is not logged in, hide Log Out link, show Sign In and Register links
            ?>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Sign In</a>
            </li>
            <?php
        }
        ?>
      </ul>
    </div>
  </div>
</nav>


<?php
// Include the footer file
include('includes/footer.php');
?>