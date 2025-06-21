<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Painel do Dono - BarberX' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/barberx/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/barberx/assets/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg p-3 navbar-primary bg-primary text-white">
            <div class="container d-flex align-items-center justify-content-between">

                <a class="navbar-brand d-flex align-items-center" href="/barberx/dashboard">
                    <img src="/barberx/assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                    <strong class="text-white">BarberX Dono</strong>
                </a>

                <div class="d-flex gap-4">
                    <a class="nav-link text-white" href="/barberx/dashboard">Dashboard</a>
                    <a class="nav-link text-white" href="/barberx/agenda">Agendamentos</a>
                    <a class="nav-link text-white" href="/barberx/barbearias">Minhas Barbearias</a>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-4"></i>
                    <span class="text-white">Olá, <?= $_SESSION['dono_nome'] ?? 'Dono' ?></span>
                </div>
            </div>
        </nav>
    </header>

    <main>
