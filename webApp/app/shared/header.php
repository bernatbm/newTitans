<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<header>
    <div class="titleLogo">
        <img src="/webApp/app/assets/imagenes/newTitans.svg" class="service-img">
        <a href="/webApp/index.php"><h1>Isla Transfers</h1></a>
    </div>

    <nav>
        <?php if (isset($_SESSION['userName'])): ?>
            <?php
                $perfilLink = '/webApp/app/model/perfilUsuario.php'; // Por defecto

                if (isset($_SESSION['isAdmin'])) {
                    if ($_SESSION['isAdmin'] == 1) {
                        $perfilLink = '/webApp/app/admin/panelAdministrador.php';
                    } elseif ($_SESSION['isAdmin'] == 2) {
                        $perfilLink = '/webApp/app/corporativo/panelCorporativo.php';
                    }
                }
            ?>

            <span>
                <a href="<?php echo $perfilLink; ?>">
                    <?php echo "Hola, " . strtoupper($_SESSION['userName']); ?>
                </a>
            </span>

            <?php if ($_SESSION['isAdmin'] == 1): ?>
                <p class="admin-label">[ Admin ]</p>
            <?php elseif ($_SESSION['isAdmin'] == 2): ?>
                <p class="admin-label">[ Corp ]</p>
            <?php endif; ?>

            <a href="/webApp/app/model/logout.php">CERRAR SESIÓN</a>

        <?php else: ?>
            <a href="/webApp/app/registro/registro.php">REGISTRO</a>
            <a href="/webApp/app/model/login.php">LOGIN</a>
        <?php endif; ?>
    </nav>
</header>