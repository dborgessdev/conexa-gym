<template>
    <v-container class="fill-height">
      <v-row justify="center">
        <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
          <v-card class="pa-5 rounded-xl shadow-card">
            <v-card-title class="text-center text-h4 mb-6">
              Cadastro de Rotinas de Treinos
            </v-card-title>
  
            <v-divider></v-divider>
  
            <v-form @submit.prevent="adicionarTreino" class="mt-4">
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="novoTreino.nome"
                    label="Nome do Treino"
                    required
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
  
                <v-col cols="12">
                  <v-text-field
                    v-model="novoTreino.series"
                    label="Número de Séries"
                    type="number"
                    required
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
  
                <v-col cols="12">
                  <v-text-field
                    v-model="novoTreino.repeticoes"
                    label="Número de Repetições"
                    type="number"
                    required
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
  
                <v-col cols="12">
                  <v-btn type="submit" block color="primary" class="rounded-lg">
                    <v-icon left>add</v-icon> Adicionar Treino
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
  
            <v-divider class="my-4"></v-divider>
  
            <v-card-title class="text-center text-h5 mb-4">
              Treinos Cadastrados
            </v-card-title>
  
            <v-row v-if="treinos.length > 0">
              <v-col cols="12" v-for="(treino, index) in treinos" :key="index" class="mb-4">
                <v-row>
                  <v-col cols="3" class="text-right">
                    <v-icon color="primary">fitness_center</v-icon>
                  </v-col>
                  <v-col cols="9">
                    <p><strong>{{ treino.nome }}:</strong> {{ treino.series }} séries de {{ treino.repeticoes }} repetições</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
  
            <v-row v-else>
              <v-col cols="12" class="text-center">
                <p>Nenhum treino cadastrado.</p>
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
        novoTreino: {
          nome: '',
          series: null,
          repeticoes: null,
        },
        treinos: [],
      };
    },
    methods: {
      adicionarTreino() {
        if (this.novoTreino.nome && this.novoTreino.series && this.novoTreino.repeticoes) {
          this.treinos.push({ ...this.novoTreino });
          this.novoTreino = { nome: '', series: null, repeticoes: null };
        } else {
          alert('Por favor, preencha todos os campos.');
        }
      },
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