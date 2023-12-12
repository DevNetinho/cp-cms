<template>
    
    <div class="row d-flex justify-content-center align-items-center h-100">
        <alert-component tipo="danger" mensagem="Conteúdo pesquisado não foi encontrado!" v-if="alerta == 'erro'" style="width: 98%"> </alert-component>

        <div class="mt-2">
            <pesquisar-component> 
                <template v-slot:conteudo>
                    <!-- CONTEÚDO DA BARRA DE PESQUISA -->
                    <input class="form-control me-2" type="search" placeholder="Pesquisar postagem..." aria-label="Search" v-model="pesquisaInput" @keyup.enter="pesquisarPost()" style="width: 30%" maxlength="100">
                    <button class="btn btn-primary" type="submit" @click="pesquisarPost()">Pesquisar</button>
                    <div class="ms-4 mt-2">
                        <img class="ponteiro" title="Atualizar lista" src="../../images/refresh.png" width="20px" height="20px" @click="carregarCard()">
                    </div>

                </template>
            </pesquisar-component>
            </div>
        <div class="col-9 mt-4">
            <div class="card mb-5" v-for="post in posts" :key="post.id">
                
                <!-- MUDAR COMPORTAMENTO DO CARD-BODY, COM BASE NA ACÃO QUE O MESMO TERÁ -->
                <div :class="{ 'card-body': acao === 'padrao', 'card-body card-hover ponteiro': acao === 'editar'  }">
                    <h5 class="card-title">{{ post.titulo }}</h5>
                    <p class="card-text">{{ post.texto }}</p>                    
                    <img v-if="post.imagem" :src="'/storage/' + post.imagem" width="200" height="200">                    
                </div>
                <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                                        
                                        
                    <div class="text-right">
                        Data do post: <strong> {{ dataFormatada(post.created_at) }} </strong>
                    </div>
                    
                    <div v-if="acao === 'editar'" class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-secondary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#modalEditarRemover" @click="titulo = 'Editar post', tipo = 'editar', postagem = post"> Editar</button>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#modalEditarRemover" @click="titulo = 'Remover post', tipo = 'remover', postagem = post"> Remover </button>
                    </div>
                </div>
            </div>


            <!-- MODAL PARA EDIÇÃO OU REMOÇÃO DE POSTS -->
            <modal-component :titulo="titulo">
                <template v-slot:conteudo> 
                    <!-- <alert-component tipo="success" mensagem="Campos atualizados com sucesso!" v-if="alerta == 'sucesso'"> </alert-component>                     -->
                    <alert-component tipo="danger" :mensagem="mensagemErro['titulo'][0]" v-if="alerta == 'erro' && mensagemErro['titulo'] !== undefined"> </alert-component>
                    <alert-component tipo="danger" :mensagem="mensagemErro['texto'][0]" v-if="alerta == 'erro' && mensagemErro['texto'] !== undefined"> </alert-component>
                    
                    <p v-if="tipo === 'remover'" class="fs-5"> Tem certeza que deseja remover este post?</p>                  

                    <div v-if="tipo === 'editar'" @focusout="carregarCard(), alerta = ''">
                        <div class="form-group">
                            <div class="mt-2">
                                <label for="titulo"> Título do post </label>
                                <input v-model="postagem.titulo" id="titulo" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mt-2">
                                <label for="titulo"> Texto </label>
                                <textarea v-model="postagem.texto" id="texto" type="text" rows="10" class="form-control" > </textarea>
                            </div>
                        </div>

                    </div>
                </template>


                <!-- BOTÕES DO MODAL -->
                <template v-slot:footer>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="carregarCard()">Fechar</button>
                    
                    <button v-if="tipo === 'editar'" type="button" class="btn btn-success" @click="editarPost()">Salvar</button>

                    <button v-if="tipo === 'remover'" type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="removerPost()">Remover</button>

                </template>

            </modal-component>


        </div>
    
        <template> 
            <paginate-component>
                <li v-for="(item, index) in p.links" :key="index" :class="item.active ? 'page-item active' : 'page-item'">
                    <a class="page-link" href="#"  v-html="item.label" @click="paginacao(item.url)">                 
                    </a>
                </li>
                   

            </paginate-component>
        </template>
        

    </div>
    
