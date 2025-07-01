-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS barberx;
USE barberx;

-- Tabela de donos das barbearias
CREATE TABLE dono (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) UNIQUE,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de barbearias
CREATE TABLE barbearia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT,
    dono_id INT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    imagem VARCHAR(255),
    FOREIGN KEY (dono_id) REFERENCES dono(id) ON DELETE CASCADE
);

-- Tabela de horários
CREATE TABLE horario_funcionamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barbearia_id INT NOT NULL,
    dia_semana ENUM('domingo','segunda','terca','quarta','quinta','sexta','sabado') NOT NULL,
    horario_abertura TIME NOT NULL,
    horario_fechamento TIME NOT NULL,
    FOREIGN KEY (barbearia_id) REFERENCES barbearia(id) ON DELETE CASCADE
);

-- Tabela de profissionais
CREATE TABLE profissional (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    barbearia_id INT NOT NULL,
    FOREIGN KEY (barbearia_id) REFERENCES barbearia(id) ON DELETE CASCADE
);

-- Tabela de clientes
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) UNIQUE,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255),
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
    barbearia_id INT,
    data_hora DATETIME NOT NULL,
    status ENUM('agendado', 'concluido', 'cancelado') DEFAULT 'agendado',
    observacoes TEXT,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (profissional_id) REFERENCES profissional(id),
    FOREIGN KEY (servico_id) REFERENCES servico(id),
    FOREIGN KEY (barbearia_id) REFERENCES barbearia(id)
);

