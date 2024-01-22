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
        <v-card-title>Login </v-card-title>
        <v-alert
          v-model="alert"
          :value="alert"
          color="red"
          icon="mdi-alert"
          transition="scale-transition"
          shaped
          prominent
          type="error"
          :text="error"
          >

        </v-alert>
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
          class="my-12 mx-12"
        >

          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          ></v-text-field>

          <v-text-field
            v-model="password"
            :rules="passwordRules"
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            label="Senha"
            @click:append="show2 = !show2"
            required
          ></v-text-field>

          <v-btn
            :disabled="!valid"
            color="success"
            class="mr-10"
            @click="login"
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
      valid: true,
      alert: false,
      error:'',
      email: '',
      emailRules: [
         v => !!v || 'E-mail obrigatorio',
         v => /.+@.+\..+/.test(v) || 'E-mail invalido',
      ],
      password:'',
      passwordRules:[
         v => !!v || 'Senha obrigatoria',
         v => (v && v.length >= 6) || 'Senha tem que no minimo 6 caracteres',
      ],
      show2: false,
      loading:false,
    };
  },
  methods: {
    // Faça login no usuário
    login() {
        var url = "http://localhost/teste/api/v1/auth";
          // Faça uma solicitação HTTP POST para a rota /api/login
        this.loading = true;
        axios.post(url, {
            email: this.email,
            password: this.password,
        })
        .then(response => {
          // Se a solicitação for bem-sucedida, autentique o usuário
          if (response.status === 250) {
            // Armazene o token de acesso no armazenamento local
            localStorage.setItem('token', response.data.token);
            // Redirecione o usuário para a página inicial
            this.$router.push('/task');
            this.loading = false;
          }
        })
        .catch(error => {
            this.loading = false;
            // Se a solicitação falhar, exiba uma mensagem de erro
            alert("Data => "+JSON.stringify(error.response));
            this.alert = true;
            this.error = error.response.data.message;
        });
    },
  },
};
</script>