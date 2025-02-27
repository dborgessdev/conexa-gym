<template>
  <v-container class="perfil-container">
    <v-card class="perfil-card" elevation="3">
      <v-card-title class="text-center">
        <v-icon class="perfil-icon" size="36">mdi-account-cog</v-icon>
        Perfil do Administrador
      </v-card-title>
      <v-btn color="primary" to="/home">
        <span class="material-symbols-outlined">home</span> Home
      </v-btn>
      <v-card-text>
        <v-list dense>
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Nome:</v-list-item-title>
              <v-list-item-subtitle>{{ admin.username }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-email</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Email:</v-list-item-title>
              <v-list-item-subtitle>{{ admin.email }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      admin: JSON.parse(localStorage.getItem("user")) || {}
    };
  }
};
</script>

<style scoped>
.perfil-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.perfil-card {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  border-radius: 12px;
}

.perfil-icon {
  margin-bottom: 10px;
  color: #1976d2;
}
</style>
