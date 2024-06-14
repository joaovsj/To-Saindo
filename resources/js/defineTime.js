// recarrega a pagina
function reload(){
    document.location.reload(true)
}

// envia formulario
function submitForm(){

    // // verifica se pelo menos um horario foi enviado para subit o formulario
    // const input1 = document.getElementById("primeiroHorario");
    // if(input1.value === ""){
    //     return false;
    // }

    var form = document.getElementById('form');
    form.submit();
}


const items = [
    "seg-1", "ter-1", "qua-1", "qui-1", "sex-1",
    "seg-2", "ter-2", "qua-2", "qui-2", "sex-2",
    "seg-3", "ter-3", "qua-3", "qui-3", "sex-3",
    "seg-4", "ter-4", "qua-4", "qui-4", "sex-4",
    "seg-5", "ter-5", "qua-5", "qui-5", "sex-5",
    "seg-6", "ter-6", "qua-6", "qui-6", "sex-6"
]


function definir(item){
    
    var retorno = adicionarDiaSemana(items[item]);

    if(retorno == false){
        // exibir mensagem ultrapassou o limite
        const div = document.getElementById('msg-time');
        div.classList.add('active');
        return null;
    }

    // pegar hora
    var time = document.getElementById(items[item]); 
    time.style.background = '#ff2d75';

    adicionarInput(time)   
}


// adiciona dia da semana no input
function adicionarDiaSemana(dia){
    
    
    const primeiroDia = document.getElementById('primeiroDia');
    const segundoDia = document.getElementById('segundoDia');
    const terceiroDia = document.getElementById('terceiroDia');
    const quartoDia = document.getElementById('quartoDia');

    if(primeiroDia.value === ""){
        primeiroDia.value = dia;

    }else if(segundoDia.value === ""){
        segundoDia.value = dia;

    }else if(terceiroDia.value === ""){
        terceiroDia.value = dia;

    }else if(quartoDia.value === ""){
        quartoDia.value = dia;

    }else{
        return false;
    }

}

// adiciona hora no input
function adicionarInput(time){
    const input1 = document.getElementById("primeiroHorario");
    const input2 = document.getElementById("segundoHorario");
    const input3 = document.getElementById("terceiroHorario");
    const input4 = document.getElementById("quartoHorario");

    if(input1.value === ""){
        input1.value = time.innerHTML;
    }
    else if(input2.value === ""){
        input2.value = time.innerHTML; 
    }else if(input3.value === ""){
        input3.value = time.innerHTML; 

    }else{
        input4.value = time.innerHTML;
    }

    /*
        time.style.background = 'none';
        alert('Escolha apenas dois campos');
    */ 
}
