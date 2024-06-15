<?php
ob_start(); // start output buffering

// Initialize the session
session_start();
$admin_username = "lidia";

$status = 0;
$username_err = $password_err = $login_err = "";

// Load users from XML
$users_xml = simplexml_load_file('users.xml');
$users = [];
foreach ($users_xml->user as $user) {
    $users[(string)$user->username] = [
        'id' => (int)$user->id,
        'username' => (string)$user->username,
        'password' => (string)$user->password
    ];
}

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["username"] == $admin_username) {
        header("location: welcome_admin.php");
    } else {
        header("location: welcome.php");
    }
    exit;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        if (isset($users[$username])) {
            $hashed_password = $users[$username]['password'];
            if (password_verify($password, $hashed_password)) {
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $users[$username]['id'];
                $_SESSION["username"] = $username;

                $status = 1;

                // Handle remember me functionality
                if (!empty($_POST["rememberme"])) {
                    $rememberme = $_POST["rememberme"];
                    setcookie('username', $username, time() + 30000);
                    setcookie('password', $password, time() + 30000);
                } else {
                    setcookie('username', $username, 1);
                    setcookie('password', $password, 1);
                }

                // Redirect based on user type
                if ($username == $admin_username) {
                    header("location: welcome_admin.php");
                } else {
                    header("location: welcome.php");
                }
                exit;
            } else {
                // Password is not valid
                $login_err = "Invalid username or password.";
                $status = 2;
            }
        } else {
            // Username doesn't exist
            $login_err = "Invalid username or password.";
            $status = 2;
        }
    }
}

ob_flush(); // flush output buffer
?>


<html lang="en">
    <head>
       
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Business Casual - Start Bootstrap Theme</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    
    </head>
    <body>
        
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-upper text-primary mb-3">Delicacy. Elegance. </span>
                <span class="site-heading-lower">Hair bows store</span>
            </h1>
        </header>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.php">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="index.php">Home</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="about.php">About</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href=<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["username"] == $admin_username)
                                                                                                    echo"products_admin.php";
                                                                                               else
                                                                                                   echo"products.php";?>>Products</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="page-section cta">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="cta-inner bg-faded text-center rounded">
                            <h2 class="section-heading mb-5">
                                <span class="section-heading-upper"></span>
                                <span class="section-heading-lower">Login</span>
                            </h2>
                            <div class="wrapper">
       
                            <p>Please fill in your credentials to login.</p>

                            <div align="center">

        
        <div class="container">
            
            <div class="loginform">
                
                <form method='POST' name="form1" onsubmit="return checkCaptcha();">
                    <label>Username:</label><br/>
                    <div class='form-group'>
                        
                        <input class="forminput" type="text" class="form-control" placeholder="Enter your username" name="username" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>">
                    </div>
                    <br/>
                    <label>Password:</label>
                    <div class='form-group'>
                        
                        <input class="forminput" type="password" placeholder="Enter your password" name="password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>">
                    </div>
                    <?php
                    if($status==2)
                    {
                        echo "<span class='signup'>This account doesn't exist</span><br>";
                    }
                    ?>
                    <br/>
                    Remember me<input class="signup" type="checkbox" class="rememberme" name="rememberme" value="1">
                    <input  type="submit" class="forminput button" value="Login" name="login">
                </form>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </div>
        </div>
                                


                            </div>
                            </div>
            </div>
        </section>
        
        <footer class="footer text-faded text-center py-5">
            <div class="container"><p class="m-0 small">Copyright &copy; bowsforyou.com</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
