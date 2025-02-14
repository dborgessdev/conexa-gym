<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" md="8">
        <v-card class="pa-5">
          <v-card-title class="text-center text-h4">Painel Administrativo</v-card-title>

          <v-row class="mt-4">
            <v-col cols="6" sm="3">
              <v-btn block color="primary" @click="goTo('perfil')">
                <v-icon left>mdi-account</v-icon> Perfil
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="blue" @click="goTo('gerenciar')">
                <v-icon left>mdi-cog</v-icon> Gerenciar
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="green" @click="goTo('dashboard')">
                <v-icon left>mdi-chart-bar</v-icon> Dashboard
              </v-btn>
            </v-col>

            <v-col cols="6" sm="3">
              <v-btn block color="red" @click="logout">
                <v-icon left>mdi-logout</v-icon> Sair
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
}
</style>
