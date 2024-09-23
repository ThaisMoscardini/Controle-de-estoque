<?php
     
    include 'Produtos.php'; 
    class ProdutosService 
    {
          
          public function get( $nome = null )
          {
              if ($nome){
                            
                 return Produtos::select($nome) ;
              }else{
                 
                 return Produtos::selectAll() ;
              }

          }


          // funcão para inclusão de dados
          public function post()
          {
               //Pegar os dados em formato JSON para incluir no BD.
               $dados = json_decode(file_get_contents('php://input'), true, 512);
               if ($dados == null){
                     throw new Exception("Preencher os dados!");
               }
               return Produtos::insert($dados); 
          }


          // funcão para alteração de dados
          public function put($id = null)
          {
            if ($id == null){
                throw new Exception("Falta o codigo !");
              }
              //Pegar as informações para atualizar no BD
              $dados = json_decode(file_get_contents('php://input'), true, 512);
              if ($dados == null){
                throw new Exception("Falta informação!");
              }
              return Produtos::update($id,$dados);


          }


          // funcão para exclusão de dados
          public function delete($id)
          {
            try {
                  return Produtos::delete($id);
              } catch (Exception $e) {
                  throw new Exception($e->getMessage());
              }
          }
    }