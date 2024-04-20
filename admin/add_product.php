<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
    header("location: login.php");
    exit(); // Stop further execution
}

include 'header.php';
include 'lib/connection.php';

$result = "";

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = __DIR__ . "/product_img/";

    // Generate a unique filename
    $uniqueFilename = uniqid().'_'.$filename;

    // Check if all fields are filled
    if(empty($name) || empty($category) || empty($description) || empty($quantity) || empty($price) || empty($filename)) {
        $result = "<h2>All fields are required.</h2>";
    } else {
        // Insert data into the database
        $insertSql = "INSERT INTO product (name, category, description, quantity, price, imgname) VALUES ('$name', '$category', '$description', $quantity, $price, '$uniqueFilename')";
        if($conn->query($insertSql)) {
            // Move uploaded file to the desired folder
            if(copy($tempname, $folder.$uniqueFilename)) {
              $result = "<h2>Data inserted successfully.</h2>";
          } else {
              $result = "<h2>Failed to upload image: ".error_get_last()['message']."</h2>";
          }          
        } else {
            $result = "<h2>Error: ".$conn->error."</h2>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <div class="container">
        <?php echo $result; ?>
        <h4>Add Product</h4>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputName">
            </div>
            <div class="mb-3">
                <label for="exampleInputCategory" class="form-label">Category</label>
                <!-- <input type="text" name="category" class="form-control" id="exampleInputCategory"> -->
                <select name="category" id="exampleInputCategory">
                    <option value="men watch">men watch</option>
                    <option value="men ring">men ring</option>
                    <option value="men bracelet">men bracelet</option>
                    <option value="men necklace">men necklace</option>
                    <option value="women watch">women watch</option>
                    <option value="women ring">women ring</option>
                    <option value="women bracelet">women bracelet</option>
                    <option value="women necklace">women necklace</option>
                    <option value="custom bracelet">custom bracelet</option>
                    <option value="custom necklace">custom necklace</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputQuantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" id="exampleInputQuantity">
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Price</label>
                <input type="Number" name="price" class="form-control" id="exampleInputPrice">
            </div>
            <div class="mb-3">
                <label for="exampleInputDescription" class="form-label">Description</label>
                <textarea rows="10" cols="50" name="description" class="form-control" id="exampleInputDescription"></textarea>

            </div>
            <div class="mb-3">
                <label for="uploadfile" class="form-label">Image</label>
                <input type="file" name="uploadfile" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
