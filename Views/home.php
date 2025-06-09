<div class="container my-4">

    <h1 class="text-center mb-5"><?= $titulo ?? 'Bem-vindo à BarberX' ?></h1>

    <div class="row justify-content-center gap-4">
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Gerencie seus cursos</h5>
                        <p class="card-text">Cadastre, edite e visualize os cursos disponíveis.</p>
                    </div>
                    <a href="" class="btn btn-primary mt-3">Ver cursos</a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Relatórios e Gráficos</h5>
                        <p class="card-text">Visualize dados dos cursos em gráficos ou gere PDFs.</p>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="" class="btn btn-success w-100">Gráficos</a>
                        <a href="" class="btn btn-secondary w-100">PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>