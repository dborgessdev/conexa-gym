<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
        <v-card class="pa-5 rounded-xl shadow-card">
          <v-card-title class="text-center text-h4 mb-6">
            Gerenciar Treinos dos Alunos
          </v-card-title>

          <v-divider></v-divider>

          <!-- Select v2 para selecionar aluno -->
          <v-row class="mt-4">
            <v-col cols="12">
              <v-autocomplete
                v-model="alunoSelecionado"
                :items="alunos"
                item-value="id"
                item-title="username"
                label="Selecione um aluno"
                dense
                outlined
              ></v-autocomplete>
            </v-col>
          </v-row>

          <!-- Botão para abrir modal de gerenciamento -->
          <v-row v-if="alunoSelecionado">
            <v-col cols="12">
              <v-btn block color="primary" class="rounded-lg" @click="abrirModalTreinos">
                <v-icon left>edit</v-icon> Gerenciar Treino
              </v-btn>
            </v-col>
          </v-row>

          <v-divider class="my-4"></v-divider>

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

    <!-- Modal para Gerenciar Treinos -->
    <v-dialog v-model="modalTreinos" max-width="600px">
      <v-card>
        <v-card-title class="text-h5">
          Gerenciar Treinos - {{ alunoSelecionado?.username || 'Selecionado' }}
        </v-card-title>
        <v-divider></v-divider>

        <v-card-text>
          <div v-for="(treinos, dia) in treinosSemana" :key="dia">
            <v-subheader>{{ dia }}</v-subheader>
            <v-row v-for="(treino, index) in treinos" :key="index">
              <v-col cols="12">
                <v-text-field v-model="treino.nome" label="Nome do Exercício" dense outlined></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="treino.series" label="Séries" type="number" dense outlined></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="treino.repeticoes" label="Repetições" type="number" dense outlined></v-text-field>
              </v-col>
            </v-row>
          </div>
        </v-card-text>

        <v-divider></v-divider>
        
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" text @click="modalTreinos = false">Cancelar</v-btn>
          <v-btn color="green darken-1" text @click="salvarTreinos">Salvar</v-btn>
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
      alunoSelecionado: null,
      treinosSemana: {
        Segunda: [{ nome: "", series: 1, repeticoes: 1 }],
        Terça: [{ nome: "", series: 1, repeticoes: 1 }],
        Quarta: [{ nome: "", series: 1, repeticoes: 1 }],
        Quinta: [{ nome: "", series: 1, repeticoes: 1 }],
        Sexta: [{ nome: "", series: 1, repeticoes: 1 }],
        Sábado: [{ nome: "", series: 1, repeticoes: 1 }],
        Domingo: [{ nome: "", series: 1, repeticoes: 1 }]
      },
      modalTreinos: false,
    };
  },
  mounted() {
    this.carregarAlunos();
  },
  methods: {
    async carregarAlunos() {
      try {
        const response = await axios.get("http://localhost:8000/user/get-users");
        this.alunos = response.data.filter(user => user.role.toLowerCase() === "aluno");
      } catch (error) {
        console.error("Erro ao buscar alunos:", error);
      }
    },
    abrirModalTreinos() {
      this.modalTreinos = true;
    },
    async salvarTreinos() {
      try {
        const response = await axios.post("http://localhost:8000/training/save", {
          userId: this.alunoSelecionado.id,
          treinos: this.treinosSemana
        });

        if (response.data.success) {
          alert("Treinos salvos com sucesso!");
          this.modalTreinos = false;
        } else {
          alert("Erro ao salvar os treinos.");
        }
      } catch (error) {
        console.error("Erro ao salvar treinos:", error);
      }
    }
  }
};
</script>

<style scoped>
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
</style>