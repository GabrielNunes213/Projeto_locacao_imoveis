<?php
include('Classes/listar_imoveis.php');
$b = new ListarImoveis();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locação Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    
<header>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="imagens_site/logo.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
            Locação Imóveis
            </a>
            <ul class="navbar-nav" style="display: flex;flex-direction: row;">
                <li class="nav-item" style="padding-right: 20px;">
                    <a class="nav-link" aria-current="page" href="adicionar_imovel.php">Clique aqui para adicionar seu imóvel</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="deletar_imovel.php">Deletar imóvel</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main>

<div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
<?php

$b->conexao();
$b->mostrarimoveis(); // Puxa Informação da função motrarimoveis().

?>
</div>

</main>

</body>
</html>