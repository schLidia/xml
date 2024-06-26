<?php
session_start();
$admin_username = "lidia";
$admin_password = "lidia123";

// Load XML file
$xml = simplexml_load_file('produse.xml');

// Find the product by ID
$id = $_GET['id'] ?? '';
$product = null;
foreach ($xml->product as $item) {
    if ((int)$item->id === (int)$id) {
        $product = $item;
        break;
    }
}
?>

<!DOCTYPE html>
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="index.php">Home</a></li>
                <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="about.php">About</a></li>
                <li class="nav-item px-lg-4"><a class="nav-link text-uppercase"
                                                href=<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["username"] == $admin_username)
                                                    echo "products_admin.php";
                                                else
                                                    echo "products.php"; ?>>Products</a></li>
                <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="page-section">
    <div class="container">
        <div class="product-item">
            <div class="product-item-title d-flex">
                <div class="bg-faded p-5 d-flex me-auto rounded">
                    <h2 class="section-heading mb-0">
                        <span class="section-heading-lower"><?php echo $product->name;?></span>
                        <span class="section-heading-upper"><?php echo "Price: " . $product->price . " $";?></span>
                    </h2>
                </div>
            </div>
            <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="<?php echo $product->image;?>">
            <div class="product-item-description d-flex ms-auto">
                <div class="bg-faded p-5 rounded">
                    <p class="mb-0"><?php echo "<b>Color</b>: ".$product->color;?></p>
                     <p class="mb-0"><?php echo "<b>Description</b>: ".$product->description;?></p>
                     
                    <p class="m-0"><a href="products.php">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Copyright &copy; Your Website 2023</p>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>