</template>

<script>

    export default {  
        props: ['acao'],

        mounted() {
            
            this.carregarCard();
        },
        data() {
            return {
                postagem: '', //ARMAZENA O POST QUE O USER CLICOU
                titulo: '',
                tipo: '',                
                url: 'http://localhost:8000/api/v1/post',
                urlPesquisa: '',
                pesquisaInput: '',
                urlPagina: '',
                posts: {},
                imagem: false,
                p: '',
                arquivoImagem: '',
                alerta: '',
                mensagemErro: {},
                arquivo: '',
                alerta: ''

            }
        },
        methods: {           

            carregarCard() {
                
                this.alerta = ''
                let url = this.url + '?' + this.urlPagina;               

                axios.get(url)
                    .then(response => {
                        this.posts = response.data.data;
                        this.p = response.data;

                        this.posts.forEach(element => { //ADICIONAR UMA CHAVE DE VALOR FALSE PARA MANIPULARMOS OS UPS QUANDO O USUÁRIO INTERAGIR.
                            this.$set(element, 'upCheck', false);                            
                        });
                        
                        
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },

            dataFormatada(date) { //FUNÇÃO PARA FORMATAR AS DATAS
                date = date.split('T');
                let nova_data = date[0].split('-');
                return nova_data[2] + '/' + nova_data[1] + '/' + nova_data[0];

            },
            
            paginacao(url) {
                if(url) {
                    this.urlPagina = url.split('?')[1];
                    this.carregarCard();
                }
            },

            editarPost() {               
                let url = this.url + '/' + this.postagem.id;
                
                let formData = new FormData();
                formData.append('titulo', this.postagem.titulo);
                formData.append('texto', this.postagem.texto);
                formData.append('_method', 'patch');
                
                if (this.arquivoImagem) {
                    formData.append('imagem', this.arquivoImagem);
                }

                let config = {
                    headers: {
                        'Content-Type': 'application/json'
                        //TOKEN INSERIDO POR MEIO DOS INTERCEPTORS DO AXIOS NO ARQUIVO bootstrap.js
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        
                        this.alerta = 'sucesso'
                        alert('Post editado com sucesso!')
                    })
                    .catch(errors => {
                        
                        if(errors.response.status === 401) {
                            
                            alert('Sessão expirada, faça login novamente para editar');
                        }
                        this.alerta = 'erro'
                        this.mensagemErro = errors.response.data.errors

                    })

                this.carregarCard();

            },

            removerPost() { //REMOVER POST
                let url = this.url + '/' + this.postagem.id;
                
                
                let config = {
                    headers: {
                        'Content-Type': 'application/json'        
                    }
                }

                axios.delete(url, config)
                    .then(response => {
                        
                    })
                    .catch(errors => {
                        if(errors.response.status === 401) {
                            
                            alert('Sessão expirada, faça login novamente para remover o post');
                        }
                        
                    })
                this.carregarCard();

            },

            carregarImagem(e) { //recupera arquivo de imagem
                this.arquivoImagem = e.target.files[0];            
            },

            pesquisarPost() {
                if(this.pesquisaInput == '') {
                    return this.carregarCard();
                    
                }
                this.urlPesquisa = this.url + '/pesquisar/' + this.pesquisaInput;
                                
                

                let config = {
                    headers: {
                        'Content-Type': 'application/json'                        
                    }
                }

                //ELABORAR UM CARREGAMENTO DOS CARDS DE ACORDO COM A PALAVRA PESQUISADA;
                axios.get(this.urlPesquisa, config)
                    .then(response => {
                                              
                        this.posts = response.data.data; // PASSANDO OS POSTS RETORNADOS NA PESQUISA
                        this.p = response.data
                    })                    
                    .catch(errors => {
                        this.alerta = 'erro';
                        console.log(errors);
                    })

                
                //ARRUMAR UMA FORMA DE DAR UMA MENSAGEM NA VIEW CASO A PALAVRA PESQUISADA NÃO SEJA ENCONTRADA NOS REGISTROS;

                //ELABORAR UMA FORMA DE VOLTAR A EXIBIR TODOS OS REGISTROS CASO O USUÁRIO DEIXE DE USAR O CAMPO DE PESQUISA.



            }


            
        }
    }
</script>
