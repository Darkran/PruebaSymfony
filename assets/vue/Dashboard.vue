<!-- assets/LoginForm.vue -->

<template>
  <div class="container mt-5">
    <img src="assets/logo.jfif" alt="Logo" class="mb-4">
    <div v-if="feedback" class="feedback">{{ feedback }}</div>
    <div v-if="error" class="error">{{ error }}</div>
    <div class="dashboard-container">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Maquinas</h5>
            <button @click="readForm('Maquinas')" class="btn btn-primary">Leer</button>
            <button @click="newForm('Maquinas')" class="btn btn-primary">Nuevo</button>
            <button @click="editForm('Maquinas')" class="btn btn-primary">Editar</button>
            <button @click="deleteForm('Maquinas')" class="btn btn-primary">Borrar</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Recaudaciones</h5>
            <button @click="readForm('Recaudaciones')" class="btn btn-primary">Leer</button>
            <button @click="newForm('Recaudaciones')" class="btn btn-primary">Nuevo</button>
            <button @click="editForm('Recaudaciones')" class="btn btn-primary">Editar</button>
            <button @click="deleteForm('Recaudaciones')" class="btn btn-primary">Borrar</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Videos</h5>
            <button @click="readForm('Videos')" class="btn btn-primary">Leer</button>
            <button @click="newForm('Videos')" class="btn btn-primary">Nuevo</button>
            <button @click="editForm('Videos')" class="btn btn-primary">Editar</button>
            <button @click="deleteForm('Videos')" class="btn btn-primary">Borrar</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Clientes</h5>
            <button @click="readForm('Clientes')" class="btn btn-primary">Leer</button>
            <button @click="newForm('Clientes')" class="btn btn-primary">Nuevo</button>
            <button @click="editForm('Clientes')" class="btn btn-primary">Editar</button>
            <button @click="deleteForm('Clientes')" class="btn btn-primary">Borrar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="right-content">
      <div v-if="selectedTable">
        <h2>{{ selectedTable }}</h2>

        <div v-if="showReadOptions">
          <div>
            <button @click="readAll(selectedTable)" class="btn btn-primary">Leer Todos</button>

          </div>
          <div>
            <input v-model="idToRead" type="text" class="form-control mb-2" placeholder="Id a leer">
            <button @click="readById(selectedTable)" class="btn btn-primary">Leer por ID</button>
          </div>

          <table class="tableClientes">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in clientData" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.nombre }}</td>
              </tr>
            </tbody>
          </table>

        </div>

        <div v-if="showNewMachineForm">
          <div>
            <input v-model="machineName" type="text" class="form-control mb-2" placeholder="Nombre de Maquina">
            <select v-model="machineClient" class="form-control mb-2">
              <option v-for="item in clientData" :value="item.id" :key="item.id">{{ item.nombre }}</option>
            </select>
            <button @click="newData(selectedTable)" class="btn btn-primary">Guardar</button>
          </div>
        </div>

        <div v-if="showNewVideoForm">
          <div>
            <input v-model="videoName" type="text" class="form-control mb-2" placeholder="Nombre de video">
            <input v-model="VideoSec" type="number" class="form-control mb-2" placeholder="Duracion en segundos">
            <button @click="newData(selectedTable)" class="btn btn-primary">Guardar</button>
          </div>
        </div>

        <div v-if="showNewClientForm">
          <div>
            <input v-model="clientName" type="text" class="form-control mb-2" placeholder="Nombre de cliente">
            <button @click="newData(selectedTable)" class="btn btn-primary">Guardar</button>
          </div>
        </div>




      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import '../styles/dashboard.css';
import { TriggerOpTypes } from 'vue';

export default {
  data() {
    return {
      selectedTable: null,
      showReadOptions: false,
      showNewClientForm: false,
      showNewVideoForm: false,
      showNewMachineForm: false,
      feedback: null,
      error: null,
      idToRead: '',
      clientName: '',
      clientData: '',
    };
  },
  methods: {
    readForm(table) {
      this.selectedTable = table;
      this.showReadOptions = true;
      this.showNewClientForm = false;
      this.showNewVideoForm = false;
      this.showNewMachineForm = false;

    },

    readAll(table) {
      if (table == "Clientes") {
        axios.get('/cliente')
          .then(response => {
            this.clientData = response.data;
            this.error = null;
          })
          .catch(error => {
            this.error = error.response.data.message;
            this.feedback = null;
          });
      }
      console.log(`Reading all records from ${this.selectedTable}`);
    },

    readById(table) {
      if (table == "Clientes") {
        axios.get(`/cliente/${this.idToRead}`)
          .then(response => {
            this.clientData = response.data;
            console.log(this.clientData);
            this.error = null;
          })
          .catch(error => {
            this.error = error.response.data.message;
            this.feedback = null;
          });
      }
      console.log(`Reading record with ID ${this.idToRead} from ${this.selectedTable}`);
    },

    newForm(table) {
      this.selectedTable = table;
      this.showReadOptions = false;
      this.showNewVideoForm = false;
      this.showNewClientForm = false;
      this.showNewMachineForm = false;

      if (table == 'Clientes') {
        this.showNewClientForm = true;
      } else if (table == 'Videos') {
        this.showNewVideoForm = true;
      } else if (table == 'Maquinas') {
        this.clientData = this.readAll('Clientes');
        this.showNewMachineForm = true;
        
      }

    },

    newData(table) {

      if (table == "Clientes") {
        const formData = {
          nombre: this.clientName,
        };

        axios.post('/cliente', formData)
          .then(response => {
            this.feedback = response.data.message;
            this.error = null;
          })
          .catch(error => {
            this.error = error.response.data.message;
            this.feedback = null;
          });
      } else if (table == 'Videos') {
        const formData = {
          nombre: this.videoName,
          duracion: this.VideoSec
        };

        axios.post('/video', formData)
          .then(response => {
            this.feedback = response.data.message;
            this.error = null;
          })
          .catch(error => {
            this.error = error.response.data.message;
            this.feedback = null;
          });

      } else if (table == 'Maquinas') {
        const formData = {
          nombre: this.machineName,
          cliente: this.machineClient,
          tipo: this.machineType,
          videos: this.machineVideos
        };

        axios.post('/maquina', formData)
          .then(response => {
            this.feedback = response.data.message;
            this.error = null;
          })
          .catch(error => {
            this.error = error.response.data.message;
            this.feedback = null;
          });
      }

    }

    // Add methods for New, Edit, and Delete operations if needed
  }
}


</script>