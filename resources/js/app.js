require('./bootstrap');
window.Vue = require('vue');

import VueTheMask from 'vue-the-mask'

Vue.use(VueTheMask);

Vue.component(
    'create-fraud',
    require('./components/CreateFraudComponent.vue').default
);

Vue.component(
    'search-fraud',
    require('./components/SearchFraudComponent.vue').default
);

var app = new Vue({
    el: '#app'
});
