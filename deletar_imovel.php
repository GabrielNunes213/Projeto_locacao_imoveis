<?php
include('Classes/deletar_imoveis.php');
$de = new DeletarImoveis();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Imóvel</title>
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

<main style="display:flex; align-items:center; justify-content:center;">
<form method="POST">
    <div class="mb-3" style="width: 400px;">
        <label class="form-label"><b>Digite o Código do imóvel informado na tela inicial e o CPF que ele pertence.</b></label>
        <label for="codigo" class="form-label">Digite O Código do Imóvel</label>
        <input type="number" class="form-control" id="codigo" name="codigo" required>
        <label for="cpf" class="form-label">Digite o CPF</label>
        <input type="text" class="form-control" id="cpf" name="cpf" minlenght="8" maxlenght="8" required>
    </div>
    <center><button type="submit" class="btn btn-primary mb-2">Enviar</button></center>
</form>
</main>

<?php

if(isset($_POST['codigo']) AND isset($_POST['cpf'])){
    if(strlen($_POST['cpf']) == 11){
        $cpf = addslashes($_POST['cpf']);
        $codigo = addslashes($_POST['codigo']);

        $de->conexao();
        $de->deletar_imovel($cpf,$codigo);
    } else {
        echo '<p style="text-align: center;">CPF não é válido!</p>';
    }
}

?>
</body>
</html>