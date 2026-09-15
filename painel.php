<?php
include 'funcoes.php';
include 'header.php';

$treinamentos = getTreinamentos();
$funcionarios = getFuncionarios();
$obrigatorios = getTrilhasPorFuncao();
$concluidos = getTreinamentosConcluidos();

// Função auxiliar para formatar datas (Y-m-d para d/m/Y)
function formatarData($dataStr) {
    if (empty($dataStr)) return '--';
    return date('d/m/Y', strtotime($dataStr));
}
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">Painel de Gestão de Treinamentos</h2>
        <p class="text-muted">Acompanhe todos os treinamentos operacionais cadastrados.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="cadastrar.php" class="btn btn-success fw-semibold shadow-sm">+ Novo Treinamento</a>
    </div>
</div>

<!-- Tabela 1: Lista de Treinamentos -->
<div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="py-3 ps-4">ID</th>
                    <th class="py-3">Título</th>
                    <th class="py-3">Categoria</th>
                    <th class="py-3">Data Cadastro</th>
                    <th class="py-3">Data Realização</th>
                    <th class="py-3 pe-4">Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($treinamentos as $curso): ?>
                    <!-- Adicionado 'cursor: pointer' e data-bs-target para abrir o modal -->
                    <tr style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalParticipantes<?= $curso['id'] ?>" title="Clique para ver os participantes">
                        <td class="ps-4 fw-bold text-secondary">#<?= $curso['id'] ?></td>
                        <td class="fw-semibold text-dark"><?= $curso['titulo'] ?></td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                                <?= $curso['categoria'] ?>
                            </span>
                        </td>
                        <!-- Já com a correção do ?? '' para evitar os alertas antigos -->
                        <td class="text-muted small"><?= formatarData($curso['data_cadastro'] ?? '') ?></td>
                        <td class="text-muted small fw-bold"><?= formatarData($curso['data_realizacao'] ?? '') ?></td>
                        <td class="text-muted small pe-4" style="max-width: 250px;"><?= $curso['descricao'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light text-muted small text-center py-2">
        💡 <i>Dica: Clique em qualquer treinamento acima para visualizar os colaboradores participantes.</i>
    </div>
</div>

<div class="row mb-3 mt-4">
    <div class="col-12">
        <h3 class="fw-bold text-danger border-bottom pb-2">🚨 Pendências por Função</h3>
        <p class="text-muted">Colaboradores que ainda não concluíram cursos obrigatórios para suas respectivas posições.</p>
    </div>
</div>

<!-- Tabela 2: Pendências de Treinamento -->
<div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-danger bg-opacity-10 text-danger">
                <tr>
                    <th class="py-3 ps-4">Código</th>
                    <th class="py-3">Funcionário</th>
                    <th class="py-3">Função</th>
                    <th class="py-3 pe-4">Treinamento Pendente</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $temPendencia = false;
                
                // Lista de garantia caso a sessão do usuário ainda esteja usando a versão velha
                $nomesGarantidos = [
                    1 => 'Introdução às Práticas ESG',
                    2 => 'Gestão de Resíduos e Economia Circular',
                    3 => 'Diversidade, Equidade e Inclusão (DEI)',
                    4 => 'Segurança na Operação de Empilhadeiras'
                ];

                foreach ($funcionarios as $func): 
                    $funcao = $func['funcao'];
                    $codigo = $func['codigo'];
                    
                    if (isset($obrigatorios[$funcao])):
                        $cursosExigidos = $obrigatorios[$funcao];
                        $cursosFeitos = $concluidos[$codigo] ?? [];
                        
                        foreach ($cursosExigidos as $idExigido):
                            if (!in_array($idExigido, $cursosFeitos)):
                                $temPendencia = true;
                                
                                // Solução do Desconhecido: Tenta pegar o nome da memória padrão primeiro
                                $nomeCurso = $nomesGarantidos[$idExigido] ?? 'Treinamento Pendente';
                                
                                // Tenta achar o título real no array ativo da sessão
                                foreach($treinamentos as $t) {
                                    if ($t['id'] == $idExigido) {
                                        $nomeCurso = $t['titulo'];
                                        break;
                                    }
                                }
                ?>
                    <tr>
                        <td class="ps-4 fw-bold text-secondary"><?= $codigo ?></td>
                        <td class="fw-semibold text-dark"><?= $func['nome'] ?></td>
                        <td class="text-muted"><?= $funcao ?></td>
                        <td><span class="badge bg-danger rounded-pill px-3 py-2"><?= $nomeCurso ?></span></td>
                    </tr>
                <?php 
                            endif;
                        endforeach;
                    endif;
                endforeach;

                if (!$temPendencia):
                ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-success fw-bold">Todas as obrigações de treinamento estão em dia!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAIS DE PARTICIPANTES (Gerados dinamicamente) -->
<!-- ========================================== -->
<?php foreach ($treinamentos as $curso): ?>
<div class="modal fade" id="modalParticipantes<?= $curso['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $curso['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLabel<?= $curso['id'] ?>">Participantes do Treinamento #<?= $curso['id'] ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-3 bg-light border-bottom">
                    <strong class="text-dark"><?= $curso['titulo'] ?></strong><br>
                    <small class="text-muted">Carga Horária: <?= $curso['carga_horaria'] ?></small>
                </div>
                
                <ul class="list-group list-group-flush">
                    <?php
                    $participantesDesteCurso = [];
                    // Filtra quais funcionários têm este curso concluído
                    foreach ($funcionarios as $func) {
                        $cursosFeitosPeloFunc = $concluidos[$func['codigo']] ?? [];
                        if (in_array($curso['id'], $cursosFeitosPeloFunc)) {
                            $participantesDesteCurso[] = $func;
                        }
                    }

                    if (count($participantesDesteCurso) > 0):
                        foreach ($participantesDesteCurso as $p):
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <span class="fw-semibold text-dark"><?= $p['nome'] ?></span><br>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary mt-1"><?= $p['funcao'] ?></span>
                            </div>
                            <span class="badge bg-success px-2 py-1 rounded-pill">Inscrito / Concluído</span>
                        </li>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                        <div class="text-center py-5 text-muted">
                            <p class="mb-0">Nenhum funcionário registrado neste treinamento.</p>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php
include 'footer.php';
?>
