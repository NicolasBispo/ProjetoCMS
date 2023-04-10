// Selecione todas as `nav-link` e adicione um evento de clique a cada uma
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        // Obtenha o `id` do `nav-link` clicado
        const id = link.getAttribute('id');

        // Atualize o conteúdo de `main` com base no `id`
        updateMainContent(id);
    });
});


function updateMainContent(id) {
    // Selecione o elemento `main` e atualize seu conteúdo com base no `id`
    const main = document.querySelector('main');
    switch (id) {
        case 'posts':
            ajax_requests('exibir_posts', "");
            break;

        case 'usuarios':
            main.innerHTML = `
         <div id="users-content" class="animate-fade-in">
             <h2>Meus Usuários</h2>
             <p>Aqui está o conteúdo dos meus usuários.</p>
         </div>
     `;
            break;
        default:
            main.innerHTML = '';
    }
}

function ajax_requests(request_name, parametro) {
    const main = document.querySelector('main');
    if (request_name == "exibir_posts") {

        $.ajax({
            url: './PHP_API/admin_area_process.php',
            method: 'POST',
            dataType: "json",
            data: {
                action: "getPosts"
            },
            success: function (response) {
                atualizarPosts(main, response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
    if (request_name == 'delete_post') {
        $.ajax({
            url: './PHP_API/admin_area_process.php',
            method: 'POST',
            dataType: "json",
            data: {
                action: "deletePost",
                id: parametro
            },
            success: function (response) {
                console.log("resultado do response" + response.success + response.message);
                if (response.success == true) {
                    ajax_requests('exibir_posts', "");
                    console.log("ajax requests_exibir_posts executado");
                }
                else if (response.success == false) {
                    console.log("Erro");
                }

            },
            error: function (response) {
                console.log(response);
            }
        });
    }
    if (request_name == 'edit_post') {
        $.ajax({
            url: './PHP_API/admin_area_process.php',
            method: 'POST',
            dataType: "json",
            data: {
                action: "editarPost",
                id: parametro
            },
            success: function (response) {
                console.log("resultado do response" + response.data + response.message);

                if (response.data == false) {
                    console.log("Erro");
                }
                else {
                    console.log("Resultado:" + response.data);
                    exibirFormularioEdicaoPost(main, response.data);
                }

            },
            error: function (response) {
                console.log("Erro na resposta do request: " + response);
            }
        });
    }
}

function atualizarPosts(main, response) {
    // Limpar o conteúdo atual de `main`
    main.innerHTML = '';


    const div_container = document.createElement('div');
    div_container.classList.add('animate-fade-in');
    div_container.classList.add('container-posts');
    const div_identificacao = document.createElement('div');
    div_identificacao.classList.add('linha');
    const div_identificacao_id = document.createElement('div');
    const div_identificacao__categoria = document.createElement('div');
    const div_identificacao_titulo = document.createElement('div');
    const div_identificacao_texto = document.createElement('div');
    const div_identificacao_imagem = document.createElement('div');
    const div_identificacao_idcriador = document.createElement('div');
    const div_identificacao_horarioCriacao = document.createElement('div');

    div_identificacao_id.classList.add('col');
    div_identificacao__categoria.classList.add('col');
    div_identificacao_titulo.classList.add('col');
    div_identificacao_idcriador.classList.add('col');
    div_identificacao_horarioCriacao.classList.add('col');

    div_identificacao_id.innerHTML = "Posts";
    div_identificacao__categoria.innerHTML = "Categoria";
    div_identificacao_titulo.innerHTML = "Titulo";
    div_identificacao_texto.innerHTML = "Texto";
    div_identificacao_imagem.innerHTML = "Imagem";
    div_identificacao_idcriador.innerHTML = "Id criador";
    div_identificacao_horarioCriacao.innerHTML = "Horário publicação";

    div_identificacao.appendChild(div_identificacao_id);
    div_identificacao.appendChild(div_identificacao__categoria);
    div_identificacao.appendChild(div_identificacao_titulo);
    div_identificacao.appendChild(div_identificacao_idcriador);
    div_identificacao.appendChild(div_identificacao_horarioCriacao);

    div_container.appendChild(div_identificacao);
    // Iterar sobre os objetos e criar um elemento `li` para cada post
    $.each(response.data, function (index, post) {

        const div_row = document.createElement('div');
        const div_col_id = document.createElement('div');
        const div_col_categoria = document.createElement('div');
        const div_col_titulo = document.createElement('div');
        const div_col_texto = document.createElement('div');
        const div_col_imagem = document.createElement('div');
        const div_col_idcriador = document.createElement('div');
        const div_col_horarioCriacao = document.createElement('div');

        const div_col_ferramentas = document.createElement('div');
        const div_sub_col_ferramentas_ver = document.createElement('button');
        const div_sub_col_ferramentas_editar = document.createElement('button');
        const div_sub_col_ferramentas_excluir = document.createElement('button');




        //Adiciona uma linha a tabela
        div_row.classList.add('linha');
        div_row.id = post.id;

        //Adiciona uma coluna para cada elemento da tabela
        div_col_id.classList.add('col');
        div_col_categoria.classList.add('col');
        div_col_titulo.classList.add('col');
        div_col_texto.classList.add('col');
        div_col_imagem.classList.add('col');
        div_col_idcriador.classList.add('col');
        div_col_horarioCriacao.classList.add('col');
        div_col_ferramentas.classList.add('col');


        //Configurando a barra de ferramentas por post
        //Configurando a função de visualizar o post
        div_sub_col_ferramentas_ver.classList.add('ferramentas');
        div_sub_col_ferramentas_ver.classList.add('ferramentas-ver');
        div_sub_col_ferramentas_ver.innerHTML = "Ver";
        div_sub_col_ferramentas_ver.addEventListener('click', () => {
            let url = './posts/' + post.id + '/' + post.url_slug;
            window.open(url);
        })

        //configurando a função de editar post
        div_sub_col_ferramentas_editar.classList.add('ferramentas');
        div_sub_col_ferramentas_editar.classList.add('ferramentas-editar');
        div_sub_col_ferramentas_editar.innerHTML = "Editar";
        div_sub_col_ferramentas_editar.addEventListener('click', () => {
            ajax_requests('edit_post', div_row.id)
        })

        //Configurando a função de excluir post
        div_sub_col_ferramentas_excluir.classList.add('ferramentas');
        div_sub_col_ferramentas_excluir.classList.add('ferramentas-excluir');
        div_sub_col_ferramentas_excluir.innerHTML = 'Excluir';
        div_sub_col_ferramentas_excluir.addEventListener('click', () => {
            ajax_requests('delete_post', div_row.id);

        })


        //Anexando todas as divs a div responsavel pelas ferramentas
        div_col_ferramentas.appendChild(div_sub_col_ferramentas_ver);
        div_col_ferramentas.appendChild(div_sub_col_ferramentas_editar);
        div_col_ferramentas.appendChild(div_sub_col_ferramentas_excluir);

        //Inserindo o valor de cada post nas divs geradas
        div_col_id.innerHTML = post.id;
        div_col_categoria.innerHTML = post.categoria_post;
        div_col_titulo.innerHTML = post.titulo;
        div_col_texto.innerHTML = post.texto_post;
        div_col_imagem.innerHTML = post.imagem_destaque;
        div_col_idcriador.innerHTML = post.id_criador_post;
        div_col_horarioCriacao.innerHTML = post.horario_post;


        //Adicionando a linha atual as colunas geradas
        div_row.appendChild(div_col_id);
        div_row.appendChild(div_col_categoria);
        div_row.appendChild(div_col_titulo);
        //Comentado pois nao tenho interesse em exibir esse campo //div_row.appendChild(div_col_texto);
        // div_row.appendChild(div_col_imagem);
        div_row.appendChild(div_col_idcriador);
        div_row.appendChild(div_col_horarioCriacao);
        div_row.appendChild(div_col_ferramentas);

        div_container.appendChild(div_row);
    });

    main.appendChild(div_container);

}

function exibirFormularioEdicaoPost(main, post) {

    main.innerHTML = '';
    const form = document.createElement('form');

    const linha1 = document.createElement('div'); //categoria e criador horarioCriacao
    const linha1_col1 = document.createElement('div');
    const linha1_col2 = document.createElement('div');


    const linha2 = document.createElement('div'); //titulo
    const linha3 = document.createElement('div'); //texto
    const linha4 = document.createElement('div');
    const submitBtn = document.createElement('button');

    //Adicionando classes
    form.classList.add('form-edicao');

    linha1.classList.add('linhas');
    linha1.classList.add('linha1');

    linha2.classList.add('linhas');
    linha2.classList.add('linha2');

    linha3.classList.add('linhas');
    linha3.classList.add('linha3');

    linha4.classList.add('linhas');
    linha4.classList.add('linha4');

    //Criando todas labels
    const label_categoria = document.createElement('h5');
    const label_titulo = document.createElement('h5');
    const label_texto = document.createElement('h5');
    const label_criador = document.createElement('h5');
    const label_horariocriacao = document.createElement('h5');

    //Criando todos inputs
    const input_categoria = document.createElement('input');
    const input_titulo = document.createElement('input');
    const input_texto = document.createElement('textarea');
    const input_criador = document.createElement('input');
    const input_horarioCriacao = document.createElement('input');
    input_categoria.type = "text";
    input_titulo.type = "text";
    input_texto.type = "text";
    input_criador.type = "text";
    input_horarioCriacao.type = "text";

    //atribuindo um "for" a todas labels
    //label_categoria.htmlFor = "input_categoria";
    label_titulo.htmlFor = "input_titulo";
    label_texto.htmlFor = "input_texto";
    label_criador.htmlFor = "input_criador";
    label_horariocriacao.htmlFor = "input_horarioCriacao";

    //Atribundo um valor html a todos labels
    label_categoria.innerHTML = "Categoria post";
    label_titulo.innerHTML = "Titulo post";
    label_texto.innerHTML = "Texto do post";
    label_criador.innerHTML = "Criador do post"
    label_horariocriacao.innerHTML = "Horário de publicação";

    //Atribuindo um ID ao textarea
    input_texto.id = "texto_post";

    //Atribuindo um "name" a todos inputs
    input_categoria.name = "input_categoria";
    input_titulo.name = "input_titulo";
    input_texto.name = "input_texto";
    input_criador.name = "input_criador";
    input_horarioCriacao.name = "input_horarioCriacao";

    //Atribuindo um valor html a todos inputs
    input_categoria.value = post.categoria_post;
    input_titulo.value = post.titulo;
    input_texto.value = post.texto_post;
    input_criador.value = post.id_criador_post;
    input_horarioCriacao.value = post.horario_post;

    //Adicionando valor html ao botao de submit
    submitBtn.innerHTML = "Salvar";

    //Adicionando categoria a col1 da linha1
    linha1_col1.appendChild(label_categoria);
    linha1_col1.appendChild(input_categoria);

    //Adicionando horarioCriacao a col2 da linha1
    linha1_col2.appendChild(label_horariocriacao);
    linha1_col2.appendChild(input_horarioCriacao);

    //Adicionando col1 e col2 a linha 1
    linha1.appendChild(linha1_col1);
    linha1.appendChild(linha1_col2);

    //Adicionando a linha2 valores titulo
    linha2.appendChild(label_titulo);
    linha2.appendChild(input_titulo);

    //Adicionando a linha3 valores horarioCriacao
    linha3.appendChild(label_texto);
    linha3.appendChild(input_texto);

    //Adicionando criador a linha 4
    linha4.appendChild(label_criador);
    linha4.appendChild(input_criador);

    //Adicionando todos valores ao form
    form.appendChild(linha1);
    form.appendChild(linha2);
    form.appendChild(linha3);
    form.appendChild(linha4);
    form.appendChild(submitBtn);

    main.appendChild(form);

    //Ativando o Editor de texto
    ClassicEditor
        .create(document.querySelector('#texto_post'), {
            // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.
            language: 'pt-br'
        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
}