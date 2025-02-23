-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 23/02/2025 às 02:49
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `conexa_gym`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1739138322);

-- --------------------------------------------------------

--
-- Estrutura para tabela `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `students`
--

INSERT INTO `students` (`id`, `user_id`, `age`, `weight`, `height`) VALUES
(1, 3, NULL, NULL, NULL),
(2, 5, NULL, NULL, NULL),
(3, 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `specialty`, `experience`) VALUES
(1, 4, NULL, NULL),
(2, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','professor','aluno') NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `auth_key`) VALUES
(2, 'admin', 'admin@example.com', '$2y$13$CwJpJGn7/uWK73/Vr71.guZ9yLhAJ24gRXaGDQfhoWtOpKmAUG4fi', 'admin', 'pYwnkE9Xh-01NjFcbh2QUJuJUtP8xmaJ'),
(3, 'teste', 'alunoteste@teste.com', '$2y$13$MsrE1GoZZgoaZspJKBk6lOPArgk9KLxGYtIaULB1TJzeDqlyD7UQK', 'aluno', NULL),
(4, 'Carneiro Daltro', 'carnedalt@teste.com', '$2y$13$4Ct9oFoTQwLaBhz9zz0KVO6piGJCSuzDy0V5qf6k.oDtGSo5gca86', 'professor', NULL),
(5, 'Kananda', 'kanandateste@teste.com', '$2y$13$.Ua0VLC1OAIhQzWc1Ryzjej7.ewa9PvE8OkOtRudk754HbQwOWxcO', 'aluno', NULL),
(6, 'teste2', 'teste@teste.com', '$2y$13$OhDD.QSQIP.ffDdqJ8lHAenz17ZVPn1k6jpdeP2Yke3LDC5P4WaQ6', 'aluno', NULL),
(7, 'rt', 'check@teste.com', '$2y$13$1aknZZ8tXsdJ9QH0V1rES.lBTn8D3VhzeX.epu/nqB0RlByLNaFji', 'professor', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Índices de tabela `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Índices de tabela `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
