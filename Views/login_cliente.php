<div class="container mt-5">
    <h2 class="text-center mb-4">Login do Cliente</h2>

    <form action="/barberx/login_cliente" method="post" class="mx-auto" style="max-width: 500px;">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
            >
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input
                type="password"
                class="form-control"
                id="senha"
                name="senha"
                required
            >
        </div>

        <?php if (!empty($erro)): ?>
            <div class="my-4 text-danger fw-bold text-center">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary text-white">Entrar</button>
        </div>
    </form>
</div>
