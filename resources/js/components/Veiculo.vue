<template>
    <div class="container">
            <div class="text-center">
                <img width="720px" class="img-fluid" :src="'/storage/'+veiculo.imagem" alt="">
            </div>
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-weight-bold h2">{{veiculo.marca + ' ' + veiculo.modelo + ' ' + veiculo.ano}}</p>
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="h5 mt-3"><Icon icon="mdi:car-door" width="40"/>{{' ' + veiculo.numero_portas + ' portas'}}</p>
                                <p class="h5 mt-3"><Icon icon="mdi:car-brake-abs" width="40" />{{' ' + veiculo.abs == 1 ? ' Possui abs' : ' Não possui abs'}}</p>
                                <p class="h5 mt-3"><Icon icon="bxs:gas-pump" width="40" />{{' ' + veiculo.motor}}</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="h5 mt-3"><Icon icon="mdi:airbag" width="40" />{{' ' + veiculo.air_bag == 1 ? ' Possui air bag' : ' Não possui air bag'}}</p>
                                <p class="h5 mt-3"><Icon icon="icon-park-outline:baby-car-seat" width="40" />{{' ' + veiculo.lugares + ' assentos'}}</p>
                                <p class="h5 mt-3"><Icon icon="fluent:transmission-20-filled" width="40" />{{' ' + veiculo.transmissao}}</p>
                            </div>
                        </div>
                        <p class="text-monospace h5 mt-5">Hospedado por:</p>
                        <p class="h5 font-weight-bold" >{{ veiculo.user.name}}</p>
                        <p class="h5">Conta criada em: {{ veiculo.user.created_at | Data}}</p>
                    </div>
                    <div class="col-lg-6">
                        <p class="h5 font-weight-bold mb-4">{{ 'Informe o dia e o horário que deseja reservar o veículo' }}</p>
                    
                        <div class="form-group w-75">
                            <input-container-component titulo="Dia da reserva" id="novoReserva" id-help="novoReservaHelp" texto-ajuda="Clique no icone de calendário para facilitar a escolha">
                                <input type="date" required class="form-control" id="inputReserva" aria-describedby="novoReservaHelp" placeholder="Data de reserva" v-model="reservaDia">
                            </input-container-component>
                        </div>

                        <div class="form-group w-75">
                            <label for="tipoHorarioId">Escolha o horário de uso</label>
                            <select required class="form-control" name="Horario" id="tipoHorarioId" v-model="selectHorario">
                                <option value="" disabled selected>Selecione o horário de uso</option>
                                <option value="madrugada">00:00 até 07:59</option>
                                <option value="dia">08:00 até 17:59</option>
                                <option value="noite">18:00 até 23:59</option>
                            </select>
                        </div>

                        <div>
                            <button v-if="selectHorario" class="btn btn-primary rounded-pill" @click="calculaValor(),getCodePagseguro()">Calcular Valor</button>
                        </div>

                        <div>
                            <button v-if="codigo" class="btn btn-primary rounded-pill" @click="redirecionar()">Ir para pagamento</button>
                        </div>
                        
                        <input type="hidden" name="" id="" v-model="valor">
                        <div class="h5 mt-3">
                            <span v-if="valor">Valor calculado: {{$store.state.item.valor | Preco}}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    <h3>Avaliações dos usuários</h3>
                    <hr>
                    <h4 v-if="!veiculo.avaliacoes[0]">Veículo sem avaliações!</h4>
                    <div v-for="avaliacao in veiculo.avaliacoes" class="container mt-3">
                        <div class="row">
                            
                            <div class="col-md-10">
                                <p class="h5 font-weight-bold">{{ avaliacao.user.name}}</p>
                            </div>
                            <div class="col-md-2">
                                <star-rating read-only :star-size="30" :show-rating="false" :rating="avaliacao.avaliacao"></star-rating>
                            </div>
                        </div>
                        <p class="h6">{{ avaliacao.created_at | Data}}</p>
                        <br>
                        <p class="h5">{{ avaliacao.comentario}}</p>
                        <hr>
                    </div>
                </div>
            </div>

    </div>
</template>

