<div class="container mt-5 mb-5">
  <div class="card shadow-lg rounded-4 p-4 animate__animated animate__fadeIn">
    <h2 class="text-center mb-4">Cadastro de Barbearia</h2>
    <form
      action="/barberx/cadastrar_barbearia"
      method="post"
      class="row g-4"
    >
      <div class="col-md-6">
        <label for="nome" class="form-label fw-bold">Nome da Barbearia</label>
        <input
          type="text"
          class="form-control shadow-sm"
          id="nome"
          name="nome"
          required
          value="<?= $_POST['nome'] ?? '' ?>"
        />
      </div>

      <div class="col-md-6">
        <label for="cnpj" class="form-label fw-bold">CNPJ</label>
        <input
          type="text"
          class="form-control shadow-sm"
          id="cnpj"
          name="cnpj"
          value="<?= $_POST['cnpj'] ?? '' ?>"
        />
      </div>

      <div class="col-md-6">
        <label for="telefone" class="form-label fw-bold">Telefone</label>
        <input
          type="text"
          class="form-control shadow-sm"
          id="telefone"
          name="telefone"
          value="<?= $_POST['telefone'] ?? '' ?>"
        />
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label fw-bold">Email</label>
        <input
          type="email"
          class="form-control shadow-sm"
          id="email"
          name="email"
          value="<?= $_POST['email'] ?? '' ?>"
        />
      </div>

      <div class="col-12">
        <label for="endereco" class="form-label fw-bold">Endereço</label>
        <input
          type="text"
          class="form-control shadow-sm"
          id="endereco"
          name="endereco"
          value="<?= $_POST['endereco'] ?? '' ?>"
        />
      </div>

      <input type="hidden" name="dono_id" value="<?= $_SESSION['dono_id'] ?>" />

      <hr class="mt-4" />

      <h4 class="mt-3">Horários de Funcionamento</h4>
      <div class="row g-2">
        <?php
        $dias_semana = [
          'domingo',
          'segunda',
          'terca',
          'quarta',
          'quinta',
          'sexta',
          'sabado'
        ];
        foreach ($dias_semana as $dia): ?>
          <div class="col-12 col-md-6 mb-2 d-flex align-items-center">
            <div class="form-check me-2">
              <input
                class="form-check-input"
                type="checkbox"
                name="dias_abertos[<?= $dia ?>][ativo]"
                id="dia_<?= $dia ?>"
                value="1"
                <?= isset($_POST['dias_abertos'][$dia]['ativo']) ? 'checked' : '' ?>
              />
              <label class="form-check-label fw-semibold" for="dia_<?= $dia ?>">
                <?= ucfirst($dia) ?>
              </label>
            </div>
            <input
              type="time"
              class="form-control ms-2"
              name="dias_abertos[<?= $dia ?>][abertura]"
              value="<?= $_POST['dias_abertos'][$dia]['abertura'] ?? '' ?>"
            />
            <input
              type="time"
              class="form-control ms-2"
              name="dias_abertos[<?= $dia ?>][fechamento]"
              value="<?= $_POST['dias_abertos'][$dia]['fechamento'] ?? '' ?>"
            />
          </div>
        <?php endforeach; ?>
      </div>

      <hr class="mt-4" />

      <h4>Profissionais</h4>
      <div id="profissionais" class="animate__animated animate__fadeInUp">
        <div class="row mb-2 g-2 align-items-end profissional-row">
          <div class="col-4">
            <input
              type="text"
              name="profissionais[0][nome]"
              class="form-control shadow-sm"
              placeholder="Nome"
            />
          </div>
          <div class="col-4">
            <input
              type="text"
              name="profissionais[0][telefone]"
              class="form-control shadow-sm"
              placeholder="Telefone"
            />
          </div>
          <div class="col-3">
            <input
              type="email"
              name="profissionais[0][email]"
              class="form-control shadow-sm"
              placeholder="Email"
            />
          </div>
          <div class="col-1">
            <button
              type="button"
              class="btn btn-danger btn-sm"
              onclick="removerCampo(this)"
            >
              &times;
            </button>
          </div>
        </div>
      </div>
      <button
        type="button"
        class="btn btn-outline-primary w-25 mx-auto mb-3"
        onclick="adicionarProfissional()"
      >
        + Adicionar Profissional
      </button>

      <h4>Serviços</h4>
      <div id="servicos" class="animate__animated animate__fadeInUp">
        <div class="row mb-2 g-2 align-items-end servico-row">
          <div class="col-3">
            <input
              type="text"
              name="servicos[0][nome]"
              class="form-control shadow-sm"
              placeholder="Serviço"
            />
          </div>
          <div class="col-3">
            <input
              type="text"
              name="servicos[0][descricao]"
              class="form-control shadow-sm"
              placeholder="Descrição"
            />
          </div>
          <div class="col-3">
            <input
              type="number"
              name="servicos[0][preco]"
              class="form-control shadow-sm"
              placeholder="Preço"
              step="0.01"
            />
          </div>
          <div class="col-2">
            <input
              type="number"
              name="servicos[0][duracao_minutos]"
              class="form-control shadow-sm"
              placeholder="Duração (min)"
            />
          </div>
          <div class="col-1">
            <button
              type="button"
              class="btn btn-danger btn-sm"
              onclick="removerCampo(this)"
            >
              &times;
            </button>
          </div>
        </div>
      </div>
      <button
        type="button"
        class="btn btn-outline-success w-25 mx-auto mb-3"
        onclick="adicionarServico()"
      >
        + Adicionar Serviço
      </button>

      <?php if (!empty($erro)): ?>
        <div
          class="alert alert-danger text-center fw-bold animate__animated animate__shakeX"
        >
          <?= $erro ?>
        </div>
      <?php endif; ?>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg shadow">
          Cadastrar Barbearia
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  let indiceProf = 1;
  function adicionarProfissional() {
    const container = document.getElementById("profissionais");
    container.insertAdjacentHTML(
      "beforeend",
      `
      <div class="row mb-2 g-2 align-items-end profissional-row animate__animated animate__fadeInUp">
          <div class="col-3">
              <input type="text" name="profissionais[${indiceProf}][nome]" class="form-control shadow-sm" placeholder="Nome">
          </div>
          <div class="col-3">
              <input type="text" name="profissionais[${indiceProf}][telefone]" class="form-control shadow-sm" placeholder="Telefone">
          </div>
          <div class="col-3">
              <input type="email" name="profissionais[${indiceProf}][email]" class="form-control shadow-sm" placeholder="Email">
          </div>
          <div class="col-1">
              <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
          </div>
      </div>
      `
    );
    indiceProf++;
  }

  let indiceServico = 1;
  function adicionarServico() {
    const container = document.getElementById("servicos");
    container.insertAdjacentHTML(
      "beforeend",
      `
      <div class="row mb-2 g-2 align-items-end servico-row animate__animated animate__fadeInUp">
          <div class="col-3">
              <input type="text" name="servicos[${indiceServico}][nome]" class="form-control shadow-sm" placeholder="Serviço">
          </div>
          <div class="col-3">
              <input type="text" name="servicos[${indiceServico}][descricao]" class="form-control shadow-sm" placeholder="Descrição">
          </div>
          <div class="col-3">
              <input type="number" name="servicos[${indiceServico}][preco]" class="form-control shadow-sm" placeholder="Preço" step="0.01">
          </div>
          <div class="col-2">
              <input type="number" name="servicos[${indiceServico}][duracao_minutos]" class="form-control shadow-sm" placeholder="Duração (min)">
          </div>
          <div class="col-1">
              <button type="button" class="btn btn-danger btn-sm" onclick="removerCampo(this)">&times;</button>
          </div>
      </div>
      `
    );
    indiceServico++;
  }

  function removerCampo(botao) {
    botao.closest(".row").classList.add("animate__fadeOut");
    setTimeout(() => {
      botao.closest(".row").remove();
    }, 300);
  }
</script>
