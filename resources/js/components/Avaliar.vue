<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h4">Avalie este veículo</div>
                        
                    <div class="card-body">
                        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Avaliação cadastrada com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a avaliação" v-if="transacaoStatus == 'Erro'"></alert-component>
                        <star-rating :star-size="30" v-model="avaliacao.nota"></star-rating>
                        <div class="form-group">
                            <label class="mt-3" for="Textarea1">Escreva um comentário</label>
                            <textarea v-model="avaliacao.comentario" class="form-control" id="Textarea1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" @click="salvar()">Avaliar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';

    export default {
        components: {
            StarRating
        },
        data(){
            return {
                urlBase: 'http://localhost:8000/api/v1/avaliacao',
                avaliacao: {nota: '', comentario: ''},
                transacaoDetalhes: '',
                transacaoStatus: '',
                id: window.location.href.split('/').pop(),
            }
        },
        methods:{
            salvar() {
                let formData = new FormData();
                formData.append('avaliacao', this.avaliacao.nota)
                formData.append('comentario', this.avaliacao.comentario)
                formData.append('veiculo_id', this.id)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'Adicionado'

                    })
                    .catch(errors => {
                        this.transacaoStatus = 'Erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            data: errors.response.data.errors
                        }
                    })
            },
            remover(){
                let url = this.urlBase + '/' + this.id
                let formData = new FormData();
                formData.append('_method', 'delete')

                axios.post(url, formData)
                    .then(response => {

                    })
            },
        }
    }
</script>
