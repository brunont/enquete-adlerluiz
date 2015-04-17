SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_enquete
-- ----------------------------
DROP TABLE IF EXISTS `tbl_enquete`;
CREATE TABLE `tbl_enquete` (
  `int_idaenquete` int(11) NOT NULL AUTO_INCREMENT,
  `vhr_nome` varchar(100) DEFAULT NULL,
  `vhr_descricao` varchar(160) DEFAULT NULL,
  `dte_criacao` datetime DEFAULT NULL,
  `bln_concluido` bit(1) DEFAULT NULL,
  PRIMARY KEY (`int_idaenquete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_opcao
-- ----------------------------
DROP TABLE IF EXISTS `tbl_opcao`;
CREATE TABLE `tbl_opcao` (
  `int_idaopcao` int(11) NOT NULL AUTO_INCREMENT,
  `int_idfpergunta` int(11) DEFAULT NULL,
  `vhr_titulo` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`int_idaopcao`),
  KEY `fk_pergunta` (`int_idfpergunta`),
  CONSTRAINT `fk_pergunta` FOREIGN KEY (`int_idfpergunta`) REFERENCES `tbl_pergunta` (`int_idapergunta`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_pergunta
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pergunta`;
CREATE TABLE `tbl_pergunta` (
  `int_idapergunta` int(255) NOT NULL AUTO_INCREMENT,
  `int_idfenquete` int(11) DEFAULT NULL,
  `int_ordem` int(11) DEFAULT NULL,
  `vhr_titulo` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`int_idapergunta`),
  KEY `fk_enquete` (`int_idfenquete`),
  CONSTRAINT `fk_enquete` FOREIGN KEY (`int_idfenquete`) REFERENCES `tbl_enquete` (`int_idaenquete`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_voto
-- ----------------------------
DROP TABLE IF EXISTS `tbl_voto`;
CREATE TABLE `tbl_voto` (
  `int_idavotos` int(11) NOT NULL AUTO_INCREMENT,
  `int_idfopcao` int(11) DEFAULT NULL,
  PRIMARY KEY (`int_idavotos`),
  KEY `fk_opcao` (`int_idfopcao`),
  CONSTRAINT `fk_opcao` FOREIGN KEY (`int_idfopcao`) REFERENCES `tbl_opcao` (`int_idaopcao`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
