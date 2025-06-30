<div class="container py-5">
    <h2 class="display-5 fw-bold mb-5 text-primary animate__animated animate__fadeInDown">Minha Agenda</h2>

    <!-- filtros -->
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-md-4 mb-2">
            <select id="filtro-status" class="form-select shadow rounded">
                <option value="">Todos os Status</option>
                <option value="agendado">Agendado</option>
                <option value="concluido">Concluído</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <input type="date" id="filtro-data" class="form-control shadow rounded">
        </div>
        <div class="col-md-4 mb-2">
            <button class="btn btn-primary w-100 shadow rounded" id="limpar-filtros">
                Limpar Filtros
            </button>
        </div>
    </div>

    <?php if (!empty($todos)) : ?>
        <div class="table-responsive animate__animated animate__fadeInUp shadow rounded-3 bg-white border">
            <table id="agenda-table" class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Barbearia</th>
                        <th scope="col">Serviço</th>
                        <th scope="col">Profissional</th>
                        <th scope="col">Data/Hora</th>
                        <th scope="col">Status</th>
                        <th scope="col">Observações</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos as $a) : ?>
                        <tr data-status="<?= strtolower($a->status) ?>" data-data="<?= date('Y-m-d', strtotime($a->data_hora)) ?>">
                            <td>
                                <?php
                                $imageUrl = !empty($a->barbearia_imagem) ? 'assets/img/' . htmlspecialchars($a->barbearia_imagem) : 'assets/img/noimage.png';
                                ?>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= $imageUrl ?>" alt="Barbearia" class="rounded shadow-sm" style="width:50px; height:50px; object-fit:cover;">
                                    <span class="fw-bold text-dark-blue"><?= htmlspecialchars($a->barbearia_nome) ?></span>
                                </div>
                            </td>
                            <td class="text-dark-gray"><?= htmlspecialchars($a->servico_nome) ?></td>
                            <td class="text-dark-gray"><?= htmlspecialchars($a->profissional_nome) ?></td>
                            <td class="text-dark-gray"><?= date('d/m/Y H:i', strtotime($a->data_hora)) ?></td>
                            <td>
                                <?php
                                $status = strtolower(trim($a->status));
                                $badgeClass = match ($status) {
                                    'agendado'  => 'bg-success',
                                    'concluido' => 'bg-primary',
                                    'cancelado' => 'bg-danger',
                                    default     => 'bg-secondary',
                                };
                                echo '<span class="badge ' . $badgeClass . ' text-white py-2 px-3 rounded-pill shadow-sm">' . ucfirst($status) . '</span>';
                                ?>
                            </td>
                            <td class="text-dark-gray"><?= htmlspecialchars($a->observacoes) ?></td>
                            <td class="text-center">
                                <?php if (strtolower($a->status) === 'agendado'): ?>
                                    <a href="/barberx/cancelar_agendamento?id=<?= $a->agendamento_id ?>" class="btn btn-sm btn-danger" title="Cancelar" onclick="return confirm('Tem certeza que deseja cancelar este agendamento?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="alert alert-info mt-5 animate__animated animate__fadeIn">
            Você ainda não possui agendamentos cadastrados. Que tal <a href="/barberx/barbearias" class="fw-bold text-primary">agendar agora</a>?
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filtroStatus = document.getElementById("filtro-status");
        const filtroData = document.getElementById("filtro-data");
        const limparFiltros = document.getElementById("limpar-filtros");

        filtroStatus.addEventListener("change", filtrarTabela);
        filtroData.addEventListener("change", filtrarTabela);
        limparFiltros.addEventListener("click", function() {
            filtroStatus.value = "";
            filtroData.value = "";
            filtrarTabela();
        });

        function filtrarTabela() {
            const status = filtroStatus.value.trim().toLowerCase();
            const data = filtroData.value;

            document.querySelectorAll("#agenda-table tbody tr").forEach(function(row) {
                const rowStatus = (row.dataset.status || '').trim().toLowerCase();
                const rowData = row.dataset.data;

                let exibir = true;

                if (status && rowStatus !== status) {
                    exibir = false;
                }
                if (data) {
                    const dataFiltro = new Date(data).toISOString().slice(0, 10);
                    if (rowData !== dataFiltro) {
                        exibir = false;
                    }
                }

                row.style.display = exibir ? "" : "none";
            });
        }
    });
</script>