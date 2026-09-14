<?php
include 'funcoes.php';
include 'header.php';

$treinamentos = getTreinamentos();
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">Painel de Gestao de Treinamentos</h2>
        <p class="text-muted">Acompanhe e gerencie todos os treinamentos operacionais cadastrados.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="cadastrar.php" class="btn btn-success fw-semibold shadow-sm">+ Novo Treinamento</a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="py-3 ps-4">ID</th>
                    <th class="py-3">Titulo</th>
                    <th class="py-3">Categoria</th>
                    <th class="py-3">Carga Horaria</th>
                    <th class="py-3 pe-4">Descricao</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($treinamentos as $curso): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-secondary">#<?= $curso['id'] ?></td>
                        <td class="fw-semibold text-dark"><?= $curso['titulo'] ?></td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                                <?= $curso['categoria'] ?>
                            </span>
                        </td>
                        <td class="text-muted"><?= $curso['carga_horaria'] ?></td>
                        <td class="text-muted small pe-4" style="max-width: 300px;"><?= $curso['descricao'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'footer.php';
?>