<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ak-Menengah | Login</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/signin.css?v=2.2">

</head>

<body >
    <div class="container">
        <main class="form-signin w-100 m-auto shadow-lg p-3 mb-5 bg-body rounded">
            <form action="cekLogin.php" method="POST">
                <h1 class="h3 mb-3 fw-normal text-center">Log in</h1>
                <?php
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == 'gagal') {
                            echo "<div class='alert text-center text-danger' > Username atau Password salah !!!</div>";
                        } 
                    }
                ?>
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="w-100 btn mb-2 btn-lg btn-primary" type="submit">Log in</button>
                <br>
                <small class=""><a href="../../">Kembali</a></small>
                <br>

            </form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>