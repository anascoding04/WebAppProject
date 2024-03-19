<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="vh-100 bg-danger">
    <main class="h-100 d-flex justify-content-center align-items-center">
        <div class="login bg-white p-4 rounded shadow">
            <h1 class="text-center mb-4">WebApp Login</h1>

            <form action="./php/auth.php" method="post">
                <input type="text" class="form-control mb-2" name="txtUser" placeholder="Username" id="username">
                <input type="password" class="form-control mb-2" name="txtPass" placeholder="Password" id="password">

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </main>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://www.google.com/recaptcha/api.js?render=6Ld0KZ4pAAAAAFskRX_7jQEYL6At_0wALTzfrsI2"></script>

<script>

    grecaptcha.ready(function() {
        grecaptcha.execute('6Ld0KZ4pAAAAAFskRX_7jQEYL6At_0wALTzfrsI2', { action: 'login' } ).then(function (token) {

            $('#formLogin').submit(function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: './php/auth.php',
                        type: 'post',
                        data: {
                            txtUser: $('input[name="txtUser"]').val(),
                            txtPass: $('input[name="txtPass"]').val(),
                            token: token
                        },
                        success: function (response) {
                            if (response == 'true') {
                                window.location.href = './dashboard.php';
                            } else {
                                alert(response);
                            }
                        }
                    });
                });

        });
});

</script>


</html>