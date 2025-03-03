<template>
    <v-container class="fill-height">
      <v-row justify="center">
        <v-col cols="12" md="8">
          <v-card class="pa-8 shadow-card">
            <v-card-title class="text-center text-h3 font-weight-bold">
              📊 Dashboard Administrativo
            </v-card-title>
            <v-btn color="primary" to="/home">
                <span class="material-symbols-outlined">home</span> Home
            </v-btn>
            <v-divider class="my-6"></v-divider>
  
            <!-- Campo de Busca -->
            <v-autocomplete
                v-if="users.length > 0"
                v-model="selectedUser"
                :items="users"
                item-title="username"
                item-value="id"
                label="Pesquisar Usuário"
                dense
                outlined
                clearable
                no-data-text="Nenhum usuário encontrado"
                class="mt-4"
                >
            <template v-slot:item="{ props, item }">
                <v-list-item v-bind="props">
                <v-list-item-title>
                    {{ item.raw.status }}
                </v-list-item-title>
                </v-list-item>
            </template>
            </v-autocomplete>
  
            <p v-else class="text-center mt-4 text-red">Carregando usuários...</p>
  
            <!-- Exibição de detalhes do usuário selecionado -->
            <v-card v-if="selectedUserData" class="mt-4 pa-4">
              <v-card-subtitle>Detalhes do Usuário</v-card-subtitle>
              <v-card-text>
                <p><strong>Nome:</strong> {{ selectedUserData.username }}</p>
                <p><strong>Status:</strong> {{ selectedUserData.status }}</p>
                <p><strong>Email:</strong> {{ selectedUserData.email }}</p>
                <p><strong>Tipo:</strong>{{ selectedUserData.role }}</p>
              </v-card-text>
            </v-card>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "DashboardAdmin",
    data() {
      return {
        users: [],
        selectedUser: null,
      };
    },
    computed: {
      selectedUserData() {
        return this.users?.find((user) => user.id === this.selectedUser) || null;
      },
    },
    async mounted() {
      await this.fetchUsers();
    },
    methods: {
      async fetchUsers() {
        try {
          const response = await axios.get("http://localhost:8000/user/get-users");
            // Se a resposta for um array, atribuímos diretamente
            if (Array.isArray(response.data)) {
            this.users = response.data;
            } else {
            console.error("Formato de resposta inesperado", response.data);
            }
        } catch (error) {
            console.error("Erro ao buscar usuários:", error);
        }
      }
    },
  };
  </script>
  