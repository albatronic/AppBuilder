/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : pre_bd_plataforma

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2012-02-13 13:35:04
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `pre_tbl_contadorvisitas`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_contadorvisitas`;
CREATE TABLE `pre_tbl_contadorvisitas` (
  `id_contadorvisitas` int(11) NOT NULL auto_increment,
  `numerodevisitas` int(11) default NULL,
  `fecha` date default NULL,
  PRIMARY KEY  (`id_contadorvisitas`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_contadorvisitas
-- ----------------------------
INSERT INTO pre_tbl_contadorvisitas VALUES ('1', '23', null);
INSERT INTO pre_tbl_contadorvisitas VALUES ('2', '20', '2012-01-26');
INSERT INTO pre_tbl_contadorvisitas VALUES ('3', '1', '2012-01-29');
INSERT INTO pre_tbl_contadorvisitas VALUES ('4', '1', '2012-01-31');
INSERT INTO pre_tbl_contadorvisitas VALUES ('5', '1', '2012-02-01');

-- ----------------------------
-- Table structure for `pre_tbl_opciones`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_opciones`;
CREATE TABLE `pre_tbl_opciones` (
  `id_opcion` int(11) NOT NULL auto_increment,
  `nivel` int(11) default NULL,
  `pertenece_a` int(11) default NULL,
  `txtmostrar` varchar(50) default NULL,
  `descripcion` varchar(200) default NULL,
  `mostrar` varchar(5) default NULL,
  `es_opcion_super` varchar(5) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id_opcion`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_opciones
-- ----------------------------
INSERT INTO pre_tbl_opciones VALUES ('1', '1', '0', 'Login', '', 'NO', 'NO', '1');
INSERT INTO pre_tbl_opciones VALUES ('2', '1', '0', 'Ayuda a Domicilio', '', 'SI', 'NO', '2');
INSERT INTO pre_tbl_opciones VALUES ('3', '2', '2', 'Personas Asistidas', '', 'SI', 'NO', '3');
INSERT INTO pre_tbl_opciones VALUES ('4', '1', '0', 'Terceros', '', 'SI', 'NO', '4');
INSERT INTO pre_tbl_opciones VALUES ('5', '2', '4', 'Localidades', '', 'SI', 'NO', '5');
INSERT INTO pre_tbl_opciones VALUES ('6', '2', '4', 'Provincias', '', 'SI', 'NO', '6');
INSERT INTO pre_tbl_opciones VALUES ('7', '2', '4', 'Paises', '', 'SI', 'NO', '7');
INSERT INTO pre_tbl_opciones VALUES ('8', '2', '4', 'Terceros', '', 'SI', 'NO', '8');
INSERT INTO pre_tbl_opciones VALUES ('9', '3', '8', 'Nuevo', '', 'SI', 'NO', '9');
INSERT INTO pre_tbl_opciones VALUES ('10', '2', '2', 'Auxiliares', '', 'SI', 'NO', '10');
INSERT INTO pre_tbl_opciones VALUES ('11', '3', '10', 'Nuevo', '', 'SI', 'NO', '11');
INSERT INTO pre_tbl_opciones VALUES ('12', '3', '3', 'Nuevo', '', 'SI', 'NO', '12');
INSERT INTO pre_tbl_opciones VALUES ('13', '3', '8', 'Modificar', '', 'NO', 'NO', '13');
INSERT INTO pre_tbl_opciones VALUES ('14', '3', '8', 'Eliminar', '', 'NO', 'NO', '14');
INSERT INTO pre_tbl_opciones VALUES ('15', '3', '8', 'Listado', '', 'SI', 'NO', '15');

-- ----------------------------
-- Table structure for `pre_tbl_perfilesdeusuarios`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_perfilesdeusuarios`;
CREATE TABLE `pre_tbl_perfilesdeusuarios` (
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
-- Records of pre_tbl_perfilesdeusuarios
-- ----------------------------
INSERT INTO pre_tbl_perfilesdeusuarios VALUES ('1', 'SuperAdministrador', 'SI', '1', 'SI', 'SI', 'NO', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '25e4c0a8aaf496d997ce7e85bcdae07b', null);
INSERT INTO pre_tbl_perfilesdeusuarios VALUES ('2', 'Administrador', 'SI', '2', 'SI', 'SI', 'NO', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '7e785104c09aa77b70765a2a3fd972e0', null);

-- ----------------------------
-- Table structure for `pre_tbl_permisos`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_permisos`;
CREATE TABLE `pre_tbl_permisos` (
  `id_permiso` int(11) NOT NULL auto_increment,
  `id_usuario` int(11) default NULL,
  `id_opcion` int(11) default NULL,
  `valor` varchar(5) default NULL,
  PRIMARY KEY  (`id_permiso`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_permisos
-- ----------------------------
INSERT INTO pre_tbl_permisos VALUES ('1', '1', '1', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('2', '2', '1', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('3', '1', '2', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('4', '2', '2', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('5', '1', '3', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('6', '2', '3', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('7', '1', '4', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('8', '2', '4', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('9', '1', '5', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('10', '2', '5', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('11', '1', '6', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('12', '2', '6', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('13', '1', '7', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('14', '2', '7', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('15', '1', '8', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('16', '2', '8', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('17', '1', '9', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('18', '2', '9', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('19', '1', '10', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('20', '2', '10', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('21', '1', '11', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('22', '2', '11', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('23', '1', '12', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('24', '2', '12', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('25', '1', '13', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('26', '2', '13', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('27', '1', '14', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('28', '2', '14', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('29', '1', '15', 'SI');
INSERT INTO pre_tbl_permisos VALUES ('30', '2', '15', 'SI');

-- ----------------------------
-- Table structure for `pre_tbl_registromodificaciones`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_registromodificaciones`;
CREATE TABLE `pre_tbl_registromodificaciones` (
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
-- Records of pre_tbl_registromodificaciones
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_tbl_tiposusuarios`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_tiposusuarios`;
CREATE TABLE `pre_tbl_tiposusuarios` (
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
-- Records of pre_tbl_tiposusuarios
-- ----------------------------
INSERT INTO pre_tbl_tiposusuarios VALUES ('1', 'administrador', 'SI', '1', 'SI', 'SI', 'NO', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '0993726e13ccb196a6d3b9219906df84');
INSERT INTO pre_tbl_tiposusuarios VALUES ('2', 'usuarioweb', 'SI', '2', 'SI', 'SI', 'NO', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '774c5c888deaf7f61b8bd09722adedba');

-- ----------------------------
-- Table structure for `pre_tbl_t_terceros`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_t_terceros`;
CREATE TABLE `pre_tbl_t_terceros` (
  `id_tercero` int(11) NOT NULL auto_increment,
  `num_tercero_md5` varchar(100) default NULL,
  `apellido1` varchar(250) default NULL,
  `apellido2` varchar(250) default NULL,
  `nombre` varchar(250) default NULL,
  `nombre_completo` varchar(250) default NULL,
  `nif_cif` varchar(25) default NULL,
  `es_nif_` varchar(5) default NULL,
  `telf_fijo` varchar(250) default NULL,
  `telf_movil` varchar(250) default NULL,
  `fax` varchar(250) default NULL,
  `email` varchar(250) default NULL,
  `web` varchar(250) default NULL,
  `numero_ss` varchar(100) default NULL,
  `fech_nacimiento` datetime default NULL,
  `sexo` varchar(5) default NULL,
  `num_nacionalidad_md5` varchar(250) default NULL,
  `num_representante_legal_md5` varchar(250) default NULL,
  `domicilio_social` varchar(250) default NULL,
  `num_localidad_social` int(11) default NULL,
  `num_provincia_social` int(11) default NULL,
  `num_pais_social` int(11) default NULL,
  `codigopostal_social` varchar(10) default NULL,
  `num_direccion_social_md5` varchar(250) default NULL,
  `direccion_social_completa` varchar(250) default NULL,
  `domicilio_comunicaciones` varchar(250) default NULL,
  `num_localidad_comunicaciones` int(11) default NULL,
  `num_provincia_comunicaciones` int(11) default NULL,
  `num_pais_comunicaciones` int(11) default NULL,
  `codigopostal_comunicaciones` varchar(10) default NULL,
  `num_direccion_comunicaciones_md5` varchar(250) default NULL,
  `direccion_comunica_completa` varchar(250) default NULL,
  `domicilio_empadrona` varchar(250) default NULL,
  `num_localidad_empadrona` int(11) default NULL,
  `num_provincia_empadrona` int(11) default NULL,
  `num_pais_empadrona` int(11) default NULL,
  `codigopostal_empadrona` varchar(10) default NULL,
  `num_direccion_empadrona_md5` varchar(250) default NULL,
  `direccion_empadrona_completa` varchar(250) default NULL,
  `observaciones` blob,
  `publicar` varchar(5) default NULL,
  `esdatopredeterminado` varchar(5) default NULL,
  `fechapublicacion` datetime default NULL,
  `usuariopublicacion` int(11) default NULL,
  `fechaultimamodificacion` datetime default NULL,
  `usuarioultimamodificacion` int(11) default NULL,
  `eliminado` varchar(5) default NULL,
  `fechaeliminar` datetime default NULL,
  `usuarioqueelimina` int(11) default NULL,
  PRIMARY KEY  (`id_tercero`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_t_terceros
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_tbl_usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_usuarios`;
CREATE TABLE `pre_tbl_usuarios` (
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
-- Records of pre_tbl_usuarios
-- ----------------------------
INSERT INTO pre_tbl_usuarios VALUES ('1', '1', 'admin', '8fc5f4ce8ec22e0762725772fe6e188d', '16810e188912497d9cf0637a74a3e238', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '1', 'SI', 'SI', '2012-01-26 14:57:15', '0000-00-00 00:00:00', 'NO', 'NO', null, null, '23', null, null);
INSERT INTO pre_tbl_usuarios VALUES ('2', '1', 'adm', 'f1bab2bd0d03d6e75ae70aec614c3bbf', '9b9653edb56a50a3f0bd0f85a7a84701', 'NO', 'NO', null, null, null, null, null, null, null, 'SI', '2012-01-26 14:57:15', '1', '2012-01-26 14:57:15', '1', '2', 'SI', 'SI', '2012-01-26 14:57:15', '0000-00-00 00:00:00', 'NO', 'NO', null, null, null, null, null);

-- ----------------------------
-- Table structure for `pre_tbl_versiones`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_versiones`;
CREATE TABLE `pre_tbl_versiones` (
  `id_version` int(11) NOT NULL auto_increment,
  `fechaactualizacion` datetime default NULL,
  `version` varchar(25) default NULL,
  PRIMARY KEY  (`id_version`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_versiones
-- ----------------------------
INSERT INTO pre_tbl_versiones VALUES ('1', '2012-01-26 14:57:16', '1.0.0');

-- ----------------------------
-- Table structure for `pre_tbl_visitas`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tbl_visitas`;
CREATE TABLE `pre_tbl_visitas` (
  `id_visita` int(11) NOT NULL auto_increment,
  `fecha` date default NULL,
  `hora` time default NULL,
  `num_usuario` int(11) default NULL,
  `num_usuario_md5` varchar(100) default NULL,
  `sesion` varchar(100) default NULL,
  `tiempo_absoluto` int(11) default NULL,
  PRIMARY KEY  (`id_visita`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tbl_visitas
-- ----------------------------
INSERT INTO pre_tbl_visitas VALUES ('1', '2012-01-26', '14:57:30', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327586250');
INSERT INTO pre_tbl_visitas VALUES ('2', '2012-01-26', '14:58:31', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327586311');
INSERT INTO pre_tbl_visitas VALUES ('3', '2012-01-26', '15:20:48', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327587648');
INSERT INTO pre_tbl_visitas VALUES ('4', '2012-01-26', '15:49:53', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327589393');
INSERT INTO pre_tbl_visitas VALUES ('5', '2012-01-26', '15:52:28', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327589548');
INSERT INTO pre_tbl_visitas VALUES ('6', '2012-01-26', '15:53:05', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327589585');
INSERT INTO pre_tbl_visitas VALUES ('7', '2012-01-26', '15:53:51', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327589631');
INSERT INTO pre_tbl_visitas VALUES ('8', '2012-01-26', '15:55:39', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327589739');
INSERT INTO pre_tbl_visitas VALUES ('9', '2012-01-26', '16:00:33', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327590033');
INSERT INTO pre_tbl_visitas VALUES ('10', '2012-01-26', '16:02:59', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327590179');
INSERT INTO pre_tbl_visitas VALUES ('11', '2012-01-26', '16:05:03', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327590303');
INSERT INTO pre_tbl_visitas VALUES ('12', '2012-01-26', '16:19:34', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327591174');
INSERT INTO pre_tbl_visitas VALUES ('13', '2012-01-26', '16:33:08', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327591988');
INSERT INTO pre_tbl_visitas VALUES ('14', '2012-01-26', '16:38:45', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327592325');
INSERT INTO pre_tbl_visitas VALUES ('15', '2012-01-26', '16:40:19', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327592419');
INSERT INTO pre_tbl_visitas VALUES ('16', '2012-01-26', '16:44:46', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327592686');
INSERT INTO pre_tbl_visitas VALUES ('17', '2012-01-26', '16:50:19', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327593019');
INSERT INTO pre_tbl_visitas VALUES ('18', '2012-01-26', '16:57:17', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327593437');
INSERT INTO pre_tbl_visitas VALUES ('19', '2012-01-26', '17:28:32', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327595312');
INSERT INTO pre_tbl_visitas VALUES ('20', '2012-01-26', '17:39:06', '1', '16810e188912497d9cf0637a74a3e238', '127cd1066ff795617fa1a0a459a2cabe', '1327595946');
INSERT INTO pre_tbl_visitas VALUES ('21', '2012-01-29', '21:07:09', '1', '16810e188912497d9cf0637a74a3e238', 'c787c8f4b5dc7fe64ffdf806caf56dd0', '1327867629');
INSERT INTO pre_tbl_visitas VALUES ('22', '2012-01-31', '13:55:22', '1', '16810e188912497d9cf0637a74a3e238', '186a0de23b42fc3504848578139bda04', '1328014522');
INSERT INTO pre_tbl_visitas VALUES ('23', '2012-02-01', '13:52:59', '1', '16810e188912497d9cf0637a74a3e238', '407981244131942b683c0877149c1011', '1328100779');
