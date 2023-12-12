<template>
    
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-9 mt-4">
            
            <alert-component tipo="success" mensagem="Postado com sucesso!" v-if="alerta == 'sucesso'"> </alert-component>
            <alert-component tipo="danger" :mensagem="mensagemErro['titulo'][0]" v-if="alerta == 'erro' && mensagemErro['titulo'] !== undefined"> </alert-component>
            <alert-component tipo="danger" :mensagem="mensagemErro['texto'][0]" v-if="alerta == 'erro' && mensagemErro['texto'] !== undefined"> </alert-component>


            
            <div class="input-group-lg mt-2">
                <label class="form-label fs-4" for="titulo"> Título do post </label>
                <input v-model="titulo" id="titulo" type="text" class="form-control" placeholder="Insira o título do post aqui...">        
            </div>
        
            <div class="input-group-lg mt-3">
                <label class="form-label fs-4" for="texto"> Texto do post </label>
                <textarea v-model="texto" id="texto" type="text" class="form-control" rows="5" placeholder="Insira o texto do post aqui..."></textarea>
            </div>

            <div class="mt-3">
                <label for="arquivo" class="form-label fs-4">Inserir imagem</label>
                <input class="form-control" type="file" id="arquivo" @change="previewImagem($event); carregarImagem($event)">                   
            </div>

            <div class="mt-3">
                <img v-if="previewUrl" v-bind:class="previewUrl" v-bind:src="previewUrl" alt="Pré-visualizar" widht="200px" height="200px">
            </div>

            <div class="mt-3">
                <button type="submit" style="float: right;" class="btn btn-primary btn-lg" @click="salvar()">Postar</button>
            </div>
            
                
            
        </div>
    
    </div>
    
</template>

<script>
    export default {
        
        data() {
            return {
                previewUrl: null,
                titulo: '',
                texto: '',
                arquivoImagem: '', //array responsável por armazenar a imagem
                url: 'http://localhost:8000/api/v1/post',
                alerta: '',
                mensagemErro: ''
            }
        },
        methods: {
            previewImagem(event) { //Mostrar a imagem caso seja anexada
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    this.previewUrl = null;
                }
            },
            
            carregarImagem(e) { 
                this.arquivoImagem = e.target.files[0];             
            },

            salvar() {
                
                //definindo os inputs da request
                let formData = new FormData();
                formData.append('titulo', this.titulo);
                formData.append('texto', this.texto);
                formData.append('up', 0);
                                    
                if(this.arquivoImagem) {
                    formData.append('imagem', this.arquivoImagem);
                }

                //headers
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }


                axios.post(this.url, formData, config)
                    .then(response => {
                        //ZERANDO CAMPOS PARA POSTERIOR POSTAGEM
                        this.alerta = 'sucesso';
                        this.titulo = '';
                        this.texto = '';
                        this.previewUrl = null;

                        
                    })
                    .catch(errors => {
                        if(errors.response.status === 401) { 
                            alert('Sessão expirada, faça login novamente para criar um post');
                        }
                        this.alerta = 'erro';
                        this.mensagemErro = errors.response.data.errors
                        console.log(errors.response.data.errors);
                    })
            }            
        }
    }
</script>
