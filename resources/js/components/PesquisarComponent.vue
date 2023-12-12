<template>
    
    <div class="d-flex"> 
        <slot name="conteudo"> 
        </slot>        
    </div>


</template>

<script>
    export default {
        
        data() {
            return {
                url: 'http://localhost:8000/api/v1/post/pesquisar/',
                pesquisaInput: ''
            }
        },

        methods: {
            pesquisarPost() {
                if(this.pesquisaInput == '') {
                    return alert('Insira algum dado a ser pesquisado!');
                }
                // const token = document.cookie.split(';')[1].split('=')[1];
                let urlPesquisa = this.url + this.pesquisaInput;

                let config = {
                    headers: {
                        'Content-Type': 'application/json'                        
                    }
                }

                //ELABORAR UM CARREGAMENTO DOS CARDS DE ACORDO COM A PALAVRA PESQUISADA;
                axios.get(urlPesquisa, config)
                    .then(response => {
                        this.posts = response.data; // PASSANDO OS POSTS DA PESQUISA VIA PROPS
                        console.log(response.data)
                    })                    
                    .catch(errors => {
                        console.log(errors)
                    })

                
                //ARRUMAR UMA FORMA DE DAR UMA MENSAGEM NA VIEW CASO A PALAVRA PESQUISADA NÃO SEJA ENCONTRADA NOS REGISTROS;

                //ELABORAR UMA FORMA DE VOLTAR A EXIBIR TODOS OS REGISTROS CASO O USUÁRIO DEIXE DE USAR O CAMPO DE PESQUISA.


            }
        }
    }
</script>
