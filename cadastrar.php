<?php
include 'funcoes.php';

$mensagem = '';
$mostrarModal = false;
$novoTreinamentoId = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar_treinamento') {
        $titulo = trim($_POST['titulo']);
        $categoria = trim($_POST['categoria']);
        $carga_horaria = trim($_POST['carga_horaria']);
        $descricao = trim($_POST['descricao']);
        $data_realizacao = trim($_POST['data_realizacao']);
        $data_cadastro = date('Y-m-d'); 

        if (!empty($titulo) && !empty($categoria) && !empty($carga_horaria) && !empty($descricao)) {
            $novoTreinamentoId = adicionarTreinamento($titulo, $categoria, $carga_horaria, $descricao, $data_cadastro, $data_realizacao);
            $mostrarModal = true;
            $mensagem = '<div class="alert alert-success">Treinamento cadastrado! Agora selecione os funcionários participantes.</div>';
        } else {
            $mensagem = '<div class="alert alert-danger">Preencha todos os campos obrigatórios.</div>';
        }
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'atribuir_funcionarios') {
        $id_treinamento = $_POST['treinamento_id'];
        $inscritos = $_POST['funcionarios'] ?? [];
        
        $concluidos = getTreinamentosConcluidos();
        foreach ($inscritos as $cod_func) {
            $concluidos[$cod_func][] = $id_treinamento;
        }
        $_SESSION['treinamentos_concluidos'] = $concluidos;
        $mensagem = '<div class="alert alert-success">Funcionários inscritos com sucesso!</div>';
    }
}

include 'header.php';
$funcionarios = getFuncionarios();
?>

<div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h2 class="fw-bold text-success mb-3">Cadastro de Treinamento Operacional</h2>
            <p class="text-muted mb-4">Preencha os dados abaixo para registrar um novo curso na plataforma ESG.</p>

            <?= $mensagem ?>

            <!-- NOVO: Botões de Preenchimento Rápido -->
            <div class="mb-4 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                <label class="form-label fw-bold text-success mb-2">⚡ Sugestões de Preenchimento (Cursos Pendentes)</label>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-light border-success text-success fw-semibold" onclick="preencherForm('Segurança na Operação de Empilhadeiras', 'Governança e Segurança', '8 horas', 'Normas essenciais e prevenção de acidentes com maquinário pesado.')">
                        Empilhadeira (Pendente)
                    </button>
                    <button type="button" class="btn btn-sm btn-light border-success text-success fw-semibold" onclick="preencherForm('Prevenção de Acidentes e NRs', 'Governança e Segurança', '10 horas', 'Treinamento obrigatório focado nas Normas Regulamentadoras aplicáveis.')">
                        Segurança do Trabalho (Pendente)
                    </button>
                    <button type="button" class="btn btn-sm btn-light border-success text-success fw-semibold" onclick="preencherForm('Práticas ESG na Operação de Máquinas', 'Ambiental e Social', '4 horas', 'Impactos na produção e como atuar de forma sustentável no chão de fábrica.')">
                        Operador de Máquinas (Pendente)
                    </button>
                </div>
            </div>

            <form action="cadastrar.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar_treinamento">
                
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Título do Treinamento</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Ex: Gestão Ambiental Avançada">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categoria" class="form-label fw-semibold">Categoria</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" required placeholder="Ex: Ambiental, Social ou Governança">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="carga_horaria" class="form-label fw-semibold">Carga Horária</label>
                        <input type="text" class="form-control" id="carga_horaria" name="carga_horaria" required placeholder="Ex: 8 horas">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="data_realizacao" class="form-label fw-semibold">Data de Realização (Prevista/Concluída)</label>
                    <input type="date" class="form-control" id="data_realizacao" name="data_realizacao" required>
                </div>

                <div class="mb-4">
                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="4" required placeholder="Escreva um resumo sobre o conteúdo abordado..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">Salvar Treinamento</button>
                    <a href="painel.php" class="btn btn-outline-secondary px-4 py-2">Ver Painel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Inclusão de Funcionários (Mesmo de antes) -->
<?php if ($mostrarModal): ?>
<div class="modal fade" id="modalInclusao" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <!-- ... [O restante do modal continua idêntico à versão anterior] ... -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="cadastrar.php" method="POST">
        <input type="hidden" name="acao" value="atribuir_funcionarios">
        <input type="hidden" name="treinamento_id" value="<?= $novoTreinamentoId ?>">
        
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalLabel">Adicionar Participantes</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <?php foreach ($funcionarios as $func): ?>
                <div class="col-md-6 mb-2">
                    <div class="form-check border p-2 rounded">
                        <input class="form-check-input ms-1" type="checkbox" name="funcionarios[]" value="<?= $func['codigo'] ?>" id="func_<?= $func['codigo'] ?>">
                        <label class="form-check-label ms-2" for="func_<?= $func['codigo'] ?>">
                            <strong><?= $func['nome'] ?></strong><br>
                            <small class="text-muted"><?= $func['funcao'] ?></small>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="modal-footer">
          <a href="painel.php" class="btn btn-outline-secondary">Pular</a>
          <button type="submit" class="btn btn-success fw-semibold">Confirmar Inscrições</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalInclusao'));
        myModal.show();
    });
</script>
<?php endif; ?>

<!-- Script para o Preenchimento Automático -->
<script>
function preencherForm(titulo, categoria, carga, descricao) {
    document.getElementById('titulo').value = titulo;
    document.getElementById('categoria').value = categoria;
    document.getElementById('carga_horaria').value = carga;
    document.getElementById('descricao').value = descricao;
}
</script>

<?php
include 'footer.php';
?>
