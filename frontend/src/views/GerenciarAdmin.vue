<template>
    <v-container>
      <v-card>
        <v-card-title>Gerenciar Usuários</v-card-title>
        <v-card-text>
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn v-bind="props">Alunos</v-btn>
            </template>
            <v-list>
              <v-list-item v-for="aluno in alunos" :key="aluno.id">
                {{ aluno.username }} - {{ aluno.age }} anos
              </v-list-item>
            </v-list>
          </v-menu>
  
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn v-bind="props">Professores</v-btn>
            </template>
            <v-list>
              <v-list-item v-for="professor in professores" :key="professor.id">
                {{ professor.username }} - {{ professor.specialty }}
              </v-list-item>
            </v-list>
          </v-menu>
        </v-card-text>
      </v-card>
    </v-container>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        alunos: [],
        professores: [],
      };
    },
    async created() {
      try {
        const token = localStorage.getItem("token");
        const responseAlunos = await axios.get("/api/users/alunos", {
          headers: { Authorization: `Bearer ${token}` },
        });
        const responseProfessores = await axios.get("/api/users/professores", {
          headers: { Authorization: `Bearer ${token}` },
        });
  
        this.alunos = responseAlunos.data;
        this.professores = responseProfessores.data;
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      }
    },
  };
  </script>
  