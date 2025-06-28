<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de Barbearia</h2>

    <form action="/barberx/cadastrar_barbearia" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Barbearia</label>
            <input
                type="text"
                class="form-control"
                id="nome"
                name="nome"
                required
                value="<?= $_POST['nome'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="cnpj" class="form-label">CNPJ</label>
            <input
                type="text"
                class="form-control"
                id="cnpj"
                name="cnpj"
                value="<?= $_POST['cnpj'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input
                type="text"
                class="form-control"
                id="telefone"
                name="telefone"
                value="<?= $_POST['telefone'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="<?= $_POST['email'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input
                type="text"
                class="form-control"
                id="endereco"
                name="endereco"
                value="<?= $_POST['endereco'] ?? '' ?>">
        </div>

        <input type="hidden" name="dono_id" value="<?= $_SESSION['dono_id'] ?>">

        <?php if (!empty($erro)): ?>
            <div class="alert text-danger text-center fw-bold alert-danger animate__animated animate__shakeX">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary text-white">Cadastrar Barbearia</button>
        </div>
    </form>
</div>