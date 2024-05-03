<?php
SESSION_START();

if (isset($_SESSION['auth'])) {
  if ($_SESSION['auth'] != 1) {
    header("location:login.php");
  }
} else {
  header("location:login.php");
}
include 'header.php';
include 'lib/connection.php';

$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if (isset($_POST['update_update_btn'])) {
  $name = $_POST['update_name'];
  $category = $_POST['update_category'];
  $quantity = $_POST['update_quantity'];
  $description = $_POST['update_description'];

  $price = $_POST['update_Price'];
  $update_id = $_POST['update_id'];
  $update_quantity_query = mysqli_query($conn, "UPDATE `product` SET quantity = '$quantity' , name='$name' , category='$category' ,price='$price', description='$description'  WHERE id = '$update_id'");
  if ($update_quantity_query) {
    header('location:all_product.php');
  }
  ;
}
;

if (isset($_GET['remove'])) {
  $remove_id = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM `product` WHERE id = '$remove_id'");
  header('location:all_product.php');
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/pending_orders.css">

</head>

<body>

  <div class="container pendingbody">
    <h5>All Product</h5>
    <table class="table">
      <thead>
        <tr>
        <th scope="col">Id</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">category</th>

          <th scope="col">Quantity</th>
          <th scope="col">Price</th>
          <th scope="col">Description</th>

          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><img src="product_img/<?php echo $row['imgname']; ?>" style="width:50px;"></td>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
                <td><input type="text" name="update_name" value="<?php echo $row['name']; ?>"></td>
               <td><input type="text" name="update_category" value="<?php echo $row['category']; ?>" readonly></td>


                <td><input type="number" name="update_quantity" value="<?php echo $row['quantity']; ?>"></td>
                <td> <input type="number" name="update_Price" value="<?php echo $row['Price']; ?>"></td>
                <td>
                  <textarea name="update_description" rows="4" cols="50" style="overflow-y: scroll;"><?php echo $row['description']; ?></textarea>
                </td>

                <td> <input type="submit" value="update" name="update_update_btn" class="btn btn-primary">
              </form>
              </td>
              <td><a href="all_product.php?remove=<?php echo $row['id']; ?>" class="btn btn-danger">remove</a></td>
            </tr>
            <?php
          }
        } else
          echo "0 results";
        ?>
      </tbody>
    </table>



  </div>

</body>

</html>