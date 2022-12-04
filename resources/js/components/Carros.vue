<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Veículo cadastrado com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o veículo" v-if="transacaoStatus == 'Erro'"></alert-component>
                <card-component titulo="Cadastre seu Veículos" class="text-center h4">
                    <template v-slot:conteudo>
                        <div class="form-group">
                                <input type="number" class="form-control" id="inputAno" aria-describedby="anoHelp" placeholder="Ano do veículo" v-model="carro.ano">
                        </div>

                        <div class="form-group">
                            <select class="custom-select" v-model="selectMarca">
                                <option value="" disabled selected>Escolha uma marca</option>
                                <option v-for="marca,chaveMarca in marcas.data" :key="chaveMarca" :value="marca.nome">{{ marca.nome }}</option>
                            </select>
                        </div> 

                        <div class="form-group">
                            <select class="custom-select" v-for="modelo in modelosFiltrados" v-model="selectModelo">
                                <option value="" disabled selected>Escolha um modelo</option>
                                <option v-for="model in modelo.modelos" :value="model.nome" >{{ model.nome}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="custom-select" v-model="selectGrupo">
                                <option value="" disabled selected>Escolha um grupo</option>
                                <option v-for="grupo in grupos.data" :value="grupo.grupo" >{{ grupo.grupo}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                                <input type="text" class="form-control" id="inputChassi" aria-describedby="chassiHelp" placeholder="Informe o chassi do veículo" v-model="carro.chassi">
                        </div>

                        <div class="form-group">
                                <input type="text" class="form-control" id="inputPlaca" aria-describedby="placaHelp" placeholder="Informe a placa do veículo" v-model="carro.placa">
                        </div>

                        <div class="form-group">
                                <input type="text" class="form-control" id="inputCor" aria-describedby="corHelp" placeholder="Informe a cor do veículo" v-model="carro.cor">
                        </div>

                        <div class="input-group mt-3 mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputImagem" aria-describedby="inputImagemHelp" @change="carregarImagem($event)">
                                <label class="custom-file-label" for="inputImagem">Selecione uma imagem</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                                <input type="text" class="form-control" id="inputContato" aria-describedby="contatoHelp" placeholder="Telefone para contato" v-model="carro.telefone">
                        </div>
                            
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-lg rounded-pill btn-primary" @click="salvar()">Cadastrar</button>
                    </template>
                </card-component>
            </div>
        </div>
    </div>

</template>

<script>
    export default{
        data(){
            return {
            urlBase: 'http://localhost:8000/api/v1/marca',
            urlVeiculo: 'http://localhost:8000/api/v1/veiculo',
            urlGrupos: 'http://localhost:8000/api/v1/grupos',
            carro: { ano: '', telefone: '', chassi: '', placa: '', cor: ''},
            grupos: { data: []},
            marcas: { data: [] },
            selectMarca: '',
            selectModelo: '',
            selectGrupo: '',
            transacaoStatus: '',
            transacaoDetalhes: {},
            arquivoImagem: [],
            }
        },
        methods:{
            salvar(){
                let marca = this.modelosFiltrados
                let motor = ''
                let transmissao = ''
                let imagemMarca = ''
                let imagemModelo = ''
                let numero_portas = ''
                let air_bag = ''
                let abs = ''
                let lugares = ''
                for(let m in marca){
                    imagemMarca = marca[m].imagem
                    for(let n in marca[m].modelos){
                        if(marca[m].modelos[n].nome == this.selectModelo){
                            imagemModelo = marca[m].modelos[n].imagem
                            numero_portas = marca[m].modelos[n].numero_portas
                            air_bag = marca[m].modelos[n].air_bag
                            abs = marca[m].modelos[n].abs
                            lugares = marca[m].modelos[n].lugares
                            motor = marca[m].modelos[n].motor
                            transmissao = marca[m].modelos[n].transmissao
                        }
                    }
                }

                let formData = new FormData();
                formData.append('ano', this.carro.ano)
                formData.append('marca', this.selectMarca)
                formData.append('modelo', this.selectModelo)
                formData.append('imagem_marca', imagemMarca)
                formData.append('imagem_modelo', imagemModelo)
                formData.append('contato', this.carro.telefone)
                formData.append('numero_portas', numero_portas)
                formData.append('motor', motor)
                formData.append('transmissao', transmissao)
                formData.append('air_bag', air_bag)
                formData.append('abs' , abs)
                formData.append('lugares', lugares)
                formData.append('grupo', this.selectGrupo)
                formData.append('chassi', this.carro.chassi)
                formData.append('placa', this.carro.placa)
                formData.append('cor', this.carro.cor)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlVeiculo, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'Adicionado'                     
                        this.transacaoDetalhes = {
                            mensagem: 'Modelo '+ response.data.modelo + ' cadastrado'
                        }
                        
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'Erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            data: errors.response.data.errors
                        }
                    })
            },
            getMarcas(){
                let url = this.urlBase
                axios.get(url)
                    .then(response => {
                        this.marcas = response.data
                    })
                    .catch(errors => {
                        console.log('ERRO Get')
                    })
                },

            getGrupos(){
            let url = this.urlGrupos
            axios.get(url)
                .then(response => {
                    this.grupos = response.data
                    console.log(this.grupos);
                })
                .catch(errors => {
                    console.log('ERRO Get')
                })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
        },
        computed: {
            modelosFiltrados(){
                return this.marcas.data.filter((obj, i) => {
                    return obj.nome === this.selectMarca
                });
            },
        },
        mounted(){
            this.getGrupos()
            this.getMarcas()
        }
    }
    
</script>