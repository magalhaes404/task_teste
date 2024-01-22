<template>
  <div>
    <v-app-bar
      color="blue"
      dense
      dark
    >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>Listar Tarefas</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-btn icon class="mx-12"
        @click="logout"
      >
        <v-icon>mdi-logout</v-icon>
        Sair
      </v-btn>

    </v-app-bar>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
        email: '',
        name:'',
    };
  },
  methods: {
    // Faça login no usuário
    logout() {
        var url = "http://localhost/teste/api/v1/auth/logout";
        var token =  localStorage.getItem('token');
        axios.get(url, {
              headers: {
                Authorization: 'Bearer '+token,
              },
            })
        .then(response => {
          // Se a solicitação for bem-sucedida, autentique o usuário
          if (response.status === 250) {
            this.$router.push('/');

          }
        });
    },
  },
};
</script>