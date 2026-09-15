<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retorna a lista de funcionários fictícios
function getFuncionarios() {
    return [
        ['codigo' => 101, 'nome' => 'Carlos Silva', 'funcao' => 'Operador de Empilhadeira'],
        ['codigo' => 102, 'nome' => 'Maria Oliveira', 'funcao' => 'Analista Ambiental'],
        ['codigo' => 103, 'nome' => 'João Santos', 'funcao' => 'Gestor de Sustentabilidade'],
        ['codigo' => 104, 'nome' => 'Ana Costa', 'funcao' => 'Técnico de Segurança do Trabalho'],
        ['codigo' => 105, 'nome' => 'Paulo Pereira', 'funcao' => 'Operador de Máquinas'],
        ['codigo' => 106, 'nome' => 'Fernanda Lima', 'funcao' => 'Operador de Empilhadeira'],
        ['codigo' => 107, 'nome' => 'Roberto Alves', 'funcao' => 'Auxiliar Administrativo'],
    ];
}

// Define quais IDs de treinamento são obrigatórios para cada função
function getTrilhasPorFuncao() {
    return [
        'Operador de Empilhadeira' => [1, 4], 
        'Analista Ambiental' => [1, 2],
        'Técnico de Segurança do Trabalho' => [1, 3, 4],
        'Operador de Máquinas' => [1]
    ];
}

// Tabela (simulada) de quais funcionários concluíram quais cursos
function getTreinamentosConcluidos() {
    if (!isset($_SESSION['treinamentos_concluidos'])) {
        $_SESSION['treinamentos_concluidos'] = [
            101 => [1],    // Carlos fez apenas Introdução (Falta o de Empilhadeira)
            106 => [1, 4], // Fernanda completou todos
            102 => [1, 2], // Maria completou todos
            104 => [4],    // Ana fez o de segurança, falta introdução
        ];
    }
    return $_SESSION['treinamentos_concluidos'];
}

function getTreinamentos() {
    $padroes = [
    ];

    if (!isset($_SESSION['meus_treinamentos'])) {
        $_SESSION['meus_treinamentos'] = $padroes;
    }

    return $_SESSION['meus_treinamentos'];
}

function adicionarTreinamento($titulo, $categoria, $carga_horaria, $descricao, $data_cadastro, $data_realizacao) {
    $lista = getTreinamentos();
    
    // Gerar um ID seguro
    $maxId = 0;
    foreach ($lista as $item) {
        if ($item['id'] > $maxId) $maxId = $item['id'];
    }
    $novoId = $maxId + 1;
    
    $novoCurso = [
        'id' => $novoId,
        'titulo' => $titulo,
        'categoria' => $categoria,
        'carga_horaria' => $carga_horaria,
        'descricao' => $descricao,
        'data_cadastro' => $data_cadastro,
        'data_realizacao' => $data_realizacao
    ];

    array_unshift($_SESSION['meus_treinamentos'], $novoCurso);
    return $novoId;
}
?>
