require('./bootstrap');
window.Vue = require('vue');

Vue.component(
    'create-fraud',
    require('./components/CreateFraudComponent.vue').default
);

var app = new Vue({
    el: '#app'
});
