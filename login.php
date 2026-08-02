<?php

include "connect.php";

if (isset($_SESSION["name"])) {
    header("Location: home.php");
    exit();
}

$error = "";
$name = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid security token. Please refresh the page and try again.";
    } else {
        $name = trim($_POST["name"] ?? "");
        $pass = $_POST["pass"] ?? "";

        if (empty($name) || empty($pass)) {
            $error = "Please enter both username and password.";
        } else {
            $sql = $conn->prepare("select password from user where name=?");
            if ($sql) {
                $sql->bind_param('s', $name);
                $sql->execute();
                $sql->store_result();
                $sql->bind_result($password);

                if ($sql->fetch()) {
                    // Primary authentication: Verify against secure password hash
                    if (password_verify($pass, $password)) {
                        session_regenerate_id(true);
                        $_SESSION["name"] = $name;
                        header("Location: home.php");
                        exit();
                    }
                    // Safe legacy fallback: Check password_get_info() before checking plain-text
                    else {
                        $pwd_info = password_get_info($password);
                        if ($pwd_info['algo'] === 0 && $pass === $password) {
                            $new_hash = password_hash($pass, PASSWORD_DEFAULT);
                            $update_sql = $conn->prepare("update user set password=? where name=?");
                            if ($update_sql) {
                                $update_sql->bind_param('ss', $new_hash, $name);
                                $update_sql->execute();
                            }

                            session_regenerate_id(true);
                            $_SESSION["name"] = $name;
                            header("Location: home.php");
                            exit();
                        } else {
                            $error = "Invalid Credentials";
                        }
                    }
                } else {
                    $error = "Invalid Credentials";
                }
            } else {
                $error = "An error occurred while processing login.";
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Login</title>
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

            body {
                background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
                font-family: Arial, sans-serif;
                color: #212529;
                min-height: 100vh;
            }

            .login-card {
                background-color: white;
                border-radius: 12px;
                padding: 35px !important;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            }

            .login-card:hover {
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            }
            
            .login-btn {
                background-color: #0d6efd;
                color: white;
                border: none;
                border-radius: 8px;
                padding: 10px 35px;
                font-weight: 600;
                transition: 0.3s;
            }

            .login-btn:hover {
                background-color: #0b5ed7;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
            }
        </style>
        
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <h3 class="text-center my-4">Login Form</h3>
            <div class="container text-center login-card my-4 col-md-6">
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
                            id="loginName"
                            placeholder="Name"
                            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                        />
                        <label for="loginName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control"
                            name="pass"
                            id="loginPass"
                            placeholder="Password"
                        />
                        <label for="loginPass">Password</label>
                    </div>
                    <button
                        type="submit"
                        class="btn login-btn"
                    >
                        <i class="bi bi-box-arrow-in-right"></i> Login
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
