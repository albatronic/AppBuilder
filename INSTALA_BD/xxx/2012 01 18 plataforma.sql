/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : plataforma

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2012-01-18 10:05:03
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `contadorvisitas`
-- ----------------------------
DROP TABLE IF EXISTS `contadorvisitas`;
CREATE TABLE `contadorvisitas` (
  `id_contadorvisitas` int(11) NOT NULL auto_increment,
  `numerodevisitas` int(11) default NULL,
  `fecha` date default NULL,
  PRIMARY KEY  (`id_contadorvisitas`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contadorvisitas
-- ----------------------------
INSERT INTO contadorvisitas VALUES ('1', '39', null);
INSERT INTO contadorvisitas VALUES ('2', '2', '2011-12-30');
INSERT INTO contadorvisitas VALUES ('3', '1', '2011-12-31');
INSERT INTO contadorvisitas VALUES ('4', '23', '2011-12-30');
INSERT INTO contadorvisitas VALUES ('5', '13', '2012-01-17');

-- ----------------------------
-- Table structure for `opciones`
-- ----------------------------
DROP TABLE IF EXISTS `opciones`;
CREATE TABLE `opciones` (
  `id_opcion` int(11) NOT NULL auto_increment,
  `nivel` int(11) default NULL,
  `pertenece_a` int(11) default NULL,
  `txtmostrar` varchar(50) default NULL,
  `descripcion` varchar(200) default NULL,
  `mostrar` varchar(5) default NULL,
  `es_opcion_super` varchar(5) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id_opcion`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of opciones
-- ----------------------------
INSERT INTO opciones VALUES ('1', '1', '0', 'Login', '', 'NO', 'NO', '1');
INSERT INTO opciones VALUES ('2', '1', '0', 'Ayuda a Domicilio', '', 'SI', 'NO', '2');
INSERT INTO opciones VALUES ('3', '2', '2', 'Personas Asistidas', '', 'SI', 'NO', '3');
INSERT INTO opciones VALUES ('4', '1', '0', 'Terceros', '', 'SI', 'NO', '4');
INSERT INTO opciones VALUES ('5', '2', '4', 'Localidades', '', 'SI', 'NO', '5');
INSERT INTO opciones VALUES ('6', '2', '4', 'Provincias', '', 'SI', 'NO', '6');
INSERT INTO opciones VALUES ('7', '2', '4', 'Paises', '', 'SI', 'NO', '7');
INSERT INTO opciones VALUES ('8', '2', '4', 'Terceros', '', 'SI', 'NO', '8');
INSERT INTO opciones VALUES ('9', '2', '8', 'Nuevo', '', 'SI', 'NO', '9');

-- ----------------------------
-- Table structure for `perfilesdeusuarios`
-- ----------------------------
DROP TABLE IF EXISTS `perfilesdeusuarios`;
CREATE TABLE `perfilesdeusuarios` (
  `id_perfildeusuario` int(11) NOT NULL auto_increment,
  `perfildeusuario` varchar(50) default NULL,
  `esdatopredeterminado` varchar(5) default NULL,
  `orden` int(11) default NULL,
  `publicar` varchar(5) default NULL,
  `es_de_superadministrador` varchar(5) default NULL,
  `solo_visible_para_superadministrador` varchar(5) default NULL,
  `fechapublicacion` datetime default NULL,
  `usuariopublicacion` int(11) default NULL,
  `fechaultimamodificacion` datetime default NULL,
  `usuarioultimamodificacion` int(11) default NULL,
  `num_perfildeusuario_md5` varchar(100) default NULL,
  `eliminado` varchar(5) default NULL,
  PRIMARY KEY  (`id_perfildeusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of perfilesdeusuarios
-- ----------------------------
INSERT INTO perfilesdeusuarios VALUES ('1', 'SuperAdministrador', 'SI', '1', 'SI', 'SI', 'NO', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '25e4c0a8aaf496d997ce7e85bcdae07b', null);
INSERT INTO perfilesdeusuarios VALUES ('2', 'Administrador', 'SI', '2', 'SI', 'SI', 'NO', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '7e785104c09aa77b70765a2a3fd972e0', null);

-- ----------------------------
-- Table structure for `permisos`
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL auto_increment,
  `id_usuario` int(11) default NULL,
  `id_opcion` int(11) default NULL,
  `valor` varchar(5) default NULL,
  PRIMARY KEY  (`id_permiso`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO permisos VALUES ('1', '1', '1', 'SI');
INSERT INTO permisos VALUES ('2', '2', '1', 'SI');
INSERT INTO permisos VALUES ('3', '1', '2', 'SI');
INSERT INTO permisos VALUES ('4', '2', '2', 'SI');
INSERT INTO permisos VALUES ('5', '1', '3', 'SI');
INSERT INTO permisos VALUES ('6', '2', '3', 'SI');
INSERT INTO permisos VALUES ('7', '1', '4', 'SI');
INSERT INTO permisos VALUES ('8', '2', '4', 'SI');
INSERT INTO permisos VALUES ('9', '1', '5', 'SI');
INSERT INTO permisos VALUES ('10', '2', '5', 'SI');
INSERT INTO permisos VALUES ('11', '1', '6', 'SI');
INSERT INTO permisos VALUES ('12', '2', '6', 'SI');
INSERT INTO permisos VALUES ('13', '1', '7', 'SI');
INSERT INTO permisos VALUES ('14', '2', '7', 'SI');
INSERT INTO permisos VALUES ('15', '1', '8', 'SI');
INSERT INTO permisos VALUES ('16', '2', '8', 'SI');
INSERT INTO permisos VALUES ('17', '1', '9', 'SI');
INSERT INTO permisos VALUES ('18', '2', '9', 'SI');

-- ----------------------------
-- Table structure for `registromodificaciones`
-- ----------------------------
DROP TABLE IF EXISTS `registromodificaciones`;
CREATE TABLE `registromodificaciones` (
  `id_registromodificaciones` int(11) NOT NULL auto_increment,
  `tabla` varchar(50) default NULL,
  `num_objeto_md5` varchar(100) default NULL,
  `num_usuario` int(11) default NULL,
  `nombre_usuario` varchar(50) default NULL,
  `fecha_modificacion` datetime default NULL,
  `sesion` varchar(100) default NULL,
  PRIMARY KEY  (`id_registromodificaciones`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of registromodificaciones
-- ----------------------------

-- ----------------------------
-- Table structure for `semillas`
-- ----------------------------
DROP TABLE IF EXISTS `semillas`;
CREATE TABLE `semillas` (
  `id_semilla` int(11) NOT NULL auto_increment,
  `num_semilla` int(11) default NULL,
  `semilla` varchar(100) default NULL,
  PRIMARY KEY  (`id_semilla`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of semillas
-- ----------------------------
INSERT INTO semillas VALUES ('1', '1', '79464212afb7fd6c38699d0617eaedeb');

-- ----------------------------
-- Table structure for `tiposusuarios`
-- ----------------------------
DROP TABLE IF EXISTS `tiposusuarios`;
CREATE TABLE `tiposusuarios` (
  `id_tipousuario` int(11) NOT NULL auto_increment,
  `tipousuario` varchar(50) default NULL,
  `esdatopredeterminado` varchar(5) default NULL,
  `orden` int(11) default NULL,
  `publicar` varchar(5) default NULL,
  `es_de_superadministrador` varchar(5) default NULL,
  `solo_visible_para_superadministrador` varchar(5) default NULL,
  `fechapublicacion` datetime default NULL,
  `usuariopublicacion` int(11) default NULL,
  `fechaultimamodificacion` datetime default NULL,
  `usuarioultimamodificacion` int(11) default NULL,
  `num_tipousuario_md5` varchar(100) default NULL,
  PRIMARY KEY  (`id_tipousuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tiposusuarios
-- ----------------------------
INSERT INTO tiposusuarios VALUES ('1', 'administrador', 'SI', '1', 'SI', 'SI', 'NO', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '0993726e13ccb196a6d3b9219906df84');
INSERT INTO tiposusuarios VALUES ('2', 'usuarioweb', 'SI', '2', 'SI', 'SI', 'NO', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '774c5c888deaf7f61b8bd09722adedba');

-- ----------------------------
-- Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL auto_increment,
  `num_tipousuario` int(11) default NULL,
  `nick` varchar(50) default NULL,
  `password` varchar(100) default NULL,
  `quiensoy` varchar(100) default NULL,
  `listadecorreo` varchar(5) default NULL,
  `listadesms` varchar(5) default NULL,
  `email` varchar(100) default NULL,
  `telefonomovil` varchar(25) default NULL,
  `nombre` varchar(100) default NULL,
  `apellidos` varchar(100) default NULL,
  `empresa` varchar(100) default NULL,
  `num_empresa` int(11) default NULL,
  `fotografia` varchar(100) default NULL,
  `esdatopredeterminado` varchar(5) default NULL,
  `fechapublicacion` datetime default NULL,
  `usuariopublicacion` int(11) default NULL,
  `fechaultimamodificacion` datetime default NULL,
  `usuarioultimamodificacion` int(11) default NULL,
  `num_perfildeusuario` int(11) default NULL,
  `revisado` varchar(5) default NULL,
  `cuentahabilitada` varchar(5) default NULL,
  `fechaactivar` datetime default NULL,
  `fechadesactivar` datetime default NULL,
  `hacambiadosusdatos` varchar(5) default NULL,
  `eliminado` varchar(5) default NULL,
  `fechaeliminar` datetime default NULL,
  `usuarioqueelimina` int(11) default NULL,
  `numerodevisitas` int(11) default NULL,
  `campoextra1` varchar(100) default NULL,
  `hacambiadosupassword` varchar(5) default NULL,
  PRIMARY KEY  (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO usuarios VALUES ('1', '1', 'admin', '8fc5f4ce8ec22e0762725772fe6e188d', '16810e188912497d9cf0637a74a3e238', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '1', 'SI', 'SI', '2011-12-30 18:06:20', '0000-00-00 00:00:00', 'NO', 'NO', null, null, '14', null, null);
INSERT INTO usuarios VALUES ('2', '1', 'adm', 'f1bab2bd0d03d6e75ae70aec614c3bbf', '9b9653edb56a50a3f0bd0f85a7a84701', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '2011-12-30 18:06:20', '1', '2011-12-30 18:06:20', '1', '2', 'SI', 'SI', '2011-12-30 18:06:20', '0000-00-00 00:00:00', 'NO', 'NO', null, null, '20', null, null);

-- ----------------------------
-- Table structure for `versiones`
-- ----------------------------
DROP TABLE IF EXISTS `versiones`;
CREATE TABLE `versiones` (
  `id_version` int(11) NOT NULL auto_increment,
  `fechaactualizacion` datetime default NULL,
  `version` varchar(25) default NULL,
  PRIMARY KEY  (`id_version`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of versiones
-- ----------------------------
INSERT INTO versiones VALUES ('1', '2011-12-30 18:06:20', '1.0.0');

-- ----------------------------
-- Table structure for `visitas`
-- ----------------------------
DROP TABLE IF EXISTS `visitas`;
CREATE TABLE `visitas` (
  `id_visita` int(11) NOT NULL auto_increment,
  `fecha` date default NULL,
  `hora` time default NULL,
  `num_usuario` int(11) default NULL,
  `num_usuario_md5` varchar(100) default NULL,
  `sesion` varchar(100) default NULL,
  `tiempo_absoluto` int(11) default NULL,
  PRIMARY KEY  (`id_visita`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visitas
-- ----------------------------
INSERT INTO visitas VALUES ('1', '2011-12-30', '18:31:11', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '501495d4111b4b865b479e5f99fc7d78', '1325266271');
INSERT INTO visitas VALUES ('2', '2011-12-30', '18:31:33', '1', '16810e188912497d9cf0637a74a3e238', '501495d4111b4b865b479e5f99fc7d78', '1325266293');
INSERT INTO visitas VALUES ('3', '2011-12-30', '18:36:11', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '501495d4111b4b865b479e5f99fc7d78', '1325266571');
INSERT INTO visitas VALUES ('4', '2011-12-30', '18:39:14', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '501495d4111b4b865b479e5f99fc7d78', '1325266754');
INSERT INTO visitas VALUES ('5', '2011-12-30', '18:49:57', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '501495d4111b4b865b479e5f99fc7d78', '1325267397');
INSERT INTO visitas VALUES ('6', '2011-12-30', '19:00:55', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325268055');
INSERT INTO visitas VALUES ('7', '2011-12-30', '19:01:05', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325268065');
INSERT INTO visitas VALUES ('8', '2011-12-30', '19:28:54', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325269734');
INSERT INTO visitas VALUES ('9', '2011-12-30', '19:29:22', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325269762');
INSERT INTO visitas VALUES ('10', '2011-12-30', '19:33:08', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325269988');
INSERT INTO visitas VALUES ('11', '2011-12-30', '19:35:13', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270113');
INSERT INTO visitas VALUES ('12', '2011-12-30', '19:35:37', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270137');
INSERT INTO visitas VALUES ('13', '2011-12-30', '19:36:03', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270163');
INSERT INTO visitas VALUES ('14', '2011-12-30', '19:36:41', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270201');
INSERT INTO visitas VALUES ('15', '2011-12-30', '19:40:29', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270429');
INSERT INTO visitas VALUES ('16', '2011-12-30', '19:43:01', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270581');
INSERT INTO visitas VALUES ('17', '2011-12-30', '19:44:33', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270673');
INSERT INTO visitas VALUES ('18', '2011-12-30', '19:48:27', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '3ee26a4fbe5c377efaa1c8d49c9fcb72', '1325270907');
INSERT INTO visitas VALUES ('19', '2011-12-30', '19:49:41', '2', '9b9653edb56a50a3f0bd0f85a7a84701', 'cf76236f5b01d234167fac579eadc084', '1325270981');
INSERT INTO visitas VALUES ('20', '2011-12-30', '19:53:15', '2', '9b9653edb56a50a3f0bd0f85a7a84701', 'cf76236f5b01d234167fac579eadc084', '1325271195');
INSERT INTO visitas VALUES ('21', '2011-12-30', '22:17:15', '2', '9b9653edb56a50a3f0bd0f85a7a84701', '42762674d698bab8839d03f5104137b9', '1325279835');
INSERT INTO visitas VALUES ('22', '2012-01-17', '11:59:28', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326797968');
INSERT INTO visitas VALUES ('23', '2012-01-17', '12:06:03', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326798363');
INSERT INTO visitas VALUES ('24', '2012-01-17', '12:06:50', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326798410');
INSERT INTO visitas VALUES ('25', '2012-01-17', '12:20:20', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326799220');
INSERT INTO visitas VALUES ('26', '2012-01-17', '12:23:13', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326799393');
INSERT INTO visitas VALUES ('27', '2012-01-17', '12:23:31', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326799411');
INSERT INTO visitas VALUES ('28', '2012-01-17', '12:32:37', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326799957');
INSERT INTO visitas VALUES ('29', '2012-01-17', '12:55:17', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326801317');
INSERT INTO visitas VALUES ('30', '2012-01-17', '12:56:59', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326801419');
INSERT INTO visitas VALUES ('31', '2012-01-17', '13:02:51', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326801771');
INSERT INTO visitas VALUES ('32', '2012-01-17', '14:13:34', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326806014');
INSERT INTO visitas VALUES ('33', '2012-01-17', '14:27:08', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326806828');
INSERT INTO visitas VALUES ('34', '2012-01-17', '14:37:57', '1', '16810e188912497d9cf0637a74a3e238', '2d707c171b98f5ee7d157292ca541c0b', '1326807477');
