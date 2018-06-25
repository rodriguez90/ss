/*
 Navicat Premium Data Transfer

 Source Server         : sgt
 Source Server Type    : SQL Server
 Source Server Version : 13004001
 Source Host           : PEDRO-PC\SQLEXPRESS:1433
 Source Catalog        : sgt
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 13004001
 File Encoding         : 65001

 Date: 11/06/2018 00:19:37
*/


-- ----------------------------
-- Table structure for adm_user
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[adm_user]') AND type IN ('U'))
	DROP TABLE [dbo].[adm_user]
GO

CREATE TABLE [dbo].[adm_user] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [username] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [auth_key] varchar(max) COLLATE Modern_Spanish_CI_AS  NULL,
  [password] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [email] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [nombre] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [apellidos] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [creado_por] varchar(max) COLLATE Modern_Spanish_CI_AS  NULL,
  [status] smallint  NOT NULL,
  [created_at] bigint  NULL,
  [updated_at] bigint  NULL,
  [password_reset_token] varbinary(max)  NULL,
  [cedula] varchar(50) COLLATE Modern_Spanish_CI_AS  NOT NULL
)
GO

ALTER TABLE [dbo].[adm_user] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of adm_user
-- ----------------------------
SET IDENTITY_INSERT [dbo].[adm_user] ON
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1', N'root', NULL, N'$2y$13$zCsRHm1Irfu8JaQCMes1cuhDuI7MXgI.SEqiLyB0P/gn5W6znHS.C', N'root@xedrux.com', N'Yander', N'Pelfort', NULL, N'1', NULL, N'1526355240', NULL, N'85052621160')
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1021', N'prueba1', NULL, N'$2y$13$zIg8TMrW3zqAkiy4p7FRd./vMYs/Oz6GA/prFxl5.397jRQ.gn.q6', N'prueba1@xedrux.com', N'Prueba1', N'p1', N'root', N'1', N'1526360998', N'1526365373', NULL, N'1111')
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1022', N'prueba2', NULL, N'$2y$13$rNA5RSm0WygJxb.FW0Iqh.6S9/MhDtmmtdVsC8BbdP732KjGHDp6C', N'prueba2@xedrux.com', N'Prueba2', N'P2', N'root', N'1', N'1526361116', N'1526365359', NULL, N'111122')
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1024', N'pedro', NULL, N'$2y$13$44YdZq9gam4XjnE5LpFMRu9VYLD2dZgUfb7Al4lM0m3DAzDK3iIRC', N'pedro@test.co', N'pedro', N'rodriguez', N'root', N'1', N'1528154303', N'1528154303', NULL, N'90010641428')
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1025', N'agencia', NULL, N'$2y$13$Xd6P71i/IK.LCL8QI.FBXuFZLmoGX39pLYcP9Ag/zuxUecFd0D4ou', N'admin@test.co', N'agencia', N'agencia', N'root', N'1', N'1528595775', N'1528595775', NULL, N'0111111111')
GO

INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1026', N'ciatransporte', NULL, N'$2y$13$lz1lV.FYLolYAkUYIu3Y6eEOgDenCNTKaOyA6u4EZDPqgOPvshmf2', N'test@test.co', N'ciatransporte', N'rodriguezciatransporte', N'root', N'1', N'1528595893', N'1528595893', NULL, N'0102010201')
GO

SET IDENTITY_INSERT [dbo].[adm_user] OFF
GO


-- ----------------------------
-- Table structure for agency
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[agency]') AND type IN ('U'))
	DROP TABLE [dbo].[agency]
GO

CREATE TABLE [dbo].[agency] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [code_oce] varchar(10) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [ruc] varchar(13) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [active] bit  NOT NULL
)
GO

ALTER TABLE [dbo].[agency] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of agency
-- ----------------------------
SET IDENTITY_INSERT [dbo].[agency] ON
GO

INSERT INTO [dbo].[agency] ([id], [name], [code_oce], [ruc], [active]) VALUES (N'1', N'aaa', N'111', N'111', N'1')
GO

INSERT INTO [dbo].[agency] ([id], [name], [code_oce], [ruc], [active]) VALUES (N'2', N'aaaa', N'111', N'111', N'1')
GO

SET IDENTITY_INSERT [dbo].[agency] OFF
GO


-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[auth_assignment]') AND type IN ('U'))
	DROP TABLE [dbo].[auth_assignment]
GO

CREATE TABLE [dbo].[auth_assignment] (
  [item_name] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [user_id] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [created_at] int  NULL
)
GO

ALTER TABLE [dbo].[auth_assignment] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO [dbo].[auth_assignment]  VALUES (N'Administracion', N'1', NULL)
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Administrador_depósito', N'1008', N'1526329431')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Administrador_depósito', N'1009', N'1526329525')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Administrador_depósito', N'1010', N'1526329654')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Administrador_depósito', N'1011', N'1526329719')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Agencia', N'1025', N'1528595775')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1013', N'1526337541')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1018', N'1526360601')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1019', N'1526359091')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1020', N'1526359210')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1021', N'1526360998')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Cia_transporte', N'1026', N'1528595893')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1012', N'1526333774')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1014', N'1526338793')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1015', N'1526339515')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1016', N'1526340591')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1017', N'1526342323')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1022', N'1526361116')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1023', N'1528153797')
GO

INSERT INTO [dbo].[auth_assignment]  VALUES (N'Importador_Exportador', N'1024', N'1528154303')
GO


-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[auth_item]') AND type IN ('U'))
	DROP TABLE [dbo].[auth_item]
GO

CREATE TABLE [dbo].[auth_item] (
  [name] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [type] smallint  NOT NULL,
  [description] text COLLATE Modern_Spanish_CI_AS  NULL,
  [rule_name] varchar(64) COLLATE Modern_Spanish_CI_AS  NULL,
  [data] varchar(64) COLLATE Modern_Spanish_CI_AS  NULL,
  [created_at] int  NULL,
  [updated_at] int  NULL
)
GO

