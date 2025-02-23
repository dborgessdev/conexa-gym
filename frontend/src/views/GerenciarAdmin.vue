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

        <v-btn color="primary" @click="dialogAluno = true">Adicionar Aluno</v-btn>

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

        <v-btn color="primary" @click="dialogProfessor = true">Adicionar Professor</v-btn>
      </v-card-text>
    </v-card>

    <!-- Modal para cadastrar Aluno -->
    <v-dialog v-model="dialogAluno" max-width="400px">
      <v-card>
        <v-card-title>Cadastrar Aluno</v-card-title>
        <v-card-text>
          <v-text-field v-model="novoAluno.username" label="Nome"></v-text-field>
          <v-text-field v-model="novoAluno.email" label="Email"></v-text-field>
          <v-text-field v-model="novoAluno.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="novoAluno.age" label="Idade" type="number"></v-text-field>
          <v-text-field v-model="novoAluno.weight" label="Peso (kg)" type="number"></v-text-field>
          <v-text-field v-model="novoAluno.height" label="Altura (m)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogAluno = false">Cancelar</v-btn>
          <v-btn color="primary" @click="cadastrarAluno">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal para cadastrar Professor -->
    <v-dialog v-model="dialogProfessor" max-width="400px">
      <v-card>
        <v-card-title>Cadastrar Professor</v-card-title>
        <v-card-text>
          <v-text-field v-model="novoProfessor.username" label="Nome"></v-text-field>
          <v-text-field v-model="novoProfessor.email" label="Email"></v-text-field>
          <v-text-field v-model="novoProfessor.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="novoProfessor.specialty" label="Especialidade"></v-text-field>
          <v-text-field v-model="novoProfessor.experience" label="Experiência (anos)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogProfessor = false">Cancelar</v-btn>
          <v-btn color="primary" @click="cadastrarProfessor">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      alunos: [],
      professores: [],
      dialogAluno: false,
      dialogProfessor: false,
      novoAluno: {
        username: "",
        email: "",
        password: "",
        age: "",
        weight: "",
        height: "",
      },
      novoProfessor: {
        username: "",
        email: "",
        password: "",
        specialty: "",
        experience: "",
      },
    };
  },
  async created() {
    await this.buscarUsuarios();
  },
  methods: {
    async buscarUsuarios() {
      try {
        const token = localStorage.getItem("token");
        const responseAlunos = await axios.get("http://localhost:8000/index.php?r=user/alunos", {
          headers: { Authorization: `Bearer ${token}` },
        });
        const responseProfessores = await axios.get("http://localhost:8000/index.php?r=user/professores", {
          headers: { Authorization: `Bearer ${token}` },
        });

        this.alunos = responseAlunos.data;
        this.professores = responseProfessores.data;
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      }
    },
    async cadastrarAluno() {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.post("http://localhost:8000/index.php?r=user/create-user", {
          username: this.novoAluno.username,
          email: this.novoAluno.email,
          password: this.novoAluno.password,
          role: "aluno",
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.data.success) {
          alert("Aluno cadastrado com sucesso!");
          this.dialogAluno = false;
          this.buscarUsuarios();
        } else {
          alert("Erro ao cadastrar aluno: " + response.data.message);
        }
      } catch (error) {
        console.error("Erro ao cadastrar aluno:", error);
      }
    },
    async cadastrarProfessor() {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.post("http://localhost:8000/index.php?r=user/create-user", {
          username: this.novoProfessor.username,
          email: this.novoProfessor.email,
          password: this.novoProfessor.password,
          role: "professor",
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.data.success) {
          alert("Professor cadastrado com sucesso!");
          this.dialogProfessor = false;
          this.buscarUsuarios();
        } else {
          alert("Erro ao cadastrar professor: " + response.data.message);
        }
      } catch (error) {
        console.error("Erro ao cadastrar professor:", error);
      }
    },
  },
};
</script>
