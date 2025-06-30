<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de cliente</h2>

    <form action="/barberx/cadastrar_cliente" method="post" class="mx-auto" style="max-width: 500px;">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome completo</label>
            <input
                type="text"
                class="form-control"
                id="nome"
                name="nome"
                required
                value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>">
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input
                type="text"
                class="form-control"
                id="telefone"
                name="telefone"
                maxlength="15"
                required
                value="<?= isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : '' ?>"
                oninput="formatarTelefone(this)" />
        </div>

        <script>
            function formatarTelefone(input) {
                let valor = input.value.replace(/\D/g, '');

                if (valor.length > 10) {
                    valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
                } else {
                    valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                }
                input.value = valor;
            }
        </script>

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
            <button type="submit" class="btn btn-primary text-white">Cadastrar</button>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert text-danger text-center fw-bold alert-danger animate__animated animate__shakeX">
                <?= $erro ?>
            </div>
        <?php endif; ?>

    </form>
</div>