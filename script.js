/** desenvolvendo o javascript
 * aqui a gente vai fazer a comunicação com o php e alterar elementos chave na nossa pagina principal 
 */
// declarando as variaveis const
//lembrando que as consts são permanentes 
const form = document.getElementById(formObjeto);
const mensagem = document.getElementById(mensagem);
const listaregistros = document.getElementById(listaregistros);
const totalRegistros = document.getElementById(totalRegistros);
const btnAtualiza = document.getElementById(btnAtualiza);

const botoesFiltro = document.querySelectorAll(".filtro");//pegar os botoes de filtro 

//declarar recebem instruções vindas da página.
let registros = []; // Array (uma coleção de registros)
let filtroAtual = "todos";

//funções - fuctions - def 
function mostrarMensagem(text, tipo){
    /*essa função irá substituir ou incluir o texto da mensagem */
    mensagem.textContent = texto;
    mensagem.className = `mensagem ${tipo}`;
} 

//apagar a mensagem com o tempo...
function limparMensagemDepois(){
    setTimeout(()=> {
        mensagem.textContent = "";
        mensagem.className = "mensagem";0
    },4500); /*limpa a mensagem e volta ao estado original depois de 4500 milisegndos (4 segundos e meio)*/
}
/**
 * formato de data americano YYYY-dd-mm
 * 
 */
function formatarData(dataISO){
    if(!dataISO) return "data nao informada"
    const partes = dataISO.split("-");

    if(partes.length !== 3){
        return "data invalida";
    }else{
        return`${partes[2]}/${partes[1]}/${partes[0]}`;
    }
    
}
function renderizarRegistros(){
    /*aqui vamos tratar o filtro*/
    const registrosFiltrados = filtroAtual === "todos"?
    registros : registros.filter((item) => item.tipo === filtroAtual);
    /*atualizar o filtro*/
    totalRegistros.textContent = registros.length;

    listaregistros.innerHTML = "";
    if(registrosFiltrados.length ===0){
        listaregistros.innerHTML = "<p>0 registros encontrados";
        return;//toda a  vez galera que eu der um retorno, a função encerra  
    }
    //para cada item, vou criar uma div
    registrosFiltrados.forEach((item) =>{
        const div = document.createElement("div");
        div.className =  "item";
        div.innerHTML = `
        <div class="item-img">${iconeDoObjeto(item.objeto)}</div>
        <div>
    <div classs= "tag ${escaparHTML(item.tipo)}">${escaparHTML(item.tipo).toUpperCase()}
         </div>
         <h3>${escaparHTML(item.objeto)}</h3>
         <p><strong>local</strong>${escaparHTML(item.local)}</p>
         <p><strong>Data:</strong>${formatarData(escaparHTML(item.data))}</p>
         <p><strong>Descrição</strong>${escaparHTML(item.descricao)}</p>
        </div>
        `;
        //adicionar a div como um filho
        listaregistros.appendChild(div);
    });
    
}
async function carregarRegistros() {
    try {
        const resposta = await fetch ("listar.php",{
            method: "GET",
            cache:"no-stpre"
        });
        if(!resposta.ok){
            throw new Error ("erro ao carregar");
        }
        const dados = await fetch("respsta.json");
    } catch (error) {
        
    }
}