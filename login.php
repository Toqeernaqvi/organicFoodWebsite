<?php

SESSION_START();

if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth'] == 1) {
        header("location:index.php");
    }
}


include "lib/connection.php";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    // $pass = md5($_POST['password']);
    $pass = ($_POST['password']);
    $loginquery = "SELECT * FROM users WHERE email='$email' AND pass='$pass'";
    $loginres = $conn->query($loginquery);

    echo $loginres->num_rows;

    if ($loginres->num_rows > 0) {

        while ($result = $loginres->fetch_assoc()) {
            $username = $result['f_name'];
            $userid = $result['id'];
        }

        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['auth'] = 1;
        header("location:index.php");
    } else {
        echo "invalid";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>cse411</title>


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-5 ">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="">
                                <div class="">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user">
                                            <div class="form-group mb-3">
                                                <input type="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                    placeholder="Enter Email Address">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password" name="password">
                                            </div>
                                            <div class="form-group">

                                            </div>

                                            <input class="btn btn-primary btn-user btn-block" type="submit"
                                                name="submit" value="login">

                                            <hr>
                                            <div class="text-center px-8 py-2 shadow-none bg-light rounded">
                                                <a class="small" href="register.php">Create an
                                                    Account!</a>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>


</body>

</html>