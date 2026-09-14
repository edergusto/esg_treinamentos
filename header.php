<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESG Treinamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333333;
        }
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="index.php">
                ESG Treinamentos
            </a>
            <div class="ms-auto d-flex gap-2">
                <a class="btn btn-outline-light btn-sm px-3" href="index.php">Home</a>
                <a class="btn btn-success btn-sm px-3" href="cadastrar.php">Novo Treinamento</a>
                <a class="btn btn-outline-warning btn-sm px-3" href="painel.php">Painel de Gestao</a>
            </div>
        </div>
    </nav>

    <main class="container my-5 flex-grow-1">