<template>
    <v-container class="fill-height">
      <v-row justify="center">
        <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
          <v-card class="pa-5 rounded-xl shadow-card">
            <v-card-title class="text-center text-h4 mb-6">
              Rotina de Treinos do Aluno
            </v-card-title>
  
            <v-divider></v-divider>
  
            <v-row class="mt-4" justify="center">
              <v-col cols="12" class="mb-4">
                <v-row>
                  <v-col cols="3" class="text-right">
                    <v-icon color="primary">fitness_center</v-icon>
                  </v-col>
                  <v-col cols="9">
                    <p><strong>Treino 1:</strong> Agachamento - 4 séries de 12 repetições</p>
                  </v-col>
                </v-row>
              </v-col>
  
              <v-col cols="12" class="mb-4">
                <v-row>
                  <v-col cols="3" class="text-right">
                    <v-icon color="primary">fitness_center</v-icon>
                  </v-col>
                  <v-col cols="9">
                    <p><strong>Treino 2:</strong> Supino reto - 4 séries de 10 repetições</p>
                  </v-col>
                </v-row>
              </v-col>
  
              <v-col cols="12" class="mb-4">
                <v-row>
                  <v-col cols="3" class="text-right">
                    <v-icon color="primary">fitness_center</v-icon>
                  </v-col>
                  <v-col cols="9">
                    <p><strong>Treino 3:</strong> Remada unilateral - 3 séries de 12 repetições</p>
                  </v-col>
                </v-row>
              </v-col>
  
              <v-col cols="12" class="mb-4">
                <v-row>
                  <v-col cols="3" class="text-right">
                    <v-icon color="primary">fitness_center</v-icon>
                  </v-col>
                  <v-col cols="9">
                    <p><strong>Treino 4:</strong> Desenvolvimento militar - 4 séries de 10 repetições</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
  
            <v-divider></v-divider>
  
            <v-row class="mt-4" justify="center">
              <v-col cols="12">
                <v-btn block color="primary" to="/home" class="rounded-lg btn-hover">
                  <v-icon left>home</v-icon> Home
                </v-btn>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        // adicionar as rotinas depois
      };
    },
  };
  </script>
  
  <style scoped>
  .v-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(to right, #eef2f3, #d9e2ec);
    padding-right: 600px;
  }
  
  .shadow-card {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 16px;
    width: 500px;
  }
  
  .v-btn {
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 0.3s ease-in-out;
    padding: 16px 0;
    font-size: 16px;
  }
  
  .v-btn:hover {
    transform: scale(1.05);
    filter: brightness(1.2);
  }
  
  .v-card {
    background-color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 800px;
  }
  
  .v-card-title {
    color: #424242;
    text-align: center;
    padding-right: 15px;
  }
  
  .v-divider {
    margin: 16px 0;
  }
  
  
  .material-icons {
    font-size: 28px;
    margin-right: 10px;
  }
  
  .text-wrap {
    white-space: normal;
    word-break: break-word;
    text-align: center;
  }
  
  .btn-hover {
    transition: all 0.3s ease-in-out;
  }
  </style>
  