<template>
  <div class="home-container">
    <h1>Bem-vindo à Home</h1>
    <p>Você está autenticado!</p>
    <button @click="logout">Sair</button>
  </div>
</template>

<script>
export default {
  name: "Home",
  methods: {
    logout() {
      localStorage.removeItem("user");
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
.home-container {
  text-align: center;
  margin-top: 50px;
}

button {
  padding: 10px 20px;
  background: red;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background: darkred;
}
</style>
  