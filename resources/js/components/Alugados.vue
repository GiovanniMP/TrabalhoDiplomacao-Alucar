<template>
    <div class="container">
        <h3 class="mb-3">Seus veículos alugados</h3>
        <div class="row justify-content-center">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Preço</th>
                    <th scope="col">Data de compra</th>
                    <th scope="col">Modelo</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="alugado in alugado.data">
                        <td>{{alugado.preco}}</td>
                        <td>{{alugado.data | data}}</td>
                        <td>{{alugado.veiculo.marca + ' ' + alugado.veiculo.modelo}}</td>
                        <td><a @click="setStore(alugado.veiculo),avaliar()" class="btn btn-primary">Devolver</a></td>
                    </tr>
                </tbody>
                </table>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                urlBase: 'http://localhost:8000/api/v1/alugado',
                alugado: { data: [] },
            }
        },
        methods:{
            setStore(obj){
                this.$store.state.item = obj
            },
            getAlugados(){
                let url = this.urlBase
                axios.get(url)
                    .then(response => {
                        this.alugado = response.data
                    })
                    .catch(errors => {
                        console.log('ERRO Get')
                    })
            },
            avaliar(){
                /*let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData();
                formData.append('_method', 'delete')

                axios.post(url, formData)
                    .then(response => {
                        this.getAlugados()
                    })*/
                location.href="http://localhost:8000/avaliar/" + this.$store.state.item.id
            },
        },
        mounted() {
            this.getAlugados()
        }
    }
</script>
