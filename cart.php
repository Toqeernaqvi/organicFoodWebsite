<?php
 include'header.php';
 include'lib/connection.php';


// if(isset($_SESSION['auth']))
// {
//    if($_SESSION['auth']!=1)
//    {
//        header("location:login.php");
//    }
// }
// else
// {
//    header("location:login.php");
// }
if(isset($_POST['order_btn'])){
  $userid = $_POST['user_id'];
  $name = $_POST['user_name'];
  $number = $_POST['number'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $payment_method =  $_POST['payment_method'];
  
  /*$price_total = $_POST['total'];*/
  $status="pending";

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` where userid='$userid'");
  $price_total = 0;
  if(mysqli_num_rows($cart_query) > 0){
     while($product_item = mysqli_fetch_assoc($cart_query)){
        $product_name[] = $product_item['productid'] .' ('. $product_item['quantity'] .')  ('. $product_item['name'] .') ';
        $product_price = number_format($product_item['price'] * $product_item['quantity']);
        $price_total += $product_price;
        $sql = "SELECT * FROM product";
        $result = $conn -> query ($sql);
      
        if (mysqli_num_rows($result) > 0) {
          // output data of each rowfvz
          while($row = mysqli_fetch_assoc($result)) {
            if($row['id']===$product_item['productid'])
            {
              if($product_item['quantity']<=$row['quantity'])
              {
                $update_id=$row['id'];
                $t=$row['quantity']-$product_item['quantity'];
                $update_quantity_query = mysqli_query($conn, "UPDATE `product` SET quantity = '$t' WHERE id = '$update_id'");
                

                $flag=1;


                

              }
              else
              {
                echo "out of stock " .$row['name']." Quantity:".$row['quantity'];
              }
            }
          }

        }

     };
     if($flag==1)
     {
       $total_product = implode(', ',$product_name);
       $detail_query = mysqli_query($conn, "INSERT INTO `orders`(userid, name, address, phone,    email,  payment_method, totalproduct, totalprice, status) VALUES('$userid','$name','$address','$number','$email', '$payment_method', '$total_product','$price_total','$status')") or die($conn -> error);
           
             $cart_query1 = mysqli_query($conn, "delete FROM `cart` where userid='$userid'");
             header("location:index.php");

     }
  };



}

$id=$_SESSION['userid'];
 $sql = "SELECT * FROM cart where userid='$id'";
 $result = $conn -> query ($sql);

 if(isset($_POST['update_update_btn'])){
  $update_value = $_POST['update_quantity'];
  $update_id = $_POST['update_quantity_id'];
  $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
  if($update_quantity_query){
     header('location:cart.php');
  };
};

if(isset($_GET['remove'])){
  $remove_id = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
  header('location:cart.php');
};


?>

<div class="container pendingbody">
  <h5 class="mb-5">cart</h5>
  <table class="table">
    <thead>
      <tr>
        <!-- <th scope="col">#</th> -->
        <th scope="col">Name</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
   $total=0;
          if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              ?>

      <tr>
        <!-- <th scope="row">1</th> -->
        <td><?php echo $row["name"] ?></td>

        <td>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="update_quantity_id" value="<?php echo  $row['id']; ?>">
            <input type="number" name="update_quantity" min="1" value="<?php echo $row['quantity']; ?>"
              class="w-25 rounded-0 border d-inline-flex focus-ring form-control quantity-field">
            <input type="submit" value="update" name="update_update_btn" class="border d-inline-flex focus-ring btn"
              style={background: "#FAEAE5" }>
          </form>
        </td>
        <td>Rs&nbsp;<?php echo $row["price"]*$row["quantity"]  ?></td>
        <?php $total=$total+$row["price"]*$row["quantity"] ;?>
        <input type="hidden" name="status" value="pending">
        <td><a href="cart.php?remove=<?php echo $row['id']; ?>">remove</a></td>
      </tr>
      <?php 
    }
        } 
        else 
            echo "No Products in the Cart";
        ?>

    </tbody>
  </table>
  <style>
  .myDiv {
    background-color: lightblue;
    text-align: right;
  }

  .cart-quantity {
    width: 30px;
  }

  /* Chrome, Safari, Edge, Opera */
  .quantity-field::-webkit-outer-spin-button,
  .quantity-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  .quantity-field[type=number] {
    -moz-appearance: textfield;
  }
  </style>


  <div class="myDiv mb-5">
    <?php echo "<h style='font-size: 24px;'>Total Amount= $total</h>"; ?>
  </div>

  <tbody>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <h5 class="mb-2">Payment Method</h5>
      <input type="radio" id="cod" name="payment_method" value="cod" required>
      <label for="cod">Cash On Delivery</label><br>
      <input type="radio" id="online_transfer" name="payment_method" value="online_transfer" required>
      <label for="online_transfer">Online Transfer</label><br>

      <div id="account_number_field" style="display:none;">
        <div style="display: flex; align-items: center;">
          <img src="img/jazzcashLogo.jpg" alt="Logo"
            style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
          <p style="margin: 0;">JazzCash Account Number: XXXXXXXXX</p>
        </div>

        <div style="display: flex; align-items: center;">
          <img src="./img/jazzcashLogo.jpg" alt="Logo"
            style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
          <p style="margin: 0;">JazzCash Account Number: XXXXXXXXX</p>
        </div>

        <div style="display: flex; align-items: center;">
          <img src="img/jazzcashLogo.jpg" alt="Logo"
            style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
          <p style="margin: 0;">JazzCash Account Number: XXXXXXXXX</p>
        </div>

        <div style="display: flex; align-items: center;">
          <img src="img/jazzcashLogo.jpg" alt="Logo"
            style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
          <p style="margin: 0;">JazzCash Account Number: XXXXXXXXX</p>
        </div>
        <br>
        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your
          order will not be shipped until the funds have cleared in our account.</p>
      </div>

      <div class="input-group form-group">
        <input type="hidden" name="total" value="<?php echo $total ?>">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
        <input type="hidden" name="user_name" value="<?php echo $_SESSION['username']; ?>">
        <input type="text" class="form-control" placeholder="Address" name="address">
      </div>
      <div class="input-group form-group">
        <input type="number" class="form-control" placeholder="Phone Number" name="number">
      </div>
      <div class="input-group form-group">
        <input type="emaild" class="form-control" placeholder="email" name="email">
      </div>

      <div class="form-group">
        <input type="submit" value="Order Now" name="order_btn" class="btn btn-primary">
      </div>

    </form>
  </tbody>
</div>


<?php
 include'footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var cashOnDeliveryRadio = document.getElementById('cod');
  var onlineTransferRadio = document.getElementById('online_transfer');
  var accountNumberField = document.getElementById('account_number_field');

  cashOnDeliveryRadio.addEventListener('change', function() {
    if (this.checked) {
      accountNumberField.style.display = 'none';
    }
  });

  onlineTransferRadio.addEventListener('change', function() {
    if (this.checked) {
      accountNumberField.style.display = 'block';
    } else {
      accountNumberField.style.display = 'none';
    }
  });
});
</script>