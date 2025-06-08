<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'BarberX' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="assets\styles\style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg p-3 navbar-primary bg-primary text-white">
            <div class="container d-flex  align-items-center">

                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="assets\img\logo.png" alt="Logo" width="40" height="40" class="me-2">
                    <strong>BarberX</strong>
                </a>

                <div class="d-flex gap-4">
                    <a class="nav-link" href="/listar">Barbearias</a>
                    <a class="nav-link" href="/grafico">Gráfico</a>
                    <a class="nav-link" href="/gerar_pdf">PDF</a>
                    <a class="nav-link" href="/alunos_mapa">Mapa</a>
                </div>

                <div class="d-flex align-items-center">
                    <?php if (!empty($usuario)): ?>
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <span>Olá, <?= htmlspecialchars($usuario['nome']) ?></span>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-light me-2">Login</a>
                        <a href="/cadastro" class="btn btn-light">Cadastrar-se</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main>