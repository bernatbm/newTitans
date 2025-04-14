<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<header>
    <div class="titleLogo">
    <a href="/index.php">
        <img src="/assets/imagenes/newTitans.svg" class="service-img" alt="Logo Isla Transfers">
    </a>
        <a href="/index.php"><h1>Isla Transfers</h1></a>
    </div>
    <nav>
        <?php if (isset($_SESSION['userName'])): ?>

            
            
            <?php if ($_SESSION['isAdmin'] == 1): ?>
                
                <a href="../admin/panelAdministrador.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a>
            <?php elseif ($_SESSION['isAdmin'] == 2): ?>
                
                <a href="../corporativo/panelCorporativo.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a>
            <?php else: ?>
                
                <a href="../usuario/perfilUsuario.php"><?php echo "Hola, " . strtoupper($_SESSION['userName']); ?></a>
            <?php endif; ?>
            
            <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
                <p class="admin-label">[ Admin ]</p>
                <?php elseif (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 2): ?>
                <p class="admin-label">[ Corp ]</p>
            <?php endif; ?>

           


            <a href="../model/logout.php">CERRAR SESIÓN</a>
        <?php else: ?>
            
            <?php if (in_array(basename($_SERVER['PHP_SELF']), ['index.php','registro.php'])): ?>
                <a href="../model/login.php">LOGIN</a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>
<?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
    <header class="header-secundario">
        <nav>
            <a class= "addUser" href="/registro/registro.php">
                <img  src="../assets/imagenes/addNewUser.svg" alt="Añadir Usuario">
            </a>

            <a class="aerohotel" href="javascript:void(0);" onclick="redirigirFormulario('aeropuerto-hotel')">
                <img src="../assets/imagenes/AeroHotel.svg" alt="Trayectos">
            </a>

        </nav>
    </header>
<?php endif; ?>
<script src="../js/adminsections.js"></script>
