<?php
include 'funcoes.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $carga_horaria = trim($_POST['carga_horaria']);
    $descricao = trim($_POST['descricao']);

    if (!empty($titulo) && !empty($categoria) && !empty($carga_horaria) && !empty($descricao)) {
        adicionarTreinamento($titulo, $categoria, $carga_horaria, $descricao);
        $mensagem = '<div class="alert alert-success">Treinamento cadastrado com sucesso!</div>';
    } else {
        $mensagem = '<div class="alert alert-danger">Preencha todos os campos do formulario.</div>';
    }
}

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h2 class="fw-bold text-success mb-3">Cadastro de Treinamento Operacional</h2>
            <p class="text-muted mb-4">Preencha os dados abaixo para registrar um novo curso na plataforma ESG.</p>

            <?= $mensagem ?>

            <form action="cadastrar.php" method="POST">
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Titulo do Treinamento</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Ex: Gestao Ambiental Avancada">
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label fw-semibold">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required placeholder="Ex: Ambiental, Social ou Governanca">
                </div>

                <div class="mb-3">
                    <label for="carga_horaria" class="form-label fw-semibold">Carga Horaria</label>
                    <input type="text" class="form-control" id="carga_horaria" name="carga_horaria" required placeholder="Ex: 8 horas">
                </div>

                <div class="mb-4">
                    <label for="descricao" class="form-label fw-semibold">Descricao</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="4" required placeholder="Escreva um resumo sobre o conteudo abordado..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">Salvar Treinamento</button>
                    <a href="painel.php" class="btn btn-outline-secondary px-4 py-2">Ver Painel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>