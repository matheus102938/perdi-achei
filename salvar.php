<?php
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    //se o metodo nao for o get, vou encerrar
        http_response_code(405); // metodo nao permitido
        echo json_encode([
            "sucesso" => false,
            "erro" => "Metodo não Permitido"], 
        JSON_UNESCAPED_UNICODE);
        exit;
    }
/*vou pegar a entrada do post */
$entrada = file_get_contents("php://input");

/*decodificar*/
$dados = json_decode($entrada, true);

if(!is_array($dados)){
    http_response_code(400); // bad request (invalida)
    echo json_encode([
        "sucesso" => false,
        "erro" => "JSON Inválido"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

foreach($camposObrigatorios as $campo){
    if(!isset($dados[$campo]) || trim($dados[$campo]) ==="" ){
        http_response_code(400);
        echo json_encode([
            "sucesso" => false,
            "erro" => "O campo {$campo} é obrigatório"
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
function limparTexto($valor, $limite = 300){
    /*funçoes de segurança para evitar injeçao de codigos maliciosos, longe dos perigos noturnos */
    $valor = trim  ((string) $valor);
    //garante que é texto e remove espaço nas bordas 
    $valor = strip_tags($valor);
    //garante não injeção de html
    return $valor; // da  
    }
    /*chamar o arquivo*/
    $arquivo = __DIR__. "/registros.json";
    /*garantir se o arquivo existe */
    if(!file_exists($arquivo)){
        file_put_contents($arquivo, []);
    }
    $conteudoAtual = file_get_contents($arquivo);

    $registros = json_decode($conteudoAtual, true); /*transformando em array */

    if (!is_array($registros)){
        $registros = [];
    }
    $novoRegistro = [
        "id" => uniqid("item_", true),
        "objeto" => limparTexto($dados["objeto"],80),
        "tipo" =>$tipo,
        "local" => limparTexto($dados["local"],100),
        "data" => limparTexto($dados["data"],10)
        "descricao" => limparTexto($dados["descricao"],350)
        "contato" => limparTexto($dados["contato"],100)
        //pegar a data e hora do servidor 
        "criado_em" => date("d/m/Y H:i:s")
    ];
    
    array_unshift($registros, $novoRegistro);

    $salvou = file_put_contents($arquivo, json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
    );

    if($salvou === false){
        http_response_code(500);
        echo json_encode([
            "sucesso" => false,
            "erro" => "Não foi possível salvar"
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Salvo com Sucesso",
        "registro" => $novoRegistro
    ], JSON_UNESCAPED_UNICODE);

?>