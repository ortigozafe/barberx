<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'BarberX' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/barberx/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/barberx/assets/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg p-3 navbar-primary bg-primary text-white">
            <div class="container d-flex align-items-center justify-content-between">

                <?php if (isset($_SESSION['dono_id'])): ?>
                    <!-- Header do dono -->
                    <a class="navbar-brand d-flex align-items-center" href="/barberx/dashboard">
                        <img src="/barberx/assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                        <strong class="text-white">BarberX Dono</strong>
                    </a>

                    <div class="d-flex gap-4">
                        <a class="nav-link text-white" href="/barberx/dashboard">Dashboard</a>
                        <a class="nav-link text-white" href="/barberx/agenda_dono">Agendamentos</a>
                        <a class="nav-link text-white" href="/barberx/barbearias_dono">Minhas Barbearias</a>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-transparent text-white dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuDono" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Olá, <?= htmlspecialchars($_SESSION['dono_nome']) ?></span>
                            <i class="bi bi-person-circle fs-4 ms-2 me-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDono">
                            <li><a class="dropdown-item" href="/barberx/perfil_dono">Perfil</a></li>
                            <li><a class="dropdown-item" href="/barberx/logout">Sair</a></li>
                        </ul>
                    </div>

                <?php else: ?>
                    <!-- Header do cliente -->
                    <a class="navbar-brand d-flex align-items-center" href="/barberx">
                        <img src="/barberx/assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                        <strong class="text-white">BarberX</strong>
                    </a>

                    <div class="d-flex gap-4">
                        <a class="nav-link text-white" href="/barberx/barbearias">Barbearias</a>
                        <a class="nav-link text-white" href="/barberx/agenda">Agenda</a>
                        <a class="nav-link text-white" href="/barberx/contato">Contato</a>
                        <a class="nav-link text-white" href="/barberx/empresas">Empresas</a>
                    </div>

                    <div class="d-flex align-items-center">
                        <?php if (isset($_SESSION['cliente_id'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-transparent text-white dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuCliente" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Olá, <?= htmlspecialchars($_SESSION['cliente_nome']) ?></span>
                                    <i class="bi bi-person-circle fs-4 ms-2 me-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuCliente">
                                    <li><a class="dropdown-item" href="/barberx/perfil_cliente">Perfil</a></li>
                                    <li><a class="dropdown-item" href="/barberx/logout">Sair</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="/barberx/logar_cliente" class="btn btn-outline-light me-2">Login</a>
                            <a href="/barberx/cadastrar_cliente" class="btn btn-light">Cadastrar-se</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </nav>
    </header>

    <main>