<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile widget -->
                <div class="bg-white shadow rounded overflow-hidden">
                    <div class="px-4 pt-0 pb-4 bg-dark">
                        <div class="media align-items-end profile-header">
                            <div class="profile mr-3"></div>
                            <div class="media-body mb-5 text-white">
                                <h4 class="mt-0 mb-0">{{user.name}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 px-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0">Veículos cadastrados</h5>
                        </div>
                        <div class="row">
                            <h5 class="ml-5" v-if="veiculos.data[0].user_id != user.id">Sem veículos cadastrados</h5>
                            <div class="col mb-3" v-for="veiculo in veiculos.data" v-if="veiculo.user_id == user.id">
                                <div class="card shadow-sm">
                                    <img :src="'/storage/'+veiculo.imagem" class="card-img-top img-thumbnail " :style="styles">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">{{veiculo.marca + ' ' + veiculo.modelo + ' ' + veiculo.ano}}</h5>
                                        <p class="card-text">{{'Proprietário: ' + veiculo.user.name}}</p>
                                        <a href="#" class="btn btn-primary" @click="redirect(veiculo.id)">Visitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <paginate-component v-if="veiculos.data[0].user_id == user.id">
                                <li v-for="l, key in veiculos.links" :key="key" class="page-item" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                    <a class="page-link" href="#" v-html="l.label"></a>
                                </li>
                            </paginate-component>
                        </div>
                        <div class="py-4">
                            
                        </div>
                    </div>
                </div><!-- End profile widget -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                styles: {
                    width: '100%',
                    height: '150px',
                    'object-fit': 'cover',
                },
                urlBase: 'http://localhost:8000/api/v1/veiculo/',
                urlUser: 'http://localhost:8000/api/v1/me',
                veiculos: { data: [] },
                user: {},
            }
        },
        methods:{
            getVeiculos(){
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                axios.get(url)
                    .then(response => {
                        this.veiculos = response.data
                    })
                    .catch(errors => {
                        console.log('ERRO Get')
                    })
                },
                getUser(){
                let url = this.urlUser
                axios.get(url)
                    .then(response => {
                        this.user = response.data
                    })
                    .catch(errors => {
                        console.log('ERRO Get')
                    })
                },
                redirect(data){
                window.location.href = 'http://localhost:8000/veiculo/' + data
            },
        },
        mounted() {
            this.getVeiculos()
            this.getUser()
        }
    }
</script>
