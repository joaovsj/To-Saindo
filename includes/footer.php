<script>
    // variaveis
    const btn = document.querySelector('#btn');
    const btnSearch = document.querySelector('.bx-search');
    const sidebar = document.querySelector('.sidebar');
    const home = document.querySelector('.homeContent');

    //eventos de escuta
    btn.addEventListener('click', () => {
        sidebar.classList.toggle('active')
        home.classList.toggle('active')
    });

    btnSearch.addEventListener('click', () => {
        sidebar.classList.toggle('active')
        home.classList.toggle('active')
    });


</script>

</body>
</html>