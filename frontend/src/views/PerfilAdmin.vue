<template>
  <div>
    <h1>Perfil do Administrador</h1>
    <p>Nome: {{ admin.username }}</p>
    <p>Email: {{ admin.email }}</p>
  </div>
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
