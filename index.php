<?php
include 'funcoes.php';
include 'header.php';

$treinamentos = getTreinamentos();
// Pega os 3 mais recentes cadastrados
$ultimos_treinamentos = array_slice($treinamentos, 0, 3);

// Função para exibir a data bonitinha
function formatarDataPreview($dataStr) {
    if (empty($dataStr)) return '--/--/----';
    return date('d/m/Y', strtotime($dataStr));
}
?>

<div class="row text-center mb-5 mt-4">
    <div class="col-md-12">
        <h1 class="display-5 fw-bold text-success mb-3">Plataforma de Treinamentos ESG</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Acompanhe a capacitação da sua equipe em práticas de sustentabilidade, responsabilidade social e governança.
        </p>
        <a href="painel.php" class="btn btn-success btn-lg px-5 py-2 mt-3 rounded-pill fw-semibold shadow-sm">
            Acessar Painel de Gestão
        </a>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 text-center">
        <h4 class="fw-bold text-dark border-bottom pb-3 d-inline-block px-4">Prévia: Últimos Cadastrados</h4>
    </div>
</div>

<div class="row justify-content-center">
    <?php foreach ($ultimos_treinamentos as $curso): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-4 p-3">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                            <?= $curso['categoria'] ?>
                        </span>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2"><?= $curso['titulo'] ?></h5>
                    <p class="card-text text-secondary flex-grow-1 small mb-4"><?= $curso['descricao'] ?></p>
                    
                    <div class="mt-auto border-top pt-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-semibold">⏱ <?= $curso['carga_horaria'] ?></span>
                        <span class="text-muted small">📅 <?= formatarDataPreview($curso['data_realizacao'] ?? '') ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include 'footer.php';
?>
