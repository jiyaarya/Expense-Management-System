<?php if (isset($_SESSION['name'])): ?>
<nav class="navbar navbar-expand-lg shadow bg-body-tertiary px-md-5">
  <div class="container-fluid">
    <a class="navbar-brand me-md-6" href="index.php">Expense</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Expenses
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./add_expense.php">Add Expense</a></li>
            <li><a class="dropdown-item" href="./all_expense.php">All Expenses</a></li>
            <li><a class="dropdown-item" href="./search_expense.php">Search Expense</a></li>
          </ul>
        </li>
      </ul>
      <div>
        <div class="dropdown">
          <button class="btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if (!empty($_SESSION['user_pic']) && file_exists("images/user_image/" . $_SESSION['user_pic'])): ?>
              <img src="images/user_image/<?= $_SESSION['user_pic'] ?>" class="rounded-circle me-2" width="32" height="32" alt="Profile">
            <?php else: ?>
              <i class="bi fs-3 bi-person-bounding-box me-3"></i>
            <?php endif; ?>
            <span><?= ucfirst($_SESSION['name']) ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
<?php endif; ?>