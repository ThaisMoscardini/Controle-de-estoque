<?php
// Configuração dos cabeçalhos CORS para permitir todas as origens
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");



      
      require_once 'config.php' ; 
      
      
      class Produtos 
      {

        
        
        public static function buscarPorNome(string $nome)
        {
            $tabela = "produtos";
            $coluna = "nome_produto";
        
            // Conecta ao banco de dados
            $connPdo = new PDO(dbDrive . ':host=' . dbHost . '; dbname=' . dbName, dbUser, dbPass);
        
            // Monta a query SQL com o filtro pelo nome do produto usando LIKE
            $sql = "SELECT * FROM $tabela WHERE $coluna LIKE :nome";
            
            $stmt = $connPdo->prepare($sql);
        
            // Configura o parâmetro de busca para incluir o caractere de percentual (%) antes e depois do nome
            $nomePesquisa = '%' . $nome . '%';
            $stmt->bindParam(':nome', $nomePesquisa, PDO::PARAM_STR);
        
            // Executa a query
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                // Retorna os dados encontrados
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Se não houver resultados, lança uma exceção
                throw new Exception("Sem registros do produto com o nome '$nome'");
            }
            try {
                $nomeProduto = $_GET['nome_produto']; // Supondo que o nome do produto venha da query string
                $resultado = Produtos::buscarPorNome($nomeProduto);
                echo json_encode($resultado);
            } catch (Exception $e) {
                echo json_encode(array("message" => $e->getMessage()));
            }
            
        }
        
        
        



        public static function select(int $id)
        {
            
            $tabela = "produtos"; 
            $coluna = "codigo_produto"; 
            
            // Conectando com o banco de dados através da classe (objeto) PDO
            // pegando as informações do config.php (variáveis globais)
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            
            // Usando comando sql que será executado no banco de dados para consultar um 
            // determinado registro 
            $sql = "select * from $tabela where $coluna = :id" ;
            
            //preparando o comando Select do SQL para ser executado usando método prepare()
            $stmt = $connPdo->prepare($sql);  

            //configurando (ou mapear) o parametro de busca
            $stmt->bindValue(':id' , $id) ;
           
            // Executando o comando select do SQL no banco de dados
            $stmt->execute() ;
           
            if ($stmt->rowCount() > 0) // se houve retorno de dados (Registros)
            {
                //imprimir usando : var_dump( $stmt->fetch(PDO::FETCH_ASSOC) );

                // retornando os dados do banco de dados através do método fetch(...)
                return $stmt->fetch(PDO::FETCH_ASSOC) ;
                
            }else{// se não houve retorno de dados, jogar no classe Exception (erro)
                  // e mostrar a mensagem "Sem registro do aluno"                
                throw new Exception("Sem registro do produto");
            }

        }
        
        
        public static function selectAll()
        {
            $tabela = "produtos"; 
            
            // conectando com o banco de dados através da classe (objeto) PDO
            // pegando as informações do config.php (variáveis globais)
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            //criar execução de consulta usando a linguagem SQL
            $sql = "select * from $tabela"  ;
            // preparando o comando Select do SQL para ser executado usando método prepare()
            $stmt = $connPdo->prepare($sql);
            // Executando o comando select do SQL no banco de dados
            $stmt->execute() ;

               

            if ($stmt->rowCount() > 0) // se houve retorno de dados (Registros)
            {
                // retornando os dados do banco de dados através do método fetchAll(...)
                return $stmt->fetchAll(PDO::FETCH_ASSOC) ;
            }else{
                throw new Exception("Sem registros");
            }

        }
        public static function insert($dados)
        {
            $tabela = "produtos"; 
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            $sql = "insert into $tabela (nome_produto, lado_produto,valor_produto,quantidade_produto) values (:nome,:lado,:valor,:quantidade)";
            $stmt = $connPdo->prepare($sql);
            
            $stmt->bindValue(':nome', $dados['nome_produto']);
            $stmt->bindValue(':lado', $dados['lado_produto']);
            $stmt->bindValue(':valor', $dados['valor_produto']);
            $stmt->bindValue(':quantidade', $dados['quantidade_produto']);
            $stmt->execute() ;

            if ($stmt->rowCount() > 0) 
            {                
                return 'Dados cadastrados com sucesso!' ;
            }else{
                throw new Exception("Erro ao inserir os dados");
            }
        }

        public static function delete($id)
        {
            $tabela = "produtos"; 
            $coluna = "codigo_produto";
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            $sql = "delete from $tabela where $coluna = :id";
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id' , $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) 
            {                
                return 'Dados excluidos com sucesso!' ;
            }else{
                throw new Exception("Erro ao excluir os dados");
            }
        }

     public static function update($id,$dados)
     {
        $tabela = "produtos"; 
        $coluna = "codigo_produto"; 
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
        $sql = "update $tabela set nome_produto=:nome,lado_produto=:lado,valor_produto=:valor,quantidade_produto=:quantidade where $coluna=:id";
        $stmt = $connPdo->prepare($sql);
        
        $stmt->bindValue(':nome', $dados['nome_produto']);
            $stmt->bindValue(':lado', $dados['lado_produto']);
            $stmt->bindValue(':valor', $dados['valor_produto']);
            $stmt->bindValue(':quantidade', $dados['quantidade_produto']);
            $stmt->bindValue(':id' , $id);
        $stmt->execute() ;

        if ($stmt->rowCount() > 0) 
        {                
            return 'Dados alterados com sucesso!' ;
        }else{
            throw new Exception("Erro ao alterar os dados");
        }



     }





      }