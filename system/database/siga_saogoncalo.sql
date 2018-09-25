-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: sige_bd
-- ------------------------------------------------------
-- Server version	5.7.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aluno` (
  `id_aluno` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `tipo_doc` char(1) NOT NULL,
  `num_doc` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `nome_pai` varchar(100) DEFAULT NULL,
  `nome_mae` varchar(100) DEFAULT NULL,
  `naturalidade` varchar(50) DEFAULT NULL,
  `nacionalidade` varchar(50) DEFAULT NULL,
  `endereco` varchar(300) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `localizacao` char(1) DEFAULT NULL,
  `transporte` char(1) NOT NULL,
  PRIMARY KEY (`id_aluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aluno_turma`
--

DROP TABLE IF EXISTS `aluno_turma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aluno_turma` (
  `id_turma` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `situacao` char(1) NOT NULL,
  PRIMARY KEY (`id_turma`,`id_aluno`),
  KEY `fkey_Aluno_Turma_1_idx` (`id_turma`),
  KEY `fkey_Aluno_Turma_2_idx` (`id_aluno`),
  CONSTRAINT `fkey_Aluno_Turma_1` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Aluno_Turma_2` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno_turma`
--

LOCK TABLES `aluno_turma` WRITE;
/*!40000 ALTER TABLE `aluno_turma` DISABLE KEYS */;
/*!40000 ALTER TABLE `aluno_turma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ano_escolaridade`
--

DROP TABLE IF EXISTS `ano_escolaridade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ano_escolaridade` (
  `id_ano_escolaridade` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id_ano_escolaridade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ano_escolaridade`
--

LOCK TABLES `ano_escolaridade` WRITE;
/*!40000 ALTER TABLE `ano_escolaridade` DISABLE KEYS */;
/*!40000 ALTER TABLE `ano_escolaridade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auxilio`
--

DROP TABLE IF EXISTS `auxilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auxilio` (
  `id_auxilio` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` char(11) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `endereco` varchar(300) DEFAULT NULL,
  `instituicao` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `banco` varchar(30) DEFAULT NULL,
  `agencia` varchar(20) DEFAULT NULL,
  `conta` varchar(20) DEFAULT NULL,
  `operacao` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_auxilio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auxilio`
--

LOCK TABLES `auxilio` WRITE;
/*!40000 ALTER TABLE `auxilio` DISABLE KEYS */;
/*!40000 ALTER TABLE `auxilio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplina`
--

DROP TABLE IF EXISTS `disciplina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disciplina` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id_disciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplina`
--

LOCK TABLES `disciplina` WRITE;
/*!40000 ALTER TABLE `disciplina` DISABLE KEYS */;
/*!40000 ALTER TABLE `disciplina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplina_turma`
--

DROP TABLE IF EXISTS `disciplina_turma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disciplina_turma` (
  `id_turma` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL,
  `id_professor` char(11) NOT NULL,
  PRIMARY KEY (`id_turma`,`id_disciplina`),
  KEY `fkey_Disciplina_Turma_1_idx` (`id_turma`),
  KEY `fkey_Disciplina_Turma_2_idx` (`id_disciplina`),
  KEY `fkey_Disciplina_Turma_3_idx` (`id_professor`),
  CONSTRAINT `fkey_Disciplina_Turma_1` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Disciplina_Turma_2` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`id_disciplina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Disciplina_Turma_3` FOREIGN KEY (`id_professor`) REFERENCES `funcionario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplina_turma`
--

LOCK TABLES `disciplina_turma` WRITE;
/*!40000 ALTER TABLE `disciplina_turma` DISABLE KEYS */;
/*!40000 ALTER TABLE `disciplina_turma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escola`
--

DROP TABLE IF EXISTS `escola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escola` (
  `id_escola` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `inep` varchar(50) DEFAULT NULL,
  `responsavel` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(300) DEFAULT NULL,
  `inicio_func` varchar(5) DEFAULT NULL,
  `fim_func` varchar(5) DEFAULT NULL,
  `lei_autorizacao` varchar(100) DEFAULT NULL,
  `etapas_ensino` varchar(5) DEFAULT NULL,
  `turno` varchar(5) DEFAULT NULL,
  `periodo` char(1) DEFAULT NULL,
  `localizacao` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_escola`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escola`
--

LOCK TABLES `escola` WRITE;
/*!40000 ALTER TABLE `escola` DISABLE KEYS */;
/*!40000 ALTER TABLE `escola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionario` (
  `cpf` char(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` char(1) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `vinculo` char(1) NOT NULL,
  `terceirizado_empresa` varchar(50) DEFAULT NULL,
  `endereco` varchar(300) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `escolaridade` char(1) DEFAULT NULL,
  `area_especializacao` varchar(50) DEFAULT NULL,
  `carga_horaria` int(11) DEFAULT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fkey_Funcionario_1_idx` (`id_cargo`),
  CONSTRAINT `fkey_Funcionario_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario_escola`
--

DROP TABLE IF EXISTS `funcionario_escola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionario_escola` (
  `id_func_esc` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` char(11) NOT NULL,
  `id_escola` int(11) NOT NULL,
  `dia` varchar(8) NOT NULL,
  `hora_inicio` varchar(5) NOT NULL,
  `hora_fim` varchar(5) NOT NULL,
  PRIMARY KEY (`id_func_esc`),
  KEY `fkey_Funcionario_Escola_1` (`id_funcionario`),
  KEY `fkey_Funcionario_Escola_2` (`id_escola`),
  CONSTRAINT `fkey_Funcionario_Escola_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Funcionario_Escola_2` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id_escola`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario_escola`
--

LOCK TABLES `funcionario_escola` WRITE;
/*!40000 ALTER TABLE `funcionario_escola` DISABLE KEYS */;
/*!40000 ALTER TABLE `funcionario_escola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turma`
--

DROP TABLE IF EXISTS `turma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turma` (
  `id_turma` int(11) NOT NULL AUTO_INCREMENT,
  `id_escola` int(11) NOT NULL,
  `ano_atividade` int(11) NOT NULL,
  `id_ano_escolaridade` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `periodo` char(1) DEFAULT NULL,
  `turno` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_turma`),
  KEY `fkey_Turma_1_idx` (`id_escola`),
  KEY `fkey_Turma_2_idx` (`id_ano_escolaridade`),
  CONSTRAINT `fkey_Turma_1` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id_escola`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Turma_2` FOREIGN KEY (`id_ano_escolaridade`) REFERENCES `ano_escolaridade` (`id_ano_escolaridade`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma`
--

LOCK TABLES `turma` WRITE;
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
/*!40000 ALTER TABLE `turma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` char(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `tipo` char(1) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fkey_Usuario_1_idx` (`id_funcionario`),
  CONSTRAINT `fkey_Usuario_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_escola`
--

DROP TABLE IF EXISTS `usuario_escola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_escola` (
  `id_usuario` int(11) NOT NULL,
  `id_escola` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_escola`),
  KEY `fkey_Usuario_Escola_1_idx` (`id_usuario`),
  KEY `fkey_Usuario_Escola_2_idx` (`id_escola`),
  CONSTRAINT `fkey_Usuario_Escola_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkey_Usuario_Escola_2` FOREIGN KEY (`id_escola`) REFERENCES `escola` (`id_escola`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_escola`
--

LOCK TABLES `usuario_escola` WRITE;
/*!40000 ALTER TABLE `usuario_escola` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_escola` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-23  9:28:50
