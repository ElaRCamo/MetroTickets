<main>
    <div class="page-content">
        <div id="tittle">
            <div class="LAB">
                <img id="logoInicio" src="../../imgs/Grammer_Logo.ico" alt="Logo Grammer">
            </div>
            <div class="LAB">
                <h1 class="">LABORATORIO DE</h1>
            </div>
            <div class="text-box">
                <h1 class="">METROLOGÍA</h1>
            </div>
        </div>
        <div class="wrapper">
            <form id="formInicioSesion" action="../../dao/login.php" method="post" >
                <h2 id="iniciarSesion">Iniciar Sesión</h2>
                <div class="input-box">
                    <input type="text" name="numNomina" id="numNomina" placeholder="No. de nómina" required>
                    <i class="las la-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password"  id="password" placeholder="Contraseña" required>
                    <i class="las la-lock"></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Recuérdame</label>
                    <a href="recordarPassword.php">¿Has olvidado la contraseña?</a>
                </div>

                <button type="submit" class="btn login" name="iniciarSesionBtn">Iniciar Sesión</button>

                <div class="register-link">
                    <p>¿No tienes cuenta? <a href="register.php">REGÍSTRATE</a> </p>
                </div>
            </form>
        </div>
    </div>
</main>
