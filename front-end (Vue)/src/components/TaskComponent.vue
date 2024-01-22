<AuthComponent />
<template>
  <v-card>
      <v-card-title>
        <v-alert
          v-model="alert"
          :value="alert"
          icon="mdi-alert"
          transition="scale-transition"
          shaped
          prominent
          :text="error"
          :type="type"
          >

        </v-alert>

        <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
              @click="newTask"
            >
              Nova Tarefa
        </v-btn>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="desserts"
        :loading="loading"
        loading-text="Carregando Aguarde"
      >
        <template #[`item.id`]="{ item }">
          <v-chip
            :color="getColor(item.id)"
            dark
          >
            {{ item.id }}
          </v-chip>
        </template>
        <template #[`item.actions`]="{ item }">
        <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                        <v-btn
                              color="primary"
                              dark
                              class="mb-2"
                              @click="editTask(item.id)"
                        >

                              <v-icon
                                small
                                class="mr-2"
                              >
                                mdi-pencil
                              </v-icon>
                        </v-btn>
                        <v-btn
                              color="danger"
                              dark
                              class="mb-2"
                              @click="deleteTask(item.id)"
                        >

                              <v-icon
                                small
                              >
                                mdi-delete
                              </v-icon>
                        </v-btn>

                  </v-col>
                </v-row>
            </v-container>
        </template>
    </v-data-table>
    <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">
                Deletar essa Tarefa
            </v-card-title>
            <v-card-body>
                Tem certeza que deseja continuar?
            </v-card-body>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        color="blue"
        :length="pageCount"
        @update:model-value="next"
      >
      </v-pagination>
    </div>
  </v-card>
</template>

<script>
import axios from 'axios';

  export default {
    data () {
      return {
        dialogDelete: false,
        page:1,
        pageCount:10,
        loading:true,
        deleteTaskId: 0,
        alert: false,
        error:'',
        type:'',
        headers: [
          { text: 'Id',value: 'id'},
          { text: 'Titulo',value: 'title' },
          { text: 'Descricao',value: 'descript' },
          { text: "",value:'actions'}
        ],
        desserts: []
      };
    },
    created () {
      this.all();
	},
    methods :{
        all() {
            var url = "http://localhost/teste/api/v1/task?page="+this.page;
              // Faça uma solicitação HTTP POST para a rota /api/login
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
                this.desserts = response.data.data;
                this.page = response.data.current_page;
                this.pageCount = response.data.last_page;
              }
            })
            .catch(error => {
                this.loading = false;
                // Se a solicitação falhar, exiba uma mensagem de erro
                //alert("Data => "+JSON.stringify(error.response));
                if(error.response.status === 401){
                      this.$router.push('/');
                }
            });
        },
        deleteTaskOk() {
            var url = "http://localhost/teste/api/v1/task/"+this.deleteTaskId;
              // Faça uma solicitação HTTP POST para a rota /api/login
            this.loading = true;
            var token =  localStorage.getItem('token');
            axios.delete(url, {
              headers: {
                Authorization: 'Bearer '+token,
              },
            })
            .then(response => {
              // Se a solicitação for bem-sucedida, autentique o usuário
              if (response.status === 250) {
                this.loading = false;
                this.alert = true;
                this.type = 'success';
                this.error = response.data.message;
              }
            })
            .catch(error => {
                this.loading = false;
                // Se a solicitação falhar, exiba uma mensagem de erro
                //alert("Data => "+JSON.stringify(error.response));
                this.alert = true;
                this.error = error.response.data.message;
                this.type='erro'
                if(error.response.status === 401){
                      this.$router.push('/login');
                }
            });
        },
        getColor (id) {
            if ((id / 2) % 0)
            return 'blue';
            else return 'green';
        },
        newTask(){
          this.$router.push('/task/new');
        },
        editTask(id){
          this.$router.push('/task/'+id);
        },
        deleteTask(id){
            this.deleteTaskId = id;
            this.dialogDelete = true;
        },
        next(page){
           this.page = page;
           this.all();
        },
        deleteItemConfirm () {
            this.deleteTaskOk();
            this.all();
            this.closeDelete();
        },
       closeDelete () {
            this.dialogDelete = false
            this.deleteTaskId = -1;
       },

	},
  }
</script>