ALTER TABLE [dbo].[auth_item] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO [dbo].[auth_item]  VALUES (N'Admin_mod', N'2', N'acceso al modulo administrador', NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Admin_prueba', N'2', N'prueba de crear permiso', NULL, NULL, N'1526269550', N'1526269550')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Administracion', N'1', N'root', NULL, NULL, NULL, NULL)
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Administrador_depósito', N'1', N'Administrador del depósito ', NULL, NULL, N'1526269475', N'1526269475')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Agencia', N'1', N'Serán los que por medio del sistema ingresen la eCas con la información de los contenedores. El significado y lógica de eCas serán explicados más adelante.', NULL, NULL, N'1526269415', N'1526269415')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Cia_transporte', N'1', N'Entrarán al sistema a especificar los choferes y las placas de los carros con los que retirarán los contenedores solicitados por un usuario Y con rol Importador/Exportador, así como seleccionar los turnos o los cupos de acuerdo a si es una recepción o un despacho. Notar que estos usuarios dependen directamente de los usuarios Importadores/Exportadores.  ', NULL, NULL, N'1526269434', N'1526269434')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Depósito', N'1', N'Gestiona los cupos y asigna las agencias y los tipos de contenedores a los calendarios.', NULL, NULL, N'1526269452', N'1526269452')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'Importador_Exportador', N'1', N'Serán aquellos usuarios que entrarán al sistema a solicitar que una compañía de transporte X retire (Despacho) o entregue (Recepción) contenedores al TPG.', NULL, NULL, N'1526269359', N'1526269359')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'user_create', N'2', N'crear usuarios', NULL, NULL, N'1526270230', N'1526270230')
GO

INSERT INTO [dbo].[auth_item]  VALUES (N'user_list', N'2', N'listar usuarios', NULL, NULL, N'1528595641', N'1528595641')
GO


-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[auth_item_child]') AND type IN ('U'))
	DROP TABLE [dbo].[auth_item_child]
GO

CREATE TABLE [dbo].[auth_item_child] (
  [parent] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [child] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL
)
GO

ALTER TABLE [dbo].[auth_item_child] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO [dbo].[auth_item_child]  VALUES (N'Administracion', N'Admin_mod')
GO

INSERT INTO [dbo].[auth_item_child]  VALUES (N'Administracion', N'Admin_prueba')
GO

INSERT INTO [dbo].[auth_item_child]  VALUES (N'Administracion', N'user_create')
GO

INSERT INTO [dbo].[auth_item_child]  VALUES (N'Administracion', N'user_list')
GO


-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[auth_rule]') AND type IN ('U'))
	DROP TABLE [dbo].[auth_rule]
GO

CREATE TABLE [dbo].[auth_rule] (
  [name] varchar(64) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [data] varchar(64) COLLATE Modern_Spanish_CI_AS  NULL,
  [created_at] int  NULL,
  [updated_at] int  NULL
)
GO

ALTER TABLE [dbo].[auth_rule] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Table structure for calendar
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[calendar]') AND type IN ('U'))
	DROP TABLE [dbo].[calendar]
GO

CREATE TABLE [dbo].[calendar] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [id_warehouse] int  NOT NULL,
  [start_datetime] datetime  NOT NULL,
  [end_datetime] datetime  NOT NULL,
  [amount] int  NOT NULL
)
GO

ALTER TABLE [dbo].[calendar] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of calendar
-- ----------------------------
SET IDENTITY_INSERT [dbo].[calendar] ON
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'1', N'1', N'2018-06-10 12:59:24.000', N'2018-06-10 13:52:42.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'2', N'1', N'2018-06-10 07:00:00.000', N'2018-06-10 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'3', N'1', N'2018-06-10 08:00:00.000', N'2018-06-10 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'4', N'1', N'2018-06-10 09:00:00.000', N'2018-06-10 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'5', N'1', N'2018-06-10 10:00:00.000', N'2018-06-10 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'6', N'1', N'2018-06-10 11:00:00.000', N'2018-06-10 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'7', N'1', N'2018-06-10 12:00:00.000', N'2018-06-10 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'8', N'1', N'2018-06-10 13:00:00.000', N'2018-06-10 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'9', N'1', N'2018-06-10 14:00:00.000', N'2018-06-10 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'10', N'1', N'2018-06-11 07:00:00.000', N'2018-06-11 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'11', N'1', N'2018-06-11 08:00:00.000', N'2018-06-11 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'12', N'1', N'2018-06-11 09:00:00.000', N'2018-06-11 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'13', N'1', N'2018-06-11 10:00:00.000', N'2018-06-11 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'14', N'1', N'2018-06-11 11:00:00.000', N'2018-06-11 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'15', N'1', N'2018-06-11 12:00:00.000', N'2018-06-11 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'16', N'1', N'2018-06-11 13:00:00.000', N'2018-06-11 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'17', N'1', N'2018-06-11 14:00:00.000', N'2018-06-11 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'18', N'1', N'2018-06-12 07:00:00.000', N'2018-06-12 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'19', N'1', N'2018-06-12 08:00:00.000', N'2018-06-12 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'20', N'1', N'2018-06-12 09:00:00.000', N'2018-06-12 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'21', N'1', N'2018-06-12 10:00:00.000', N'2018-06-12 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'22', N'1', N'2018-06-12 11:00:00.000', N'2018-06-12 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'23', N'1', N'2018-06-12 12:00:00.000', N'2018-06-12 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'24', N'1', N'2018-06-12 13:00:00.000', N'2018-06-12 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'25', N'1', N'2018-06-12 14:00:00.000', N'2018-06-12 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'26', N'1', N'2018-06-13 07:00:00.000', N'2018-06-13 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'27', N'1', N'2018-06-13 08:00:00.000', N'2018-06-13 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'28', N'1', N'2018-06-13 09:00:00.000', N'2018-06-13 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'29', N'1', N'2018-06-13 10:00:00.000', N'2018-06-13 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'30', N'1', N'2018-06-13 11:00:00.000', N'2018-06-13 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'31', N'1', N'2018-06-13 12:00:00.000', N'2018-06-13 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'32', N'1', N'2018-06-13 13:00:00.000', N'2018-06-13 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'33', N'1', N'2018-06-13 14:00:00.000', N'2018-06-13 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'34', N'1', N'2018-06-14 07:00:00.000', N'2018-06-14 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'35', N'1', N'2018-06-14 08:00:00.000', N'2018-06-14 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'36', N'1', N'2018-06-14 09:00:00.000', N'2018-06-14 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'37', N'1', N'2018-06-14 10:00:00.000', N'2018-06-14 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'38', N'1', N'2018-06-14 11:00:00.000', N'2018-06-14 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'39', N'1', N'2018-06-14 12:00:00.000', N'2018-06-14 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'40', N'1', N'2018-06-14 13:00:00.000', N'2018-06-14 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'41', N'1', N'2018-06-14 14:00:00.000', N'2018-06-14 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'42', N'1', N'2018-06-15 07:00:00.000', N'2018-06-15 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'43', N'1', N'2018-06-15 08:00:00.000', N'2018-06-15 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'44', N'1', N'2018-06-15 09:00:00.000', N'2018-06-15 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'45', N'1', N'2018-06-15 10:00:00.000', N'2018-06-15 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'46', N'1', N'2018-06-15 11:00:00.000', N'2018-06-15 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'47', N'1', N'2018-06-15 12:00:00.000', N'2018-06-15 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'48', N'1', N'2018-06-15 13:00:00.000', N'2018-06-15 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'49', N'1', N'2018-06-15 14:00:00.000', N'2018-06-15 15:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'50', N'1', N'2018-06-16 07:00:00.000', N'2018-06-16 08:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'51', N'1', N'2018-06-16 08:00:00.000', N'2018-06-16 09:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'52', N'1', N'2018-06-16 09:00:00.000', N'2018-06-16 10:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'53', N'1', N'2018-06-16 10:00:00.000', N'2018-06-16 11:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'54', N'1', N'2018-06-16 11:00:00.000', N'2018-06-16 12:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'55', N'1', N'2018-06-16 12:00:00.000', N'2018-06-16 13:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'56', N'1', N'2018-06-16 13:00:00.000', N'2018-06-16 14:00:00.000', N'5')
GO

