<div class="container mt-5 text-white">
    <h2 class="text-center mb-4 text-black">Fale Conosco</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form action="/barberx/enviar_contato" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="nome" class="form-label text-black" >Seu nome</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-black">Seu e-mail</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="mensagem" class="form-label text-black">Mensagem</label>
            <textarea class="form-control" name="mensagem" id="mensagem" rows="4" required></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>
