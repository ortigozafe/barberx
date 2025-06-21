<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'BarberX' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/barberx/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/barberx/assets/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle fs-4"></i>
                        <span class="text-white">Olá, <?= htmlspecialchars($_SESSION['dono_nome']) ?></span>
                    </div>

                <?php else: ?>
                    <!-- Header do cliente -->
                    <a class="navbar-brand d-flex align-items-center" href="/barberx">
                        <img src="/barberx/assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                        <strong class="text-white">BarberX</strong>
                    </a>

                    <div class="d-flex gap-4">
                        <a class="nav-link text-white" href="/barberx">Home</a>
                        <a class="nav-link text-white" href="/barberx/barbearias">Barbearias</a>
                        <a class="nav-link text-white" href="/barberx/agenda">Agenda</a>
                        <a class="nav-link text-white" href="/barberx/contato">Contato</a>
                        <a class="nav-link text-white" href="/barberx/empresas">Empresas</a>
                    </div>

                    <div class="d-flex align-items-center">
                        <?php if (isset($_SESSION['cliente_id'])): ?>
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <span class="text-white">Olá, <?= htmlspecialchars($_SESSION['cliente_nome']) ?></span>
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