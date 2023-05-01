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

    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>


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
                                            <div class="form-group mb-3 position-relative">
                                                <input type="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                    placeholder="Enter Email Address">
                                                <small>Error message</small>
                                            </div>
                                            <div class="form-group mb-3 position-relative">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password" name="password">
                                                <small>Error message</small>
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

    <script>
        const form = document.querySelector('form')
        const email = document.querySelector('#exampleInputEmail')
        const password = document.querySelector('#exampleInputPassword')

        console.log('hello')

        function showError(input, message) {
            const formControl = input.parentElement;
            const small = formControl.querySelector('small');
            small.className = 'error';
            small.textContent = message;
        }

        function removeError(input) {
            const formControl = input.parentElement;
            const small = formControl.querySelector('small');
            small.classList = '';
        }

        function checkEmail(input) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(input.value.trim())) {
                return
            } else {
                showError(input, 'Email is not valid');
            }
        }


        function checkRequired(inputArr) {
            inputArr.forEach(function (input) {
                if (input.value.trim() === '') {
                    showError(input, `${getFieldName(input)} is required`);
                } else {
                    removeError(input)
                }
            });
        }


        function checkLength(input, min, max) {
            if (input.value.length < min) {
                showError(
                    input,
                    `${getFieldName(input)} must be at least ${min} characters`
                );
            } else if (input.value.length > max) {
                showError(
                    input,
                    `${getFieldName(input)} must be less than ${max} characters`
                );
            } else {
                removeError(input)
            }
        }


        function getFieldName(input) {
            console.log(input.name)
            return input.name;
        }


        form.addEventListener("submit", function (e) {

            console.log('success')

            checkRequired([email, password]);
            checkLength(password, 4, 25);
            checkEmail(email);
        });

    </script>

</body>

</html>