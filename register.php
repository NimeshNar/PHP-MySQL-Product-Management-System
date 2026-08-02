<?php

include "connect.php";

$error = "";
$name = "";
$email = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid security token. Please refresh the page and try again.";
    } else {
        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $pass = $_POST["pass"] ?? "";

        if (empty($name) || empty($email) || empty($pass)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } elseif (strlen($pass) < 8) {
            $error = "Password must be at least 8 characters long.";
        } else {
            // Check for existing username or email
            $check_stmt = $conn->prepare("select name, email from user where name=? or email=?");
            if ($check_stmt) {
                $check_stmt->bind_param("ss", $name, $email);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();

                if ($check_result->num_rows > 0) {
                    $existing = $check_result->fetch_assoc();
                    if ($existing['name'] === $name) {
                        $error = "Username is already taken. Please choose a different name.";
                    } else {
                        $error = "Email address is already registered. Please use another email.";
                    }
                } else {
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                    $sql = $conn->prepare("insert into user (name, email, password) values(?,?,?)");
                    if ($sql) {
                        $sql->bind_param('sss', $name, $email, $hashed_pass);
                        if ($sql->execute()) {
                            header("Location: login.php");
                            exit();
                        } else {
                            $error = "Registration failed. Please try again.";
                        }
                    } else {
                        $error = "An error occurred while processing registration.";
                    }
                }
            } else {
                $error = "An error occurred while processing registration.";
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Register</title>
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

            /* Main Content */
            main {
                min-height: calc(100vh - 100px);
                padding-top: 50px;
            }

            /* Page Heading */
            main h3 {
                font-weight: 700;
                color: #212529;
            }

            /* Registration Card */
            .register-card {
                background-color: white;
                border-radius: 12px;
                padding: 35px !important;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                transition: 0.3s;
            }

            .register-card:hover {
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

            /* Register Button */
            .register-btn {
                background-color: #0d6efd;
                color: white;
                border: none;
                border-radius: 8px;
                padding: 10px 35px;
                font-weight: 600;
                transition: 0.3s;
            }

            .register-btn:hover {
                background-color: #0b5ed7;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
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

                .register-card {
                    width: 90% !important;
                    padding: 25px !important;
                }

            }
        </style>

    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <h3 class="text-center my-4">Registration Form</h3>
            <div class="container text-center register-card my-4 col-md-6">
                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger py-2 mb-3" role="alert">
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php } ?>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="regName"
                            placeholder="Name"
                            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="regName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            name="email"
                            id="regEmail"
                            placeholder="Email"
                            value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="regEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control"
                            name="pass"
                            id="regPass"
                            placeholder="Password"
                        />
                        <label for="regPass">Password (min 8 characters)</label>
                    </div>
                    <button
                        type="submit"
                        class="btn register-btn"
                    >
                        <i class="bi bi-person-plus"></i> Register
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
