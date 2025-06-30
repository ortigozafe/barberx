<?php require_once 'Views/layout/header.php'; ?>

<?php
$profissionais = $barbearia->profissionais ?? [];
$servicos = $barbearia->servicos ?? [];
$horarios = $barbearia->horarios ?? [];
?>

<div class="container mt-5 mb-5">
  <div class="card shadow-lg rounded-4 p-4 animate__animated animate__fadeIn">
    <h2 class="text-center mb-4">Editar Barbearia</h2>
    <form action="/barberx/atualizar_barbearia" method="post" class="row g-4">
      <input type="hidden" name="id" value="<?= $barbearia->id ?>" />

      <div class="col-md-6">
        <label for="nome" class="form-label fw-bold">Nome da Barbearia</label>
        <input type="text" class="form-control shadow-sm" id="nome" name="nome" value="<?= htmlspecialchars($barbearia->nome) ?>" />
      </div>

      <div class="col-md-6">
        <label for="cnpj" class="form-label fw-bold">CNPJ</label>
        <input type="text" class="form-control shadow-sm" id="cnpj" name="cnpj" value="<?= htmlspecialchars($barbearia->cnpj) ?>" />
      </div>

      <div class="col-md-6">
        <label for="telefone" class="form-label fw-bold">Telefone</label>
        <input type="text" class="form-control shadow-sm" id="telefone" name="telefone" value="<?= htmlspecialchars($barbearia->telefone) ?>" />
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control shadow-sm" id="email" name="email" value="<?= htmlspecialchars($barbearia->email) ?>" />
      </div>

      <div class="col-12">
        <label for="endereco" class="form-label fw-bold">Endereço</label>
        <input type="text" class="form-control shadow-sm" id="endereco" name="endereco" value="<?= htmlspecialchars($barbearia->endereco) ?>" />
      </div>

      <hr class="mt-4" />

      <h4>Horários de Funcionamento</h4>
      <div class="row g-2">
        <?php
        $dias = ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
        foreach ($dias as $dia):
          $horario = $horarios[$dia] ?? ['ativo' => false, 'abertura' => '', 'fechamento' => ''];
        ?>
          <div class="col-12 col-md-6 mb-2 d-flex align-items-center">
            <div class="form-check me-2">
              <input class="form-check-input" type="checkbox" name="dias_abertos[<?= $dia ?>][ativo]" value="1" <?= $horario['ativo'] ? 'checked' : '' ?> />
              <label class="form-check-label fw-semibold"><?= ucfirst($dia) ?></label>
            </div>
            <input type="time" class="form-control ms-2" name="dias_abertos[<?= $dia ?>][abertura]" value="<?= $horario['abertura'] ?>" />
            <input type="time" class="form-control ms-2" name="dias_abertos[<?= $dia ?>][fechamento]" value="<?= $horario['fechamento'] ?>" />
          </div>
        <?php endforeach; ?>
      </div>

      <hr class="mt-4" />

      <h4>Profissionais</h4>
      <div id="profissionais">

        <input type="hidden" name="profissionais[vazio][id]" value="">

        <?php foreach ($profissionais as $i => $prof): ?>
        <div class="row mb-2 g-2 align-items-end profissional-row">
          <input type="hidden" name="profissionais[<?= $i ?>][id]" value="<?= $prof->id ?? '' ?>">
          <div class="col-3">
            <input type="text" name="profissionais[<?= $i ?>][nome]" class="form-control" value="<?= htmlspecialchars($prof->nome) ?>" placeholder="Nome">
          </div>
          <div class="col-3">
            <input type="text" name="profissionais[<?= $i ?>][telefone]" class="form-control" value="<?= htmlspecialchars($prof->telefone) ?>" placeholder="Telefone">
          </div>
          <div class="col-3">
            <input type="email" name="profissionais[<?= $i ?>][email]" class="form-control" value="<?= htmlspecialchars($prof->email) ?>" placeholder="Email">
          </div>
          <div class="col-2">
            <input type="text" name="profissionais[<?= $i ?>][especialidade]" class="form-control" value="<?= htmlspecialchars($prof->especialidade ?? '') ?>" placeholder="Especialidade">
          </div>
          <div class="col-1">
            <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <button type="button" class="btn btn-outline-primary w-25 mx-auto mb-3" onclick="adicionarProfissional()">+ Adicionar Profissional</button>

