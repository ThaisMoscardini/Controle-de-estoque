<?php
    
    include 'ProdutosService.php';   
    //Colocando o cabecalho para retornar os dados em formado json na saida
    header("Content-Type: application/json; charset=UTF-8"); 

    // $_GET eh uma variável do tipo array() que pegar link (endereço)
    // Metodo GET é um protocolo de solicitação.
    
    if ($_GET['url']){// se houver url ele cria a variável $url 
       
        // O comando var_dump(..) é para imprimir (mostrar)
        //var_dump($_GET); //testar !!!
        //var_dump($_GET['url']); //testar !!!
        $url = explode('/' , $_GET['url']);
        //var_dump($url);  // mostrar a url
         
        if ($url[0] === 'api') {
            array_shift($url); // Removendo 'api' da URL
        
            // Obtendo o nome do serviço e removendo-o da URL
            $service = ucfirst($url[0]) . 'Service';
            array_shift($url);
        
            $method = strtolower($_SERVER['REQUEST_METHOD']);
        
            // Acessando os dados do BD: get, post, put e delete
            try {
                // Chamando o método do serviço e passando os parâmetros da URL
                if ($method == 'get' && $service == 'ProdutosService' && isset($_GET['nome_produto'])) {
                    $nomeProduto = $_GET['nome_produto'];
                    $resultado = Produtos::buscarPorNome($nomeProduto);
                    echo json_encode($resultado);
                    return; // Retorna para interromper a execução após a resposta
                }
        
                $response = call_user_func_array(array(new $service, $method), $url);
        
                http_response_code(200); // Sucesso
                echo json_encode(array('status' => 'success', 'data' => $response));
            } catch (Exception $e) {
                http_response_code(404); // Não encontrado
                echo json_encode(array('status' => 'error', 'data' => $e->getMessage()));
            }
        }
    }        
