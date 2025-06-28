<div class="container mt-5">
    <h2 class="text-center mb-4">Login do Cliente</h2>

    <form action="/barberx/logar_cliente" method="post" class="mx-auto" style="max-width: 500px;">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>

        <div class="mb-4">
            <label for="senha" class="form-label">Senha</label>
            <input
                type="password"
                class="form-control"
                id="senha"
                name="senha"
                required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary text-white">Entrar</button>
        </div>
        
        <?php if (!empty($erro)): ?>
            <div class="alert text-danger text-center fw-bold alert-danger animate__animated animate__shakeX">
                <?= $erro ?>
            </div>
        <?php endif; ?>

    </form>
</div>