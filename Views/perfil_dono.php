<div class="container py-5 d-flex rounded justify-content-center">
    <div class="card shadow-lg animate__animated animate__fadeInUp" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Meu Perfil</h2>
        </div>
        <div class="card-body rounded bg-white p-4">
            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger animate__animated animate__shakeX">
                    <?= $erro ?>
                </div>
            <?php endif; ?>

            <?php if ($retornoDono): ?>
                <form method="post" action="/barberx/perfil_dono" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold text-dark-blue">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="<?= $retornoDono->nome ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-dark-blue">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= $retornoDono->email ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label fw-bold text-dark-blue">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone"
                            value="<?= $retornoDono->telefone ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label fw-bold text-dark-blue">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha"
                            placeholder="Deixe em branco para manter a senha atual">
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/barberx" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-save me-1"></i> Salvar
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning animate__animated animate__fadeIn">
                    Nenhum dado de dono encontrado.
                </div>
            <?php endif; ?>
            <?php if (!empty($erro)): ?>
                <div class="my-4 text-center alert alert-danger animate__animated animate__shakeX">
                    <?= $erro ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>