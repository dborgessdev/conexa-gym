<template>
    <v-container>
      <v-card>
        <v-card-title class="text-h5">Cadastro de Aluno</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="cadastrarAluno">
            <v-text-field v-model="aluno.username" label="Nome" required></v-text-field>
            <v-text-field v-model="aluno.age" label="Idade" type="number" required></v-text-field>
            <v-text-field v-model="aluno.weight" label="Peso (kg)" type="number" required></v-text-field>
            <v-text-field v-model="aluno.height" label="Altura (m)" type="number" required></v-text-field>
            <v-text-field v-model="aluno.password" label="Senha" type="password" required></v-text-field>
            <v-btn type="submit" color="primary">Cadastrar</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-container>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        aluno: {
          username: "",
          age: "",
          weight: "",
          height: "",
          password: "",
        },
      };
    },
    methods: {
        async cadastrarAluno() {
            try {
                const response = await axios.post("http://localhost:8000/api/users/create-user", {
                username: this.username,
                password: this.password,
                age: this.age,
                weight: this.weight,
                height: this.height,
                role: "aluno", // Adicionando role para o backend identificar
                });

                console.log("Aluno cadastrado com sucesso:", response.data);
            } catch (error) {
                console.error("Erro ao cadastrar aluno:", error);
            }
        },
    },
  };
  </script>
  