<?php

    require_once 'controller/UsuarioController.php';
    $usuario = new UsuarioController();
    $usuario->registro();

    session_start();
    # $_SESSION['dato'] = 'valor';
    # $_SESSION['rol'] = 'admin';
    # session_destroy();

    # $_GET['variable'];
    # $_POST['variable'];

    #CSRF    
    
    if(empty($_SESSION['key'])) {
        $_SESSION['key'] = bin2hex( random_bytes(32) );        
    }

    //echo $_SESSION['key'];

    # creando CSRF token
    $scrf = hash_hmac('sha256', 'registro.php', $_SESSION['key']);

    if(isset($_POST['registrar'])) {
        if(hash_equals($scrf, $_POST['csrf'])){
            $datos = array(
                'nombre' => $_POST['nombre'],
                'apodo' => $_POST['apodo'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password'])
            );

            $usuario->guardarUsuario($datos);
        } else {
            header("Location: error.php");
            die();
        }    
    }

?>
<body>
    <div class="container-fluid register-login">
        <div class="row wrapper">
            <div class="col-lg padding-none bg-image-container">
                <div class="container__image">
                    <div class="image--points"></div>
                </div>
            </div>
            <div class="col-lg form-center d-flex justify-content-center align-items-center">
                <div class="container-form">
                    <h1 class="register-login-h1">Registro</h1>
                    <p class="register-login-p">Por favor ingrese sus datos para crear su cuenta</p>

                    <?php

                        if(isset($_SESSION['mensaje'])) {
                            echo "<div class='alert alert-primary' role='alert'>".$_SESSION['mensaje']."</div>";
                        }
                    ?>

                    <form action="#" method="POST" name="registroForm" id="registroForm">

                        <input type="hidden" name="csrf" id="csrf" value="<?php echo $scrf;?>">

                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                    <label for="nombre" class="form-label">Nombre</label>
                                </div>
                            </div>

                            <div class="col-lg">
                                <div class="form-group">
                                    <input type="text" id="apodo" name="apodo" class="form-control" required>
                                    <label for="apodo" class="form-label">Apodo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" required>
                                <label for="email" class="form-label">E-mail</label>
                            </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <label for="password" class="form-label">Contraseña</label>
                        </div>
                        <div class="form-group margin--bottom">
                                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
                                <label for="confirmpassword" class="form-label">Confirmar contraseña</label>
                            </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <input class="form-check-input checked--form--input" type="checkbox" id="acepto" value="">
                                <label class="form-check-label order-2" for="acepto">Acepto los términos y condiciones</label>
                                <label class="label--ckecked order-1" for="acepto"></label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-lg-center">
                            <button type="submit" id="registrar" name="registrar" class="btn btn-signup--register align-self-center">Aceptar</button>
                        </div>
                        <a href="#" class="register-link--haveaccount">¿Ya tiene una contraseña? Entrar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
