<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <card-component titulo="Busca de modelos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do modelo">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                   
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do modelo">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do modelo" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                        </template>

                        <template v-slot:rodape>
                                <button type="submit" class="btn btn-primary  float-right" @click="pesquisar()">Pesquisar</button>
                        </template>
                </card-component>


                <card-component titulo="Relação de Modelos" class="mt-3" >
                    <template v-slot:conteudo >
                        <tablemodelos-component
                            :dados="modelos.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal' , dataTarget: '#modalModeloAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'text'}, 
                                nome: {titulo: 'Nome', tipo: 'text'}, 
                                imagem: {titulo: 'Imagem', tipo: 'imagem'}, 
                                marca: {titulo: 'Marca', tipo: 'obj'},
                                numero_portas: {titulo: 'Numero de Portas', tipo: 'text'},
                                lugares: {titulo: 'Lugares', tipo: 'text'},
                                motor: {titulo: 'Motor', tipo: 'text'},
                                transmissao: {titulo: 'Transmissão', tipo: 'text'},
                                air_bag: {titulo: 'Air bag', tipo: 'boolean'},
                                abs: {titulo: 'Abs', tipo: 'boolean'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                            }"
                        ></tablemodelos-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key" class="page-item" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" href="#" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary  float-right" data-toggle="modal" data-target="#modalModelo">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

            <!-- Modal de inclusao-->
            <modal-component id="modalModelo" titulo="Adicionar modelo">
                <template v-slot:alertas>
                    <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Modelo cadastrado com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                    <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'Erro'"></alert-component>
                </template>
                <template v-slot:conteudo>

                    <div class="form-group">
                        <input-container-component titulo="Id da marca do modelo" id="novoId" id-help="novoIDHelp" texto-ajuda="Informe o id da marca para este modelo">
                            <input type="number" class="form-control" id="inputID" aria-describedby="novoIDHelp" placeholder="ID da marca" v-model="Modelo.IDModelo">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo com a cilindrada do motor">
                            <input type="text" class="form-control" id="inputNome" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="Modelo.nomeModelo">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Número de portas" id="novoPortas" id-help="novoPortasHelp" texto-ajuda="Informe o número de portas">
                            <input type="number" class="form-control" id="inputPortas" aria-describedby="novoPortasHelp" placeholder="Número de portas" v-model="Modelo.NumeroPortas">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <label for="tipoMotorId">Motor</label>
                        <select class="form-control" name="tipoMotor" id="tipoMotorId" v-model="Modelo.Motor">
                            <option value="" disabled selected>Selecione o tipo de motor</option>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Etanol">Etanol</option>
                            <option value="Flex">Flex</option>
                            <option value="Elétrico">Elétrico</option>
                        </select>
                    </div>   
                        

                    <div class="form-group">
                        <label for="tipoTransmissaoId">Transmissão</label>
                        <select class="form-control" name="tipoTransmissao" id="tipoTransmissaoId" v-model="Modelo.Transmissao">
                            <option value="" disabled selected>Selecione uma transissão</option>
                            <option value="Manual">Manual</option>
                            <option value="Automático">Automático</option>
                        </select>
                    </div>
                        

                    <div class="form-group">
                        <input-container-component titulo="Número de lugares" id="novoLugares" id-help="novoLugaresHelp" texto-ajuda="Informe o número de lugares">
                            <input type="number" class="form-control" id="inputLugares" aria-describedby="novoLugaresHelp" placeholder="Número de lugares" v-model="Modelo.Lugares">
                        </input-container-component>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" v-model="Modelo.Airbag">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Possui Air bag?">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" v-model="Modelo.Abs">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Possui ABS?">
                    </div>


                    <div class="input-group mt-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputImagem" aria-describedby="inputImagemHelp" @change="carregarImagem($event)">
                            <label class="custom-file-label" for="inputImagem">Selecione uma imagem</label>
                        </div>
                    </div>
                    
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </template>
            </modal-component>

            <!-- Modal de visualizar --> 

            <modal-component id="modalModeloVisualizar" titulo="Visualizar modelo">
                <template v-slot:alertas></template>
                <template v-slot:conteudo>
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Nome do modelo">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>

                    <input-container-component titulo="Fabricante">
                        <input type="text" class="form-control" :value="$store.state.item.marca.nome" disabled>
                    </input-container-component>

                    <input-container-component titulo="Motor">
                        <input type="text" class="form-control" :value="$store.state.item.motor" disabled>
                    </input-container-component>

                    <input-container-component titulo="Transmissão">
                        <input type="text" class="form-control" :value="$store.state.item.transmissao" disabled>
                    </input-container-component>

                    <input-container-component titulo="Imagem">
                        <img :src="'storage/'+$store.state.item.imagem" alt="" v-if="$store.state.item.imagem">
                    </input-container-component>

                    <input-container-component titulo="Data de criação">
                        <input type="text" class="form-control" :value="$store.state.item.created_at | formataData" disabled>
                    </input-container-component>
                </template> 
                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </template>
            </modal-component>

            <!-- Modal de remoção -->
            
            <modal-component id="modalModeloRemover" titulo="Remover modelo">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Remoção realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a remoção" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Nome do modelo">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>

                    <input-container-component titulo="Fabricante">
                        <input type="text" class="form-control" :value="$store.state.item.marca.nome" disabled>
                    </input-container-component>
                </template> 
                <template v-slot:rodape>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </template>
            </modal-component>

            <!-- Modal de atualizar -->

            <modal-component id="modalModeloAtualizar" titulo="Atualizar modelo">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Atualização realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a atualização" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component titulo="Id da marca do modelo" id="novoId" id-help="novoIDHelp" texto-ajuda="Informe o id da marca para este modelo">
                            <input type="number" class="form-control" id="inputID" aria-describedby="novoIDHelp" placeholder="ID da marca" v-model="$store.state.item.marca.id">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo">
                            <input type="text" class="form-control" id="inputNome" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="$store.state.item.nome">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Número de portas" id="novoPortas" id-help="novoPortasHelp" texto-ajuda="Informe o número de portas">
                            <input type="number" class="form-control" id="inputPortas" aria-describedby="novoPortasHelp" placeholder="Número de portas" v-model="$store.state.item.numero_portas">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Número de lugares" id="novoLugares" id-help="novoLugaresHelp" texto-ajuda="Informe o número de lugares">
                            <input type="number" class="form-control" id="inputLugares" aria-describedby="novoLugaresHelp" placeholder="Número de lugares" v-model="$store.state.item.lugares">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <label for="tipoMotorId">Motor</label>
                        <select class="form-control" name="tipoMotor" id="tipoMotorId" v-model="$store.state.item.motor">
                            <option value="" disabled selected>Selecione o tipo de motor</option>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Etanol">Etanol</option>
                            <option value="Flex">Flex</option>
                            <option value="Elétrico">Elétrico</option>
                        </select>
                    </div>   
                        

                    <div class="form-group">
                        <label for="tipoTransmissaoId">Transmissão</label>
                        <select class="form-control" name="tipoTransmissao" id="tipoTransmissaoId" v-model="$store.state.item.transmissao">
                            <option value="" disabled selected>Selecione uma transissão</option>
                            <option value="Manual">Manual</option>
                            <option value="Automático">Automático</option>
                        </select>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" v-model="Modelo.Airbag">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Possui Air bag?">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" v-model="Modelo.Abs">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Possui ABS?">
                    </div>

                    <div class="input-group mt-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputImagem" aria-describedby="inputImagemHelp" @change="carregarImagem($event)">
                            <label class="custom-file-label" for="inputImagem">Selecione uma imagem</label>
                        </div>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>
            </modal-component>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                Modelo: {
                    nomeModelo: '',
                    IDModelo: '',
                    NumeroPortas: '',
                    Lugares: '',
                    Airbag: true,
                    Abs: true,
                    Motor: '',
                    Transmissao: '',
                },
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                busca: { id: '' , nome: ''},
            }
        },
        methods: { 
            atualizar(){
                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('marca_id', this.$store.state.item.marca.id)
                formData.append('nome', this.$store.state.item.nome)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('motor', this.$store.state.item.motor)
                formData.append('transmissao', this.$store.state.item.transmissao)
                formData.append('air_bag', this.$store.state.item.air_bag ? this.$store.state.item.air_bag = 1 : this.$store.state.item.air_bag = 0)
                formData.append('abs', this.$store.state.item.abs ? this.$store.state.item.abs = 1 : this.$store.state.item.abs = 0)
                
                if(this.arquivoImagem[0]){
                    formData.append('imagem', this.arquivoImagem[0])
                }            

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Atualização realizada com sucesso'
                        //atualizarImagem.value = ''
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            remover(){
                let confirmar = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmar){
                    return false;
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData();
                formData.append('_method', 'delete')

                this.$store.state.transacao.status = 'sucesso'
                this.$store.state.transacao.mensagem = 'Modelo removido com sucesso'

                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })
            },
            pesquisar(){
                let filtro = ''

                for(let chave in this.busca){
                    if(this.busca[chave]){
                        if(filtro != ''){
                            filtro += ";"
                        }
                        filtro += chave + ':like:' + '%' + this.busca[chave] + '%'
                    }
                }

                if(filtro != ''){
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro=' + filtro
                }else{
                    this.urlFiltro = ''
                }
                this.carregarLista()
                
            },
            paginacao(l){
                if(l.url){
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista()
                }
                
            },  
            carregarLista(){

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                axios.get(url)
                    .then(response => {
                        this.modelos = response.data
                    })
                    .catch(errors => {

                    })
            },  
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                let formData = new FormData();
                formData.append('marca_id', this.Modelo.IDModelo)
                formData.append('nome', this.Modelo.nomeModelo)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('numero_portas', this.Modelo.NumeroPortas)
                formData.append('lugares', this.Modelo.Lugares)
                formData.append('motor', this.Modelo.Motor)
                formData.append('transmissao', this.Modelo.Transmissao)
                formData.append('air_bag', this.Modelo.Airbag ? this.Modelo.Airbag = 1 : this.Modelo.Airbag = 0)
                formData.append('abs', this.Modelo.Abs ? this.Modelo.Abs = 1 : this.Modelo.Abs = 0)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'Adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro:' +  response.data.id
                        }
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'Erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            data: errors.response.data.errors
                        }
                    })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>

