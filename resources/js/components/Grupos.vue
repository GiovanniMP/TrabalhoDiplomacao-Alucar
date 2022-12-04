<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <card-component titulo="Busca de grupos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do grupo">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                   
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Número do grupo" id="inputGrupo" id-help="GrupoHelp" texto-ajuda="Opcional. Informe o número do grupo">
                                    <input type="number" class="form-control" id="inputGrupo" aria-describedby="GrupoHelp" placeholder="Número do grupo" v-model="busca.grupo">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                        <template v-slot:rodape>
                                <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                        </template>
                </card-component>


                <card-component titulo="Relação dos grupos" class="mt-3">
                    <template v-slot:conteudo>
                        <tablegrupos-component 
                            :dados="grupos.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalGruposVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal' , dataTarget: '#modalGruposAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalGruposRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'text'}, 
                                grupo: {titulo: 'Grupo', tipo: 'text'}, 
                                domingo: {titulo: 'Domingo', tipo: 'text'}, 
                                segunda: {titulo: 'Segunda', tipo: 'text'},
                                terca: {titulo: 'Terça', tipo: 'text'},
                                quarta: {titulo: 'Quarta', tipo: 'text'},
                                quinta: {titulo: 'Quinta', tipo: 'text'},
                                sexta: {titulo: 'Sexta', tipo: 'text'},
                                sabado: {titulo: 'Sábado', tipo: 'text'},
                                madrugada: {titulo: 'Preço Magrudada', tipo: 'text'},
                                dia: {titulo: 'Preço Dia', tipo: 'text'},
                                noite: {titulo: 'Preço noite', tipo: 'text'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'}, 
                            }"
                        ></tablegrupos-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in grupos.links" :key="key" class="page-item" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" href="#" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalGrupos">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

            <!-- Modal de inclusao-->
            <modal-component id="modalGrupos" titulo="Adicionar grupo">
                <template v-slot:alertas>
                    <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Grupo cadastrado com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                    <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o grupo" v-if="transacaoStatus == 'Erro'"></alert-component>
                </template>
                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component titulo="Número do grupo" id="novoGrupo" id-help="novoGrupoHelp" texto-ajuda="Informe o número do grupo">
                            <input type="text" class="form-control" id="inputGrupo" aria-describedby="novoGrupoHelp" placeholder="Número do grupo" v-model="grupo.numero">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Domingo" id="novoDomingo" id-help="novoDomingoHelp" texto-ajuda="Informe o multiplicador para domingo">
                            <input type="text" class="form-control" id="inputDomingo" aria-describedby="novoDomingoHelp" placeholder="Multiplicador para Domingo" v-model="grupo.domingo">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Segunda" id="novoSegunda" id-help="novoSegundaHelp" texto-ajuda="Informe o multiplicador para Segunda">
                            <input type="text" class="form-control" id="inputSegunda" aria-describedby="novoSegundaHelp" placeholder="Multiplicador para Segunda" v-model="grupo.segunda">
                        </input-container-component>
                    </div>
                    
                    <div class="form-group">
                        <input-container-component titulo="Terça" id="novoTerca" id-help="novoTercaHelp" texto-ajuda="Informe o multiplicador para Terça">
                            <input type="text" class="form-control" id="inputTerca" aria-describedby="novoTercaHelp" placeholder="Multiplicador para Terça" v-model="grupo.terca">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Quarta" id="novoQuarta" id-help="novoQuartaHelp" texto-ajuda="Informe o multiplicador para Quarta">
                            <input type="text" class="form-control" id="inputQuarta" aria-describedby="novoQuartaHelp" placeholder="Multiplicador para Quarta" v-model="grupo.quarta">
                        </input-container-component>
                    </div>
                
                    <div class="form-group">
                        <input-container-component titulo="Quinta" id="novoQuinta" id-help="novoQuintaHelp" texto-ajuda="Informe o multiplicador para Quinta">
                            <input type="text" class="form-control" id="inputQuinta" aria-describedby="novoQuintaHelp" placeholder="Multiplicador para Quinta" v-model="grupo.quinta">
                        </input-container-component>
                    </div>
                                        
                    <div class="form-group">
                        <input-container-component titulo="Sexta" id="novoSexta" id-help="novoSextaHelp" texto-ajuda="Informe o multiplicador para Sexta">
                            <input type="text" class="form-control" id="inputSexta" aria-describedby="novoSextaHelp" placeholder="Multiplicador para Sexta" v-model="grupo.sexta">
                        </input-container-component>
                    </div>
                                        
                    <div class="form-group">
                        <input-container-component titulo="Sábado" id="novoSabado" id-help="novoSabadoHelp" texto-ajuda="Informe o multiplicador para Sabado">
                            <input type="text" class="form-control" id="inputSabado" aria-describedby="novoSabadoHelp" placeholder="Multiplicador para Sabado" v-model="grupo.sabado">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Madrugada" id="novoMadrugada" id-help="novoMadrugadaHelp" texto-ajuda="Informe o preço para este grupo durante a Madrugada">
                            <input type="text" class="form-control" id="inputMadrugada" aria-describedby="novoMadrugadaHelp" placeholder="Preço durante a Madrugada" v-model="grupo.madrugada">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Dia" id="novoDia" id-help="novoDiaHelp" texto-ajuda="Informe o preço para este grupo durante o Dia">
                            <input type="text" class="form-control" id="inputDia" aria-describedby="novoDiaHelp" placeholder="Preço durante o Dia" v-model="grupo.dia">
                        </input-container-component>
                    </div>
                    
                    <div class="form-group">
                        <input-container-component titulo="Noite" id="novoNoite" id-help="novoNoiteHelp" texto-ajuda="Informe o preço para este grupo durante a Noite">
                            <input type="text" class="form-control" id="inputNoite" aria-describedby="novoNoiteHelp" placeholder="Preço durante a Noite" v-model="grupo.noite">
                        </input-container-component>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </template>
            </modal-component>

            <!-- Modal de visualizar --> 

            <modal-component id="modalGruposVisualizar" titulo="Visualizar">
                <template v-slot:alertas></template>
                <template v-slot:conteudo>
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Numero do grupo">
                        <input type="text" class="form-control" :value="$store.state.item.grupo" disabled>
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
            
            <modal-component id="modalGruposRemover" titulo="Remover grupo">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Remoção realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a remoção" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                    
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>

                    <input-container-component titulo="Número do grupo">
                        <input type="text" class="form-control" :value="$store.state.item.grupo" disabled>
                    </input-container-component>
                </template> 
                <template v-slot:rodape>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </template>
            </modal-component>

            <!-- Modal de atualizar -->

            <modal-component id="modalGruposAtualizar" titulo="Atualizar marca">
                <template v-slot:alertas>
                    <alert-component tipo="success" titulo="Atualização realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso' "></alert-component>
                    <alert-component tipo="danger" titulo="Erro ao realizar a atualização" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro' "></alert-component>
                </template>
                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component titulo="Número do grupo" id="novoGrupo" id-help="novoGrupoHelp" texto-ajuda="Informe o número do grupo">
                            <input type="text" class="form-control" id="inputGrupo" aria-describedby="novoGrupoHelp" placeholder="Número do grupo" v-model="$store.state.item.grupo">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Domingo" id="novoDomingo" id-help="novoDomingoHelp" texto-ajuda="Informe o multiplicador para domingo">
                            <input type="text" class="form-control" id="inputDomingo" aria-describedby="novoDomingoHelp" placeholder="Multiplicador para Domingo" v-model="$store.state.item.domingo">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Segunda" id="novoSegunda" id-help="novoSegundaHelp" texto-ajuda="Informe o multiplicador para Segunda">
                            <input type="text" class="form-control" id="inputSegunda" aria-describedby="novoSegundaHelp" placeholder="Multiplicador para Segunda" v-model="$store.state.item.segunda">
                        </input-container-component>
                    </div>
                    
                    <div class="form-group">
                        <input-container-component titulo="Terça" id="novoTerca" id-help="novoTercaHelp" texto-ajuda="Informe o multiplicador para Terça">
                            <input type="text" class="form-control" id="inputTerca" aria-describedby="novoTercaHelp" placeholder="Multiplicador para Terça" v-model="$store.state.item.terca">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Quarta" id="novoQuarta" id-help="novoQuartaHelp" texto-ajuda="Informe o multiplicador para Quarta">
                            <input type="text" class="form-control" id="inputQuarta" aria-describedby="novoQuartaHelp" placeholder="Multiplicador para Quarta" v-model="$store.state.item.quarta">
                        </input-container-component>
                    </div>
                
                    <div class="form-group">
                        <input-container-component titulo="Quinta" id="novoQuinta" id-help="novoQuintaHelp" texto-ajuda="Informe o multiplicador para Quinta">
                            <input type="text" class="form-control" id="inputQuinta" aria-describedby="novoQuintaHelp" placeholder="Multiplicador para Quinta" v-model="$store.state.item.quinta">
                        </input-container-component>
                    </div>
                                        
                    <div class="form-group">
                        <input-container-component titulo="Sexta" id="novoSexta" id-help="novoSextaHelp" texto-ajuda="Informe o multiplicador para Sexta">
                            <input type="text" class="form-control" id="inputSexta" aria-describedby="novoSextaHelp" placeholder="Multiplicador para Sexta" v-model="$store.state.item.sexta">
                        </input-container-component>
                    </div>
                                        
                    <div class="form-group">
                        <input-container-component titulo="Sábado" id="novoSabado" id-help="novoSabadoHelp" texto-ajuda="Informe o multiplicador para Sabado">
                            <input type="text" class="form-control" id="inputSabado" aria-describedby="novoSabadoHelp" placeholder="Multiplicador para Sabado" v-model="$store.state.item.sabado">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Madrugada" id="novoMadrugada" id-help="novoMadrugadaHelp" texto-ajuda="Informe o preço para este grupo durante a Madrugada">
                            <input type="text" class="form-control" id="inputMadrugada" aria-describedby="novoMadrugadaHelp" placeholder="Preço durante a Madrugada" v-model="$store.state.item.madrugada">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Dia" id="novoDia" id-help="novoDiaHelp" texto-ajuda="Informe o preço para este grupo durante o Dia">
                            <input type="text" class="form-control" id="inputDia" aria-describedby="novoDiaHelp" placeholder="Preço durante o Dia" v-model="$store.state.item.dia">
                        </input-container-component>
                    </div>
                    
                    <div class="form-group">
                        <input-container-component titulo="Noite" id="novoNoite" id-help="novoNoiteHelp" texto-ajuda="Informe o preço para este grupo durante a Noite">
                            <input type="text" class="form-control" id="inputNoite" aria-describedby="novoNoiteHelp" placeholder="Preço durante a Noite" v-model="$store.state.item.noite">
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
                urlBase: 'http://localhost:8000/api/v1/grupos',
                urlPaginacao: '',
                urlFiltro: '',
                grupo: {
                    numero: '',
                    domingo: '',
                    segunda: '',
                    terca: '',
                    quarta: '',
                    quinta: '',
                    sexta: '',
                    sabado: '',
                    madrugada: '',
                    dia: '',
                    noite: '',
                },
                transacaoStatus: '',
                transacaoDetalhes: {},
                grupos: { data: [] },
                busca: { id: '' , numero: ''},
            }
        },
        methods: {
            atualizar(){
                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('grupo', this.$store.state.item.grupo)
                formData.append('domingo',this.$store.state.item.domingo )
                formData.append('segunda', this.$store.state.item.segunda)
                formData.append('terca', this.$store.state.item.terca)
                formData.append('quarta', this.$store.state.item.quarta)
                formData.append('quinta', this.$store.state.item.quinta)
                formData.append('sexta', this.$store.state.item.sexta)
                formData.append('sabado', this.$store.state.item.sabado)
                formData.append('madrugada', this.$store.state.item.madrugada)
                formData.append('dia', this.$store.state.item.dia)
                formData.append('noite', this.$store.state.item.noite)          

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
                        this.grupos = response.data
                        console.log(this.grupos);
                    })
                    .catch(errors => {

                    })
            }, 
            salvar() {
                let formData = new FormData();
                formData.append('grupo', this.grupo.numero)
                formData.append('domingo',this.grupo.domingo )
                formData.append('segunda', this.grupo.segunda)
                formData.append('terca', this.grupo.terca)
                formData.append('quarta', this.grupo.quarta)
                formData.append('quinta', this.grupo.quinta)
                formData.append('sexta', this.grupo.sexta)
                formData.append('sabado', this.grupo.sabado)
                formData.append('madrugada', this.grupo.madrugada)
                formData.append('dia', this.grupo.dia)
                formData.append('noite', this.grupo.noite)

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

