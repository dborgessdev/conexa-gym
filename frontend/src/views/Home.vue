<template>
  <div>
    <HomeAdmin v-if="userRole === 'admin'" />
    <HomeProfessor v-else-if="userRole === 'professor'" />
    <HomeAluno v-else-if="userRole === 'aluno'" />
    <p v-else>Erro: Tipo de usuário desconhecido</p>
  </div>
</template>

<script>
import HomeAdmin from "@/views/HomeAdmin.vue";
import HomeProfessor from "@/views/HomeProfessor.vue";
import HomeAluno from "@/views/HomeAluno.vue";

export default {
  name: "Home",
  components: {
    HomeAdmin,
    HomeProfessor,
    HomeAluno,
  },
  data() {
    return {
      userRole: null,
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    if (user && user.role) {
      this.userRole = user.role;
    } else {
      this.$router.push("/login");
    }
  },
};
</script>
