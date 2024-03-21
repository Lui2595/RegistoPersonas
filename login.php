<?php
session_start();
if (isset($_POST["login"] )) {
   
    if($_POST["login"] == "Amal@2024") {
        $_SESSION["user"] = "User";
        header("Location:index.php");
       }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
    <nav class="navbar navbar-light bg-black w-100 mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-light">Registro de entregas</span>
        </div>
    </nav>
    <div class="container">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Contraseña</label>
                    <input
                        type="password"
                        class="form-control"
                        name="login"
                        id=""
                        placeholder="Contraseña"
                    />
                </div>
                <input
                    name=""
                    id=""
                    class="btn btn-primary"
                    type="Submit"
                    value="Entrar"
                />
                
            </form>
    </div>
</body>

</html>