#!/bin/bash
# ============================================
# PostgreSQL Docker Runner
# Autor: Vinicius Rech
# Descrição: Sobe um container local do Postgres
# ============================================

# Configurações do container
CONTAINER_NAME="postgres_local"
DB_USER="laravel_user"
DB_PASS="laravel_password"
DB_NAME="laravel_db"
VOLUME_NAME="pgdata18"
PORT=5432
IMAGE="postgres:latest"

# Verifica se o Docker está rodando
if ! systemctl is-active --quiet docker; then
    echo "🟡 Iniciando serviço Docker..."
    sudo systemctl start docker
fi

# Verifica se já existe um container com o mesmo nome
if [ "$(docker ps -aq -f name=$CONTAINER_NAME)" ]; then
    echo "⚠️  Já existe um container chamado $CONTAINER_NAME."
    echo "Parando e removendo o antigo..."
    docker rm -f $CONTAINER_NAME >/dev/null 2>&1
fi

# Executa o container
echo "🚀 Subindo o container PostgreSQL..."
docker run -d \
  --name $CONTAINER_NAME \
  -e POSTGRES_USER=$DB_USER \
  -e POSTGRES_PASSWORD=$DB_PASS \
  -e POSTGRES_DB=$DB_NAME \
  -p $PORT:5432 \
  -v $VOLUME_NAME:/var/lib/postgresql \
  $IMAGE

# Confirma se subiu corretamente
if [ $? -eq 0 ]; then
    echo "✅ Container '$CONTAINER_NAME' iniciado com sucesso!"
    echo "📦 Banco: $DB_NAME"
    echo "👤 Usuário: $DB_USER"
    echo "🔑 Senha: $DB_PASS"
    echo "🌍 Porta: $PORT"
else
    echo "❌ Erro ao iniciar o container PostgreSQL."
fi
