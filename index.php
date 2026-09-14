<?php
include 'funcoes.php';
include 'header.php';

$treinamentos = getTreinamentos();
?>

<div class="row text-center mb-5">
    <div class="col-md-12">
        <h1 class="display-5 fw-bold text-success mb-3">Plataforma de Treinamentos ESG</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Capacite sua equipe com cursos focados em sustentabilidade, responsabilidade social e governanca corporativa.
        </p>
    </div>
</div>

<div class="row justify-content-center">
    <?php foreach ($treinamentos as $curso): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-4 p-2">
                <div class="card-body d-flex flex-column text-center">
                    <div class="mb-3">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                            <?= $curso['categoria'] ?>
                        </span>
                    </div>
                    <h4 class="card-title fw-bold text-dark mb-3"><?= $curso['titulo'] ?></h4>
                    <p class="card-text text-secondary flex-grow-1 small mb-4"><?= $curso['descricao'] ?></p>
                    <div class="mt-auto">
                        <p class="text-muted small mb-3">Carga horaria: <strong><?= $curso['carga_horaria'] ?></strong></p>
                        <button class="btn btn-success w-100 rounded-pill py-2 fw-semibold shadow-sm" onclick="alert('Inscricao realizada com sucesso!')">Inscrever-se</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include 'footer.php';
?>