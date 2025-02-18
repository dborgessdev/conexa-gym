<template>
    <div>
      <h1>Perfil do Aluno</h1>
      <p>Nome: {{ aluno.username }}</p>
      <p>Idade: {{ aluno.age }} anos</p>
      <p>Peso: {{ aluno.weight }} kg</p>
      <p>Altura: {{ aluno.height }} m</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        aluno: JSON.parse(localStorage.getItem("user")) || {}
      };
    }
  };
  </script>
  