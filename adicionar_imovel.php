<?php
include('Classes/divulgar_imovel.php');
$d = new DivulgarImovel();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Imóvel</title>
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
<form method="POST" enctype="multipart/form-data">
  <div class="mb-3" style="width: 400px;">
    <label class="form-label"><b>Caso você já tenha anunciado um imóvel com seu CPF basta digitar somente ele. Caso você nunca tenha registrado um imóvel preencha todos dados.</b></label>
    <label for="cep" class="form-label">Digite O Cep do Imóvel</label>
    <input type="text" class="form-control" id="cep" name="cep" minlenght="8" maxlenght="8" required>
    <div id="cep_div" class="form-text">Digite seu Cep Acima, apenas os numeros.</div>
    <label for="cpf" class="form-label">Digite seu CPF</label>
    <input type="text" class="form-control" id="cpf" name="cpf" minlenght="11" maxlenght="11" required>
    <div id="cpf_div" class="form-text">Digite seu Cpf Acima, apenas os numeros.</div>
    <label for="email" class="form-label">Digite seu Email</label>
    <input type="email" class="form-control" id="email" name="email" minlenght="1" maxlenght="50">
    <label for="nome" class="form-label">Digite seu Nome Completo</label>
    <input type="text" class="form-control" id="nome" name="nome" minlenght="1" maxlenght="50">
    <label for="telefone" class="form-label">Digite seu Celular(Whatsapp) Ex: +5531998654582</label>
    <input type="text" class="form-control" id="telefone" name="telefone" value="+55" minlenght="14" maxlenght="14">
    
    <label class="form-label"><b>Agora os Dados do Imóvel</b></label>

    <label for="foto" class="form-label">Coloque uma foto principal do imóvel</label>
    <input type="file" class="form-control" id="foto" name="foto" required>

    <label for="sobre" class="form-label">Digite Um pouco sobre o imóvel</label>
    <input type="text" class="form-control" id="sobre" name="sobre" minlenght="1" maxlenght="300" required>

    <label for="numero_quartos" class="form-label">Quantidade de quartos do Imóvel</label>
    <input type="number" class="form-control" id="numero_quartos" name="numero_quartos" minlenght="1" maxlenght="20" required>

    <label for="numero_imovel" class="form-label">Digite o numeral do imóvel</label>
    <input type="number" class="form-control" id="numero_imovel" name="numero_imovel" minlenght="1" maxlenght="6" required>

    <label for="valor_imovel" class="form-label">Digite Valor do imóvel por mês Ex:2000</label>
    <input type="number" class="form-control" id="valor_imovel" name="valor_imovel" minlenght="1" maxlenght="8" required>

  </div>
  <center><button type="submit" class="btn btn-primary mb-2">Enviar</button></center>
</form>
</main>


<?php

if(isset($_POST['cep']) and isset($_POST['cpf'])){ // Cep é obrigatórios para usar na API e o CPF para checar se o anunciante ja anunciou no site. 
    if(strlen($_POST['cep']) == 8 and strlen($_POST['cpf']) == 11){ // Cep deve ter 8 numeros que é a quantidade de numeros e o CPF é 11.
        $cep = addslashes($_POST['cep']);
        $cpf = addslashes($_POST['cpf']);
        if(isset($_POST['sobre']) and isset($_POST['numero_quartos']) and isset($_POST['numero_imovel']) and isset($_POST['valor_imovel'])){
            $sobre = addslashes($_POST['sobre']);
            $numero_quartos = addslashes($_POST['numero_quartos']);
            $numero_imovel = addslashes($_POST['numero_imovel']);
            $valor_imovel = addslashes($_POST['valor_imovel']);

            //as variaveis abaixo só vão ser utilizadas se não for encontrado o cpf no banco.
            $anunciante_email = addslashes($_POST['email']);
            $anunciante_nome = addslashes($_POST['nome']);
            $anunciante_telefone = addslashes($_POST['telefone']);

            //Upload Imagem

            if(isset($_FILES["foto"])){ // Verifica se tem o arquivo.
                $diretorio = "imagens/"; // Diretorio para onde a Imagem vai.
                $arquivo = $_FILES["foto"];
                $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION); // Pega a extensão da imagem Ex: .jpg ou .png .
                $nome_foto = strtolower(md5(uniqid($arquivo['name'])).".".$extensao); // Coloca tudo minusculo, criptografa, e cria um nome unico. 
                move_uploaded_file($arquivo["tmp_name"], "$diretorio/".$nome_foto); // Manda a imagem para pasta.
            }

            $d->conexao();
            $d->registro($cep,$cpf,$sobre,$numero_quartos,$numero_imovel,$valor_imovel,$anunciante_email,$anunciante_nome,$anunciante_telefone,$nome_foto); // Envia os dados para a função.
        }
    } else {
        echo '<p style="text-align: center;">CEP ou CPF Inválido</p><br>';
    }
}

?>
</body>
</html>