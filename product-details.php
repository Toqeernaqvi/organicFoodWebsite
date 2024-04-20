<?php
ob_start();
include 'header.php';
include 'lib/connection.php';

// Get the product name from the URL
$url = $_SERVER['REQUEST_URI'];
$product_id = isset($_GET['id']) ? $_GET['id'] : '';
// Fetch the product details based on the product name
$sql = "SELECT * FROM product WHERE id = '$product_id'";
$result = $conn->query($sql);
if (isset($_POST['add_to_cart'])) {
    $user_id = $_POST['user_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_id = $_POST['product_id'];
    $product_quantity = 1;
  
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE productid = '$product_id'  && userid='$user_id'");
  
    if (mysqli_num_rows($select_cart) > 0) {
      echo $message[] = 'product already added to cart';
  
    } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(userid, productid, name, quantity, price) VALUES('$user_id', '$product_id', '$product_name', '$product_quantity', '$product_price')");
      echo $message[] = 'product added to cart succesfully';
      header('location:cart.php');
    }
  
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/product_details.css">
</head>
<body>
<?php
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
    echo '
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            <b>Please login or signup before adding a product to your cart.</b>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    ';
}
?>
<div class="container product-details">
    <div class="row mt-5">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body ">
                            <img src="admin/product_img/<?php echo $row['imgname']; ?>" alt="Product Image" class="mb-4 w-100" loading="lazy">
                                <!-- Add more card elements for additional product details -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                <p class="details-heading">Product Details</p>
                    <div>
                        <h5 class="product-name-big"><?php echo $row["name"]; ?></h5>
                        <p class="product-price-big">Rs. <?php echo $row["Price"]; ?></p>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $row['Price']; ?>">
                            <input type="submit" class="mt-2 add-to-cart-big" value="Add to cart" name="add_to_cart">
                        </from>
                        <p class="card-text">Description: <?php echo $row["description"]; ?></p>
                    </div>
                </div>
                <?php 
            }
        } else {
            echo "<div class='col-md-12'><p>No product found</p></div>";
        }
        ?>
    </div>

     <!-- Login Modal -->
     <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="login.php" method="post">
                        <div class="form-group mb-3 position-relative">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                aria-describedby="emailHelp" name="email" placeholder="Enter Email Address">
                            <small>Error message</small>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                                placeholder="Password" name="password">
                            <small>Error message</small>
                        </div>
                        <div class="form-group">
                        </div>
                        <input class="btn btn-primary btn-user btn-block" type="submit" name="submit"
                            value="Login">
                        <hr>
                        <div class="text-center px-8 py-2 shadow-none bg-light rounded">
                            <a class="small" href="register.php">Create an Account!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <div class="elfsight-app-afa90f1b-238c-475d-8d29-f9d09dc73d37" data-elfsight-app-lazy></div>

</body>
</html>
<script>
        const addToCartButton = document.querySelector('.add-to-cart');
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));

        addToCartButton.addEventListener('click', function(event) {
            event.preventDefault();
            <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) { ?>
                loginModal.show();
            <?php } else { ?>
                // If user is already logged in, proceed with adding the product to cart
                this.closest('form').submit();
            <?php } ?>
        });
    </script>
<?php
include 'footer.php';
?>
