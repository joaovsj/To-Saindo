const form = document.querySelector('form');
const cepDigitado = document.getElementById('cep');

// evento disparado quando o valor do elemento input é alterado
cepDigitado.addEventListener("input", () => {
    
    // definindo valores de execução
    let valorInput = cepDigitado.value; 
    valor = valorInput.replace("-", "");
    
    if(valor.length == 8){ 
        
        var retorno = buscar(valor);
        retorno.then(function(valores){

            if(valores.hasOwnProperty('erro')){
            
                const msg = document.getElementById('role');     
                msg.classList.add('active');

            }else{
                form["uf"].value = valores.uf;
                form["cidade"].value = valores.localidade;
                form["rua"].value = valores.logradouro;
                form["bairro"].value = valores.bairro;
            }
        });
    }
});

async function buscar(cep){
    
    const response = await fetch("https://viacep.com.br/ws/"+cep+"/json/");
    const jsonBody = await response.json();
    
    return jsonBody;
}