<template>
    <div>
      <h1>Perfil do Professor</h1>
      <p>Nome: {{ professor.username }}</p>
      <p>Especialidade: {{ professor.specialty }}</p>
      <p>Experiência: {{ professor.experience }} anos</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        professor: JSON.parse(localStorage.getItem("user")) || {}
      };
    }
  };
  </script>
  