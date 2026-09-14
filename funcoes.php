<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getTreinamentos() {
    $padroes = [
        [
            'id' => 1,
            'titulo' => 'Introducao as Praticas ESG',
            'categoria' => 'Ambiental e Social',
            'carga_horaria' => '4 horas',
            'descricao' => 'Fundamentos sobre governanca corporativa, impacto ambiental e responsabilidade social nas empresas modernas.'
        ],
        [
            'id' => 2,
            'titulo' => 'Gestao de Residuos e Economia Circular',
            'categoria' => 'Ambiental',
            'carga_horaria' => '6 horas',
            'descricao' => 'Como aplicar conceitos de economia circular, reducao de residuos e reciclagem eficiente no ambiente industrial.'
        ],
        [
            'id' => 3,
            'titulo' => 'Diversidade, Equidade e Inclusao (DEI)',
            'categoria' => 'Social',
            'carga_horaria' => '5 horas',
            'descricao' => 'Promovendo ambientes de trabalho seguros, inclusivos e livres de discriminacao, valorizando o capital humano.'
        ]
    ];

    if (!isset($_SESSION['meus_treinamentos'])) {
        $_SESSION['meus_treinamentos'] = $padroes;
    }

    return $_SESSION['meus_treinamentos'];
}

function adicionarTreinamento($titulo, $categoria, $carga_horaria, $descricao) {
    $lista = getTreinamentos();
    
    $novoId = count($lista) + 1;
    
    $novoCurso = [
        'id' => $novoId,
        'titulo' => $titulo,
        'categoria' => $categoria,
        'carga_horaria' => $carga_horaria,
        'descricao' => $descricao
    ];

    array_unshift($_SESSION['meus_treinamentos'], $novoCurso);
}
?>