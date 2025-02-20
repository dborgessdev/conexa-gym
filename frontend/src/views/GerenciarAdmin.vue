<template>
  <v-container>
    <v-card>
      <v-card-title class="text-h5">Gerenciar Usuários</v-card-title>
      <v-card-text>
        <!-- Dropdown de Alunos -->
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

        <!-- Dropdown de Professores -->
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

  <!-- Botões de Cadastro -->
  <v-container>
    <v-card>
      <v-card-title class="text-h5">Cadastrar Usuários</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="6">
            <v-btn block color="primary" @click="modalAluno = true">
              <v-icon left>mdi-account-plus</v-icon> Cadastrar Aluno
            </v-btn>
          </v-col>
          <v-col cols="12" sm="6">
            <v-btn block color="green" @click="modalProfessor = true">
              <v-icon left>mdi-account-plus</v-icon> Cadastrar Professor
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>

  <!-- MODAL DE CADASTRO DE ALUNO -->
  <v-dialog v-model="modalAluno" max-width="500px">
    <v-card>
      <v-card-title class="text-h5">Cadastro de Aluno</v-card-title>
      <v-card-text>
        <v-text-field label="Nome" v-model="novoAluno.username"></v-text-field>
        <v-text-field label="Idade" type="number" v-model="novoAluno.age"></v-text-field>
        <v-text-field label="Peso (kg)" type="number" v-model="novoAluno.weight"></v-text-field>
        <v-text-field label="Altura (cm)" type="number" v-model="novoAluno.height"></v-text-field>
        <v-text-field label="Senha" type="password" v-model="novoAluno.password"></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn color="red" text @click="modalAluno = false">Cancelar</v-btn>
        <v-btn color="blue" text @click="cadastrarAluno">Salvar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <!-- MODAL DE CADASTRO DE PROFESSOR -->
  <v-dialog v-model="modalProfessor" max-width="500px">
    <v-card>
      <v-card-title class="text-h5">Cadastro de Professor</v-card-title>
      <v-card-text>
        <v-text-field label="Nome" v-model="novoProfessor.username"></v-text-field>
        <v-text-field label="Especialidade" v-model="novoProfessor.specialty"></v-text-field>
        <v-text-field label="Anos de Experiência" type="number" v-model="novoProfessor.experience"></v-text-field>
        <v-text-field label="Senha" type="password" v-model="novoProfessor.password"></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn color="red" text @click="modalProfessor = false">Cancelar</v-btn>
        <v-btn color="blue" text @click="cadastrarProfessor">Salvar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      alunos: [],
      professores: [],
      modalAluno: false,
      modalProfessor: false,
      novoAluno: { username: "", age: "", weight: "", height: "", password: "" },
      novoProfessor: { username: "", specialty: "", experience: "", password: "" },
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
  methods: {
    async cadastrarAluno() {
      try {
        const token = localStorage.getItem("token");
        await axios.post("/api/users/create-aluno", this.novoAluno, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.modalAluno = false;
        alert("Aluno cadastrado com sucesso!");
      } catch (error) {
        alert("Erro ao cadastrar aluno!");
        console.error(error);
      }
    },
    async cadastrarProfessor() {
      try {
        const token = localStorage.getItem("token");
        await axios.post("/api/users/create-professor", this.novoProfessor, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.modalProfessor = false;
        alert("Professor cadastrado com sucesso!");
      } catch (error) {
        alert("Erro ao cadastrar professor!");
        console.error(error);
      }
    },
  },
};
</script>
