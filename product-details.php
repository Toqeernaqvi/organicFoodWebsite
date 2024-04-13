<?php
include 'header.php';
include 'lib/connection.php';

// Get the product name from the URL
$url = $_SERVER['REQUEST_URI'];
$product_id = isset($_GET['id']) ? $_GET['id'] : '';

// Fetch the product details based on the product name
$sql = "SELECT * FROM product WHERE id = '$product_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/product_details.css">
</head>
<body>

<div class="container product-details">
    <h2 class="my-4">Product Details: <?php echo $product_name; ?></h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                        <img src="admin/product_img/<?php echo $row['imgname']; ?>" alt="Product Image">
                            <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">ID: <?php echo $row["id"]; ?></h6>
                            <p class="card-text">Price: <?php echo $row["Price"]; ?></p>
                            <p class="card-text">Description: <?php echo $row["description"]; ?></p>
                            <!-- Add more card elements for additional product details -->
                        </div>
                    </div>
                </div>
                <?php 
            }
        } else {
            echo "<div class='col-md-12'><p>No product found</p></div>";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include 'footer.php';
?>
