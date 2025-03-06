# Usa a imagem oficial do Node.js
FROM node:18

# Define o diretório de trabalho
WORKDIR /app

# Copia apenas os arquivos de configuração do npm (package.json e package-lock.json)
COPY package*.json ./

# Instala as dependências
RUN npm install

# Agora, copia o restante dos arquivos
COPY . .

# Expõe a porta do frontend
EXPOSE 5173

# Comando para rodar o Vue em modo desenvolvimento
CMD ["npm", "run", "dev", "--", "--host"]

