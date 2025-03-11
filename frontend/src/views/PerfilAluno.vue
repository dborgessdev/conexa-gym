<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
        <v-card class="pa-5 rounded-xl shadow-card">
          <v-card-title class="text-center text-h4 mb-6">
            Perfil do Aluno
          </v-card-title>

          <v-divider></v-divider>

          <v-row class="mt-4" justify="center">
            <v-col cols="12" class="mb-4">
              <v-row>
                <v-col cols="3" class="text-right">
                  <v-icon color="primary">account_circle</v-icon>
                </v-col>
                <v-col cols="9">
                  <p><strong>Nome:</strong> {{ aluno.username }}</p>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" class="mb-4">
              <v-row>
                <v-col cols="3" class="text-right">
                  <v-icon color="primary">cake</v-icon>
                </v-col>
                <v-col cols="9">
                  <p><strong>Idade:</strong> {{ aluno.age }} anos</p>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" class="mb-4">
              <v-row>
                <v-col cols="3" class="text-right">
                  <v-icon color="primary">fitness_center</v-icon>
                </v-col>
                <v-col cols="9">
                  <p><strong>Peso:</strong> {{ aluno.weight }} kg</p>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" class="mb-4">
              <v-row>
                <v-col cols="3" class="text-right">
                  <v-icon color="primary">height</v-icon>
                </v-col>
                <v-col cols="9">
                  <p><strong>Altura:</strong> {{ aluno.height }} m</p>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" class="mb-4">
              <v-row>
                <v-col cols="3" class="text-right">
                  <v-icon :color="aluno.status === 'liberado' ? 'green' : 'red'">verified</v-icon>
                </v-col>
                <v-col cols="9">
                  <p><strong>Status:</strong> 
                    <span :style="{ color: aluno.status === 'liberado' ? 'green' : 'red' }">
                      {{ aluno.status }}
                    </span>
                  </p>
                </v-col>
              </v-row>
            </v-col>
          </v-row>

          <v-divider></v-divider>

          <v-row class="mt-4" justify="center">
            <v-col cols="12">
              <v-btn block color="primary" to="/home" class="rounded-lg btn-hover">
                <v-icon left>home</v-icon> Home
              </v-btn>
            </v-col>
            <v-col cols="12">
              <v-btn block color="success" class="rounded-lg btn-hover" @click="modalPagamento = true">
                <v-icon left>payment</v-icon> Pagar Mensalidade
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <v-dialog v-model="modalPagamento" max-width="500px">
      <v-card>
        <v-card-title class="text-h5">Pagamento da Mensalidade</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <p>Valor: R$ {{ valorMensalidade }}</p>
          <v-select
            v-model="formaPagamento"
            :items="['Pix', 'Cartão de Crédito']"
            label="Forma de Pagamento"
          ></v-select>
          <div v-if="formaPagamento === 'Pix'" class="text-center">
            <p>Escaneie o QR Code para pagamento:</p>
            <v-img src="/qrcode-fake.png" max-width="150" class="mx-auto"></v-img>
          </div>
          <div v-if="formaPagamento === 'Cartão de Crédito'">
            <v-text-field label="Número do Cartão" v-model="cartao.numero"></v-text-field>
            <v-text-field label="Validade" v-model="cartao.validade"></v-text-field>
            <v-text-field label="CVV" v-model="cartao.cvv" type="password"></v-text-field>
          </div>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="red" text @click="modalPagamento = false">Cancelar</v-btn>
          <v-btn color="green" @click="realizarPagamento">Pagar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    const savedUser = JSON.parse(localStorage.getItem("user")) || {};
  return {
      aluno: {
        id: savedUser.id || null, // Garante que ID seja recuperado corretamente
        username: savedUser.username || "",
        age: savedUser.age || 0,
        weight: savedUser.weight || 0,
        height: savedUser.height || 0,
        status: savedUser.status || "bloqueado",
      },
      modalPagamento: false,
      formaPagamento: "",
      cartao: {
        numero: "",
        validade: "",
        cvv: ""
      }
    };
  },
  computed: {
    valorMensalidade() {
      return 75;
    }
  },
  methods: {
    async realizarPagamento() {
      try {
        const apiBaseUrl = "http://localhost:8000";
        const response = await axios.post(`${apiBaseUrl}/user/register-payment`, { userId: this.aluno.id });
        
        if (response.data.success) {
          alert("Pagamento realizado com sucesso!");
          
          // Atualiza status
          this.aluno.status = "liberado";
          localStorage.setItem("user", JSON.stringify(this.aluno));
          
          // Força atualização da interface
          this.$forceUpdate();

          this.modalPagamento = false;
        } else {
          alert("Erro ao registrar pagamento: " + response.data.message);
        }
      } catch (error) {
        console.error("Erro na requisição:", error);
        alert("Falha ao processar o pagamento.");
      }
    }
  }
};
</script>

<style scoped>
.v-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to right, #eef2f3, #d9e2ec);
  padding: 50px;
}

.shadow-card {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  width: 100%;
  max-width: 500px;
}

.v-btn {
  font-weight: bold;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 0.3s ease-in-out;
  padding: 16px 0;
  font-size: 16px;
}

.v-btn:hover {
  transform: scale(1.05);
  filter: brightness(1.2);
}

.v-card {
  background-color: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.v-card-title {
  color: #424242;
  text-align: center;
}

.v-divider {
  margin: 16px 0;
}

.text-wrap {
  white-space: normal;
  word-break: break-word;
  text-align: center;
}

.btn-hover {
  transition: all 0.3s ease-in-out;
}
</style>
