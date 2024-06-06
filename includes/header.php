<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Management</title>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">

    <!-- Google Fonts - Poppins -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles/style.css" type="text/css">
</head>
<style>
  :root {
    --primary-color: #001f3f;
    /* Deep Navy Blue */
    --secondary-color: #FF5733;
    /* Coral */
  }

  .primary-color {
    color: var(--primary-color);
  }

  .secondary-color {
    color: var(--secondary-color);
  }

  .btn-outline-info {
    background: var(--secondary-color);
    color: var(--primary-color);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-outline-info:hover {
    background: var(--primary-color);
    color: var(--secondary-color);
    box-shadow: 0 4px 15px rgba(0, 31, 63, 0.4);
  }

  .btn-outline-info:active {
    transform: scale(0.98);
    transition: transform 0.1s ease;
  }

  .form-control:focus {
    box-shadow: none;
    border-color: transparent;
  }

  .form-floating>.form-control,
  .form-floating>.form-control-sm {
    border-bottom: 1px solid var(--primary-color);
    border-top: none;
    border-left: none;
    border-right: none;
    border-radius: 0;
  }

  .form-floating>.form-control:focus,
  .form-floating>.form-control-sm:focus {
    border-bottom-color: var(--secondary-color);
  }

  .toast-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
  }

  .navbar-nav .nav-link {
    font-size: 1rem;
    position: relative;
    padding-bottom: 10px;
    color: var(--primary-color);
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: var(--secondary-color);
  }

  .navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    width: 16%;
    /* Adjust the width to take up less space */
    transform: scaleX(0);
    height: 2px;
    bottom: 0;
    left: 0%;
    /* Center the line */
    background-color: var(--secondary-color);
    transform-origin: bottom right;
    transition: transform 0.25s ease-out;
  }

  .navbar-nav .nav-link:hover::after,
  .navbar-nav .nav-link.active::after {
    transform: scaleX(1);
    transform-origin: bottom left;
  }

  @media (min-width: 768px) {
    .navbar-nav .nav-link {
      font-size: 1rem;
    }

    .navbar-nav .nav-link::after {
      width: 100%;
      /* Full width underline for larger screens */
      left: 0;
      /* Align to left */
    }
  }
</style>

<body style="font-family: 'Poppins', sans-serif;"> <!-- Apply Poppins font to the body -->


<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">K</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      
        <?php 
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is logged in, hide Sign In and Register links, show Log Out link
            ?>
            <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
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


  <div class="py-4">
    <div class="container">
      <?php
      // Check if the current page is neither login.php nor register.php
      $current_page = basename($_SERVER['PHP_SELF']);
      if ($current_page !== 'login.php' && $current_page !== 'register.php') {
        ?>
        <div class="col-md-12 mb-3 mt-3">
        <h5>Welcome back, <?php if (isset($_SESSION['username'])): ?>
                <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
            <?php endif; ?>
        </h5>
       
    </div>
        <div class="card" style="background-color: var(--primary-color); height: auto;">
          <img class="card-img object-fit-cover" src="Homedashboard.jpg.crdownload" alt="Card image cap"
            style="max-height: 160px; width: 100%; object-fit: cover; opacity: 0.1;">
          <div class="card-img-overlay">
            <h5 class="card-title" style="color: var(--secondary-color);">Manage your workforce</h5>
            <p class="card-text" style="color: var(--secondary-color);">With Kazini, you can easily manage your workforce
              with ease</p>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
  <?php include ('includes/footer.php'); ?>