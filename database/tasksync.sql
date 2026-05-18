-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS tasksync;
USE tasksync;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    setor VARCHAR(50) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de tarefas
CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    descricao TEXT NOT NULL,
    setor VARCHAR(50) NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta') NOT NULL,
    data_cadastro DATE NOT NULL,
    status ENUM('a_fazer', 'fazendo', 'concluido') DEFAULT 'a_fazer',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Inserir alguns dados de exemplo
INSERT INTO usuarios (nome, email, setor) VALUES
('João Silva', 'joao@tasksync.com', 'Desenvolvimento'),
('Maria Oliveira', 'maria@tasksync.com', 'Design'),
('Carlos Santos', 'carlos@tasksync.com', 'Marketing');

INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, data_cadastro, status) VALUES
(1, 'Desenvolver API de usuários', 'Desenvolvimento', 'alta', CURDATE(), 'a_fazer'),
(1, 'Documentar sistema', 'Desenvolvimento', 'media', CURDATE(), 'fazendo'),
(2, 'Criar protótipo das telas', 'Design', 'alta', CURDATE(), 'concluido'),
(3, 'Criar campanha de lançamento', 'Marketing', 'baixa', CURDATE(), 'a_fazer');