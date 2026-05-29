<?php
/**endpoint - retornar dados cadastrados 
 * endpoint de leitura responde um jason
*/
header("Conten-type: application/jason; charset=UTF-8")
//garante os caracteres especias ex: açucar

if($_SERVER["REQUEST_METHOD"] !== "GET"){
//se o metodo nao for get, vou encerrar 
http_response_code (405);
echo json_encode(["erro" => "Metodo não permitido"] JSON_UNESCAPED_UNICODE);
exit;
}
//fazer a leitura do arquivo json
$arquivo = __DIR__."/registros.json";
//tratar um erro, caso o arquivo não 
if(!file_exists($arquivo)){
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}
//ler o conteudo do json
$conteudo = file_get_contents($arquivo);
//transformar ele em json
$registo = json_decode($conteudo, true);
//mostrar o conteudo do json
echo json_encode($registo, JSON_UNESCAPED_UNICODE);
?>