<script>
import { Icon } from '@iconify/vue2';
import InputContainer from './InputContainer.vue';
import StarRating from 'vue-star-rating';

    export default{
        components: {
            Icon,
            InputContainer,
            StarRating,
},
            data(){
                return{
                    urlBase: 'http://localhost:8000/api/v1/veiculo/',
                    urlGrupos: 'http://localhost:8000/api/v1/grupos',
                    urlAlugado: 'http://localhost:8000/api/v1/alugado',
                    urlPagSeguro: 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout?email=giovanni_montevechi94@hotmail.com&token=621168238B1044BC9BB8D34130A0B10B',
                    urlPagar: '',
                    urlPaginacao: '',
                    urlFiltro: '',
                    veiculo: { data: [] },
                    grupo: { data: [] },
                    selectHorario: '',
                    reservaDia: '',
                    valor: '',
                    id: window.location.href.split('/').pop(),
                    transacaoDetalhes: {},
                    transacaoStatus: '',
                    codigo: '',
                }
            },
            methods:{
                getVeiculos(){
                    let url = this.urlBase + this.id + '?' + this.urlPaginacao + this.urlFiltro
                    axios.get(url)
                        .then(response => {
                            this.veiculo = response.data
                        })
                        .catch(errors => {
                            console.log('ERRO Get')
                        })
                },
                getGrupos(){
                    let url = this.urlGrupos + '?' + this.urlPaginacao + this.urlFiltro
                    axios.get(url)
                        .then(response => {
                            this.grupo = response.data
                        })
                        .catch(errors => {
                            console.log('ERRO Get')
                        })
                },
                calculaValor(){
                    let grupo = this.veiculo.grupo
                    this.grupo.data.forEach(element => {
                        if(element.grupo === grupo){
                            const weekday = ['domingo','segunda','terca','quarta','quinta','sexta','sabado'];
                            let data = new Date(this.reservaDia)
                            let diaSemana = weekday[data.getUTCDay()];
                            let semana = Object.keys(element);
                            for (const s in semana) {
                                if(semana[s] == diaSemana){
                                    let multi = element[diaSemana]
                                    let horario = element[this.selectHorario]                               
                                    this.valor = multi * horario        
                                    this.$store.state.item.valor = multi * horario
                                }
                            }
                        }
                    });
                },
                salvar() {
                let formData = new FormData();
                formData.append('veiculo_id', this.id)
                formData.append('preco', this.valor)
                formData.append('data', this.reservaDia)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlAlugado, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'Compra com sucesso'
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
            },
            getCodePagseguro(){
                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("currency", "BRL");
                urlencoded.append("itemId1", "0001");
                urlencoded.append("itemDescription1", this.veiculo.modelo);
                urlencoded.append("itemAmount1", this.valor.toFixed(2));
                urlencoded.append("itemQuantity1", "1");
                urlencoded.append("itemWeight1", "1000");
                urlencoded.append("reference", "REF1234");
                urlencoded.append("shippingAddressRequired", false)
                urlencoded.append("extraAmount", "-0.01");
                urlencoded.append("redirectURL", "http://localhost:8000/alugados");
                urlencoded.append("maxUses", "1");
                urlencoded.append("maxAge", "3000");

                var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
                };

                fetch("https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/?email=giovanni_montevechi94@hotmail.com&token=621168238B1044BC9BB8D34130A0B10B", requestOptions)
                .then(response => response.text())
                .then(result => {
                    console.log(result.substring(76,108))
                    this.codigo = result.substring(76,108)
                })
                .catch(error => console.log('error', error));
            },
            redirecionar(){
                var code = this.codigo;
                var callback = {
                    success : function(transactionCode) {
                        //Insira os comandos para quando o usuário finalizar o pagamento. 
                        //O código da transação estará na variável "transactionCode"
                        console.log("Compra feita com sucesso, código de transação: " + transactionCode);
                        salvar()
                        location.href="https://localhost:8000/alugados";
                    },
                    abort : function() {
                        //Insira os comandos para quando o usuário abandonar a tela de pagamento.
                        console.log("abortado");
                    }
                };
                //Chamada do lightbox passando o código de checkout e os comandos para o callback
                var isOpenLightbox = PagSeguroLightbox(code, callback);
                // Redireciona o comprador, caso o navegador não tenha suporte ao Lightbox
                if (!isOpenLightbox){
                    location.href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code=" + code;
                    console.log("Redirecionamento")
}
            }

            },
            mounted(){
                let pagseguroScript = document.createElement('script')
                pagseguroScript.setAttribute('src', 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js')
                document.head.appendChild(pagseguroScript)
                this.getGrupos()
                this.getVeiculos()
            }
    }
    
    </script>