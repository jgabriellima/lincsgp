-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jul 15, 2012 as 07:05 PM
-- Versão do Servidor: 5.1.61
-- Versão do PHP: 5.3.3-1ubuntu9.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `db_sgpp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesas`
--

CREATE TABLE IF NOT EXISTS `despesas` (
  `iddespesas` int(11) NOT NULL AUTO_INCREMENT,
  `projeto_idprojeto` int(11) NOT NULL,
  `usuarios_idusuarios` int(11) NOT NULL,
  `rubrica_idrubrica` int(11) NOT NULL,
  `codigo` int(11) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `cheque` int(11) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `fornecedor` varchar(255) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `termino` date DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `beneficiario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddespesas`),
  KEY `fk_rubrica_projeto1` (`projeto_idprojeto`),
  KEY `fk_rubrica_usuarios1` (`usuarios_idusuarios`),
  KEY `fk_despesas_rubrica1` (`rubrica_idrubrica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `despesas`
--

INSERT INTO `despesas` (`iddespesas`, `projeto_idprojeto`, `usuarios_idusuarios`, `rubrica_idrubrica`, `codigo`, `ativo`, `cheque`, `unidades`, `descricao`, `fornecedor`, `valor`, `inicio`, `termino`, `url`, `local`, `motivo`, `beneficiario`) VALUES
(4, 2, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, 180, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 1, 4, 444444, NULL, 2222222, NULL, '7777777777', '777777777777777', 75, NULL, NULL, '44444444', '7777777', '777777777777', '7777777'),
(8, 2, 1, 13, 0, NULL, 0, NULL, 'lkelke', 'klek', 30, NULL, NULL, 'kleyton', 'kleyrton', 'klekel', 'kkl'),
(9, 2, 1, 14, 333, NULL, 333, NULL, 'kleyton', 'kleyton', 30, NULL, NULL, 'kleyton', 'kleyton', 'kleyton', 'kleyton'),
(10, 2, 1, 14, 222, NULL, 2222, NULL, 'kleyton', 'kleyton', 30, NULL, NULL, 'kleytongama', 'kleyton', 'kleyton', 'kleyton'),
(11, 2, 1, 13, 0, NULL, 0, NULL, 'kleyton', 'kleyton', 20, NULL, NULL, 'kleyton', 'kleyton', 'kleyton', 'kleyton'),
(12, 2, 1, 2, 123, NULL, 122, NULL, 'kleyton', 'kleyton', 525, NULL, NULL, 'kleyton', 'kleyton', 'kleyton', 'kleyton'),
(13, 2, 1, 2, 22, NULL, 22, NULL, 'kleyton', 'kleyton', 25, NULL, NULL, 'kleyton', 'kleyton', 'klkeyton', 'kleyton');

-- --------------------------------------------------------

--
-- Estrutura da tabela `financiador`
--

CREATE TABLE IF NOT EXISTS `financiador` (
  `idfinanciador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idfinanciador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `financiador`
--

INSERT INTO `financiador` (`idfinanciador`, `nome`) VALUES
(1, 'Ericson'),
(2, 'Cnpq'),
(3, 'Celpa'),
(4, 'kleyton'),
(5, 'Bruno'),
(6, 'Gleyson'),
(7, 'Juca'),
(10, 'teste8'),
(11, 'CARLOS'),
(12, 'CARLOS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--

CREATE TABLE IF NOT EXISTS `funcao` (
  `idfuncao` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idfuncao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `funcao`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `integrante`
--

CREATE TABLE IF NOT EXISTS `integrante` (
  `usuarios_idusuarios` int(11) NOT NULL,
  `projeto_idprojeto` int(11) NOT NULL,
  `funcao_idfuncao` int(11) NOT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `perfil` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`usuarios_idusuarios`,`projeto_idprojeto`),
  KEY `fk_usuarios_has_projeto_projeto1` (`projeto_idprojeto`),
  KEY `fk_usuarios_has_projeto_usuarios` (`usuarios_idusuarios`),
  KEY `fk_integrante_funcao1` (`funcao_idfuncao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `integrante`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `modalidadebolsas`
--

CREATE TABLE IF NOT EXISTS `modalidadebolsas` (
  `idmodalidadebolsas` int(11) NOT NULL AUTO_INCREMENT,
  `rubrica_idrubrica` int(11) NOT NULL,
  `tipomodalidade` varchar(45) DEFAULT NULL,
  `orgao` varchar(45) DEFAULT NULL,
  `valor_bolsa` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmodalidadebolsas`),
  KEY `fk_modalidadebolsas_rubrica1` (`rubrica_idrubrica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `modalidadebolsas`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE IF NOT EXISTS `orcamento` (
  `idorcamento` int(11) NOT NULL AUTO_INCREMENT,
  `projeto_idprojeto` int(11) NOT NULL,
  `rubrica_idrubrica` int(11) NOT NULL,
  `valor_orcamento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idorcamento`),
  KEY `fk_orcamento_projeto1` (`projeto_idprojeto`),
  KEY `fk_orcamento_rubrica1` (`rubrica_idrubrica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `orcamento`
--

INSERT INTO `orcamento` (`idorcamento`, `projeto_idprojeto`, `rubrica_idrubrica`, `valor_orcamento`) VALUES
(25, 2, 4, '1000'),
(26, 2, 13, '1000'),
(51, 2, 14, '1000'),
(62, 2, 2, '1000'),
(63, 16, 10, '1.000,00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
  `idprojeto` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_idtecnico` int(11) NOT NULL,
  `usuarios_idcoordenador` int(11) NOT NULL,
  `financiador_idfinanciador` int(11) NOT NULL,
  `proponente_idproponente` int(11) NOT NULL,
  `valor` int(11) DEFAULT NULL,
  `tipoprojeto` varchar(45) DEFAULT NULL,
  `titulo` varchar(250) NOT NULL,
  `processo` varchar(45) NOT NULL,
  `resumo` text,
  `edital` varchar(45) DEFAULT NULL,
  `inicio` date NOT NULL,
  `termino` date NOT NULL,
  `url` varchar(45) DEFAULT NULL,
  `apelido` varchar(100) NOT NULL,
  PRIMARY KEY (`idprojeto`),
  KEY `fk_projeto_usuarios1` (`usuarios_idtecnico`),
  KEY `fk_projeto_usuarios2` (`usuarios_idcoordenador`),
  KEY `fk_projeto_financiador1` (`financiador_idfinanciador`),
  KEY `fk_projeto_proponente1` (`proponente_idproponente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`idprojeto`, `usuarios_idtecnico`, `usuarios_idcoordenador`, `financiador_idfinanciador`, `proponente_idproponente`, `valor`, `tipoprojeto`, `titulo`, `processo`, `resumo`, `edital`, `inicio`, `termino`, `url`, `apelido`) VALUES
(2, 2, 1, 1, 1, 1000, 'sdasdassdsda', 'kleyton', '222222', 'ssadasdads ', '212222', '0000-00-00', '0000-00-00', 'titulo', 'Projeto2'),
(15, 2, 1, 2, 2, 22, 'Pesquisa', 'Testando', '111111/2012', 'Testando', '22222', '2011-11-12', '2011-11-12', 'teste', 'Projeto3'),
(16, 2, 1, 2, 1, 1, 'Desenvolvimento', 'kleyton', '333333/2012', 'kleyton', '3333', '2006-06-12', '2007-06-12', 'kleyton', 'kleyton');

-- --------------------------------------------------------

--
-- Estrutura da tabela `proponente`
--

CREATE TABLE IF NOT EXISTS `proponente` (
  `idproponente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idproponente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `proponente`
--

INSERT INTO `proponente` (`idproponente`, `nome`) VALUES
(1, 'Capes'),
(2, 'Celpa'),
(3, 'Julho'),
(4, 'Paulo'),
(5, 'teste'),
(6, 'pedro ivo'),
(7, 'teste5'),
(8, 'brunobaitola'),
(9, 'JACOB'),
(10, 'JACOB');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rubrica`
--

CREATE TABLE IF NOT EXISTS `rubrica` (
  `idrubrica` int(11) NOT NULL AUTO_INCREMENT,
  `tiporubrica` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrubrica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `rubrica`
--

INSERT INTO `rubrica` (`idrubrica`, `tiporubrica`) VALUES
(1, 'Auxilio Bolsa'),
(2, 'Passagem'),
(3, 'Material Consumo'),
(4, 'Material Permanente'),
(9, 'teste'),
(10, 'teste'),
(11, 'teste2'),
(12, 'teste5'),
(13, 'kelly'),
(14, 'BRUNO'),
(15, 'testandonovamente'),
(16, 'ijansdsjiansd'),
(17, 'Teste'),
(18, 'paulo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idusuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `nome`, `email`, `senha`) VALUES
(1, 'Jacob', 'jacob@ufpa.br', '123'),
(2, 'Frances', 'frances@gmail.com', '123');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `despesas`
--
ALTER TABLE `despesas`
  ADD CONSTRAINT `fk_despesas_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rubrica_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rubrica_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para a tabela `integrante`
--
ALTER TABLE `integrante`
  ADD CONSTRAINT `fk_integrante_funcao1` FOREIGN KEY (`funcao_idfuncao`) REFERENCES `funcao` (`idfuncao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_projeto_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_projeto_usuarios` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `modalidadebolsas`
--
ALTER TABLE `modalidadebolsas`
  ADD CONSTRAINT `fk_modalidadebolsas_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `orcamento`
--
ALTER TABLE `orcamento`
  ADD CONSTRAINT `fk_orcamento_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orcamento_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para a tabela `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `fk_projeto_financiador1` FOREIGN KEY (`financiador_idfinanciador`) REFERENCES `financiador` (`idfinanciador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projeto_proponente1` FOREIGN KEY (`proponente_idproponente`) REFERENCES `proponente` (`idproponente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projeto_usuarios1` FOREIGN KEY (`usuarios_idtecnico`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projeto_usuarios2` FOREIGN KEY (`usuarios_idcoordenador`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
