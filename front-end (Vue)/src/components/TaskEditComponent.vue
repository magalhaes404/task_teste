<template>
<div id="app">
  <v-app id="inspire">
    <v-card
      :loading="loading"
      width="80%"
      min-width="300px"
      max-width="500px"
      class="mx-auto my-12"
    >
        <v-card-title>Alterar Tarefa</v-card-title>
        <v-alert
          v-model="alert"
          :value="alert"
          color="red"
          icon="mdi-alert"
          transition="scale-transition"
          shaped
          prominent
          :text="error"
          type="type"
          >

        </v-alert>
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
          class="my-12 mx-12"
        >

          <v-text-field
            v-model="title"
            :rules="titleRules"
            label="Titulo"
            required
          ></v-text-field>

          <v-text-field
            v-model="descript"
            :rules="descriptRules"
            label="Descrição"
            required
          ></v-text-field>

          <v-btn
            :disabled="!valid"
            color="success"
            class="mr-10"
            @click="save"
          >
            Enviar
          </v-btn>
        </v-form>
    </v-card>
  </v-app>
</div>
</template>

<script>
import axios from 'axios';
import {useRoute} from "vue-router";

export default {
  data() {
    return {
      type:'erro',
      valid: true,
      alert: false,
      error:'',
      title: '',
      id:'',
      titleRules:[
         v => !!v || 'Titulo obrigatoria',
         v => (v && v.length >= 10) || 'O titulo tem que no minimo 10 caracteres',
      ],
      descript:'',
      descriptRules:[
         v => !!v || 'Descrição obrigatoria',
         v => (v && v.length >= 30) || 'Descrição tem que no minimo 30 caracteres',
      ],
      loading:false,
    };
  },
  created () {
     var route = useRoute();
     var id = route.params.id;
     this.id = id;
     this.get();
  },
  methods: {
    get() {
            var url = "http://localhost/teste/api/v1/task/"+this.id;
            this.loading = true;
            var token =  localStorage.getItem('token');
            axios.get(url, {
              headers: {
                Authorization: 'Bearer '+token,
              },
            })
            .then(response => {
              // Se a solicitação for bem-sucedida, autentique o usuário
              if (response.status === 250) {
                this.loading = false;
                this.title = response.data.title;
                this.descript = response.data.descript;
              }
            })
            .catch(error => {
                this.loading = false;
                // Se a solicitação falhar, exiba uma mensagem de erro
                //alert("Data => "+JSON.stringify(error.response));
                this.alert = true;
                this.error = error.response.data.message;
                if(error.response.status === 401){
                      this.$router.push('/');
                }
            });
    },
    save() {

        var url = "http://localhost/teste/api/v1/task/"+this.id;

          // Faça uma solicitação HTTP POST para a rota /api/login
            this.loading = true;
            var token =  localStorage.getItem('token');
            var head = {
                    Authorization: 'Bearer '+token,
                    'Content-Type': 'application/json',
                };
            var body = {
                'title':this.title,
                'descript':this.descript,
            };
            axios.put(url,body,
                    {
                      headers: head,
                    }
                )
            .then(response => {
              // Se a solicitação for bem-sucedida, autentique o usuário
              if (response.status === 250) {
                // Armazene o token de acesso no armazenamento local
                // Redirecione o usuário para a página inicial
                this.$router.push('/task');
                this.loading = false;
                this.type = 'success';
              }
            })
            .catch(error => {
                this.loading = false;
                // Se a solicitação falhar, exiba uma mensagem de erro
                this.alert = true;
                this.error = error.response.data.message;
                this.type = 'erro';
                if(error.response.status === 401){
                      this.$router.push('/login');
                }
            });
    },
  },
};
</script>