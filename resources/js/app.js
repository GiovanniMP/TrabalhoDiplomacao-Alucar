/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
// vuex

import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        item: {}, 
        transacao: {status: '', mensagem: '', dados: ''}
    }
})


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('marcas-component', require('./components/Marcas.vue').default);
Vue.component('input-container-component', require('./components/InputContainer.vue').default);
Vue.component('tablemarcas-component', require('./components/TableMarcas.vue').default);
Vue.component('card-component', require('./components/Card.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('paginate-component', require('./components/Paginate.vue').default);
Vue.component('welcome-component', require('./components/Welcome.vue').default);
Vue.component('modelos-component', require('./components/Modelos.vue').default);
Vue.component('tablemodelos-component', require('./components/TableModelos.vue').default);
Vue.component('carros-component', require('./components/Carros.vue').default);
Vue.component('cardb-component', require('./components/CardVeiculos.vue').default);
Vue.component('veiculo-component', require('./components/Veiculo.vue').default);
Vue.component('grupos-component', require('./components/Grupos.vue').default);
Vue.component('tablegrupos-component', require('./components/TableGrupos.vue').default);
Vue.component('perfil-component', require('./components/Perfil.vue').default);
Vue.component('alugados-component', require('./components/Alugados.vue').default);
Vue.component('avaliar-component', require('./components/Avaliar.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter('formataData', function(d) {
    if(!d) return ''

    d = d.split('T')

    let data = d[0]
    let tempo = d[1]

    //formatando a data
    data = data.split('-')
    data = data[2] + '/' + data[1] + '/' + data[0]

    //formatar o tempo
    tempo = tempo.split('.')
    tempo = tempo[0]

    return data + ' ' + tempo
})

Vue.filter('Data', function(d) {
    if(!d) return ''

    d = d.split('T')

    let data = d[0]

    //formatando a data
    data = data.split('-')
    data = data[2] + '/' + data[1] + '/' + data[0]

    return data
})

Vue.filter('Preco', function(d) {
    if(!d) return ''
    
    return d.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'})
})
    

const app = new Vue({
    el: '#app',
    store
});
