FROM postgres

# Instalar extensões adicionais
RUN apt-get update \
    && apt-get install -y postgresql-contrib

# Adicionar scripts SQL para inicialização do banco de dados
COPY init.sql /docker-entrypoint-initdb.d/

# Definir variáveis de ambiente
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD 123456
ENV POSTGRES_DB teste

EXPOSE 5432