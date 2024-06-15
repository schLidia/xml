<?php
session_start();
$admin_username = "lidia";

// Function to generate unique product ID
function generateProductID($xml) {
    $maxID = 0;
    foreach ($xml->product as $product) {
        $id = (int)$product->id;
        if ($id > $maxID) {
            $maxID = $id;
        }
    }
    return $maxID + 1;
}

// Processing form data when form is submitted
if(isset($_POST['upload'])) {
    $target = "./assets/img_produse/" . md5(uniqid(time())) . basename($_FILES['image']['name']);
    $text = $_POST['nume'];
    $text1 = $_POST['pret'];
    $text3 = $_POST['culoare'];
    $text2 = $_POST['descriere'];

    // Load XML file
    $xml = simplexml_load_file('produse.xml');

    // Generate unique ID for new product
    $newID = generateProductID($xml);

    // Prepare new product data
    $newProduct = $xml->addChild('product');
    $newProduct->addChild('id', $newID);
    $newProduct->addChild('image', $target);
    $newProduct->addChild('name', $text);
    $newProduct->addChild('price', $text1);
    $newProduct->addChild('color', $text3);
    $newProduct->addChild('description', $text2);

    // Save XML file
    $xml->asXML('produse.xml');

    // Move uploaded image to target directory
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Redirect to products.php after successful upload
        header('location: products_admin.php');
        exit; // Ensure that script stops here after redirection
    } else {
        $msg = "Vai! Vai! Vai!!!";
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
    
    <!-- Upload section -->
    <section class="page-section cta">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="cta-inner bg-faded text-center rounded">
                        <h2 class="section-heading mb-5">
                            <span class="section-heading-upper"></span>
                            <span class="section-heading-lower">Upload</span>
                        </h2>
                        <div class="wrapper">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nume</label>
                                    <input type="text" name="nume" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Pret</label>
                                    <input type="text" name="pret" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Culoare</label>
                                    <input type="text" name="culoare" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Descriere</label>
                                    <textarea name="descriere" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Imagine</label>
                                    <input type="file" name="image" class="form-control-file">
                                </div>
                                <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
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
