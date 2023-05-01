<?php

include "lib/connection.php";
$result = null;
if (isset($_POST['u_submit'])) {
    $f_name = $_POST['u_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $pass = ($_POST['pass']);
    $cpass = ($_POST['c_pass']);
    if ($pass == $cpass) {
        $insertSql = "INSERT INTO users(f_name ,l_name, email, pass) VALUES ('$f_name', '$l_name','$email', '$pass')";

        if ($conn->query($insertSql)) {
            $result = "Account Open success";
            header("location:login.php");
        } else {
            die($conn->error);
        }
    } else {
        $result = "Password Not Match";
    }
}


//echo $result_std -> num_rows;


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
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">



</head>

<body class="bg-gradient-primary">

    <div class="container">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="card o-hidden border-0 ">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="">
                        <div class="col-lg-7 shadow-lg my-5 mx-auto">
                            <div class="p-5 sign-up-form">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    <?php echo $result; ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0 position-relative">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name" name="first name">
                                        <small>Error message</small>
                                    </div>
                                    <div class="col-sm-6 position-relative ">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name" name="last name">
                                        <small>Error message</small>

                                    </div>
                                </div>
                                <div class="form-group my-3 position-relative">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address" name="email">
                                    <small>Error message</small>

                                </div>
                                <div class="form-group row position-relative ">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                        <small>Error message</small>

                                    </div>
                                    <div class="col-sm-6 mb-4 position-relative">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password" name="password">
                                        <small>Error message</small>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block mb-4"
                                    name="u_submit">Register Account</button>


                                <hr>
                                <div class="text-center px-8 py-2 shadow-none bg-light rounded">
                                    <a class="small  " href="login.html">Already have an
                                        account? Login!</a>
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
        const firstName = document.querySelector('#exampleFirstName')
        const lastName = document.querySelector('#exampleLastName')
        const email = document.querySelector('#exampleInputEmail')
        const password1 = document.querySelector('#exampleInputPassword')
        const password2 = document.querySelector('#exampleRepeatPassword')


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



        function checkPasswordsMatch(input1, input2) {
            if (input1.value !== input2.value) {
                showError(input2, 'Passwords do not match');
            }
        }

        function getFieldName(input) {
            console.log(input.name)
            return input.name;
        }


        form.addEventListener("submit", function (e) {

            checkRequired([firstName, lastName, email, password1, password2]);
            checkLength(firstName, 3, 15);
            checkLength(lastName, 3, 15);
            checkLength(password1, 6, 25);
            checkLength(password2, 6, 25);
            checkEmail(email);
            checkPasswordsMatch(password1, password2);
        });

    </script>

</body>

</html>