INSERT INTO [dbo].[calendar] ([id], [id_warehouse], [start_datetime], [end_datetime], [amount]) VALUES (N'57', N'1', N'2018-06-16 14:00:00.000', N'2018-06-16 15:00:00.000', N'5')
GO

SET IDENTITY_INSERT [dbo].[calendar] OFF
GO


-- ----------------------------
-- Table structure for container
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[container]') AND type IN ('U'))
	DROP TABLE [dbo].[container]
GO

CREATE TABLE [dbo].[container] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [code] varchar(3) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [tonnage] int  NOT NULL,
  [active] bit DEFAULT ((0)) NOT NULL
)
GO

ALTER TABLE [dbo].[container] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of container
-- ----------------------------
SET IDENTITY_INSERT [dbo].[container] ON
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'8', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'9', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'10', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'11', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'12', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'13', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'14', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'15', N'Contenedor 0', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'16', N'Contenedor 2', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'17', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'18', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'19', N'Contenedor 2', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'20', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'21', N'Contenedor 2', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'22', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'23', N'Contenedor 0', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'24', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'25', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'26', N'Contenedor 3', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'27', N'Contenedor 4', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'28', N'Contenedor 5', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'29', N'Contenedor 6', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'30', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'31', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'32', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'33', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'34', N'Contenedor 3', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'35', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'36', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'37', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'38', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'39', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'40', N'Contenedor 1', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'41', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'42', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'43', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'44', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'45', N'Contenedor 6', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'46', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'47', N'Contenedor 8', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'48', N'Contenedor 9', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'49', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'50', N'Contenedor 1', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'51', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'52', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'53', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'54', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'55', N'Contenedor 6', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'56', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'57', N'Contenedor 8', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'58', N'Contenedor 9', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'59', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'60', N'Contenedor 1', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'61', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'62', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'63', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'64', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'65', N'Contenedor 6', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'66', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'67', N'Contenedor 8', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'68', N'Contenedor 9', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'69', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'70', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'71', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'72', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'73', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'74', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'75', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'76', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'77', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'78', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'79', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'80', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'81', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'82', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'83', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'84', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'85', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'86', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'87', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'88', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'89', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'90', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'91', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'92', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'93', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'94', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'95', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'96', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'97', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'98', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'99', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'100', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'101', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'102', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'103', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'104', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'105', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'106', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'107', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'108', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'109', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'110', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'111', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'112', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'113', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'114', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'115', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'116', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'117', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'118', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'119', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'120', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'121', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'122', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'123', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'124', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'125', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'126', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'127', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'128', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'129', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'130', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'131', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'132', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'133', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'134', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'135', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'136', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'137', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'138', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'139', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'140', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'141', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'142', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'143', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'144', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'145', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'146', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'147', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'148', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'149', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'150', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'151', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'152', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'153', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'154', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'155', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'156', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'157', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'158', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'159', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'160', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'161', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'162', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'163', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'164', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'165', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'166', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'167', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'168', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'169', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'170', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'171', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'172', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'173', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'174', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'175', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'176', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'177', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'178', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'179', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'180', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'181', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'182', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'183', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'184', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'185', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'186', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'187', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'188', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'189', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'190', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'191', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'192', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'193', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'194', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'195', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'196', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'197', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'198', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'199', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'200', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'201', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'202', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'203', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'204', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'205', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'206', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'207', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'208', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'209', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'210', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'211', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'212', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'213', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'214', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'215', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'216', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'217', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'218', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'219', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'220', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'221', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'222', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'223', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'224', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'225', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'226', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'227', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'228', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'229', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'230', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'231', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'232', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'233', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'234', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'235', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'236', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'237', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'238', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'239', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'240', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'241', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'242', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'243', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'244', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'245', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'246', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'247', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'248', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'249', N'Contenedor 0', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'250', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'251', N'Contenedor 2', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'252', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'253', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'254', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'255', N'Contenedor 6', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'256', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'257', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'258', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'259', N'Contenedor 0', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'260', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'261', N'Contenedor 2', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'262', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'263', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'264', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'265', N'Contenedor 6', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'266', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'267', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'268', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'269', N'Contenedor 0', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'270', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'271', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'272', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'273', N'Contenedor 4', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'274', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'275', N'Contenedor 6', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'276', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'277', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'278', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'279', N'Contenedor 0', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'280', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'281', N'Contenedor 2', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'282', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'283', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'284', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'285', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'286', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'287', N'Contenedor 8', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'288', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'289', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'290', N'Contenedor 1', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'291', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'292', N'Contenedor 3', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'293', N'Contenedor 4', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'294', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'295', N'Contenedor 6', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'296', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'297', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'298', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'299', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'300', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'301', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'302', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'303', N'Contenedor 4', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'304', N'Contenedor 5', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'305', N'Contenedor 6', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'306', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'307', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'308', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'309', N'Contenedor 0', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'310', N'Contenedor 1', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'311', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'312', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'313', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'314', N'Contenedor 5', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'315', N'Contenedor 6', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'316', N'Contenedor 7', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'317', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'318', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'319', N'Contenedor 0', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'320', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'321', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'322', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'323', N'Contenedor 4', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'324', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'325', N'Contenedor 6', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'326', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'327', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'328', N'Contenedor 9', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'329', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'330', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'331', N'Contenedor 2', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'332', N'Contenedor 3', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'333', N'Contenedor 4', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'334', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'335', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'336', N'Contenedor 7', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'337', N'Contenedor 8', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'338', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'339', N'Contenedor 0', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'340', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'341', N'Contenedor 2', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'342', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'343', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'344', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'345', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'346', N'Contenedor 7', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'347', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'348', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'349', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'350', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'351', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'352', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'353', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'354', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'355', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'356', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'357', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'358', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'359', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'360', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'361', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'362', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'363', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'364', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'365', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'366', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'367', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'368', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'369', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'370', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'371', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'372', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'373', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'374', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'375', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'376', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'377', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'378', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'379', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'380', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'381', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'382', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'383', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'384', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'385', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'386', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'387', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'388', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'389', N'Contenedor 0', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'390', N'Contenedor 1', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'391', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'392', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'393', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'394', N'Contenedor 5', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'395', N'Contenedor 6', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'396', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'397', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'398', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'399', N'Contenedor 0', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'400', N'Contenedor 1', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'401', N'Contenedor 2', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'402', N'Contenedor 3', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'403', N'Contenedor 4', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'404', N'Contenedor 5', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'405', N'Contenedor 6', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'406', N'Contenedor 7', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'407', N'Contenedor 8', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'408', N'Contenedor 9', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'409', N'Contenedor 0', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'410', N'Contenedor 1', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'411', N'Contenedor 2', N'DRY', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'412', N'Contenedor 3', N'RRF', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'413', N'Contenedor 4', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'414', N'Contenedor 5', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'415', N'Contenedor 6', N'RRF', N'20', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'416', N'Contenedor 7', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'417', N'Contenedor 8', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'418', N'Contenedor 9', N'DRY', N'40', N'1')
GO

