<template>
    <v-container>
      <v-card>
        <v-card-title class="text-h5">Cadastro de Professor</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="cadastrarProfessor">
            <v-text-field v-model="professor.username" label="Nome" required></v-text-field>
            <v-text-field v-model="professor.specialty" label="Especialidade" required></v-text-field>
            <v-text-field v-model="professor.experience" label="Experiência (anos)" type="number" required></v-text-field>
            <v-text-field v-model="professor.password" label="Senha" type="password" required></v-text-field>
            <v-btn type="submit" color="green">Cadastrar</v-btn>
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
        professor: {
          username: "",
          specialty: "",
          experience: "",
          password: "",
        },
      };
    },
    methods: {
      async cadastrarProfessor() {
        try {
          await axios.post("http://localhost:8000/index.php?r=user/create-professor", this.professor);
          alert("Professor cadastrado com sucesso!");
          this.$router.push("/admin/gerenciar");
        } catch (error) {
          alert("Erro ao cadastrar professor.");
        }
      },
    },
  };
  </script>
  