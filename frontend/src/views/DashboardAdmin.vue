<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" md="8">
        <v-card class="pa-8 shadow-card">
          <v-card-title class="text-center text-h3 font-weight-regular">
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
            <v-list-item v-bind="props" class="ma-1"> <!-- Margem de 2px -->
              <v-list-item-action>
                <v-btn
                  :color="item.raw.status === 1 ? 'green' : 'red'"
                  small
                  @click="openModal(item.raw)"
                >
                  {{ item.raw.status === 1 ? "Liberado" : "Bloqueado" }}
                </v-btn>
              </v-list-item-action>
            </v-list-item>
          </template>
        </v-autocomplete>

          <p v-else class="text-center mt-4 text-red">Carregando usuários...</p>

          <!-- Exibição de detalhes do usuário selecionado -->
          <v-card v-if="selectedUserData" class="mt-4 pa-4">
            <v-card-subtitle>Detalhes do Usuário</v-card-subtitle>
            <v-card-text>
              <p><strong>Nome:</strong> {{ selectedUserData.username }}</p>
              <p><strong>Email:</strong> {{ selectedUserData.email }}</p>
              <p><strong>Tipo:</strong> {{ selectedUserData.role }}</p>
              <p><strong>Status:</strong> 
                <v-btn
                  :color="selectedUserData.status === 1 ? 'green' : 'red'"
                  small
                  @click="openModal(selectedUserData)"
                >
                  {{ selectedUserData.status === 1 ? "Liberado" : "Bloqueado" }}
                </v-btn>
              </p>
            </v-card-text>
          </v-card>
        </v-card>
      </v-col>
    </v-row>

    <!-- Modal de Ações -->
    <v-dialog v-model="modalOpen" max-width="500px">
      <v-card>
        <v-card-title class="text-h5">Gerenciar Acesso</v-card-title>
        <v-card-text>
          <p><strong>Usuário:</strong> {{ modalUser?.username }}</p>

          <!-- Enviar Cobrança -->
          <v-divider class="my-2"></v-divider>
          <p><strong>Enviar Cobrança:</strong></p>
          <v-text-field label="E-mail" v-model="email" outlined dense></v-text-field>
          <v-text-field label="WhatsApp" v-model="whatsapp" outlined dense></v-text-field>
          <v-btn color="primary" block @click="sendCharge">Enviar</v-btn>

          <!-- Liberar acesso unitário -->
          <v-divider class="my-2"></v-divider>
          <p><strong>Liberar acesso por 1 dia:</strong></p>
          <v-btn color="green" block @click="grantTemporaryAccess">
            Liberar por 1 dia
          </v-btn>
        </v-card-text>

        <v-card-actions>
          <v-btn color="red" block @click="modalOpen = false">Fechar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
      modalOpen: false,
      modalUser: null,
      email: "",
      whatsapp: "",
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
        if (Array.isArray(response.data)) {
          this.users = response.data;
        } else {
          console.error("Formato de resposta inesperado", response.data);
        }
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      }
    },

    openModal(user) {
      this.modalUser = user;
      this.email = user.email || "";
      this.whatsapp = "";
      this.modalOpen = true;
    },

    sendCharge() {
      if (!this.email && !this.whatsapp) {
        alert("Preencha pelo menos um campo para enviar a cobrança.");
        return;
      }

      console.log(`Enviando cobrança para ${this.modalUser.username}`);
      console.log(`E-mail: ${this.email}, WhatsApp: ${this.whatsapp}`);

      // Aqui você pode implementar a chamada para API que enviará a cobrança
      alert("Cobrança enviada com sucesso!");
    },

    async grantTemporaryAccess() {
      try {
        const response = await axios.post("http://localhost:8000/user/temporary-access", {
          userId: this.modalUser.id,
        });

        if (response.data.success) {
          alert("Acesso liberado por 1 dia!");
          this.modalUser.status = 1; // Atualiza visualmente
          this.modalOpen = false;
        } else {
          alert("Erro ao liberar acesso.");
        }
      } catch (error) {
        console.error("Erro ao liberar acesso:", error);
      }
    },
  },
};
</script>
