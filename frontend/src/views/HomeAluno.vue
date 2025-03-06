<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
        <v-card class="pa-5 rounded-xl shadow-card">
          <v-card-title class="text-center text-h4 mb-6">
            Área do Aluno
          </v-card-title>

          <v-row class="mt-4" justify="center">
            <!-- Botão Perfil -->
            <v-col cols="12">
              <v-btn block color="primary" @click="goTo('perfil')" class="rounded-lg btn-hover">
                <v-icon left>account_circle</v-icon> Perfil
              </v-btn>
            </v-col>

            <!-- Botão Meus Treinos -->
            <v-col cols="12">
              <v-btn block color="blue" @click="goTo('treinos')" class="rounded-lg btn-hover">
                <v-icon left>fitness_center</v-icon> Meus Treinos
              </v-btn>
            </v-col>

            <!-- Botão Sair -->
            <v-col cols="12">
              <v-btn block color="red" @click="logout" class="rounded-lg btn-hover">
                <v-icon left>logout</v-icon> Sair
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
  name: "HomeAluno",
  methods: {
    goTo(page) {
      this.$router.push(`/aluno/${page}`);
    },
    logout() {
      localStorage.removeItem("user");
      this.$router.push("/login");
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
  width:1800px;
  background: linear-gradient(to right, #eef2f3, #d9e2ec);
  padding: 50px;
}

.shadow-card {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  width: 100%;  /* Garantir que o card ocupe toda a largura disponível */
  max-width: 500px; /* Limitar a largura máxima para o card */
}

.v-btn {
  font-weight: bold;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 0.3s ease-in-out;
  padding: 16px 0; /* Aumenta a altura dos botões */
  font-size: 16px;
}

.v-btn:hover {
  transform: scale(1.05);
  filter: brightness(1.2);
}

.v-card {
  background-color: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  width: 100%; /* Certificar que o card usa toda a largura possível */
}

.v-card-title {
  color: #424242;
  white-space: normal;
  word-wrap: break-word;
}

.btn-hover {
  transition: all 0.3s ease-in-out;
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
</style>
