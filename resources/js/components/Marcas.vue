<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                   
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                        <template v-slot:rodape>
                                <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                        </template>
                </card-component>


                <card-component titulo="Relação de Marcas" class="mt-3">
                    <template v-slot:conteudo>
                        <tablemarcas-component 
                            :dados="marcas.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal' , dataTarget: '#modalMarcaAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'text'}, 
                                nome: {titulo: 'Nome', tipo: 'text'}, 
                                imagem: {titulo: 'Imagem', tipo: 'imagem'}, 
                                created_at: {titulo: 'Data de criação', tipo: 'data'}, 
                            }"
                        ></tablemarcas-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key" class="page-item" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" href="#" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

            <!-- Modal de inclusao-->
            <modal-component id="modalMarca" titulo="Adicionar marca">
                <template v-slot:alertas>
                    <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Marca cadastrada com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                    <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'Erro'"></alert-component>
                </template>
                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca">
                            <input type="text" class="form-control" id="inputNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato png">
                            <input type="file" class="form-control-file" id="inputImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                        </input-container-component>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </template>
            </modal-component>

            <!-- Modal de visualizar --> 

            <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
                <template v-slot:alertas></template>
                <template v-slot:conteudo>
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
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
            
            <modal-component id="modalMarcaRemover" titulo="Remover marca">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Remoção realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a remoção" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </template> 
                <template v-slot:rodape>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </template>
            </modal-component>

            <!-- Modal de atualizar -->

            <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Atualização realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a atualização" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o nome da marca">
                            <input type="text" class="form-control" id="inputNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da marca" v-model="$store.state.item.nome">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato png">
                            <input type="file" class="form-control-file" id="inputImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                        </input-container-component>
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
                urlBase: 'http://localhost:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id: '' , nome: ''},
            }
        },
        methods: {
            atualizar(){
                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)
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
                this.$store.state.transacao.mensagem = 'Marca removida com sucesso'

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
                        this.marcas = response.data
                    })
                    .catch(errors => {

                    })
            },  
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

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

