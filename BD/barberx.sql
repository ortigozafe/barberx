-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS barberx;
USE barberx;

-- Tabela de donos das barbearias
CREATE TABLE dono (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de barbearias
CREATE TABLE barbearia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT,
    dono_id INT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dono_id) REFERENCES dono(id) ON DELETE CASCADE
);

-- Tabela de profissionais
CREATE TABLE profissional (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    especialidade VARCHAR(100),
    barbearia_id INT NOT NULL,
    FOREIGN KEY (barbearia_id) REFERENCES barbearia(id) ON DELETE CASCADE
);

-- Tabela de clientes
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de serviços
CREATE TABLE servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2),
    duracao_minutos INT,
    barbearia_id INT NOT NULL,
    FOREIGN KEY (barbearia_id) REFERENCES barbearia(id) ON DELETE CASCADE
);

-- Tabela de agendamentos
CREATE TABLE agendamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    profissional_id INT,
    servico_id INT,
    data_hora DATETIME NOT NULL,
    status ENUM('agendado', 'concluido', 'cancelado') DEFAULT 'agendado',
    observacoes TEXT,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (profissional_id) REFERENCES profissional(id),
    FOREIGN KEY (servico_id) REFERENCES servico(id)
);

-- ======================
-- Dados de exemplo
-- ======================

-- Inserir dono
INSERT INTO dono (nome, telefone, email, senha)
VALUES ('Lucas Nogueira', '(11) 91111-2222', 'lucas@donos.com', 'senha123');

-- Inserir barbearia associada
INSERT INTO barbearia (nome, cnpj, telefone, email, endereco, dono_id)
VALUES ('Barbearia Central', '33.333.333/0001-33', '(11) 92222-3333', 'central@barber.com', 'Rua Principal, 789', 1);

-- Inserir serviços
INSERT INTO servico (nome, descricao, preco, duracao_minutos, barbearia_id)
VALUES 
('Corte Masculino', 'Corte com tesoura ou máquina.', 30.00, 30, 1),
('Barba Completa', 'Modelagem e hidratação da barba.', 25.00, 25, 1);

-- Inserir profissionais
INSERT INTO profissional (nome, telefone, email, especialidade, barbearia_id)
VALUES 
('Bruno Cortez', '(11) 90000-1111', 'bruno@barber.com', 'Corte masculino', 1),
('Rafael Silva', '(11) 90000-2222', 'rafael@barber.com', 'Barba e corte', 1);

-- Inserir cliente
INSERT INTO cliente (nome, telefone, email)
VALUES ('Carlos Silva', '(11) 97777-1234', 'carlos@email.com');

-- Inserir agendamento
INSERT INTO agendamento (cliente_id, profissional_id, servico_id, data_hora, observacoes)
VALUES (1, 1, 1, '2025-06-10 14:00:00', 'Prefere corte com tesoura');