INSERT INTO [dbo].[container] ([id], [name], [code], [tonnage], [active]) VALUES (N'419', N'Contenedor 1', N'DRY', N'40', N'1')
GO

SET IDENTITY_INSERT [dbo].[container] OFF
GO


-- ----------------------------
-- Table structure for reception
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[reception]') AND type IN ('U'))
	DROP TABLE [dbo].[reception]
GO

CREATE TABLE [dbo].[reception] (
  [id] bigint  IDENTITY(1,1) NOT NULL,
  [bl] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [trans_company_id] int  NOT NULL,
  [agency_id] int  NOT NULL,
  [active] bit  NOT NULL,
  [created_at] datetime DEFAULT (getdate()) NOT NULL
)
GO

ALTER TABLE [dbo].[reception] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of reception
-- ----------------------------
SET IDENTITY_INSERT [dbo].[reception] ON
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'2', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'3', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'4', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'5', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'6', N'1111111111111', N'2', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'14', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'15', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'16', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:09.153')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'17', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:18.350')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'18', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:36:50.300')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'19', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:38:46.323')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'20', N'1111111111111', N'1', N'1', N'1', N'2018-06-05 12:40:16.990')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'21', N'1111111111111', N'2', N'1', N'1', N'2018-06-05 12:43:14.577')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'22', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-05 20:00:37.510')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'23', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-05 21:28:55.637')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'24', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-06 02:18:54.380')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'25', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-06 02:20:35.993')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'26', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-06 02:21:41.940')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'27', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-07 12:21:09.703')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'28', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-07 12:22:25.953')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'29', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-07 12:23:06.837')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'30', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:24:13.113')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'31', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:24:42.483')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'32', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:25:20.750')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'33', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:25:27.360')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'34', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:25:53.180')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'35', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:32:46.323')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'36', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:33:23.090')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'37', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:33:57.637')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'38', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:34:13.080')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'39', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:37:55.630')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'40', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:38:24.287')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'41', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:39:06.583')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'42', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:41:12.420')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'43', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:46:53.700')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'44', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:47:09.060')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'45', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:47:24.563')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'46', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:47:43.500')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'47', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:48:08.560')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'48', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:54:07.067')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'49', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 12:54:39.517')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'50', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-07 12:57:23.877')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'51', N'1111111111111111111111111', N'4', N'1', N'1', N'2018-06-07 12:59:49.273')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'52', N'1111111111111111111111111', N'5', N'1', N'1', N'2018-06-07 13:00:50.180')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'53', N'1111111111111111111111111', N'5', N'1', N'1', N'2018-06-07 13:03:22.343')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'54', N'1111111111111111111111111', N'5', N'1', N'1', N'2018-06-07 13:05:29.293')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'55', N'1111111111111111111111111', N'5', N'1', N'1', N'2018-06-07 13:07:00.160')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'56', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-07 13:12:01.370')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'57', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 17:24:23.827')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'58', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 21:35:12.197')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'59', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 21:36:27.370')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'60', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 21:37:24.147')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'61', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 21:37:55.703')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'62', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-09 21:38:37.407')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'63', N'1111111111111111111111111', N'2', N'1', N'1', N'2018-06-10 09:14:15.410')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'64', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-10 09:16:27.253')
GO

INSERT INTO [dbo].[reception] ([id], [bl], [trans_company_id], [agency_id], [active], [created_at]) VALUES (N'65', N'1111111111111111111111111', N'1', N'1', N'1', N'2018-06-10 10:41:32.890')
GO

SET IDENTITY_INSERT [dbo].[reception] OFF
GO


-- ----------------------------
-- Table structure for reception_transaction
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[reception_transaction]') AND type IN ('U'))
	DROP TABLE [dbo].[reception_transaction]
GO

CREATE TABLE [dbo].[reception_transaction] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [reception_id] bigint  NOT NULL,
  [container_id] int  NOT NULL,
  [register_truck] varchar(50) COLLATE Modern_Spanish_CI_AS  NULL,
  [register_driver] varchar(50) COLLATE Modern_Spanish_CI_AS  NULL,
  [delivery_date] date  NOT NULL,
  [active] bit  NOT NULL
)
GO

