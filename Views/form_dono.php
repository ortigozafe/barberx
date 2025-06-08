<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de dono</h2>

    <form action="/barberx/salvar_dono" method="post" class="mx-auto" style="max-width: 500px;">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="my-4 text-danger fw-bold text-center">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <div class="d-grid">
            <button type="submit" class="btn btn-success text-white">Cadastrar</button>
        </div>
    </form>
</div>