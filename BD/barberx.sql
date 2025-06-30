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

-- Inserindo donos
INSERT INTO dono (nome, telefone, email, senha)
VALUES 
('João Barbosa', '(11) 99999-0001', 'joao@barberx.com', 'senha123'),
('Carlos Mendes', '(11) 99999-0002', 'carlos@barberx.com', 'senha123'),
('Marcos Silva', '(11) 99999-0003', 'marcos@barberx.com', 'senha123');

-- Inserindo barbearias
INSERT INTO barbearia (nome, cnpj, telefone, email, endereco, dono_id, imagem)
VALUES 
('Barbearia do João', '12.345.678/0001-01', '(11) 90000-1000', 'contato@joaobarber.com', 'Rua A, 123, São Paulo', 1, 'joaobarber.jpg'),
('Barbearia Estilo', '23.456.789/0001-02', '(11) 90000-2000', 'contato@estilo.com', 'Rua B, 456, São Paulo', 2, 'estilo.jpg'),
('Barbearia Moderna', '34.567.890/0001-03', '(11) 90000-3000', 'contato@moderna.com', 'Av. C, 789, São Paulo', 3, 'moderna.jpg');

-- Inserindo horários de funcionamento
INSERT INTO horario_funcionamento (barbearia_id, dia_semana, horario_abertura, horario_fechamento)
VALUES
(1, 'segunda', '09:00:00', '19:00:00'),
(1, 'terca', '09:00:00', '19:00:00'),
(1, 'quarta', '09:00:00', '19:00:00'),
(2, 'quinta', '10:00:00', '20:00:00'),
(2, 'sexta', '10:00:00', '20:00:00'),
(3, 'sabado', '08:00:00', '16:00:00');

-- Inserindo profissionais
INSERT INTO profissional (nome, telefone, email, barbearia_id)
VALUES
('Pedro Cortez', '(11) 98888-1111', 'pedro@barber.com', 1),
('Lucas Barros', '(11) 98888-2222', 'lucas@barber.com', 1),
('Bruno Costa', '(11) 98888-3333', 'bruno@barber.com', 2),
('Ricardo Alves', '(11) 98888-4444', 'ricardo@barber.com', 3);

-- Inserindo clientes
INSERT INTO cliente (nome, telefone, email, senha)
VALUES
('Felipe Souza', '(11) 97777-0001', 'felipe@cliente.com', 'senha123'),
('Ana Paula', '(11) 97777-0002', 'ana@cliente.com', 'senha123'),
('Roberto Lima', '(11) 97777-0003', 'roberto@cliente.com', 'senha123');

-- Inserindo serviços
INSERT INTO servico (nome, descricao, preco, duracao_minutos, barbearia_id)
VALUES
('Corte Masculino', 'Corte tradicional masculino', 50.00, 30, 1),
('Barba', 'Aparar e modelar barba', 30.00, 20, 1),
('Corte + Barba', 'Pacote corte + barba', 70.00, 50, 2),
('Hidratação', 'Hidratação capilar', 40.00, 45, 3);


-- Inserindo agendamento
INSERT INTO agendamento (cliente_id, profissional_id, servico_id, barbearia_id, data_hora, status, observacoes)
VALUES
(1, 1, 1, 5, '2025-06-30 23:00:00', 'concluido', 'Descrição teste'),
(2, 2, 2, 5, '2025-06-30 23:30:00', 'cancelado', 'Descrição teste'),
(3, 3, 3, 5, '2025-07-06 16:00:00', 'agendado', 'Descrição teste'),
(1, 4, 4, 5, '2025-07-05 11:00:00', 'agendado', 'Descrição teste');