<<<<<<< HEAD
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
=======
      <h4>Serviços</h4>
      <div id="servicos">
        <input type="hidden" name="servicos[vazio][id]" value="">

        <?php foreach ($servicos as $i => $serv): ?>
        <div class="row mb-2 g-2 align-items-end servico-row">
            <input type="hidden" name="servicos[<?= $i ?>][id]" value="<?= $serv->id ?? '' ?>">
            <div class="col-3">
                <input type="text" name="servicos[<?= $i ?>][nome]" class="form-control" value="<?= htmlspecialchars($serv->nome) ?>" placeholder="Serviço">
            </div>
            <div class="col-3">
                <input type="text" name="servicos[<?= $i ?>][descricao]" class="form-control" value="<?= htmlspecialchars($serv->descricao) ?>" placeholder="Descrição">
            </div>
            <div class="col-3">
                <input type="number" name="servicos[<?= $i ?>][preco]" class="form-control" value="<?= htmlspecialchars($serv->preco) ?>" step="0.01" placeholder="Preço">
            </div>
            <div class="col-2">
                <input type="number" name="servicos[<?= $i ?>][duracao_minutos]" class="form-control" value="<?= htmlspecialchars($serv->duracao_minutos) ?>" placeholder="Duração">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
            </div>
>>>>>>> 773ea7cf4af3f5970a3dcd4b0bab6745ad44da39
        </div>
        <?php endforeach; ?>
      </div>
      <button type="button" class="btn btn-outline-success w-25 mx-auto mb-3" onclick="adicionarServico()">+ Adicionar Serviço</button>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-success btn-lg shadow">
          Salvar Alterações
        </button>
      </div>
    </form>
  </div>
</div>

<script>
let indiceProf = <?= count($profissionais) ?>;
let indiceServico = <?= count($servicos) ?>;

function adicionarProfissional() {
  const container = document.getElementById("profissionais");
  container.insertAdjacentHTML("beforeend", `
    <div class="row mb-2 g-2 align-items-end profissional-row">
      <div class="col-3">
        <input type="text" name="profissionais[${indiceProf}][nome]" class="form-control" placeholder="Nome">
      </div>
      <div class="col-3">
        <input type="text" name="profissionais[${indiceProf}][telefone]" class="form-control" placeholder="Telefone">
      </div>
      <div class="col-3">
        <input type="email" name="profissionais[${indiceProf}][email]" class="form-control" placeholder="Email">
      </div>
      <div class="col-2">
        <input type="text" name="profissionais[${indiceProf}][especialidade]" class="form-control" placeholder="Especialidade">
      </div>
      <div class="col-1">
        <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
      </div>
    </div>
  `);
  indiceProf++;
}

function adicionarServico() {
  const container = document.getElementById("servicos");
  container.insertAdjacentHTML("beforeend", `
    <div class="row mb-2 g-2 align-items-end servico-row">
      <div class="col-3">
        <input type="text" name="servicos[${indiceServico}][nome]" class="form-control" placeholder="Serviço">
      </div>
      <div class="col-3">
        <input type="text" name="servicos[${indiceServico}][descricao]" class="form-control" placeholder="Descrição">
      </div>
      <div class="col-3">
        <input type="number" name="servicos[${indiceServico}][preco]" class="form-control" placeholder="Preço" step="0.01">
      </div>
      <div class="col-2">
        <input type="number" name="servicos[${indiceServico}][duracao_minutos]" class="form-control" placeholder="Duração">
      </div>
      <div class="col-1">
        <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
      </div>
    </div>
  `);
  indiceServico++;
}

function removerCampo(botao) {
  botao.closest(".row").remove();
}
</script>

<?php require_once 'Views/layout/footer.php'; ?>