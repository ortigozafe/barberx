<?php
// Inicia sessão se ainda não estiver iniciada
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Verifica se o dono está logado
if (!isset($_SESSION["dono"])) {
    header("Location: /barberx/logar_dono");
    exit;
}

$id_dono = $_SESSION["dono"]["id"];
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de Barbearia</h2>

    <form action="/barberx/salvar_barbearia" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Barbearia</label>
            <input
                type="text"
                class="form-control"
                id="nome"
                name="nome"
                required
                value="<?= $_POST['nome'] ?? '' ?>"
            >
        </div>

        <div class="mb-3">
            <label for="cnpj" class="form-label">CNPJ</label>
            <input
                type="text"
                class="form-control"
                id="cnpj"
                name="cnpj"
                value="<?= $_POST['cnpj'] ?? '' ?>"
            >
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input
                type="text"
                class="form-control"
                id="telefone"
                name="telefone"
                value="<?= $_POST['telefone'] ?? '' ?>"
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="<?= $_POST['email'] ?? '' ?>"
            >
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input
                type="text"
                class="form-control"
                id="endereco"
                name="endereco"
                value="<?= $_POST['endereco'] ?? '' ?>"
            >
        </div>

        <!-- Campo oculto com ID do dono -->
        <input type="hidden" name="dono_id" value="<?= $id_dono ?>">

        <?php if (!empty($erro)): ?>
            <div class="my-4 text-danger fw-bold text-center">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary text-white">Cadastrar Barbearia</button>
        </div>
    </form>
</div>
