<?php

class DeletarImoveis {
    private $pdo;
    public function conexao(){ //Função para conexão com Banco de dados.
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

    public function deletar_imovel($cpf,$codigo){
        
        // o check_deletar checa se aquele codigo de imóvel pertence aquele CPF.
        $check_deletar = $this->pdo->prepare("SELECT * FROM anunciante INNER JOIN imovel on (id_anunciante = id_anunciante_id) WHERE id_imovel = :codigo AND anunciante_cpf = :cpf");
        $check_deletar->bindValue(":cpf",$cpf);
        $check_deletar->bindValue(":codigo",$codigo);
        $check_deletar->execute();

        $resultado = $check_deletar->rowCount(); // Resultado recebe 0 ou 1.

        if($resultado == 1){ // Se for 1 as condições bateram e pode excluir.
            $deletar = $this->pdo->prepare("DELETE FROM imovel WHERE id_imovel = :codigo");
            $deletar->bindValue(":codigo",$codigo);
            $deletar->execute();
            
            echo '<p style="text-align: center;">Imóvel Deletado com sucesso!</p>';
        } else if($resultado == 0){ // Se for 0 é porque aquele CPF não é dono daquele anuncio.
            echo '<p style="text-align: center;">Ocorreu um erro!</p>';
        }

    }
}

?>