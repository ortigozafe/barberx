<div class="container py-5">
  <h2 class="text-center mb-4 fw-bold text-primary">Editar Barbearia</h2>

  <form method="post" class="bg-white p-4 rounded shadow-sm" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="nome" class="form-label fw-semibold">Nome da Barbearia</label>
      <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($barbearia->nome) ?>" required>
    </div>

    <div class="mb-3">
      <label for="cnpj" class="form-label fw-semibold">CNPJ</label>
      <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?= htmlspecialchars($barbearia->cnpj) ?>" required>
    </div>

    <div class="mb-3">
      <label for="telefone" class="form-label fw-semibold">Telefone</label>
      <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($barbearia->telefone) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label fw-semibold">E-mail</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($barbearia->email) ?>" required>
    </div>

    <div class="mb-3">
      <label for="endereco" class="form-label fw-semibold">Endereço</label>
      <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($barbearia->endereco) ?>" required>
    </div>

    <div class="mb-3">
      <label for="imagem" class="form-label fw-semibold">Imagem da Barbearia</label>
      <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
    </div>

    <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($barbearia->imagem ?? '') ?>">

    <div class="d-flex justify-content-between">
      <a href="/barberx/barbearias_dono" class="btn btn-outline-secondary px-4">Cancelar</a>
      <button type="submit" class="btn btn-primary px-4 fw-semibold">Salvar Alterações</button>
    </div>

  </form>
</div>