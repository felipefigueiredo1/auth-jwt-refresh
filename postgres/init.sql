-- Criar tabela "users"
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);

-- Inserir usuários na tabela
INSERT INTO users (name, email, password) VALUES ('John Doe', 'john@example.com', 'password123');
INSERT INTO users (name, email, password) VALUES ('Jane Smith', 'jane@example.com', 'p@ssw0rd');
INSERT INTO users (name, email, password) VALUES ('Alice Johnson', 'alice@example.com', 'secret123');
INSERT INTO users (name, email, password) VALUES ('Felipe Figueiredo', 'felipe@email.com', '123456');