ALTER TABLE [dbo].[reception_transaction] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of reception_transaction
-- ----------------------------
SET IDENTITY_INSERT [dbo].[reception_transaction] ON
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'1', N'14', N'8', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'2', N'14', N'9', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'3', N'15', N'10', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'4', N'15', N'11', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'5', N'16', N'12', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'6', N'17', N'13', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'7', N'18', N'14', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'8', N'19', N'15', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'9', N'19', N'16', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'10', N'20', N'17', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'11', N'20', N'18', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'12', N'21', N'19', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'13', N'21', N'20', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'14', N'22', N'21', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'15', N'22', N'22', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'16', N'23', N'23', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'17', N'23', N'24', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'18', N'23', N'25', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'19', N'23', N'26', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'20', N'23', N'27', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'21', N'23', N'28', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'22', N'23', N'29', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'23', N'23', N'30', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'24', N'23', N'31', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'25', N'23', N'32', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'26', N'24', N'33', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'27', N'24', N'34', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'28', N'25', N'35', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'29', N'25', N'36', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'30', N'26', N'37', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'31', N'26', N'38', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'32', N'27', N'39', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'33', N'27', N'40', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'34', N'27', N'41', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'35', N'27', N'42', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'36', N'27', N'43', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'37', N'27', N'44', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'38', N'27', N'45', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'39', N'27', N'46', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'40', N'27', N'47', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'41', N'27', N'48', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'42', N'28', N'49', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'43', N'28', N'50', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'44', N'28', N'51', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'45', N'28', N'52', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'46', N'28', N'53', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'47', N'28', N'54', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'48', N'28', N'55', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'49', N'28', N'56', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'50', N'28', N'57', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'51', N'28', N'58', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'52', N'29', N'59', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'53', N'29', N'60', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'54', N'29', N'61', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'55', N'29', N'62', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'56', N'29', N'63', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'57', N'29', N'64', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'58', N'29', N'65', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'59', N'29', N'66', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'60', N'29', N'67', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'61', N'29', N'68', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'62', N'30', N'69', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'63', N'30', N'70', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'64', N'30', N'71', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'65', N'30', N'72', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'66', N'30', N'73', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'67', N'30', N'74', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'68', N'30', N'75', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'69', N'30', N'76', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'70', N'30', N'77', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'71', N'30', N'78', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'72', N'31', N'79', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'73', N'31', N'80', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'74', N'31', N'81', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'75', N'31', N'82', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'76', N'31', N'83', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'77', N'31', N'84', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'78', N'31', N'85', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'79', N'31', N'86', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'80', N'31', N'87', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'81', N'31', N'88', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'82', N'32', N'89', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'83', N'32', N'90', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'84', N'32', N'91', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'85', N'32', N'92', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'86', N'32', N'93', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'87', N'32', N'94', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'88', N'32', N'95', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'89', N'32', N'96', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'90', N'32', N'97', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'91', N'32', N'98', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'92', N'33', N'99', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'93', N'33', N'100', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'94', N'33', N'101', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'95', N'33', N'102', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'96', N'33', N'103', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'97', N'33', N'104', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'98', N'33', N'105', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'99', N'33', N'106', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'100', N'33', N'107', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'101', N'33', N'108', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'102', N'34', N'109', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'103', N'34', N'110', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'104', N'34', N'111', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'105', N'34', N'112', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'106', N'34', N'113', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'107', N'34', N'114', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'108', N'34', N'115', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'109', N'34', N'116', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'110', N'34', N'117', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'111', N'34', N'118', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'112', N'35', N'119', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'113', N'35', N'120', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'114', N'35', N'121', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'115', N'35', N'122', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'116', N'35', N'123', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'117', N'35', N'124', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'118', N'35', N'125', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'119', N'35', N'126', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'120', N'35', N'127', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'121', N'35', N'128', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'122', N'36', N'129', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'123', N'36', N'130', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'124', N'36', N'131', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'125', N'36', N'132', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'126', N'36', N'133', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'127', N'36', N'134', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'128', N'36', N'135', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'129', N'36', N'136', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'130', N'36', N'137', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'131', N'36', N'138', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'132', N'37', N'139', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'133', N'37', N'140', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'134', N'37', N'141', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'135', N'37', N'142', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'136', N'37', N'143', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'137', N'37', N'144', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'138', N'37', N'145', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'139', N'37', N'146', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'140', N'37', N'147', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'141', N'37', N'148', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'142', N'38', N'149', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'143', N'38', N'150', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'144', N'38', N'151', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'145', N'38', N'152', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'146', N'38', N'153', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'147', N'38', N'154', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'148', N'38', N'155', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'149', N'38', N'156', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'150', N'38', N'157', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'151', N'38', N'158', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'152', N'39', N'159', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'153', N'39', N'160', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'154', N'39', N'161', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'155', N'39', N'162', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'156', N'39', N'163', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'157', N'39', N'164', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'158', N'39', N'165', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'159', N'39', N'166', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'160', N'39', N'167', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'161', N'39', N'168', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'162', N'40', N'169', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'163', N'40', N'170', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'164', N'40', N'171', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'165', N'40', N'172', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'166', N'40', N'173', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'167', N'40', N'174', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'168', N'40', N'175', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'169', N'40', N'176', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'170', N'40', N'177', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'171', N'40', N'178', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'172', N'41', N'179', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'173', N'41', N'180', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'174', N'41', N'181', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'175', N'41', N'182', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'176', N'41', N'183', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'177', N'41', N'184', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'178', N'41', N'185', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'179', N'41', N'186', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'180', N'41', N'187', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'181', N'41', N'188', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'182', N'42', N'189', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'183', N'42', N'190', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'184', N'42', N'191', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'185', N'42', N'192', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'186', N'42', N'193', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'187', N'42', N'194', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'188', N'42', N'195', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'189', N'42', N'196', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'190', N'42', N'197', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'191', N'42', N'198', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'192', N'43', N'199', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'193', N'43', N'200', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'194', N'43', N'201', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'195', N'43', N'202', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'196', N'43', N'203', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'197', N'43', N'204', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'198', N'43', N'205', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'199', N'43', N'206', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'200', N'43', N'207', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'201', N'43', N'208', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'202', N'44', N'209', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'203', N'44', N'210', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'204', N'44', N'211', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'205', N'44', N'212', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'206', N'44', N'213', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'207', N'44', N'214', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'208', N'44', N'215', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'209', N'44', N'216', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'210', N'44', N'217', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'211', N'44', N'218', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'212', N'45', N'219', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'213', N'45', N'220', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'214', N'45', N'221', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'215', N'45', N'222', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'216', N'45', N'223', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'217', N'45', N'224', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'218', N'45', N'225', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'219', N'45', N'226', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'220', N'45', N'227', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'221', N'45', N'228', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'222', N'46', N'229', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'223', N'46', N'230', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'224', N'46', N'231', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'225', N'46', N'232', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'226', N'46', N'233', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'227', N'46', N'234', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'228', N'46', N'235', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'229', N'46', N'236', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'230', N'46', N'237', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'231', N'46', N'238', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'232', N'47', N'239', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'233', N'47', N'240', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'234', N'47', N'241', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'235', N'47', N'242', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'236', N'47', N'243', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'237', N'47', N'244', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'238', N'47', N'245', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'239', N'47', N'246', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'240', N'47', N'247', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'241', N'47', N'248', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'242', N'48', N'249', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'243', N'48', N'250', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'244', N'48', N'251', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'245', N'48', N'252', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'246', N'48', N'253', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'247', N'48', N'254', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'248', N'48', N'255', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'249', N'48', N'256', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'250', N'48', N'257', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'251', N'48', N'258', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'252', N'49', N'259', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'253', N'49', N'260', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'254', N'49', N'261', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'255', N'49', N'262', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'256', N'49', N'263', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'257', N'49', N'264', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'258', N'49', N'265', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'259', N'49', N'266', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'260', N'49', N'267', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'261', N'49', N'268', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'262', N'50', N'269', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'263', N'50', N'270', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'264', N'50', N'271', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'265', N'50', N'272', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'266', N'50', N'273', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'267', N'50', N'274', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'268', N'50', N'275', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'269', N'50', N'276', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'270', N'50', N'277', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'271', N'50', N'278', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'272', N'51', N'279', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'273', N'51', N'280', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'274', N'51', N'281', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'275', N'51', N'282', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'276', N'51', N'283', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'277', N'51', N'284', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'278', N'51', N'285', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'279', N'51', N'286', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'280', N'51', N'287', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'281', N'51', N'288', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'282', N'52', N'289', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'283', N'52', N'290', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'284', N'52', N'291', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'285', N'52', N'292', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'286', N'52', N'293', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'287', N'52', N'294', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'288', N'52', N'295', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'289', N'52', N'296', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'290', N'52', N'297', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'291', N'52', N'298', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'292', N'53', N'299', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'293', N'53', N'300', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'294', N'53', N'301', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'295', N'53', N'302', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'296', N'53', N'303', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'297', N'53', N'304', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'298', N'53', N'305', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'299', N'53', N'306', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'300', N'53', N'307', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'301', N'53', N'308', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'302', N'54', N'309', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'303', N'54', N'310', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'304', N'54', N'311', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'305', N'54', N'312', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'306', N'54', N'313', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'307', N'54', N'314', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'308', N'54', N'315', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'309', N'54', N'316', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'310', N'54', N'317', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'311', N'54', N'318', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'312', N'55', N'319', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'313', N'55', N'320', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'314', N'55', N'321', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'315', N'55', N'322', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'316', N'55', N'323', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'317', N'55', N'324', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'318', N'55', N'325', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'319', N'55', N'326', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'320', N'55', N'327', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'321', N'55', N'328', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'322', N'56', N'329', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'323', N'56', N'330', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'324', N'56', N'331', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'325', N'56', N'332', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'326', N'56', N'333', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'327', N'56', N'334', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'328', N'56', N'335', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'329', N'56', N'336', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'330', N'56', N'337', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'331', N'56', N'338', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'332', N'57', N'339', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'333', N'57', N'340', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'334', N'57', N'341', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'335', N'57', N'342', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'336', N'57', N'343', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'337', N'57', N'344', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'338', N'57', N'345', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'339', N'57', N'346', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'340', N'57', N'347', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'341', N'57', N'348', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'342', N'58', N'349', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'343', N'58', N'350', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'344', N'58', N'351', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'345', N'58', N'352', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'346', N'58', N'353', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'347', N'58', N'354', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'348', N'58', N'355', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'349', N'58', N'356', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'350', N'58', N'357', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'351', N'58', N'358', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'352', N'59', N'359', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'353', N'59', N'360', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'354', N'59', N'361', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'355', N'59', N'362', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'356', N'59', N'363', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'357', N'59', N'364', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'358', N'59', N'365', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'359', N'59', N'366', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'360', N'59', N'367', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'361', N'59', N'368', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'362', N'60', N'369', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'363', N'60', N'370', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'364', N'60', N'371', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'365', N'60', N'372', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'366', N'60', N'373', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'367', N'60', N'374', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'368', N'60', N'375', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'369', N'60', N'376', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'370', N'60', N'377', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'371', N'60', N'378', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'372', N'61', N'379', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'373', N'61', N'380', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'374', N'61', N'381', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'375', N'61', N'382', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'376', N'61', N'383', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'377', N'61', N'384', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'378', N'61', N'385', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'379', N'61', N'386', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'380', N'61', N'387', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'381', N'61', N'388', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'382', N'62', N'389', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'383', N'62', N'390', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'384', N'62', N'391', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'385', N'62', N'392', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'386', N'62', N'393', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'387', N'62', N'394', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'388', N'62', N'395', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'389', N'62', N'396', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'390', N'62', N'397', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'391', N'62', N'398', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'392', N'63', N'399', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'393', N'63', N'400', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'394', N'63', N'401', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'395', N'63', N'402', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'396', N'63', N'403', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'397', N'63', N'404', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'398', N'63', N'405', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'399', N'63', N'406', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'400', N'63', N'407', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'401', N'63', N'408', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'402', N'64', N'409', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'403', N'64', N'410', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'404', N'64', N'411', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'405', N'64', N'412', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'406', N'64', N'413', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'407', N'64', N'414', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'408', N'64', N'415', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'409', N'64', N'416', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'410', N'64', N'417', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'411', N'64', N'418', NULL, NULL, N'1900-01-01', N'1')
GO

