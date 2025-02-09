# Usa a imagem oficial do Node.js
FROM node:18

# Define o diretório de trabalho
WORKDIR /app

# Copia os arquivos do frontend para o container
COPY . .

# Instala as dependências
RUN npm install

# Expõe a porta do frontend
EXPOSE 5173

# Comando para rodar o Vue em modo desenvolvimento
CMD ["npm", "run", "dev", "--", "--host"]
