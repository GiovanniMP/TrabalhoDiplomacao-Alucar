<template>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col mb-3" v-for="veiculo in veiculos.data">
                <div class="card shadow-sm " >
                    <img :src="'/storage/'+veiculo.imagem" class="card-img-top img-thumbnail " :style="styles" >
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{veiculo.marca + ' ' + veiculo.modelo + ' ' + veiculo.ano}}</h5>
                        <p class="card-text">{{'Proprietário: ' + veiculo.user.name}}</p>
                        <a href="#" class="btn btn-primary" @click="redirect(veiculo.id)">Visitar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <paginate-component v-if="veiculos.data">
                <li v-for="l, key in veiculos.links" :key="key" class="page-item" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                    <a class="page-link" href="#" v-html="l.label"></a>
                </li>
            </paginate-component>
        </div>
    </div>
</template>

<script>

export default{
        data(){
            return{
                styles: {
                    width: '100%',
                    height: '150px',
                    'object-fit': 'cover',
                },
                urlBase: 'http://localhost:8000/api/v1/veiculo',
                urlPaginacao: '',
                urlFiltro: '',
                veiculos: { data: [] },
            }
        },
        methods:{
            redirect(data){
                window.location.href = 'http://localhost:8000/veiculo/' + data
            },
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
            paginacao(l){
                if(l.url){
                    this.urlPaginacao = l.url.split('?')[1]
                    this.getVeiculos()
                }
            },
        },
        mounted(){
            this.getVeiculos()
        }
}

</script>