INSERT INTO [dbo].[reception_transaction] ([id], [reception_id], [container_id], [register_truck], [register_driver], [delivery_date], [active]) VALUES (N'412', N'65', N'419', NULL, NULL, N'1900-01-01', N'1')
GO

SET IDENTITY_INSERT [dbo].[reception_transaction] OFF
GO


-- ----------------------------
-- Table structure for ticket
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[ticket]') AND type IN ('U'))
	DROP TABLE [dbo].[ticket]
GO

CREATE TABLE [dbo].[ticket] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [reception_transaction_id] int  NOT NULL,
  [calendar_id] int  NOT NULL,
  [status] smallint  NOT NULL,
  [created_at] datetime DEFAULT (getdate()) NOT NULL,
  [active] bit DEFAULT ((1)) NOT NULL
)
GO

ALTER TABLE [dbo].[ticket] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Table structure for trans_company
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[trans_company]') AND type IN ('U'))
	DROP TABLE [dbo].[trans_company]
GO

CREATE TABLE [dbo].[trans_company] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [ruc] varchar(13) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [address] text COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [active] bit DEFAULT ((1)) NOT NULL
)
GO

ALTER TABLE [dbo].[trans_company] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of trans_company
-- ----------------------------
SET IDENTITY_INSERT [dbo].[trans_company] ON
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'1', N'xxx', N'111', N'111', N'1')
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'2', N'tttttt', N'111', N'111', N'1')
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'3', N'dsa', N'ddsds', N'dsds', N'1')
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'4', N'dsdsa', N'sdsd', N'dsd', N'1')
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'5', N'dsadsa', N'dsadsad', N'sdsad', N'1')
GO

INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'6', N'ewew', N'ewew', N'ewqewe', N'1')
GO

SET IDENTITY_INSERT [dbo].[trans_company] OFF
GO


-- ----------------------------
-- Table structure for trans_company_phone
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[trans_company_phone]') AND type IN ('U'))
	DROP TABLE [dbo].[trans_company_phone]
GO

CREATE TABLE [dbo].[trans_company_phone] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [phone_number] varbinary(12)  NOT NULL,
  [trans_company_id] int  NOT NULL
)
GO

ALTER TABLE [dbo].[trans_company_phone] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Table structure for user_agency
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[user_agency]') AND type IN ('U'))
	DROP TABLE [dbo].[user_agency]
GO

CREATE TABLE [dbo].[user_agency] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NOT NULL,
  [agency_id] int  NOT NULL
)
GO

ALTER TABLE [dbo].[user_agency] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of user_agency
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user_agency] ON
GO

INSERT INTO [dbo].[user_agency] ([id], [user_id], [agency_id]) VALUES (N'8', N'1022', N'2')
GO

INSERT INTO [dbo].[user_agency] ([id], [user_id], [agency_id]) VALUES (N'9', N'1024', N'1')
GO

INSERT INTO [dbo].[user_agency] ([id], [user_id], [agency_id]) VALUES (N'10', N'1025', N'1')
GO

SET IDENTITY_INSERT [dbo].[user_agency] OFF
GO


-- ----------------------------
-- Table structure for user_transcompany
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[user_transcompany]') AND type IN ('U'))
	DROP TABLE [dbo].[user_transcompany]
GO

CREATE TABLE [dbo].[user_transcompany] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NOT NULL,
  [transcompany_id] int  NOT NULL
)
GO

ALTER TABLE [dbo].[user_transcompany] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of user_transcompany
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user_transcompany] ON
GO

INSERT INTO [dbo].[user_transcompany] ([id], [user_id], [transcompany_id]) VALUES (N'1', N'1021', N'1')
GO

SET IDENTITY_INSERT [dbo].[user_transcompany] OFF
GO


-- ----------------------------
-- Table structure for user_warehouse
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[user_warehouse]') AND type IN ('U'))
	DROP TABLE [dbo].[user_warehouse]
GO

CREATE TABLE [dbo].[user_warehouse] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NOT NULL,
  [warehouse_id] int  NOT NULL
)
GO

ALTER TABLE [dbo].[user_warehouse] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Table structure for warehouse
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[warehouse]') AND type IN ('U'))
	DROP TABLE [dbo].[warehouse]
GO

CREATE TABLE [dbo].[warehouse] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [code_oce] varchar(50) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [name] varchar(max) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [active] bit DEFAULT ((1)) NOT NULL,
  [ruc] varchar(13) COLLATE Modern_Spanish_CI_AS  NOT NULL
)
GO

ALTER TABLE [dbo].[warehouse] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of warehouse
-- ----------------------------
SET IDENTITY_INSERT [dbo].[warehouse] ON
GO

INSERT INTO [dbo].[warehouse] ([id], [code_oce], [name], [active], [ruc]) VALUES (N'1', N'111', N'www', N'1', N'11')
GO

INSERT INTO [dbo].[warehouse] ([id], [code_oce], [name], [active], [ruc]) VALUES (N'2', N'111', N'wwww', N'1', N'111')
GO

SET IDENTITY_INSERT [dbo].[warehouse] OFF
GO


