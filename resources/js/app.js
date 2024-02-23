
import Vue from 'vue';
import { ClientTable, ServerTable} from 'vue-tables-2';
import axios from 'axios'
import swal from 'sweetalert2'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

//Configuration libraries
Vue.use(ServerTable,{ } ,  false ,  'bootstrap4');
Vue.use(ClientTable);
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Swal = swal;

import testComponent from './components/index.vue'
import tablaExport from './components/tablaExport.vue'

Vue.component('test-component', testComponent );
Vue.component('tabla-export-component', tablaExport );

const app = new Vue({
  el: '#app',
  components: {
  }
})

