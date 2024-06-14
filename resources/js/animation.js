
const btnAdd = document.getElementById("add");
const main = document.getElementById('formCurso');

btnAdd.addEventListener('click', () => {
    main.classList.toggle("visible");
});

function submitForm(){
    let form = document.getElementById('RemoveCourses');
    form.submit();
}

    