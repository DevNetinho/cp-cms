<template>
    <div>
        <alert-component tipo="danger" :mensagem="mensagemErro" v-if="alerta == 'erro'"></alert-component>        

        <div class="mt-2">
            <p v-if="acao === 'user'">Usuário atual: <strong>{{ user }}</strong></p>
            <label for="input"> {{ mensagem.label }} </label>
            <input id="input" v-model="input" :type="acao === 'password' ? 'password' : 'text'" class="form-control" :placeholder="mensagem.placeholder">        

        </div>

        <div v-if="acao === 'password'" class="mt-2">
            <label for="inputConfirm"> Insira a senha novamente: </label>
            <input id="inputConfirm" v-model="inputConfirm" :type="acao === 'password' ? 'password' : 'text'" class="form-control" :placeholder="mensagem.placeholder">        
        </div>

        <div class="mt-3">
            <button class="btn btn-success" style="float: right;" @click="salvar(acao)"> Salvar </button>           

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.verificarAcao();
        },
        props: ['acao', 'user'],
        data() {
            return {
                url: 'http://localhost:8000/api/v1/',
                input: '',
                mensagem: {                    
                    label: '',
                    placeholder: ''
                },
                inputConfirm: '',
                alerta: '',
                mensagemErro: ''
                
            }
        },

        methods: {
            verificarAcao() { //ALTERA AS MENSAGENS DE ACORDO COM A AÇÃO ESCOLHIDA
                if(this.acao === 'password') {
                    this.mensagem.label = 'Insira sua nova senha abaixo:';
                    this.mensagem.placeholder = 'Inserir senha...';

                } else if(this.acao === 'user') {
                    this.mensagem.label = 'Insira um novo nome de usuário abaixo:';
                    this.mensagem.placeholder = 'Inserir usuário...';

                } else if(this.acao === 'email') {
                    this.mensagem.label = 'Insira um novo email abaixo: ';
                    this.mensagem.placeholder = 'Inserir email...';

                }
            },

            salvar(acao) {
                let url = '';
                let campo = '';
                let aviso = '';

                if (acao === 'password') {
                    if (this.input === this.inputConfirm) { //VERIFICAÇÃO DOS CAMPOS DE SENHA
                        url = this.url + 'alterar-senha';
                        campo = 'senha';
                        aviso = alert('Senha alterada com sucesso!');  
                    } else {
                        this.mensagemErro = 'Senhas não coincidem'
                        this.alerta = 'erro';
                        return console.log('Senhas não coincidem');
                    }
                    
                } else if (acao === 'user') {
                    url = this.url + 'alterar-usuario';
                    campo = 'nome';
                    aviso = alert('Nome de usuário alterado com sucesso!');
                    
                }

                let token = document.cookie.split(';')[1].split('=')[1]; //RECUPERAÇÃO DO TOKEN PARA ACESSO A API
                

                

                let formData = new FormData();
                formData.append(campo, this.input);

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                }


                axios.post(url, formData, config)
                    .then(response => {
                        console.log(response.data);
                        aviso;
                        location.reload();
                        
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
            
        }
    }
</script>
