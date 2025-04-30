<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
check_user();

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

<div class="container py-3">
    <h2 class="text-center display-5 fw-bold py-5">Date Wise Expense</h2>
    <div class="row px-3">
        
        <!-- Today Expense -->
        <div class="col-xl-6 col-lg-6">
            <a href="./today_expense.php">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Today Expenses</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?php 
                                    $today_date = date("Y-m-d");
                                    $query = "SELECT SUM(item_price) AS total FROM expense_info WHERE item_date = '$today_date'";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'] ?? 0;
                                    ?>                         
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Yesterday Expense -->
        <div class="col-xl-6 col-lg-6">
            <a href="./yesterday_expense.php">
                <div class="card l-bg-cyan">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Yesterday Expenses</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?php 
                                    $yesterday_date = date("Y-m-d", strtotime("-1 day"));
                                    $query = "SELECT SUM(item_price) AS total FROM expense_info WHERE item_date = '$yesterday_date'";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'] ?? 0;
                                    ?>                         
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Last 7 Days Expense -->
        <div class="col-xl-6 col-lg-6">
            <a href="./seven_days_expense.php">
                <div class="card l-bg-green">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Last Week Expenses</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?php 
                                    $seven_days_ago = date("Y-m-d", strtotime("-7 days"));
                                    $query = "SELECT SUM(item_price) AS total FROM expense_info WHERE item_date BETWEEN '$seven_days_ago' AND '$today_date'";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'] ?? 0;
                                    ?>                         
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Last Month Expense -->
        <!-- Last Month Expense -->
<div class="col-xl-6 col-lg-6">
    <a href="./month_expense.php">
        <div class="card l-bg-cherry">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                <div class="mb-4">
                    <h5 class="card-title mb-0">Last Month Expenses</h5>
                </div>
                <div class="row align-items-center mb-2 d-flex">
                    <div class="col-8">
                        <h2 class="d-flex align-items-center mb-0">
                            <?php 
                            // Get the first and last date of the previous month
                            $first_day_last_month = date("Y-m-01", strtotime("-1 month")); // Example: 2025-03-01
                            $last_day_last_month = date("Y-m-t", strtotime("-1 month"));   // Example: 2025-03-31

                            // Fetch total expenses for last month
                            $query = "SELECT SUM(item_price) AS total FROM expense_info WHERE item_date BETWEEN '$first_day_last_month' AND '$last_day_last_month'";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['total'] ?? 0;
                            ?>                         
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


    </div>
</div>

<?php
include("./includes/footer.php");
?>
