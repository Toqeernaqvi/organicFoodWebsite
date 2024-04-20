<?php
include 'header.php';
include 'lib/connection.php';


$sql = "SELECT * FROM product where category = 'women jewelry'";
$result = $conn->query($sql);

if (isset($_POST['add_to_cart'])) {

  if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth'] != 1) {
      header("location:login.php");
    }
  } else {
    header("location:login.php");
  }
  $user_id = $_POST['user_id'];
  ;
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
    header('location:index.php');
  }

}
?>

<section>
  <div class="container">
    <div class="topsell-head">
      <div class="row r">
        <div class="col-md-12 text-center">
          <img src="img/mark.png">
          <h4>Women </h4>
          <p>A passage of watches you need here</p>
        </div>
      </div>
    </div>
  </div>
  <div class="all-products">
    <div class="product">
      <?php
      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="single-product">
        <div>
          <a href="product-details.php?id=<?php echo urlencode($row['id']); ?>">
          <div>
            <img src="admin/product_img/<?php echo $row['imgname']; ?>" class="product-img" data-toggle="modal"
              data-target="#exampleModal" loading="lazy">
          </div>
          <div>
            <div>
              <h4 class="mb-1 product-category">
                <?php echo $row["category"] ?>
              </h4>
              <h5 class="mb-1 product-name">
                <?php echo $row["name"] ?>
              </h5>
              </a>
              <h6 class="mb-4 product-price">Rs
                <?php echo $row["Price"] ?>
              </h6>
              <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
              <input type="hidden" name="product_price" value="<?php echo $row['Price']; ?>">
            </div>
          </div>
        </div>
      </form>
      <?php
        }
      } else
        echo "0 results";
      ?>
    </div>
  </div>
</section>

<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
<div class="elfsight-app-afa90f1b-238c-475d-8d29-f9d09dc73d37" data-elfsight-app-lazy></div>

<?php
include 'footer.php';
?>