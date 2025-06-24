<body>


    <main class="bg-light text-dark-emphasis">
        <section class="hero-section py-5 bg-primary-light">
            <div class="container text-center">
                <h2 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown text-dark-blue">Encontre sua barbearia ideal</h2>
                <p class="lead mb-5 animate__animated animate__fadeInUp text-dark-gray">Com BarberX, você explora as melhores barbearias da sua região e marca seu horário com apenas alguns cliques. Simples, rápido e no seu ritmo.</p>

                <div id="heroCarousel" class="carousel slide carousel-fade mb-5 shadow-lg rounded-3 animate__animated animate__zoomIn" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-3">
                        <div class="carousel-item active">
                            <img src="https://images.pexels.com/photos/18069698/pexels-photo-18069698/free-photo-of-homem-barbearia-cliente-atendimento.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100 img-fluid rounded-3" alt="Corte de cabelo moderno">
                            <div class="carousel-caption d-none d-md-block bg-dark-transparent-light rounded p-2">
                                <h5 class="text-white">Descubra Novas Barbearias</h5>
                                <p class="text-white-50">Explore um catálogo completo de estabelecimentos próximos a você.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.pexels.com/photos/10189427/pexels-photo-10189427.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100 img-fluid rounded-3" alt="Barba bem feita">
                            <div class="carousel-caption d-none d-md-block bg-dark-transparent-light rounded p-2">
                                <h5 class="text-white">Agende Facilmente</h5>
                                <p class="text-white-50">Escolha o serviço, barbeiro e horário ideais para você.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.pexels.com/photos/10189436/pexels-photo-10189436.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100 img-fluid rounded-3" alt="Ambiente da barbearia">
                            <div class="carousel-caption d-none d-md-block bg-dark-transparent-light rounded p-2">
                                <h5 class="text-white">Atendimento Premium Garantido</h5>
                                <p class="text-white-50">Encontre profissionais qualificados e ambientes confortáveis.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <a href='../views/barbearia.php' style='--animate-duration: 1.6s;' class='btn btn-primary btn-lg fw-bold px-5 py-3 animate__animated animate__pulse animate__infinite'>Agendar já!</a>
            </div>
        </section>

        <section id="unidades" class="unidades-section py-5 bg-light-section">
            <div class="container text-center">
                <h2 class="display-5 fw-bold mb-5 text-primary">Barbearias em Destaque</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                    <div class="col">
                        <div class="card h-100 bg-white shadow-lg border rounded-3 animate__animated animate__fadeInLeft"> <img src="https://images.pexels.com/photos/159223/barber-barbershop-shop-man-159223.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top rounded-top" alt="Barbearia Estilo & Fio">
                            <div class="card-body">
                                <h3 class="card-title text-dark-blue mb-3">Estilo & Fio Barbearia</h3>
                                <p class="card-text text-dark-gray"><i class="fas fa-map-marker-alt me-2"></i>Rua das Flores, 123 - Centro</p>
                                <p class="card-text text-dark-gray"><i class="far fa-clock me-2"></i>Seg-Sáb, 09:00 - 18:00</p>
                                <a href="../views/barbearia.php?id=1" class="btn btn-outline-primary mt-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Ver Serviços e Agendar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 bg-white shadow-lg border rounded-3 animate__animated animate__fadeInUp">
                            <img src="https://images.pexels.com/photos/159224/barber-barbershop-shop-man-159224.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top rounded-top" alt="Barbearia Navalha de Ouro">
                            <div class="card-body">
                                <h3 class="card-title text-dark-blue mb-3">Navalha de Ouro</h3>
                                <p class="card-text text-dark-gray"><i class="fas fa-map-marker-alt me-2"></i>Av. Brasil, 456 - Bairro Norte</p>
                                <p class="card-text text-dark-gray"><i class="far fa-clock me-2"></i>Seg-Sáb, 09:00 - 18:00</p>
                                <a href="../views/barbearia.php?id=2" target="_blank" class="btn btn-outline-primary mt-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Ver Serviços e Agendar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 bg-white shadow-lg border rounded-3 animate__animated animate__fadeInRight">
                            <img src="https://images.pexels.com/photos/10708687/pexels-photo-10708687.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top rounded-top" alt="Barbearia Urban Cut">
                            <div class="card-body">
                                <h3 class="card-title text-dark-blue mb-3">Urban Cut Barbearia</h3>
                                <p class="card-text text-dark-gray"><i class="fas fa-map-marker-alt me-2"></i>Shopping Sul, Loja 789</p>
                                <p class="card-text text-dark-gray"><i class="far fa-clock me-2"></i>Seg-Dom, 10:00 - 22:00</p>
                                <a href="../views/barbearia.php?id=3" target="_blank" class="btn btn-outline-primary mt-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Ver Serviços e Agendar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="../views/barbearia.php" class="btn btn-primary btn-lg fw-bold mt-5 px-5 py-3 animate__animated animate__bounceIn">Explore Todas as Barbearias</a>
            </div>
        </section>

        <section class="promo-section py-5 bg-primary-dark text-center">
            <div class="container d-flex flex-column flex-md-row align-items-center justify-content-around">
                <div class="promo-text-content mb-4 mb-md-0 me-md-5 animate__animated animate__fadeInLeft">
                    <h2 class="display-5 fw-bold text-white mb-3">Sua Barbearia no BarberX?</h2>
                    <p class="lead text-white-50 mb-4">Alcance milhares de novos clientes e otimize seus agendamentos. Cadastre-se hoje mesmo e faça parte da nossa rede de sucesso!</p>
                    <a href="../views/empresa.php" class="btn btn-light btn-lg fw-bold px-5 py-3 shadow-sm animate__animated animate__tada">Cadastre Sua Barbearia</a>
                </div>
                <div class="promo-image-content animate__animated animate__fadeInRight">
                    <a href="../views/empresa.php">
                        <img src="https://images.pexels.com/photos/3472719/pexels-photo-3472719.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Barbeiro trabalhando" class="img-fluid rounded-3 shadow-lg hover-scale">
                    </a>
                </div>
            </div>
        </section>

        <section id="avaliacoes" class="reviews-section py-5 bg-light-section">
            <div class="container text-center">
                <h2 class="display-5 fw-bold mb-5 text-primary">O que Nossos Usuários Dizem</h2>
                <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center">
                                <div class="card bg-white shadow-lg border rounded-3 p-4 mx-2 review-card animate__animated animate__flipInY">
                                    <h3 class="card-title text-dark-blue mb-2">Róger Alves</h3>
                                    <p class="card-subtitle text-muted mb-2">14/07/2024</p>
                                    <p class="card-text fs-5 text-dark-gray">"O site é sensacional! Agendo rapidinho com meu barbeiro preferido e nunca mais pego fila. Nota 10!"</p>
                                    <div class="text-info fs-4">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center">
                                <div class="card bg-white shadow-lg border rounded-3 p-4 mx-2 review-card animate__animated animate__flipInY">
                                    <h3 class="card-title text-dark-blue mb-2">Rafael Laurino Neto</h3>
                                    <p class="card-subtitle text-muted mb-2">16/07/2024</p>
                                    <p class="card-text fs-5 text-dark-gray">"Facilidade incrível! Encontrei uma barbearia nova e de qualidade perto de casa. O agendamento é super intuitivo."</p>
                                    <div class="text-info fs-4">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center">
                                <div class="card bg-white shadow-lg border rounded-3 p-4 mx-2 review-card animate__animated animate__flipInY">
                                    <h3 class="card-title text-dark-blue mb-2">Evandro Gonçalves</h3>
                                    <p class="card-subtitle text-muted mb-2">08/09/2024</p>
                                    <p class="card-text fs-5 text-dark-gray">"Chega de esperar! Com o Barbearia Connect, consigo agendar no horário que preciso e sou atendido na hora. Recomendo!"</p>
                                    <div class="text-info fs-4">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <script src="../js/script.js"></script>

</body>