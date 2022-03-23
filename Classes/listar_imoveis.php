<?php

class ListarImoveis {

    private $pdo;
    public function conexao(){ // Conexão com Banco de dados
        $host = "localhost";
        $dbname = "locacao_imoveis";
        $user = "root";
        $senha = "";

        try{
            $this->pdo = new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$senha);
        }
        catch(PDOException $e){
            echo "Erro no Banco de Dados: ".$e->getMessage();
        }
        catch(Exception $e) {
            echo "Ocorreu um erro: ".$e->getMessage();
        }        
    }


    public function mostrarimoveis(){ //Esta função Lista os imóveis disponíveis para alugar.
        $select = $this->pdo->prepare("SELECT * FROM anunciante INNER JOIN imovel on (id_anunciante = id_anunciante_id)");
        $select->execute();
        
        $cmd = $select;
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);

        foreach($res as $valor){
            echo '<div class="card m-3" style="width: auto;">';
            // A imagem o banco está armazenando apenas o nome, cada imagem tem um nome unico, ai quando vai chamar chama o nome.
            echo '<img style="max-width: 300px; height:300px; margin-top:5px;" src="imagens/'.$valor['diretorio_foto_imovel'].'"class="card-img-top" alt="Imagem">';
            echo '<div class="card-body">';

            echo '<h4 class="card-title">Código Imóvel</h4>';
            echo '<p class="card-text">'.$valor['id_imovel'].'</p>';

            echo '<h4 class="card-title">Email Anunciante</h4>';
            echo '<p class="card-text">'.$valor['anunciante_email'].'</p>';

            echo '<h4 class="card-title">Nome Anunciante</h4>';
            echo '<p class="card-text">'.$valor['anunciante_nome'].'</p>';

            echo '<h4 class="card-title">Telefone Anunciante</h4>';
            echo '<p class="card-text">'.$valor['anunciante_telefone'].'</p>';

            echo '<h4 class="card-title">Sobre imóvel</h4>';
            echo '<p class="card-text">'.$valor['sobre_imovel'].'</p>';

            echo '<h4 class="card-title">Quantidade de quartos</h4>';
            echo '<p class="card-text">'.$valor['numero_quartos'].'</p>';

            echo '<h4 class="card-title">CEP imóvel</h4>';
            echo '<p class="card-text">'.$valor['cep'].'</p>';

            echo '<h4 class="card-title">Rua imóvel</h4>';
            echo '<p class="card-text">'.$valor['rua'].'</p>';

            echo '<h4 class="card-title">Número imóvel</h4>';
            echo '<p class="card-text">'.$valor['numero_imovel'].'</p>';

            echo '<h4 class="card-title">Bairro imóvel</h4>';
            echo '<p class="card-text">'.$valor['bairro'].'</p>';

            echo '<h4 class="card-title">Cidade imóvel</h4>';
            echo '<p class="card-text">'.$valor['cidade'].'</p>';

            echo '<h4 class="card-title">Estado imóvel</h4>';
            echo '<p class="card-text">'.$valor['estado'].'</p>';

            echo '<h4 class="card-title">Valor imóvel/mês</h4>';
            echo '<p class="card-text">R$ '.$valor['valor_imovel'].' /Mês</p>';
            
            // A API do Whatsapp é para quando clicar para chamar no Whatsapp ele redirecionar para uma conversa.
            echo '<a href="https://api.whatsapp.com/send?phone='.$valor['anunciante_telefone'].'" class="btn btn-primary">Chamar no Whatsapp</a>';
            echo '</div>';
            echo '</div>';
        }
    }
}


?>