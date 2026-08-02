<?php

session_start();

if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

include "connect.php";
$result=$conn->query("select * from product");

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        
        <style>
            /* General Page */
            body {
                background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
                font-family: Arial, sans-serif;
                color: #212529;
                min-height: 100vh;
            }

            /* Navbar */
            .navbar {
                background: linear-gradient(135deg, #212529, #343a40) !important;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
                padding: 12px 0;
            }

            .navbar-brand {
                color: white !important;
                font-weight: 600;
            }

            .navbar-brand h4 {
                margin: 0;
                font-size: 20px;
            }

            .nav-link {
                color: #ced4da !important;
                margin: 0 5px;
                transition: 0.3s;
            }

            .nav-link:hover {
                color: white !important;
            }

            .nav-link.active {
                color: white !important;
                font-weight: 600;
            }

            /* Main Content */
            main {
                min-height: calc(100vh - 150px);
            }

            /* Table Container */
            .table-responsive {
                background-color: white;
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            }

            /* Table */
            .table {
                margin-bottom: 0;
                vertical-align: middle;
            }

            .table thead {
                background: linear-gradient(135deg, #212529, #343a40);
                color: white;
            }

            .table thead th {
                padding: 15px;
                font-weight: 600;
                border: none;
            }

            .table tbody td {
                padding: 15px;
            }

            .table tbody tr {
                transition: 0.2s;
            }

            .table tbody tr:hover {
                background-color: #f1f5f9;
                transform: scale(1.005);
            }

            /* Serial No Column */
            .table tbody td:nth-child(1) {
                font-weight: 600;
                color: #6c757d;
            }

            /* Price Column */
            .table tbody td:nth-child(4) {
                color: #198754;
                font-weight: 600;
            }

            /* Category Column */
            .table tbody td:nth-child(5) {
                color: #0d6efd;
                font-weight: 500;
            }

            /* Quantity Column */
            .table tbody td:nth-child(6) {
                font-weight: 600;
            }

            /* Logout Button */
            .btn-outline-success {
                border-radius: 8px;
                padding: 8px 18px;
                transition: 0.3s;
            }

            .btn-outline-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
            }

            /* Footer */
            footer {
                background-color: #212529;
                color: #adb5bd;
                text-align: center;
                padding: 20px;
                margin-top: 40px;
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {

                .navbar-brand h4 {
                    font-size: 17px;
                }

                .table-responsive {
                    padding: 15px;
                }

                .table thead th,
                .table tbody td {
                    padding: 10px;
                    font-size: 14px;
                }

            }
        </style>

    </head>

    <body>
        <header>
            <nav
                class="navbar navbar-expand-sm navbar-light bg-light"
            >
                <div class="container">
                    <a class="navbar-brand" href="#"><h4>Hello <?php echo htmlspecialchars($_SESSION["name"], ENT_QUOTES, 'UTF-8'); ?></h4></a>
                    <button
                        class="navbar-toggler d-lg-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsibleNavId"
                        aria-controls="collapsibleNavId"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="home.php" aria-current="page"
                                    >Home
                                    <span class="visually-hidden">(current)</span></a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="insert.php">Insert</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="update.php">Update</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="delete.php">Delete</a>
                            </li>
                        </ul>
                        <form class="d-flex my-2 my-lg-0">
                            <a href="logout.php"
                                class="btn btn-outline-success my-2 my-sm-0"
                                type="submit"
                            >
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            </nav>
            
        </header>
        <main>
            <div
                class="container"
            >
                
            <div
                class="table-responsive my-4 py-4"
            >
                <table
                    class="table table-bordered table-hover shadow text-center"
                >
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo htmlspecialchars($row["pid"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row["pname"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row["pprice"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row["pcategory"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row["pquantity"], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            </div>
            
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
