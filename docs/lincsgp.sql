/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : db_sgpp

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2012-11-21 17:11:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `agenda`
-- ----------------------------
DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (
  `idagenda` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) DEFAULT NULL,
  `datainicio` date DEFAULT NULL,
  `datafim` date DEFAULT NULL,
  `descricao` text,
  `remetente` int(11) DEFAULT NULL,
  `destinatario` int(11) DEFAULT NULL,
  `prioridade` int(11) DEFAULT NULL,
  `hora` datetime DEFAULT NULL,
  PRIMARY KEY (`idagenda`),
  KEY `fk_agenda_usuarios1_idx` (`remetente`),
  KEY `fk_agenda_usuarios2_idx` (`destinatario`),
  CONSTRAINT `fk_agenda_usuarios1` FOREIGN KEY (`remetente`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_usuarios2` FOREIGN KEY (`destinatario`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of agenda
-- ----------------------------

-- ----------------------------
-- Table structure for `anexo`
-- ----------------------------
DROP TABLE IF EXISTS `anexo`;
CREATE TABLE `anexo` (
  `idanexo` int(11) NOT NULL AUTO_INCREMENT,
  `filename` mediumtext,
  `filetype` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `path` mediumtext,
  `projeto_idprojeto` int(11) DEFAULT NULL,
  `relativepath` mediumtext,
  PRIMARY KEY (`idanexo`),
  KEY `fk_anexo_projeto1_idx` (`projeto_idprojeto`),
  CONSTRAINT `fk_anexo_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of anexo
-- ----------------------------
INSERT INTO `anexo` VALUES ('1', 'EDITAL PROPESP-UNIVERSITEC - 13-2012 - INOVATEC.pdf', 'application/pdf', '228.1 KB', 'C:\\wamp\\www\\lincsgp\\public\\uploads/EDITAL PRO', '1', null);

-- ----------------------------
-- Table structure for `atas`
-- ----------------------------
DROP TABLE IF EXISTS `atas`;
CREATE TABLE `atas` (
  `idata` int(11) NOT NULL AUTO_INCREMENT,
  `datacriacao` timestamp NULL DEFAULT NULL,
  `datafechamento` timestamp NULL DEFAULT NULL,
  `datareabertura` timestamp NULL DEFAULT NULL,
  `conteudo` longtext,
  `observacao` longtext,
  `ultimaalteracao` timestamp NULL DEFAULT NULL,
  `urlgoogledocs` longtext,
  `pauta` longtext,
  `assunto` mediumtext,
  `membrosexternos` mediumtext,
  `duracao` varchar(45) DEFAULT NULL,
  `palavraschaves` mediumtext,
  PRIMARY KEY (`idata`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of atas
-- ----------------------------
INSERT INTO `atas` VALUES ('28', '2012-10-19 16:40:46', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', null, null, null, null);
INSERT INTO `atas` VALUES ('29', '2012-10-19 16:40:46', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', null, null, null, null);
INSERT INTO `atas` VALUES ('30', '2012-10-19 16:40:46', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', '2012-10-19 16:40:46', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', null, null, null, null);
INSERT INTO `atas` VALUES ('31', '2012-10-19 16:53:25', '2012-10-19 16:53:25', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', '2012-10-19 16:53:25', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'TEMA DA REUNIAO', null, null, null);
INSERT INTO `atas` VALUES ('32', '2012-10-19 16:56:09', '2012-10-19 16:56:09', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', '2012-10-19 16:56:09', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sapien justo, elementum a lacinia at, adipiscing id tortor. Nullam elementum laoreet augue non luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur scelerisque viverra magna vitae imperdiet. Ut ipsum ipsum, pharetra ac dapibus ac, vulputate consectetur risus. Proin adipiscing dolor ac nulla posuere suscipit. Curabitur adipiscing lobortis libero, eget tristique tortor auctor a. In ullamcorper, arcu tincidunt convallis sollicitudin, ipsum est gravida felis, at ultrices risus massa ac odio. Ut ac turpis nisl, at luctus sem. Donec ac ligula magna. Vestibulum vel eros in erat egestas dapibus vel nec urna. ', 'sfdfsfsfsdfzsf zsfzs', null, null, null);
INSERT INTO `atas` VALUES ('33', '2012-10-19 16:56:09', '2012-10-19 16:56:09', null, 'qeq', 'eqweqwe', '2012-10-21 00:00:00', null, 'eqeqe', 'weqqweqe__1', 'Carlos, Barbosa', '3:45', null);
INSERT INTO `atas` VALUES ('34', '2012-10-20 04:10:43', '2012-10-20 04:10:43', null, 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing', '2012-10-20 04:10:43', null, 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing', 'PRojeto do MC', null, null, null);

-- ----------------------------
-- Table structure for `campo`
-- ----------------------------
DROP TABLE IF EXISTS `campo`;
CREATE TABLE `campo` (
  `idcampo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcampo`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of campo
-- ----------------------------
INSERT INTO `campo` VALUES ('1', 'beneficiario', 'Beneficiário', 'input');
INSERT INTO `campo` VALUES ('8', 'cheque', 'Cheque', 'input');
INSERT INTO `campo` VALUES ('9', 'periodo', 'Período', 'input');
INSERT INTO `campo` VALUES ('10', 'valor', 'Valor', 'input');
INSERT INTO `campo` VALUES ('11', 'motivo', 'Motivo', 'input');
INSERT INTO `campo` VALUES ('12', 'local', 'Local', 'input');
INSERT INTO `campo` VALUES ('13', 'inicio', 'Início', 'input');
INSERT INTO `campo` VALUES ('14', 'termino', 'Término', 'input');
INSERT INTO `campo` VALUES ('15', 'unidades', 'Unidades', 'input');
INSERT INTO `campo` VALUES ('16', 'fornecedor', 'Fornecedor', 'input');
INSERT INTO `campo` VALUES ('17', 'descricao', 'Descrição', 'input');

-- ----------------------------
-- Table structure for `convite`
-- ----------------------------
DROP TABLE IF EXISTS `convite`;
CREATE TABLE `convite` (
  `idconvite` int(11) NOT NULL AUTO_INCREMENT,
  `email` mediumtext,
  `usuarios_idusuarios` int(11) DEFAULT NULL,
  PRIMARY KEY (`idconvite`),
  KEY `fk_convite_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_convite_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of convite
-- ----------------------------

-- ----------------------------
-- Table structure for `despesa`
-- ----------------------------
DROP TABLE IF EXISTS `despesa`;
CREATE TABLE `despesa` (
  `iddespesa` int(11) NOT NULL AUTO_INCREMENT,
  `data_criacao` date DEFAULT NULL,
  `data_modificacao` date DEFAULT NULL,
  `projeto_idprojeto` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddespesa`),
  KEY `fk_despesa_projeto1_idx` (`projeto_idprojeto`),
  CONSTRAINT `fk_despesa_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of despesa
-- ----------------------------
INSERT INTO `despesa` VALUES ('1', '2012-11-05', null, '1');
INSERT INTO `despesa` VALUES ('2', '2012-11-06', null, '1');
INSERT INTO `despesa` VALUES ('3', '2012-11-06', null, '1');
INSERT INTO `despesa` VALUES ('4', '2012-11-06', null, '1');
INSERT INTO `despesa` VALUES ('5', '2012-11-06', null, '5');
INSERT INTO `despesa` VALUES ('6', '2012-11-06', null, '1');
INSERT INTO `despesa` VALUES ('7', '2012-11-09', null, '1');
INSERT INTO `despesa` VALUES ('8', '2012-11-09', null, '1');
INSERT INTO `despesa` VALUES ('9', '2012-11-09', null, '1');
INSERT INTO `despesa` VALUES ('10', '2012-11-09', null, '1');

-- ----------------------------
-- Table structure for `despesas`
-- ----------------------------
DROP TABLE IF EXISTS `despesas`;
CREATE TABLE `despesas` (
  `iddespesas` int(11) NOT NULL AUTO_INCREMENT,
  `projeto_idprojeto` int(11) DEFAULT NULL,
  `usuarios_idusuarios` int(11) DEFAULT NULL,
  `rubrica_idrubrica` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `cheque` int(11) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `fornecedor` varchar(255) DEFAULT NULL,
  `valor` varchar(45) DEFAULT '0,00',
  `inicio` date DEFAULT NULL,
  `termino` date DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddespesas`),
  KEY `fk_rubrica_projeto1_idx` (`projeto_idprojeto`),
  KEY `fk_rubrica_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_despesas_rubrica1_idx` (`rubrica_idrubrica`),
  CONSTRAINT `fk_despesas_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rubrica_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rubrica_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of despesas
-- ----------------------------

-- ----------------------------
-- Table structure for `despesa_rubrica_campo`
-- ----------------------------
DROP TABLE IF EXISTS `despesa_rubrica_campo`;
CREATE TABLE `despesa_rubrica_campo` (
  `despesa_iddespesa` int(11) NOT NULL,
  `rubrica_campo_idrubricacampo` int(11) NOT NULL,
  `valor` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`despesa_iddespesa`,`rubrica_campo_idrubricacampo`),
  KEY `fk_despesa_has_rubrica_campo_rubrica_campo1_idx` (`rubrica_campo_idrubricacampo`),
  KEY `fk_despesa_has_rubrica_campo_despesa1_idx` (`despesa_iddespesa`),
  CONSTRAINT `fk_despesa_has_rubrica_campo_despesa1` FOREIGN KEY (`despesa_iddespesa`) REFERENCES `despesa` (`iddespesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_despesa_has_rubrica_campo_rubrica_campo1` FOREIGN KEY (`rubrica_campo_idrubricacampo`) REFERENCES `rubrica_campo` (`idrubricacampo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of despesa_rubrica_campo
-- ----------------------------
INSERT INTO `despesa_rubrica_campo` VALUES ('1', '1', 'Gabriel Lima');
INSERT INTO `despesa_rubrica_campo` VALUES ('1', '2', '83823812312');
INSERT INTO `despesa_rubrica_campo` VALUES ('1', '3', '2012/2013');
INSERT INTO `despesa_rubrica_campo` VALUES ('1', '4', '7.400,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('2', '12', 'Cheque Field');
INSERT INTO `despesa_rubrica_campo` VALUES ('2', '13', '3');
INSERT INTO `despesa_rubrica_campo` VALUES ('2', '14', 'Lugar nenhum');
INSERT INTO `despesa_rubrica_campo` VALUES ('2', '15', 'Essa é uma descrição mais que simplificada. kkkk');
INSERT INTO `despesa_rubrica_campo` VALUES ('2', '16', '1.300,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '5', 'dddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '6', 'ddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '7', 'dddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '8', 'dd');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '9', '11/11/1111');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '10', '11/11/1111');
INSERT INTO `despesa_rubrica_campo` VALUES ('3', '11', '4.000,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('4', '12', 'ddasdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('4', '13', '111');
INSERT INTO `despesa_rubrica_campo` VALUES ('4', '14', 'aSASADASDASD');
INSERT INTO `despesa_rubrica_campo` VALUES ('4', '15', 'ASDASDASD');
INSERT INTO `despesa_rubrica_campo` VALUES ('4', '16', '3.000,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('5', '1', 'ddddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('5', '2', 'ddddddddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('5', '3', 'ddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('5', '4', '1.222,22');
INSERT INTO `despesa_rubrica_campo` VALUES ('6', '1', 'ddsadasdasdad');
INSERT INTO `despesa_rubrica_campo` VALUES ('6', '2', 'adasdas');
INSERT INTO `despesa_rubrica_campo` VALUES ('6', '3', 'ddasdasda');
INSERT INTO `despesa_rubrica_campo` VALUES ('6', '4', '400,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('7', '1', 'dsdasdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('7', '2', 'dasdasdas');
INSERT INTO `despesa_rubrica_campo` VALUES ('7', '3', 'dasdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('7', '4', '200,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('8', '1', 'dddddddddddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('8', '2', 'ddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('8', '3', 'ddddddd');
INSERT INTO `despesa_rubrica_campo` VALUES ('8', '4', '200,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('9', '1', 'dasdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('9', '2', 'asdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('9', '3', 'asdadsa');
INSERT INTO `despesa_rubrica_campo` VALUES ('9', '4', '300,00');
INSERT INTO `despesa_rubrica_campo` VALUES ('10', '1', 'dasdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('10', '2', 'asdasd');
INSERT INTO `despesa_rubrica_campo` VALUES ('10', '3', 'asdadsa');
INSERT INTO `despesa_rubrica_campo` VALUES ('10', '4', '300,00');

-- ----------------------------
-- Table structure for `faq`
-- ----------------------------
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `idfaq` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` mediumtext,
  `resposta` text,
  `usuarios_idusuarios` int(11) DEFAULT NULL,
  PRIMARY KEY (`idfaq`),
  KEY `fk_faq_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_faq_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of faq
-- ----------------------------
INSERT INTO `faq` VALUES ('1', 'dddddddddddd', 'dddddddddddd', '3');

-- ----------------------------
-- Table structure for `financiador`
-- ----------------------------
DROP TABLE IF EXISTS `financiador`;
CREATE TABLE `financiador` (
  `idfinanciador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idfinanciador`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of financiador
-- ----------------------------
INSERT INTO `financiador` VALUES ('1', 'Financiador 1');
INSERT INTO `financiador` VALUES ('2', 'Financiador 2');
INSERT INTO `financiador` VALUES ('3', 'Financiador 3');
INSERT INTO `financiador` VALUES ('4', 'Financiador 4');
INSERT INTO `financiador` VALUES ('5', 'ssss');
INSERT INTO `financiador` VALUES ('6', 'ss');
INSERT INTO `financiador` VALUES ('7', 'xxxxx');
INSERT INTO `financiador` VALUES ('8', 'ssssss');
INSERT INTO `financiador` VALUES ('9', 'qqqqq');
INSERT INTO `financiador` VALUES ('10', 'qqqqqqqqq');
INSERT INTO `financiador` VALUES ('11', 'wwwwwwwww');
INSERT INTO `financiador` VALUES ('12', 'qqqqqqqq');

-- ----------------------------
-- Table structure for `laboratorio`
-- ----------------------------
DROP TABLE IF EXISTS `laboratorio`;
CREATE TABLE `laboratorio` (
  `idlaboratorio` int(11) NOT NULL AUTO_INCREMENT,
  `laboratorio` varchar(200) DEFAULT NULL,
  `sigla` varchar(200) DEFAULT NULL,
  `coordenador` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idlaboratorio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of laboratorio
-- ----------------------------
INSERT INTO `laboratorio` VALUES ('1', 'LPRAD', null, null);
INSERT INTO `laboratorio` VALUES ('2', 'LINC', null, null);
INSERT INTO `laboratorio` VALUES ('3', 'LEA', null, null);

-- ----------------------------
-- Table structure for `planotrabalho`
-- ----------------------------
DROP TABLE IF EXISTS `planotrabalho`;
CREATE TABLE `planotrabalho` (
  `idplanotrabalho` int(11) NOT NULL AUTO_INCREMENT,
  `valor_planotrabalho` varchar(45) DEFAULT NULL,
  `rubrica_idrubrica` int(11) DEFAULT NULL,
  `projeto_idprojeto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idplanotrabalho`),
  KEY `fk_planotrabalho_rubrica1_idx` (`rubrica_idrubrica`),
  KEY `fk_planotrabalho_projeto1_idx` (`projeto_idprojeto`),
  CONSTRAINT `fk_planotrabalho_projeto1` FOREIGN KEY (`projeto_idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_planotrabalho_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of planotrabalho
-- ----------------------------
INSERT INTO `planotrabalho` VALUES ('17', '2.300,00', '10', '9');
INSERT INTO `planotrabalho` VALUES ('21', '20.000,00', '9', '5');
INSERT INTO `planotrabalho` VALUES ('22', '43.000,00', '10', '5');
INSERT INTO `planotrabalho` VALUES ('23', '4.230,00', '11', '5');
INSERT INTO `planotrabalho` VALUES ('24', '3.700,00', '10', '7');
INSERT INTO `planotrabalho` VALUES ('25', '410.000,00', '11', '7');
INSERT INTO `planotrabalho` VALUES ('30', '12.000,00', '9', '1');
INSERT INTO `planotrabalho` VALUES ('31', '20.000,00', '10', '1');

-- ----------------------------
-- Table structure for `projeto`
-- ----------------------------
DROP TABLE IF EXISTS `projeto`;
CREATE TABLE `projeto` (
  `idprojeto` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_idtecnico` int(11) DEFAULT NULL,
  `usuarios_idcoordenador` int(11) DEFAULT NULL,
  `financiador_idfinanciador` int(11) DEFAULT NULL,
  `proponente_idproponente` int(11) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `tipoprojeto` varchar(45) DEFAULT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `processo` varchar(45) DEFAULT NULL,
  `resumo` text,
  `edital` varchar(45) DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `termino` date DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `apelido` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idprojeto`),
  KEY `fk_projeto_usuarios1_idx` (`usuarios_idtecnico`),
  KEY `fk_projeto_usuarios2_idx` (`usuarios_idcoordenador`),
  KEY `fk_projeto_financiador1_idx` (`financiador_idfinanciador`),
  KEY `fk_projeto_proponente1_idx` (`proponente_idproponente`),
  CONSTRAINT `fk_projeto_financiador1` FOREIGN KEY (`financiador_idfinanciador`) REFERENCES `financiador` (`idfinanciador`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_projeto_proponente1` FOREIGN KEY (`proponente_idproponente`) REFERENCES `proponente` (`idproponente`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_projeto_usuarios1` FOREIGN KEY (`usuarios_idtecnico`) REFERENCES `usuarios` (`idusuarios`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_projeto_usuarios2` FOREIGN KEY (`usuarios_idcoordenador`) REFERENCES `usuarios` (`idusuarios`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of projeto
-- ----------------------------
INSERT INTO `projeto` VALUES ('1', '2', '2', '1', '1', '32.000,00', 'Pesquisa', 'Lorem___ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ', '3333/2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas met, consectetur adipiscing elit. Maecenas ultrices dui in libero semper aliquet. Etiam nisi quam, auctor eget facilisis ac, consectetur sit amet lacus. Aenean semper massa in lectus facilisis in varius risus venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent tempus quam ante, eu fermentum nisl. Phasellus tincidunt iaculis ante. Pellentesque gravida ', '21122', '1970-01-01', '1970-01-01', 'www.google.com', 'Lorem__ ipsum dolor sit amet, consectetur adi');
INSERT INTO `projeto` VALUES ('5', '2', '2', '3', '2', '67.230,00', 'Pesquisa', 'Lorem___ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ', '3333/2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas met, consectetur adipiscing elit. Maecenas ultrices dui in libero semper aliquet. Etiam nisi quam, auctor eget facilisis ac, consectetur sit amet lacus. Aenean semper massa in lectus facilisis in varius risus venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent tempus quam ante, eu fermentum nisl. Phasellus tincidunt iaculis ante. Pellentesque gravida ', '21122', '1970-01-01', '1970-01-01', 'www.google.com', 'Lorem__ ipsum dolor sit amet, consectetur adi');
INSERT INTO `projeto` VALUES ('7', '2', '2', '3', '2', '413.700,00', 'Selecione', 'Lorem___ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ', '3333/2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas met, consectetur adipiscing elit. Maecenas ultrices dui in libero semper aliquet. Etiam nisi quam, auctor eget facilisis ac, consectetur sit amet lacus. Aenean semper massa in lectus facilisis in varius risus venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent tempus quam ante, eu fermentum nisl. Phasellus tincidunt iaculis ante. Pellentesque gravida ', '21122', '1970-01-01', '1970-01-01', 'www.google.com', 'Lorem__ ipsum dolor sit amet, consectetur adi');
INSERT INTO `projeto` VALUES ('9', '2', '2', '2', '1', '2.300,00', 'Selecione', 'Lorem___ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ', '3333/2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas met, consectetur adipiscing elit. Maecenas ultrices dui in libero semper aliquet. Etiam nisi quam, auctor eget facilisis ac, consectetur sit amet lacus. Aenean semper massa in lectus facilisis in varius risus venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent tempus quam ante, eu fermentum nisl. Phasellus tincidunt iaculis ante. Pellentesque gravida ', '21122', '1970-01-01', '1970-01-01', 'www.google.com', 'Lorem__ ipsum dolor sit amet, consectetur adi');

-- ----------------------------
-- Table structure for `proponente`
-- ----------------------------
DROP TABLE IF EXISTS `proponente`;
CREATE TABLE `proponente` (
  `idproponente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idproponente`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of proponente
-- ----------------------------
INSERT INTO `proponente` VALUES ('1', 'Instituição 1');
INSERT INTO `proponente` VALUES ('2', 'Instituição 2');
INSERT INTO `proponente` VALUES ('3', 'Instituição 3');
INSERT INTO `proponente` VALUES ('4', 'Instituição 4');
INSERT INTO `proponente` VALUES ('5', 'Instituição 5');
INSERT INTO `proponente` VALUES ('6', 'Instituição 6');
INSERT INTO `proponente` VALUES ('7', 'Instituição 7');
INSERT INTO `proponente` VALUES ('8', 'Instituição 8');
INSERT INTO `proponente` VALUES ('9', 'Instituição 9');
INSERT INTO `proponente` VALUES ('10', 'Instituição 10');
INSERT INTO `proponente` VALUES ('11', 'Instituição 11');
INSERT INTO `proponente` VALUES ('12', null);
INSERT INTO `proponente` VALUES ('13', null);
INSERT INTO `proponente` VALUES ('14', 'Insituição 12');
INSERT INTO `proponente` VALUES ('15', 'Instituição 13');
INSERT INTO `proponente` VALUES ('16', 'Insituição 14');
INSERT INTO `proponente` VALUES ('17', 'Instituição 15');
INSERT INTO `proponente` VALUES ('18', 'Insituição 16');
INSERT INTO `proponente` VALUES ('19', 'Instituição 17');
INSERT INTO `proponente` VALUES ('20', 'Teste');
INSERT INTO `proponente` VALUES ('21', 'teste2');
INSERT INTO `proponente` VALUES ('22', 'ddddddd');
INSERT INTO `proponente` VALUES ('23', 'qqqqqq');
INSERT INTO `proponente` VALUES ('24', 'rrrrrrrr');
INSERT INTO `proponente` VALUES ('25', 'xxxxxxx');
INSERT INTO `proponente` VALUES ('26', 'vvvvvv');

-- ----------------------------
-- Table structure for `repasses`
-- ----------------------------
DROP TABLE IF EXISTS `repasses`;
CREATE TABLE `repasses` (
  `idrepasses` int(11) NOT NULL AUTO_INCREMENT,
  `datarepasse` date DEFAULT NULL,
  `valorrepasse` varchar(45) DEFAULT NULL,
  `projeto_idprojeto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idrepasses`),
  KEY `fk_repasses_projeto1_idx` (`projeto_idprojeto`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of repasses
-- ----------------------------
INSERT INTO `repasses` VALUES ('3', '2012-11-15', '32.333,33', '2');
INSERT INTO `repasses` VALUES ('4', '2012-10-31', '14.300,00', '2');
INSERT INTO `repasses` VALUES ('6', '0000-00-00', '63.000,92', '10');
INSERT INTO `repasses` VALUES ('7', '0000-00-00', '63.000,92', null);
INSERT INTO `repasses` VALUES ('16', '2012-11-04', '2.222,23', '1');
INSERT INTO `repasses` VALUES ('17', '2012-11-22', '3.232,22', '1');

-- ----------------------------
-- Table structure for `rubrica`
-- ----------------------------
DROP TABLE IF EXISTS `rubrica`;
CREATE TABLE `rubrica` (
  `idrubrica` int(11) NOT NULL AUTO_INCREMENT,
  `tiporubrica` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrubrica`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of rubrica
-- ----------------------------
INSERT INTO `rubrica` VALUES ('9', 'Auxílio e Bolsa');
INSERT INTO `rubrica` VALUES ('10', 'Passagem e Diária');
INSERT INTO `rubrica` VALUES ('11', 'Serviço');
INSERT INTO `rubrica` VALUES ('12', 'Material Permanente');
INSERT INTO `rubrica` VALUES ('14', 'Material de Consumo');

-- ----------------------------
-- Table structure for `rubrica_campo`
-- ----------------------------
DROP TABLE IF EXISTS `rubrica_campo`;
CREATE TABLE `rubrica_campo` (
  `idrubricacampo` int(11) NOT NULL AUTO_INCREMENT,
  `rubrica_idrubrica` int(11) DEFAULT NULL,
  `campo_idcampo` int(11) DEFAULT NULL,
  `obrigatorio` varchar(45) DEFAULT NULL,
  `mask` varchar(45) DEFAULT NULL,
  `validator` varchar(45) DEFAULT NULL,
  `placeholder` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrubricacampo`),
  KEY `fk_rubrica_has_campo_campo1_idx` (`campo_idcampo`),
  KEY `fk_rubrica_has_campo_rubrica1_idx` (`rubrica_idrubrica`),
  CONSTRAINT `fk_rubrica_has_campo_campo1` FOREIGN KEY (`campo_idcampo`) REFERENCES `campo` (`idcampo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rubrica_has_campo_rubrica1` FOREIGN KEY (`rubrica_idrubrica`) REFERENCES `rubrica` (`idrubrica`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of rubrica_campo
-- ----------------------------
INSERT INTO `rubrica_campo` VALUES ('1', '9', '1', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('2', '9', '8', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('3', '9', '9', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('4', '9', '10', 'required', '', 'money', '');
INSERT INTO `rubrica_campo` VALUES ('5', '10', '1', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('6', '10', '8', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('7', '10', '11', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('8', '10', '12', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('9', '10', '13', 'required', '99/99/9999', 'date', '');
INSERT INTO `rubrica_campo` VALUES ('10', '10', '14', 'required', '99/99/9999', 'date', '');
INSERT INTO `rubrica_campo` VALUES ('11', '10', '10', 'required', '', 'money', '');
INSERT INTO `rubrica_campo` VALUES ('12', '11', '8', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('13', '11', '15', 'required', '', 'number', '');
INSERT INTO `rubrica_campo` VALUES ('14', '11', '16', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('15', '11', '17', 'required', '', '', '');
INSERT INTO `rubrica_campo` VALUES ('16', '11', '10', 'required', '', 'money', '');

-- ----------------------------
-- Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `perfil` varchar(45) DEFAULT 'Membro',
  `facebook` varchar(200) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `idfacebook` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `laboratorio_idlaboratorio` int(11) DEFAULT NULL,
  `vinculo_idvinculo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusuarios`),
  KEY `fk_usuarios_laboratorio1_idx` (`laboratorio_idlaboratorio`),
  KEY `fk_usuarios_vinculo1_idx` (`vinculo_idvinculo`),
  CONSTRAINT `fk_usuarios_laboratorio1` FOREIGN KEY (`laboratorio_idlaboratorio`) REFERENCES `laboratorio` (`idlaboratorio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_vinculo1` FOREIGN KEY (`vinculo_idvinculo`) REFERENCES `vinculo` (`idvinculo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('2', 'Sandman Morpheus', 'morpheus@email.ru', '5286e80707649bbfc82bb688dfe68528', 'Membro', 'https://www.facebook.com/sandman.morpheus.33', 'Sandman', 'Morpheus', 'male', '100003519336098', '2012-10-14T01:37:30+0000', 'sandman.morpheus.33', '0', '1', '1');
INSERT INTO `usuarios` VALUES ('3', 'J Gabriel Lima', 'jgabriel.ufpa@gmail.com', '28ed5a128544f905ef24e28824d3576a', 'Membro', 'http://www.facebook.com/jgabriel.lima', 'J Gabriel', 'Lima', 'male', '100000545352864', '2012-10-14T01:37:30+0000', 'jgabriel.lima', '1', null, null);
INSERT INTO `usuarios` VALUES ('4', 'João Crisóstomo Weyl A. Costa', null, null, 'Membro', null, null, null, null, null, null, null, '0', null, null);
INSERT INTO `usuarios` VALUES ('5', 'Antonio Fernando L. Jacob Jr', null, null, 'Membro', null, null, null, null, null, null, null, '0', null, null);

-- ----------------------------
-- Table structure for `usuarios_atas`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios_atas`;
CREATE TABLE `usuarios_atas` (
  `usuarios_idusuarios` int(11) NOT NULL,
  `atas_idata` int(11) NOT NULL,
  `criador` int(11) DEFAULT NULL,
  `idusuarioatas` int(11) NOT NULL AUTO_INCREMENT,
  `lida` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusuarioatas`),
  KEY `fk_usuarios_has_atas_atas1_idx` (`atas_idata`),
  KEY `fk_usuarios_has_atas_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_usuarios_has_atas_atas1` FOREIGN KEY (`atas_idata`) REFERENCES `atas` (`idata`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_atas_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios_atas
-- ----------------------------
INSERT INTO `usuarios_atas` VALUES ('2', '30', '1', '1', null);
INSERT INTO `usuarios_atas` VALUES ('3', '30', '0', '2', null);
INSERT INTO `usuarios_atas` VALUES ('2', '31', '1', '3', null);
INSERT INTO `usuarios_atas` VALUES ('3', '31', '0', '4', null);
INSERT INTO `usuarios_atas` VALUES ('2', '32', '1', '5', null);
INSERT INTO `usuarios_atas` VALUES ('3', '32', '0', '6', null);
INSERT INTO `usuarios_atas` VALUES ('3', '33', '1', '7', null);
INSERT INTO `usuarios_atas` VALUES ('2', '34', '0', '8', null);
INSERT INTO `usuarios_atas` VALUES ('3', '34', '1', '9', null);

-- ----------------------------
-- Table structure for `vinculo`
-- ----------------------------
DROP TABLE IF EXISTS `vinculo`;
CREATE TABLE `vinculo` (
  `idvinculo` int(11) NOT NULL AUTO_INCREMENT,
  `vinculo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idvinculo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of vinculo
-- ----------------------------
INSERT INTO `vinculo` VALUES ('1', 'Bolsista');
INSERT INTO `vinculo` VALUES ('2', 'Bolsista');
INSERT INTO `vinculo` VALUES ('3', 'Coordenador');
INSERT INTO `vinculo` VALUES ('4', 'Administrador');
