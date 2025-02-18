<template>
    <v-container>
      <v-card>
        <v-card-title>Perfil</v-card-title>
        <v-card-text>
          <v-list>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title><strong>Nome:</strong> {{ userData.username }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            
            <template v-if="userData.role === 'admin'">
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Email:</strong> {{ userData.email }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            
            <template v-if="userData.role === 'professor'">
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Especialidade:</strong> {{ userData.specialty }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Experiência:</strong> {{ userData.experience }} anos</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            
            <template v-if="userData.role === 'aluno'">
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Idade:</strong> {{ userData.age }} anos</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Peso:</strong> {{ userData.weight }} kg</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title><strong>Altura:</strong> {{ userData.height }} m</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
          </v-list>
        </v-card-text>
      </v-card>
    </v-container>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        userData: {}
      };
    },
    async created() {
      console.log("PerfilUsuario.vue foi carregado!"); // Teste inicial

      try {
        console.log("Token usado para requisição:", localStorage.getItem("token"));
        
        const response = await axios.get("/api/user/profile", {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        });

        console.log("Resposta do backend:", response.data);
        this.userData = response.data;
      } catch (error) {
        console.error("Erro ao carregar perfil:", error);
      }
    }
  };
  </script>
  
  <style scoped>
  .v-card {
    max-width: 500px;
    margin: auto;
  }
  </style>
  