<template>
  <v-container>
    <v-card>
      <v-card-title class="d-flex align-center justify-space-between">
      <span>Gerenciar Usuários</span>
      <v-btn color="primary" to="/home">
        <span class="material-symbols-outlined">home</span> Home
      </v-btn>
    </v-card-title>
      <v-card-text>
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn v-bind="props">
              <span class="material-symbols-outlined">group</span> Alunos
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="aluno in alunos" :key="aluno.id">
              {{ aluno.username }} - {{ aluno.age }} anos
              <v-btn @click="editarAluno(aluno)" class="btn-amarelo">
                <span class="material-symbols-outlined">edit</span> Editar
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-btn color="primary" @click="dialogAluno = true">
          <span class="material-symbols-outlined">person_add</span> Adicionar Aluno
        </v-btn>

        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn v-bind="props">
              <span class="material-symbols-outlined">school</span> Professores
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="professor in professores" :key="professor.id">
              {{ professor.username }} - {{ professor.specialty }}
              <v-btn @click="editarProfessor(professor)" class="btn-amarelo">
                <span class="material-symbols-outlined">edit</span> Editar
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-btn color="primary" @click="dialogProfessor = true">
          <span class="material-symbols-outlined">person_add</span> Adicionar Professor
        </v-btn>
      </v-card-text>
    </v-card>

    <!-- Modal para cadastrar Aluno -->
    <v-dialog v-model="dialogAluno" max-width="400px">
      <v-card>
        <v-card-title>
          <span class="material-symbols-outlined">person_add</span> Cadastrar Aluno
        </v-card-title>
        <v-card-text>
          <v-text-field v-model="novoAluno.username" label="Nome"></v-text-field>
          <v-text-field v-model="novoAluno.email" label="Email"></v-text-field>
          <v-text-field v-model="novoAluno.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="novoAluno.age" label="Idade" type="number"></v-text-field>
          <v-text-field v-model="novoAluno.weight" label="Peso (kg)" type="number"></v-text-field>
          <v-text-field v-model="novoAluno.height" label="Altura (m)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogAluno = false">
            <span class="material-symbols-outlined">cancel</span> Cancelar
          </v-btn>
          <v-btn color="primary" @click="cadastrarAluno">
            <span class="material-symbols-outlined">save</span> Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal para cadastrar Professor -->
    <v-dialog v-model="dialogProfessor" max-width="400px">
      <v-card>
        <v-card-title>
          <span class="material-symbols-outlined">person_add</span> Cadastrar Professor
        </v-card-title>
        <v-card-text>
          <v-text-field v-model="novoProfessor.username" label="Nome"></v-text-field>
          <v-text-field v-model="novoProfessor.email" label="Email"></v-text-field>
          <v-text-field v-model="novoProfessor.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="novoProfessor.specialty" label="Especialidade"></v-text-field>
          <v-text-field v-model="novoProfessor.experience" label="Experiência (anos)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogProfessor = false">
            <span class="material-symbols-outlined">cancel</span> Cancelar
          </v-btn>
          <v-btn color="primary" @click="cadastrarProfessor">
            <span class="material-symbols-outlined">save</span> Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal para editar Aluno -->
    <v-dialog v-model="dialogEditarAluno" max-width="400px">
      <v-card>
        <v-card-title>
          <span class="material-symbols-outlined">edit</span> Editar Aluno
        </v-card-title>
        <v-card-text>
          <v-text-field v-model="alunoEditando.username" label="Nome"></v-text-field>
          <v-text-field v-model="alunoEditando.email" label="Email"></v-text-field>
          <v-text-field v-model="alunoEditando.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="alunoEditando.age" label="Idade" type="number"></v-text-field>
          <v-text-field v-model="alunoEditando.weight" label="Peso (kg)" type="number"></v-text-field>
          <v-text-field v-model="alunoEditando.height" label="Altura (m)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogEditarAluno = false">
            <span class="material-symbols-outlined">cancel</span> Cancelar
          </v-btn>
          <v-btn color="primary" @click="salvarEdicaoAluno">
            <span class="material-symbols-outlined">save</span> Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal para editar Professor -->
    <v-dialog v-model="dialogEditarProfessor" max-width="400px">
      <v-card>
        <v-card-title>
          <span class="material-symbols-outlined">edit</span> Editar Professor
        </v-card-title>
        <v-card-text>
          <v-text-field v-model="professorEditando.username" label="Nome"></v-text-field>
          <v-text-field v-model="professorEditando.email" label="Email"></v-text-field>
          <v-text-field v-model="professorEditando.password" label="Senha" type="password"></v-text-field>
          <v-text-field v-model="professorEditando.specialty" label="Especialidade"></v-text-field>
          <v-text-field v-model="professorEditando.experience" label="Experiência (anos)" type="number"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialogEditarProfessor = false">
            <span class="material-symbols-outlined">cancel</span> Cancelar
          </v-btn>
          <v-btn color="primary" @click="salvarEdicaoProfessor">
            <span class="material-symbols-outlined">save</span> Salvar
          </v-btn>
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
      dialogEditarAluno: false,
      dialogEditarProfessor: false,
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
      alunoEditando: {
        id: null,
        username: "",
        email: "",
        age: "",
        weight: "",
        height: "",
      },
      professorEditando: {
        id: null,
        username: "",
        email: "",
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
    editarAluno(aluno) {
      this.alunoEditando = { ...aluno };
      this.dialogEditarAluno = true;
    },
    editarProfessor(professor) {
      this.professorEditando = { ...professor };
      this.dialogEditarProfessor = true;
    },
    async salvarEdicaoAluno() {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.put(`http://localhost:8000/index.php?r=user/update-user&id=${this.alunoEditando.id}`, {
          username: this.alunoEditando.username,
          email: this.alunoEditando.email,
          password: this.alunoEditando.password,
          age: this.alunoEditando.age,
          weight: this.alunoEditando.weight,
          height: this.alunoEditando.height,
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.data.success) {
          alert("Aluno atualizado com sucesso!");
          this.dialogEditarAluno = false;
          this.buscarUsuarios();
        } else {
          alert("Erro ao atualizar aluno: " + response.data.message);
        }
      } catch (error) {
        console.error("Erro ao atualizar aluno:", error);
      }
    },
    async salvarEdicaoProfessor() {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.put(`http://localhost:8000/index.php?r=user/update-user&id=${this.professorEditando.id}`, {
          username: this.professorEditando.username,
          email: this.professorEditando.email,
          password: this.professorEditando.password,
          specialty: this.professorEditando.specialty,
          experience: this.professorEditando.experience,
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.data.success) {
          alert("Professor atualizado com sucesso!");
          this.dialogEditarProfessor = false;
          this.buscarUsuarios();
        } else {
          alert("Erro ao atualizar professor: " + response.data.message);
        }
      } catch (error) {
        console.error("Erro ao atualizar professor:", error);
      }
    },
  },
};
</script>