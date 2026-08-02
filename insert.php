<?php

include "connect.php";

if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

$error = "";
$name = "";
$price = "";
$category = "";
$quantity = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid security token. Please refresh the page and try again.";
    } else {
        $name = trim($_POST["name"] ?? "");
        $price = trim($_POST["price"] ?? "");
        $category = trim($_POST["category"] ?? "");
        $quantity = trim($_POST["quantity"] ?? "");

        if (empty($name) || $price === "" || empty($category) || $quantity === "") {
            $error = "All fields are required.";
        } elseif (!is_numeric($price) || floatval($price) <= 0) {
            $error = "Price must be a valid positive number.";
        } elseif (!filter_var($quantity, FILTER_VALIDATE_INT) && $quantity !== "0") {
            $error = "Quantity must be a valid integer.";
        } elseif (intval($quantity) < 0) {
            $error = "Quantity cannot be negative.";
        } else {
            $price_val = floatval($price);
            $quantity_val = intval($quantity);

            $sql = $conn->prepare("insert into product (pname,pprice,pcategory,pquantity) values(?,?,?,?)");
            if ($sql) {
                $sql->bind_param('sdsi', $name, $price_val, $category, $quantity_val);
                if ($sql->execute()) {
                    header("Location: home.php");
                    exit();
                } else {
                    $error = "Failed to add product. Please try again.";
                }
            } else {
                $error = "An error occurred while saving the product.";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Insert Product</title>
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

        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
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
                padding-top: 30px;
            }

            /* Page Heading */
            main h3 {
                font-weight: 700;
                color: #212529;
            }

            /* Insert Form Card */
            .insert-card {
                background-color: white;
                border-radius: 12px;
                padding: 35px !important;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                transition: 0.3s;
            }

            .insert-card:hover {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            }

            /* Form Inputs */
            .form-floating .form-control {
                border-radius: 8px;
                border: 1px solid #dee2e6;
            }

            .form-floating .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            }

            .form-floating label {
                color: #6c757d;
            }

            /* Submit Button */
            .insert-btn {
                background-color: #0d6efd;
                border: none;
                border-radius: 8px;
                padding: 10px 35px;
                font-weight: 600;
                transition: 0.3s;
            }

            .insert-btn:hover {
                background-color: #0b5ed7;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
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

                .insert-card {
                    width: 90% !important;
                    padding: 25px !important;
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
                                <a class="nav-link" href="home.php" aria-current="page"
                                    >Home
                                    <span class="visually-hidden">(current)</span></a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="insert.php">Insert</a>
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
            <h3 class="text-center my-4">Insert Product</h3>
            <div class="container text-center insert-card my-4 col-md-6">
                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger py-2 mb-3" role="alert">
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php } ?>
                <form action="" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="pName"
                            placeholder="Name"
                            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="pName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="price"
                            id="pPrice"
                            placeholder="Price"
                            value="<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="pPrice">Price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            name="category"
                            id="pCategory"
                            placeholder="Category"
                            value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="pCategory">Category</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input
                            type="number"
                            class="form-control"
                            name="quantity"
                            id="pQuantity"
                            placeholder="Quantity"
                            value="<?php echo htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="pQuantity">Quantity</label>
                    </div>
                    <button
                        type="submit"
                        class="btn insert-btn"
                    >
                        <i class="bi bi-plus-circle"></i> Add Product
                    </button>
                </form>
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
