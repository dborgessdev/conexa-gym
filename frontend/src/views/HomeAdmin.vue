<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" md="10">
        <v-card class="pa-8 shadow-card">
          <v-card-title class="text-center text-h3 font-weight-bold text-wrap">
            💼 Painel Administrativo
          </v-card-title>
          <v-divider class="my-6"></v-divider>

          <v-row class="mt-6" justify="center">
            <v-col cols="6" sm="3">
              <v-btn block color="primary" class="btn-hover text-wrap btn-large" @click="goTo('perfil')">
                <span class="material-symbols-outlined">account_circle</span> Perfil
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="blue" class="btn-hover text-wrap btn-large" @click="goTo('gerenciar')">
                <span class="material-symbols-outlined">settings</span> Gerenciar
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="green" class="btn-hover text-wrap btn-large" @click="goTo('dashboard')">
                <span class="material-symbols-outlined">bar_chart</span> Dashboard
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="red" class="btn-hover text-wrap btn-large" @click="logout">
                <span class="material-symbols-outlined">logout</span> Sair
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
  name: "HomeAdmin",
  methods: {
    goTo(page) {
      this.$router.push(`/admin/${page}`);
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
  background: linear-gradient(to right, #eef2f3, #d9e2ec);
  padding: 50px;
}

.shadow-card {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  border-radius: 16px;
  max-width: 900px;
}

.btn-hover {
  transition: all 0.3s ease-in-out;
  white-space: normal;
}

.btn-hover:hover {
  transform: scale(1.08);
  filter: brightness(1.2);
}

.btn-large {
  font-size: 14px;
  padding: 24px 70px;
}

.material-symbols-outlined {
  font-size: 28px;
  margin-right: 10px;
}

.text-wrap {
  white-space: normal;
  word-break: break-word;
  text-align: center;
}
</style>