-- ----------------------------
-- Primary Key structure for table adm_user
-- ----------------------------
ALTER TABLE [dbo].[adm_user] ADD CONSTRAINT [PK__adm_user__3213E83FE90C5D4A] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table agency
-- ----------------------------
ALTER TABLE [dbo].[agency] ADD CONSTRAINT [PK__agency__3213E83F8F21B755] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table auth_assignment
-- ----------------------------
ALTER TABLE [dbo].[auth_assignment] ADD CONSTRAINT [PK__auth_ass__473EC9E6E91DDE06] PRIMARY KEY CLUSTERED ([item_name], [user_id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Indexes structure for table auth_item
-- ----------------------------
CREATE NONCLUSTERED INDEX [idx-auth_item-type]
ON [dbo].[auth_item] (
  [type] ASC
)
GO

CREATE UNIQUE NONCLUSTERED INDEX [FK__auth_item__child]
ON [dbo].[auth_item] (
  [name] ASC
)
GO


-- ----------------------------
-- Triggers structure for table auth_item
-- ----------------------------
CREATE TRIGGER [dbo].[trigger_auth_item_child]
ON [dbo].[auth_item]
WITH EXECUTE AS CALLER
INSTEAD OF UPDATE, DELETE
AS
DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
    DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
    BEGIN
        IF COLUMNS_UPDATED() > 0
        BEGIN
            IF @old_name <> @new_name
                BEGIN
                    ALTER TABLE auth_item_child NOCHECK CONSTRAINT FK__auth_item__child;
                    UPDATE auth_item_child SET child = @new_name WHERE child = @old_name;
                END
                UPDATE auth_item
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE auth_item_child CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM dbo.[auth_item_child] WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM dbo.[auth_item] WHERE name IN (SELECT name FROM deleted);
                    END
        END;
GO


-- ----------------------------
-- Primary Key structure for table auth_item
-- ----------------------------
ALTER TABLE [dbo].[auth_item] ADD CONSTRAINT [PK__auth_ite__72E12F1A8D2F4182] PRIMARY KEY CLUSTERED ([name])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table auth_item_child
-- ----------------------------
ALTER TABLE [dbo].[auth_item_child] ADD CONSTRAINT [PK_auth_item_child] PRIMARY KEY CLUSTERED ([parent], [child])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table auth_rule
-- ----------------------------
ALTER TABLE [dbo].[auth_rule] ADD CONSTRAINT [PK__auth_rul__72E12F1A0D24D582] PRIMARY KEY CLUSTERED ([name])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table calendar
-- ----------------------------
ALTER TABLE [dbo].[calendar] ADD CONSTRAINT [PK__calendar__3213E83FEEA69BFD] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table container
-- ----------------------------
ALTER TABLE [dbo].[container] ADD CONSTRAINT [PK__containe__3213E83FBC99F833] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table reception
-- ----------------------------
ALTER TABLE [dbo].[reception] ADD CONSTRAINT [PK__receptio__3213E83FFF58068A] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table reception_transaction
-- ----------------------------
ALTER TABLE [dbo].[reception_transaction] ADD CONSTRAINT [PK__receptio__3213E83FCE7F60D5] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Uniques structure for table ticket
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD CONSTRAINT [UQ__ticket__E2E9858FDC308CCE] UNIQUE NONCLUSTERED ([reception_transaction_id] ASC)
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table ticket
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD CONSTRAINT [PK__ticket__3213E83F3AD89C71] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table trans_company
-- ----------------------------
ALTER TABLE [dbo].[trans_company] ADD CONSTRAINT [PK__trans_co__3213E83FF8ED87F1] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table trans_company_phone
-- ----------------------------
ALTER TABLE [dbo].[trans_company_phone] ADD CONSTRAINT [PK__trans_co__3213E83F3A505938] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table user_agency
-- ----------------------------
ALTER TABLE [dbo].[user_agency] ADD CONSTRAINT [PK__user_age__3213E83FE538F356] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table user_transcompany
-- ----------------------------
ALTER TABLE [dbo].[user_transcompany] ADD CONSTRAINT [PK__user_tra__3213E83FC3E92D52] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table user_warehouse
-- ----------------------------
ALTER TABLE [dbo].[user_warehouse] ADD CONSTRAINT [PK__user_war__3213E83FD087A5B2] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table warehouse
-- ----------------------------
ALTER TABLE [dbo].[warehouse] ADD CONSTRAINT [PK__warehous__3213E83FD76B7FE2] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table auth_assignment
-- ----------------------------
ALTER TABLE [dbo].[auth_assignment] ADD CONSTRAINT [FK__auth_assi__item___440B1D61] FOREIGN KEY ([item_name]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table auth_item
-- ----------------------------
ALTER TABLE [dbo].[auth_item] ADD CONSTRAINT [FK__auth_item__rule___44FF419A] FOREIGN KEY ([rule_name]) REFERENCES [dbo].[auth_rule] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table auth_item_child
-- ----------------------------
ALTER TABLE [dbo].[auth_item_child] ADD CONSTRAINT [FK_auth_item_child_item] FOREIGN KEY ([child]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[auth_item_child] ADD CONSTRAINT [FK_auth_item_child_auth_item_parent] FOREIGN KEY ([parent]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table calendar
-- ----------------------------
ALTER TABLE [dbo].[calendar] ADD CONSTRAINT [FK__calendar__id_war__7F2BE32F] FOREIGN KEY ([id_warehouse]) REFERENCES [dbo].[warehouse] ([id]) ON DELETE CASCADE ON UPDATE CASCADE NOT FOR REPLICATION
GO


-- ----------------------------
-- Foreign Keys structure for table reception
-- ----------------------------
ALTER TABLE [dbo].[reception] ADD CONSTRAINT [FK__reception__agenc__47DBAE45] FOREIGN KEY ([agency_id]) REFERENCES [dbo].[agency] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

ALTER TABLE [dbo].[reception] ADD CONSTRAINT [FK__reception__trans__48CFD27E] FOREIGN KEY ([trans_company_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table reception_transaction
-- ----------------------------
ALTER TABLE [dbo].[reception_transaction] ADD CONSTRAINT [FK__reception__conta__49C3F6B7] FOREIGN KEY ([container_id]) REFERENCES [dbo].[container] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table ticket
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD CONSTRAINT [FK__ticket__calendar__7E37BEF6] FOREIGN KEY ([calendar_id]) REFERENCES [dbo].[calendar] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

ALTER TABLE [dbo].[ticket] ADD CONSTRAINT [FK__ticket__receptio__4BAC3F29] FOREIGN KEY ([reception_transaction_id]) REFERENCES [dbo].[reception_transaction] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table trans_company_phone
-- ----------------------------
ALTER TABLE [dbo].[trans_company_phone] ADD CONSTRAINT [FK__trans_com__trans__4CA06362] FOREIGN KEY ([trans_company_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table user_agency
-- ----------------------------
ALTER TABLE [dbo].[user_agency] ADD CONSTRAINT [FK__user_agen__agenc__4D94879B] FOREIGN KEY ([agency_id]) REFERENCES [dbo].[agency] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

ALTER TABLE [dbo].[user_agency] ADD CONSTRAINT [FK__user_agen__user___4E88ABD4] FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO


-- ----------------------------
-- Foreign Keys structure for table user_transcompany
-- ----------------------------
ALTER TABLE [dbo].[user_transcompany] ADD CONSTRAINT [FK__user_tran__trans__4F7CD00D] FOREIGN KEY ([transcompany_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

ALTER TABLE [dbo].[user_transcompany] ADD CONSTRAINT [FK__user_tran__user___5070F446] FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table user_warehouse
-- ----------------------------
ALTER TABLE [dbo].[user_warehouse] ADD CONSTRAINT [FK__user_ware__user___5165187F] FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

ALTER TABLE [dbo].[user_warehouse] ADD CONSTRAINT [FK__user_ware__wareh__52593CB8] FOREIGN KEY ([warehouse_id]) REFERENCES [dbo].[warehouse] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

