<template >

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card mt-5">
                    <div class="card-header text-center"><h1>Login</h1></div>
                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">
                            <input type="hidden" name="_token" :value="csrf_token">
                            <div class="form-group row justify-content-center mt-4">
                                <div class="col-md-9">
                                    <input placeholder="Email" id="email" type="email" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none" name="email" value="" required autocomplete="email" autofocus v-model="email">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-9">
                                    <input placeholder="Senha" id="password" type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none" name="password" required autocomplete="current-password" v-model="password">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-9">
                                    <a class="btn btn-link" @click="resetPassword">
                                        Esqueci a senha
                                    </a>
                                </div>
                            </div>

                            <div class="form-group row mb-3 mt-5">
                                <div class="col-md-9 offset-md-4">
                                    <button type="submit" class="btn btn-lg btn-primary rounded-pill">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['csrf_token'], //data (semelhante)
        data() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            resetPassword(){
                let url = 'http://localhost:8000/password/reset'
                window.location.href = url;
            },
            login(e) {

                let url = 'http://localhost:8000/api/login'
                let configuracao = {
                    method: 'post',
                    body: new URLSearchParams({
                        'email': this.email,
                        'password': this.password
                    })
                }

                fetch(url, configuracao)
                    .then(response => response.json())
                    .then(data => {
                        if(data.token) {
                            document.cookie = 'token='+data.token+';SameSite=Lax'
                        }
                        //dar sequência no envio do form de autenticação por sessão
                        e.target.submit()
                    })
            }
        }
    }
</script>
