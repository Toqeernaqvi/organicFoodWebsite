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

  // Fetch the old image name
  $old_image_query = "SELECT imgname FROM product WHERE id = '$update_id'";
  $old_image_result = mysqli_query($conn, $old_image_query);
  $old_image_row = mysqli_fetch_assoc($old_image_result);
  $old_image_name = $old_image_row['imgname'];

  // Check if a new file has been uploaded
  if (!empty($_FILES["uploadfile"]["name"])) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = __DIR__ . "/product_img/";
    // Generate a unique filename
    $uniqueFilename = uniqid().'_'.$filename;

    // Move uploaded file to the desired folder
    if (move_uploaded_file($tempname, $folder.$uniqueFilename)) {
      // Update product details including the new image
      $update_query = "UPDATE `product` SET quantity = '$quantity' , name='$name' , category='$category' ,price='$price', imgname='$uniqueFilename', description='$description'  WHERE id = '$update_id'";
      // Remove the old image
      if ($old_image_name != "") {
        unlink($folder . $old_image_name);
      }
    } else {
      $result = "<h2>Failed to upload image.</h2>";
    }
  } else {
    // No new image uploaded, update product details excluding the image
    $update_query = "UPDATE `product` SET quantity = '$quantity' , name='$name' , category='$category' ,price='$price', description='$description'  WHERE id = '$update_id'";
  }

  // Execute the update query if defined
  if (isset($update_query)) {
    if (mysqli_query($conn, $update_query)) {
      $result = "<h2>Data updated successfully.</h2>";
    } else {
      $result = "<h2>Failed to update data: " . mysqli_error($conn) . "</h2>";
    }
  }

  header('location:all_product.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Products</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ensure jQuery is included before Bootstrap.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  <style>
    .product-img {
      width: 100px;
    }
    .description-textarea {
      overflow-y: scroll;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h5 class="mb-4">All Products</h5>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Category</th>
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
  <td><img src="product_img/<?php echo $row['imgname']; ?>" class="product-img img-thumbnail"></td>
  <td><?php echo $row['name']; ?></td>
  <td><?php echo $row['category']; ?></td>
  <td><?php echo $row['quantity']; ?></td>
  <td><?php echo $row['Price']; ?></td>
  <td><?php echo $row['description']; ?></td>
  <td>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $row['id']; ?>">Update</button>
  </td>
  <td>
  <a href="all_product.php?remove=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a>

  </td>
</tr>

<!-- Update Modal -->
<div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
          <div class="form-group">
            <label for="uploadfile">Image:</label>
            <input type="file" name="uploadfile" class="form-control-file" id="uploadfile">
          </div>
          <div class="form-group">
            <label for="update_name">Name:</label>
            <input type="text" name="update_name" value="<?php echo $row['name']; ?>" class="form-control" id="update_name">
          </div>
          <div class="form-group">
            <label for="update_category">Category:</label>
            <input type="text" name="update_category" value="<?php echo $row['category']; ?>" class="form-control" id="update_category" readonly>
          </div>
          <div class="form-group">
            <label for="update_quantity">Quantity:</label>
            <input type="number" name="update_quantity" value="<?php echo $row['quantity']; ?>" class="form-control" id="update_quantity">
          </div>
          <div class="form-group">
            <label for="update_Price">Price:</label>
            <input type="number" name="update_Price" value="<?php echo $row['Price']; ?>" class="form-control" id="update_Price">
          </div>
          <div class="form-group">
            <label for="update_description">Description:</label>
            <textarea name="update_description" rows="4" class="form-control" id="update_description"><?php echo $row['description']; ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary" name="update_update_btn">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>


          <?php
        }
      } else {
        echo "<tr><td colspan='8'>0 results</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script>
  function resetForm(formId) {
    document.getElementById('updateForm_' + formId).reset();
  }
</script>

</body>
</html>
