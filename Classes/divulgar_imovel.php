<?php

class DivulgarImovel {
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

    
    public function registro($cep,$cpf,$sobre,$numero_quartos,$numero_imovel,$valor_imovel,$anunciante_email,$anunciante_nome,$anunciante_telefone,$nome_foto){
        
        //API Via CEP pega dados buscando pelo CEP.
        //Utilizei ela para a pessoa bucar o CEP e ele ja cadastrar automaticamente o endereço.
        $url = "https://viacep.com.br/ws/$cep/json/";
        $address = file_get_contents($url);
        $array = json_decode($address);

        if(isset($array->cep) and isset($array->logradouro) and isset($array->bairro) and isset($array->localidade) and isset($array->uf)){
            $cep_imovel = $array->cep;
            $rua_imovel = $array->logradouro;
            $bairro_imovel = $array->bairro;
            $cidade_imovel = $array->localidade;
            $estado_imovel = $array->uf;
        } else {
            echo '<p style="text-align: center;">Ocorreu um erro na busca do CEP</p>';
            exit('Houve um erro');
        }

        //O select abaixo checa se o CPF da pessoa já está cadastrado, caso não tenha ele 
        //cria tudo, e se ja estiver ele apenas atribui os outros dados sem criar de novo o anunciante.
        $selectcpf = $this->pdo->prepare("SELECT * FROM anunciante WHERE anunciante_cpf = :cpf");
        $selectcpf->bindValue(":cpf",$cpf);
        $selectcpf->execute();


        if($selectcpf->rowCount() == 1){ //Caso retornar 1 o CPF já está cadastrado.
            $cmd = $selectcpf;
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $valor){
                $id_anunciante = $valor['id_anunciante']; // Pega o ID do anunciante, para dizer que aquela pessoa que anunciou.
            }

            if(isset($sobre) and isset($numero_quartos) and isset($numero_imovel) and isset($valor_imovel)){
                $insertregistro = $this->pdo->prepare("INSERT INTO imovel 
                (sobre_imovel,diretorio_foto_imovel,numero_quartos,cep,numero_imovel,rua,bairro,cidade,estado,valor_imovel,id_anunciante_id) 
                VALUES (:sobre,:nome_foto,:num_quartos,:cep,:num_imovel,:rua,:bairro,:cidade,:estado,:valor_imovel,:id_anunciante_id)");

                $insertregistro->bindValue(":sobre",$sobre);
                $insertregistro->bindValue(":nome_foto",$nome_foto);
                $insertregistro->bindValue(":num_quartos",$numero_quartos);
                $insertregistro->bindValue(":cep",$cep);
                $insertregistro->bindValue(":num_imovel",$numero_imovel);
                $insertregistro->bindValue(":rua",$rua_imovel);
                $insertregistro->bindValue(":bairro",$bairro_imovel);
                $insertregistro->bindValue(":cidade",$cidade_imovel);
                $insertregistro->bindValue(":estado",$estado_imovel);
                $insertregistro->bindValue(":valor_imovel",$valor_imovel);
                $insertregistro->bindValue(":id_anunciante_id",$id_anunciante); // Aqui ele relaciona a Foreign key do Banco.
                $insertregistro->execute();

                echo '<p style="text-align: center;">Imóvel cadastrado com sucesso!</p>';
            }
        } else if($selectcpf->rowCount() == 0) { // Quando retorna 0 é porque o select não retornou nada, logo conclui-se que não existe aquele CPF cadastrado.
            if(isset($anunciante_telefone) and isset($anunciante_nome) and isset($anunciante_email) and isset($sobre) and isset($numero_quartos) and isset($numero_imovel) and isset($valor_imovel)){//checa se tem todos dados
                $insert_anunciante = $this->pdo->prepare("INSERT INTO anunciante (anunciante_email,anunciante_nome,anunciante_telefone,anunciante_cpf) 
                VALUES (:email,:nome,:telefone,:cpf)");

                $insert_anunciante->bindValue(":email",$anunciante_email);
                $insert_anunciante->bindValue(":nome",$anunciante_nome);
                $insert_anunciante->bindValue(":telefone",$anunciante_telefone);
                $insert_anunciante->bindValue(":cpf",$cpf);
                $insert_anunciante->execute();
                
                $selectcpf_novo = $this->pdo->prepare("SELECT * FROM anunciante WHERE anunciante_cpf = :cpf"); //O mesmo select la de cima para checar de novo.
                $selectcpf_novo->bindValue(":cpf",$cpf);
                $selectcpf_novo->execute();

                $cmd = $selectcpf_novo;
                $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $valor){
                    $id_anunciante = $valor['id_anunciante']; // Pega o id do anunciante para relacionar na Foreign Key.
                }

                $insertregistro = $this->pdo->prepare("INSERT INTO imovel 
                (sobre_imovel,diretorio_foto_imovel,numero_quartos,cep,numero_imovel,rua,bairro,cidade,estado,valor_imovel,id_anunciante_id) 
                VALUES (:sobre,:nome_foto,:num_quartos,:cep,:num_imovel,:rua,:bairro,:cidade,:estado,:valor_imovel,:id_anunciante_id)");

                $insertregistro->bindValue(":sobre",$sobre);
                $insertregistro->bindValue(":nome_foto",$nome_foto);
                $insertregistro->bindValue(":num_quartos",$numero_quartos);
                $insertregistro->bindValue(":cep",$cep);
                $insertregistro->bindValue(":num_imovel",$numero_imovel);
                $insertregistro->bindValue(":rua",$rua_imovel);
                $insertregistro->bindValue(":bairro",$bairro_imovel);
                $insertregistro->bindValue(":cidade",$cidade_imovel);
                $insertregistro->bindValue(":estado",$estado_imovel);
                $insertregistro->bindValue(":valor_imovel",$valor_imovel);
                $insertregistro->bindValue(":id_anunciante_id",$id_anunciante);
                $insertregistro->execute();
                echo '<p style="text-align: center;">Imóvel cadastrado com sucesso!</p>';
            } else {
                echo '<p style="text-align: center;">Dados Incompletos, Volte e insira novamente.</p>';
            }
            
        }
    }

}

?>