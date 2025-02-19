<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="username" type="text" placeholder="Usuário" required />
      <input v-model="password" type="password" placeholder="Senha" required />
      <button type="submit">Entrar</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      username: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("http://localhost:8000/index.php?r=user/login", {
          username: this.username,
          password: this.password,
        });

        if (response.data.success) {
          // Verifica se o backend está retornando todos os dados necessários
          console.log("Dados recebidos do backend:", response.data.user);

          // Salva no localStorage corretamente
          localStorage.setItem("user", JSON.stringify(response.data.user));
          localStorage.setItem("token", response.data.user.token); // Salva o token corretamente
          
          this.$router.push("/home"); // Redireciona para home
        } else {
          this.errorMessage = response.data.message;
        }
      } catch (error) {
        this.errorMessage = "Erro ao conectar ao servidor.";
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  width: 300px;
  margin: 100px auto;
  padding: 20px;
  text-align: center;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

input {
  display: block;
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 10px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
