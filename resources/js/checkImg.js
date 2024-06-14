
    const input = document.getElementById('arquivo');
    const contImage = document.getElementById('contImg');

    input.addEventListener('click', () => {

        if(input.value != null){
            contImage.style.backgroundColor = "#ff2d75";     
        }
    });
