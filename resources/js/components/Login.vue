<template>
        <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <div v-if="erro == 1" class="alert alert-danger" role="alert">
                        Email ou senha inválidos
                    </div>

                    <form method="POST" action="" @submit.prevent="login($event)">
                        <!-- input hidden para o armazenamento do nosso token csrf -->
                        <input type="hidden" name="_token" :value="token_csrf">
                        
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus v-model="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="password" >

                            </div>
                        </div>                        

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                
                                <slot name="reset"> </slot>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       props: ['token_csrf'], //RECUPERANDO O CSRF TOKEN E PASSANDO PARA UM INPUT HIDDEN PARA AO FUNCIONAMENTO DO NOSSO FORM
       data() {
           return {
               email: '',
               password: '',
               erro: 0
           }
       },

       methods: {
            login(e) {
                
                //parâmetros necessários para fazermos uma request com o VueJs para obtermos o token jwt
                let url = 'http://localhost:8000/api/login'

                let configuracao = {
                    method: 'post',
                    body: new URLSearchParams({
                        'email' : this.email,
                        'password' : this.password                        
                    })
                }
                                
                fetch(url, configuracao)
                    .then(response => {
                        if(!response.ok) { //DISPARAR O ERRO, CASO A AUTENTICAÇÃO ESTEJA INCORRETA                
                            return this.erro = 1
                        }
                        this.erro = 0
                        return response.json()
                    })
                    .then(data => {
                        if(this.erro !== 1) {
                            console.log(data.token)
                            if(data.token) { //GUARDAR UM COOKIE COM O TOKEN, CASO OCORRA TUDO BEM NA AUTENTICAÇÃO
                                document.cookie =  'token=' + data.token + ';SameSite=Lax';
                            }
                            e.target.submit(); //ENVIANDO FORMULÁRIO PARA DAR CONTINUIDADE PARA O LOGIN
                        }
                    })
            }
        }

    }
</script>
