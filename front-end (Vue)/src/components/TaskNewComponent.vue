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
        <v-card-title>Nova Tarefa</v-card-title>
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

export default {
  data() {
    return {
      type:'erro',
      valid: true,
      alert: false,
      error:'',
      title: '',
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
  methods: {
    // Faça login no usuário
    save() {
        var url = "http://localhost/teste/api/v1/task";
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
            alert("Token => "+token);
            axios.post(url,body,
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
                      this.$router.push('/');
                }
            });
    },
  },
};
</script>