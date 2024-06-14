

window.addEventListener('load', atualizar);
window.addEventListener('scroll', atualizar);


function atualizar(e = undefined) {
    e.preventDefault();

    const elements = document.querySelectorAll('article');
    console.log(elements);

    elements.forEach((element) => {
        
        var altura = element.offsetTop + 300;

        if(altura < (window.scrollY + window.innerHeight)){
            element.classList.add('visible');
        }
    });

    //elements.forEach((element) => {
    //     if(element.offsetTop < (window.scrollY + window.innerHeight)){
    //         element.classList.add('visible');
    //     }
    // });
}

atualizar();