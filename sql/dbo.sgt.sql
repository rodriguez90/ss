/*
Navicat SQL Server Data Transfer

Source Server         : sql
Source Server Version : 130000
Source Host           : DESKTOP-JH5RE76\SQLEXPRESS:1433
Source Database       : sgt
Source Schema         : dbo

Target Server Type    : SQL Server
Target Server Version : 130000
File Encoding         : 65001

Date: 2018-06-29 06:57:25
*/


-- ----------------------------
-- Table structure for [dbo].[adm_user]
-- ----------------------------
-- DROP TABLE [dbo].[adm_user]
GO
CREATE TABLE [dbo].[adm_user] (
[id] int NOT NULL IDENTITY(1,1) ,
[username] varchar(MAX) NOT NULL ,
[auth_key] varchar(MAX) NULL ,
[password] varchar(MAX) NOT NULL ,
[email] varchar(MAX) NOT NULL ,
[nombre] varchar(MAX) NOT NULL ,
[apellidos] varchar(MAX) NOT NULL ,
[creado_por] varchar(MAX) NULL ,
[status] smallint NOT NULL ,
[created_at] bigint NULL ,
[updated_at] bigint NULL ,
[password_reset_token] varbinary(MAX) NULL ,
[cedula] varchar(50) NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[adm_user]', RESEED, 1040)
GO

-- ----------------------------
-- Records of adm_user
-- ----------------------------
SET IDENTITY_INSERT [dbo].[adm_user] ON
GO
INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1', N'root', null, N'$2y$13$zCsRHm1Irfu8JaQCMes1cuhDuI7MXgI.SEqiLyB0P/gn5W6znHS.C', N'root@xedrux.com', N'Yander', N'Pelfort', null, N'1', N'1528595775', N'1526355240', null, N'85052621160');
GO
INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1026', N'ciatransporte', null, N'$2y$13$lz1lV.FYLolYAkUYIu3Y6eEOgDenCNTKaOyA6u4EZDPqgOPvshmf2', N'prueba2@xedrux.com', N'ciatransporte', N'rodriguezciatransporte', N'root', N'1', N'1528595893', N'1530238282', null, N'0102010201');
GO
INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1039', N'importador', null, N'$2y$13$Bu2D3VI3mXkanuOx71h0D.DKFyf7/S0CP6tFy37G1X6Gz0lYXXMwq', N'importador@xedrux.com', N'importador', N'apellidos import', N'root', N'1', N'1530266291', N'1530266527', null, N'0959347094');
GO
INSERT INTO [dbo].[adm_user] ([id], [username], [auth_key], [password], [email], [nombre], [apellidos], [creado_por], [status], [created_at], [updated_at], [password_reset_token], [cedula]) VALUES (N'1040', N'exportador', null, N'$2y$13$a3VsjVa8W537yThZdcYqR.e8o6HmpucqJj.HWx6L/fgGcoJhjj9Sa', N'exportador@xedrux.com', N'Exportador', N'Apellidos Exportador', N'root', N'1', N'1530266505', N'1530266505', null, N'0959347099');
GO
SET IDENTITY_INSERT [dbo].[adm_user] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[agency]
-- ----------------------------
-- DROP TABLE [dbo].[agency]
GO
CREATE TABLE [dbo].[agency] (
[id] int NOT NULL IDENTITY(1,1) ,
[name] varchar(MAX) NOT NULL ,
[code_oce] varchar(10) NOT NULL ,
[ruc] varchar(13) NOT NULL ,
[active] bit NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[agency]', RESEED, 2)
GO

-- ----------------------------
-- Records of agency
-- ----------------------------
SET IDENTITY_INSERT [dbo].[agency] ON
GO
INSERT INTO [dbo].[agency] ([id], [name], [code_oce], [ruc], [active]) VALUES (N'1', N'xxxxxxxxxx', N'111', N'111', N'1');
GO
INSERT INTO [dbo].[agency] ([id], [name], [code_oce], [ruc], [active]) VALUES (N'2', N'agency prueba', N'111', N'111', N'1');
GO
SET IDENTITY_INSERT [dbo].[agency] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[auth_assignment]
-- ----------------------------
-- DROP TABLE [dbo].[auth_assignment]
GO
CREATE TABLE [dbo].[auth_assignment] (
[item_name] varchar(64) NOT NULL ,
[user_id] int NOT NULL ,
[created_at] int NULL 
)


GO

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Administracion', N'1', null);
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Cia_transporte', N'1026', N'1530238282');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Exportador', N'1040', N'1530266505');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Importador', N'1039', N'1530266416');
GO

-- ----------------------------
-- Table structure for [dbo].[auth_item]
-- ----------------------------
-- DROP TABLE [dbo].[auth_item]
GO
CREATE TABLE [dbo].[auth_item] (
[name] varchar(64) NOT NULL ,
[type] smallint NOT NULL ,
[description] text NULL ,
[rule_name] varchar(64) NULL ,
[data] varchar(64) NULL ,
[created_at] int NULL ,
[updated_at] int NULL 
)


GO

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'admin_mod', N'2', N'Acceso al modulo administrción', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Administracion', N'1', N'root', null, null, null, null);
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Administrador_depósito', N'1', N'Administrador del depósito ', null, null, N'1526269475', N'1526269475');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Agencia', N'1', N'Serán los que por medio del sistema ingresen la eCas con la información de los contenedores. El significado y lógica de eCas serán explicados más adelante.', null, null, N'1526269415', N'1526269415');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'agency_create', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'agency_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'agency_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'agency_update', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'agency_view', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'calendar_create', N'2', N'Crear calendario', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'calendar_delete', N'2', N'Eliminar calendario', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'calendar_list', N'2', N'Listar calendario', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'calendar_update', N'2', N'Actualizar calendario', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'calendar_view', N'2', N'Detalle de calendario', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'cia_trans_create', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'cia_trans_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'cia_trans_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'cia_trans_update', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'cia_trans_view', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Cia_transporte', N'1', N'Entrarán al sistema a especificar los choferes y las placas de los carros con los que retirarán los contenedores solicitados por un usuario Y con rol Importador/Exportador, así como seleccionar los turnos o los cupos de acuerdo a si es una recepción o un despacho. Notar que estos usuarios dependen directamente de los usuarios Importadores/Exportadores.  ', null, null, N'1526269434', N'1526269434');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'container_create', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'container_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'container_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'container_update', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'container_view', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Depósito', N'1', N'Gestiona los cupos y asigna las agencias y los tipos de contenedores a los calendarios.', null, null, N'1526269452', N'1526269452');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Exportador', N'1', N'Exportador', null, null, N'1530265454', N'1530265454');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'generating_card', N'2', N'Genera cartas de servicio.', null, null, N'1529187227', N'1529187227');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Importador', N'1', N'Importador', null, null, N'1530265440', N'1530265440');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'process_create', N'2', N'Crear procesos', null, null, N'1530265629', N'1530265629');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'process_delete', N'2', N'Eliminar Proceso', null, null, N'1530265650', N'1530265650');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'process_list', N'2', N'Listar Procesos', null, null, N'1530265609', N'1530265609');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'process_update', N'2', N'Actualizar proceso', null, null, N'1530265858', N'1530265858');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'process_view', N'2', N'Detalle proceso', null, null, N'1530265683', N'1530265683');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'ticket_create', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'ticket_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'ticket_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'ticket_update', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'ticket_view', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'trans_company_create', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'trans_company_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'trans_company_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'trans_company_update', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'trans_company_view', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'user_create', N'2', N'Crear Usuario', null, null, N'1528979542', N'1528979542');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'user_delete', N'2', N'Eliminar Usuarios', null, null, N'1528979542', N'1528979542');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'user_list', N'2', N'Listar Usuarios', null, null, N'1528979542', N'1528979542');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'user_update', N'2', N'Actualizar Usuarios', null, null, N'1528979542', N'1528979542');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'user_view', N'2', N'Ver Usuarios', null, null, N'1528979542', N'1528979542');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'warehouse_create', N'2', N'Crear Depósito', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'warehouse_delete', N'2', N'Eliminar Depósito', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'warehouse_list', N'2', N'Listar Depósito', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'warehouse_update', N'2', N'Actualizar Depósito', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'warehouse_view', N'2', N'Detalle Depósito', null, null, N'1528983960', N'1528983960');
GO

-- ----------------------------
-- Table structure for [dbo].[auth_item_child]
-- ----------------------------
-- DROP TABLE [dbo].[auth_item_child]
GO
CREATE TABLE [dbo].[auth_item_child] (
[parent] varchar(64) NOT NULL ,
[child] varchar(64) NOT NULL 
)


GO

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'admin_mod');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'agency_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'agency_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'agency_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'agency_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'agency_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'calendar_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'calendar_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'calendar_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'calendar_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'calendar_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'cia_trans_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'cia_trans_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'cia_trans_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'cia_trans_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'cia_trans_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'container_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'container_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'container_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'container_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'container_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'generating_card');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'process_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'process_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'process_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'process_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'process_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'ticket_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'ticket_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'ticket_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'ticket_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'ticket_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'trans_company_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'trans_company_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'trans_company_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'trans_company_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'trans_company_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'user_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'user_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'user_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'user_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'user_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'warehouse_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'warehouse_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'warehouse_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'warehouse_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'warehouse_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'calendar_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'calendar_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'calendar_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'calendar_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'calendar_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'ticket_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'ticket_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'ticket_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'ticket_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'ticket_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'generating_card');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'ticket_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'ticket_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'ticket_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'ticket_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'ticket_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'calendar_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'calendar_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'calendar_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'calendar_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'calendar_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'ticket_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'ticket_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Exportador', N'process_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Exportador', N'process_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Exportador', N'process_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Exportador', N'process_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Exportador', N'process_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador', N'process_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador', N'process_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador', N'process_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador', N'process_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador', N'process_view');
GO

-- ----------------------------
-- Table structure for [dbo].[auth_rule]
-- ----------------------------
-- DROP TABLE [dbo].[auth_rule]
GO
CREATE TABLE [dbo].[auth_rule] (
[name] varchar(64) NOT NULL ,
[data] varchar(64) NULL ,
[created_at] int NULL ,
[updated_at] int NULL 
)


GO

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for [dbo].[calendar]
-- ----------------------------
-- DROP TABLE [dbo].[calendar]
GO
CREATE TABLE [dbo].[calendar] (
[id] int NOT NULL IDENTITY(1,1) ,
[id_warehouse] int NOT NULL ,
[start_datetime] datetime NOT NULL ,
[end_datetime] datetime NOT NULL ,
[amount] int NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[calendar]', RESEED, 397)
GO

-- ----------------------------
-- Records of calendar
-- ----------------------------
SET IDENTITY_INSERT [dbo].[calendar] ON
GO
SET IDENTITY_INSERT [dbo].[calendar] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[container]
-- ----------------------------
-- DROP TABLE [dbo].[container]
GO
CREATE TABLE [dbo].[container] (
[id] int NOT NULL IDENTITY(1,1) ,
[name] varchar(MAX) NOT NULL ,
[code] varchar(3) NOT NULL ,
[tonnage] int NOT NULL ,
[active] bit NOT NULL DEFAULT ((0)) ,
[status] varchar(255) NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[container]', RESEED, 10)
GO

-- ----------------------------
-- Records of container
-- ----------------------------
SET IDENTITY_INSERT [dbo].[container] ON
GO
SET IDENTITY_INSERT [dbo].[container] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[process]
-- ----------------------------
-- DROP TABLE [dbo].[process]
GO
CREATE TABLE [dbo].[process] (
[id] bigint NOT NULL IDENTITY(1,1) ,
[bl] varchar(MAX) NOT NULL ,
[agency_id] int NOT NULL ,
[active] bit NOT NULL ,
[created_at] datetime NOT NULL DEFAULT (getdate()) ,
[type] tinyint NOT NULL ,
[delivery_date] date NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[process]', RESEED, 2)
GO

-- ----------------------------
-- Records of process
-- ----------------------------
SET IDENTITY_INSERT [dbo].[process] ON
GO
SET IDENTITY_INSERT [dbo].[process] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[process_transaction]
-- ----------------------------
-- DROP TABLE [dbo].[process_transaction]
GO
CREATE TABLE [dbo].[process_transaction] (
[id] int NOT NULL IDENTITY(1,1) ,
[process_id] bigint NOT NULL ,
[container_id] int NOT NULL ,
[register_truck] varchar(50) NULL ,
[register_driver] varchar(50) NULL ,
[delivery_date] date NOT NULL ,
[active] bit NOT NULL ,
[name_driver] varchar(255) NULL ,
[trans_company_id] int NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[process_transaction]', RESEED, 10)
GO

-- ----------------------------
-- Records of process_transaction
-- ----------------------------
SET IDENTITY_INSERT [dbo].[process_transaction] ON
GO
SET IDENTITY_INSERT [dbo].[process_transaction] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[ticket]
-- ----------------------------
-- DROP TABLE [dbo].[ticket]
GO
CREATE TABLE [dbo].[ticket] (
[id] int NOT NULL IDENTITY(1,1) ,
[process_transaction_id] int NOT NULL ,
[calendar_id] int NOT NULL ,
[status] smallint NOT NULL ,
[created_at] datetime NOT NULL DEFAULT (getdate()) ,
[active] bit NOT NULL DEFAULT ((1)) 
)


GO
DBCC CHECKIDENT(N'[dbo].[ticket]', RESEED, 3)
GO

-- ----------------------------
-- Records of ticket
-- ----------------------------
SET IDENTITY_INSERT [dbo].[ticket] ON
GO
SET IDENTITY_INSERT [dbo].[ticket] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[trans_company]
-- ----------------------------
-- DROP TABLE [dbo].[trans_company]
GO
CREATE TABLE [dbo].[trans_company] (
[id] int NOT NULL IDENTITY(1,1) ,
[name] varchar(MAX) NOT NULL ,
[ruc] varchar(13) NOT NULL ,
[address] text NOT NULL ,
[active] bit NOT NULL DEFAULT ((1)) 
)


GO
DBCC CHECKIDENT(N'[dbo].[trans_company]', RESEED, 6)
GO

-- ----------------------------
-- Records of trans_company
-- ----------------------------
SET IDENTITY_INSERT [dbo].[trans_company] ON
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'1', N'trans prueba', N'111', N'111', N'1');
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'2', N'xxxxx', N'111', N'111', N'1');
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'3', N'dsa', N'ddsds', N'dsds', N'1');
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'4', N'dsdsa', N'sdsd', N'dsd', N'1');
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'5', N'dsadsa', N'dsadsad', N'sdsad', N'1');
GO
INSERT INTO [dbo].[trans_company] ([id], [name], [ruc], [address], [active]) VALUES (N'6', N'ewew', N'ewew', N'ewqewe', N'1');
GO
SET IDENTITY_INSERT [dbo].[trans_company] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[trans_company_phone]
-- ----------------------------
-- DROP TABLE [dbo].[trans_company_phone]
GO
CREATE TABLE [dbo].[trans_company_phone] (
[id] int NOT NULL IDENTITY(1,1) ,
[phone_number] varbinary(12) NOT NULL ,
[trans_company_id] int NOT NULL 
)


GO

-- ----------------------------
-- Records of trans_company_phone
-- ----------------------------
SET IDENTITY_INSERT [dbo].[trans_company_phone] ON
GO
SET IDENTITY_INSERT [dbo].[trans_company_phone] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[user_agency]
-- ----------------------------
-- DROP TABLE [dbo].[user_agency]
GO
CREATE TABLE [dbo].[user_agency] (
[id] int NOT NULL IDENTITY(1,1) ,
[user_id] int NOT NULL ,
[agency_id] int NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[user_agency]', RESEED, 35)
GO

-- ----------------------------
-- Records of user_agency
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user_agency] ON
GO
INSERT INTO [dbo].[user_agency] ([id], [user_id], [agency_id]) VALUES (N'34', N'1039', N'1');
GO
INSERT INTO [dbo].[user_agency] ([id], [user_id], [agency_id]) VALUES (N'35', N'1040', N'1');
GO
SET IDENTITY_INSERT [dbo].[user_agency] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[user_transcompany]
-- ----------------------------
-- DROP TABLE [dbo].[user_transcompany]
GO
CREATE TABLE [dbo].[user_transcompany] (
[id] int NOT NULL IDENTITY(1,1) ,
[user_id] int NOT NULL ,
[transcompany_id] int NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[user_transcompany]', RESEED, 9)
GO

-- ----------------------------
-- Records of user_transcompany
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user_transcompany] ON
GO
INSERT INTO [dbo].[user_transcompany] ([id], [user_id], [transcompany_id]) VALUES (N'2', N'1026', N'1');
GO
SET IDENTITY_INSERT [dbo].[user_transcompany] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[user_warehouse]
-- ----------------------------
-- DROP TABLE [dbo].[user_warehouse]
GO
CREATE TABLE [dbo].[user_warehouse] (
[id] int NOT NULL IDENTITY(1,1) ,
[user_id] int NOT NULL ,
[warehouse_id] int NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[user_warehouse]', RESEED, 29)
GO

-- ----------------------------
-- Records of user_warehouse
-- ----------------------------
SET IDENTITY_INSERT [dbo].[user_warehouse] ON
GO
SET IDENTITY_INSERT [dbo].[user_warehouse] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[warehouse]
-- ----------------------------
-- DROP TABLE [dbo].[warehouse]
GO
CREATE TABLE [dbo].[warehouse] (
[id] int NOT NULL IDENTITY(1,1) ,
[code_oce] varchar(50) NOT NULL ,
[name] varchar(MAX) NOT NULL ,
[active] bit NOT NULL DEFAULT ((1)) ,
[ruc] varchar(13) NOT NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[warehouse]', RESEED, 2)
GO

-- ----------------------------
-- Records of warehouse
-- ----------------------------
SET IDENTITY_INSERT [dbo].[warehouse] ON
GO
INSERT INTO [dbo].[warehouse] ([id], [code_oce], [name], [active], [ruc]) VALUES (N'1', N'111', N'warehouse prueba', N'1', N'11');
GO
INSERT INTO [dbo].[warehouse] ([id], [code_oce], [name], [active], [ruc]) VALUES (N'2', N'111', N'wwww', N'1', N'111');
GO
SET IDENTITY_INSERT [dbo].[warehouse] OFF
GO

-- ----------------------------
-- Indexes structure for table adm_user
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[adm_user]
-- ----------------------------
ALTER TABLE [dbo].[adm_user] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table agency
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[agency]
-- ----------------------------
ALTER TABLE [dbo].[agency] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table auth_assignment
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[auth_assignment]
-- ----------------------------
ALTER TABLE [dbo].[auth_assignment] ADD PRIMARY KEY ([item_name], [user_id])
GO

-- ----------------------------
-- Indexes structure for table auth_item
-- ----------------------------
CREATE INDEX [idx-auth_item-type] ON [dbo].[auth_item]
([type] ASC) 
GO
CREATE UNIQUE INDEX [FK__auth_item__child] ON [dbo].[auth_item]
([name] ASC) 
GO

-- ----------------------------
-- Primary Key structure for table [dbo].[auth_item]
-- ----------------------------
ALTER TABLE [dbo].[auth_item] ADD PRIMARY KEY ([name])
GO

-- ----------------------------
-- Triggers structure for table [dbo].[auth_item]
-- ----------------------------
--DROP TRIGGER [dbo].[trigger_auth_item_child]
GO
CREATE TRIGGER [dbo].[trigger_auth_item_child]
ON [dbo].[auth_item]
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
-- Indexes structure for table auth_item_child
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[auth_item_child]
-- ----------------------------
ALTER TABLE [dbo].[auth_item_child] ADD PRIMARY KEY ([parent], [child])
GO

-- ----------------------------
-- Indexes structure for table auth_rule
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[auth_rule]
-- ----------------------------
ALTER TABLE [dbo].[auth_rule] ADD PRIMARY KEY ([name])
GO

-- ----------------------------
-- Indexes structure for table calendar
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[calendar]
-- ----------------------------
ALTER TABLE [dbo].[calendar] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table container
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[container]
-- ----------------------------
ALTER TABLE [dbo].[container] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table process
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[process]
-- ----------------------------
ALTER TABLE [dbo].[process] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table process_transaction
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[process_transaction]
-- ----------------------------
ALTER TABLE [dbo].[process_transaction] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table ticket
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[ticket]
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Uniques structure for table [dbo].[ticket]
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD UNIQUE ([process_transaction_id] ASC)
GO

-- ----------------------------
-- Indexes structure for table trans_company
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[trans_company]
-- ----------------------------
ALTER TABLE [dbo].[trans_company] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table trans_company_phone
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[trans_company_phone]
-- ----------------------------
ALTER TABLE [dbo].[trans_company_phone] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table user_agency
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[user_agency]
-- ----------------------------
ALTER TABLE [dbo].[user_agency] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table user_transcompany
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[user_transcompany]
-- ----------------------------
ALTER TABLE [dbo].[user_transcompany] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table user_warehouse
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[user_warehouse]
-- ----------------------------
ALTER TABLE [dbo].[user_warehouse] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table warehouse
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[warehouse]
-- ----------------------------
ALTER TABLE [dbo].[warehouse] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[auth_assignment]
-- ----------------------------
ALTER TABLE [dbo].[auth_assignment] ADD FOREIGN KEY ([item_name]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[auth_assignment] ADD FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[auth_item]
-- ----------------------------
ALTER TABLE [dbo].[auth_item] ADD FOREIGN KEY ([rule_name]) REFERENCES [dbo].[auth_rule] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[auth_item_child]
-- ----------------------------
ALTER TABLE [dbo].[auth_item_child] ADD FOREIGN KEY ([child]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO
ALTER TABLE [dbo].[auth_item_child] ADD FOREIGN KEY ([parent]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[calendar]
-- ----------------------------
ALTER TABLE [dbo].[calendar] ADD FOREIGN KEY ([id_warehouse]) REFERENCES [dbo].[warehouse] ([id]) ON DELETE CASCADE ON UPDATE CASCADE NOT FOR REPLICATION
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[process]
-- ----------------------------
ALTER TABLE [dbo].[process] ADD FOREIGN KEY ([agency_id]) REFERENCES [dbo].[agency] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[process_transaction]
-- ----------------------------
ALTER TABLE [dbo].[process_transaction] ADD FOREIGN KEY ([trans_company_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[process_transaction] ADD FOREIGN KEY ([container_id]) REFERENCES [dbo].[container] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[process_transaction] ADD FOREIGN KEY ([process_id]) REFERENCES [dbo].[process] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[ticket]
-- ----------------------------
ALTER TABLE [dbo].[ticket] ADD FOREIGN KEY ([calendar_id]) REFERENCES [dbo].[calendar] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[ticket] ADD FOREIGN KEY ([process_transaction_id]) REFERENCES [dbo].[process_transaction] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[trans_company_phone]
-- ----------------------------
ALTER TABLE [dbo].[trans_company_phone] ADD FOREIGN KEY ([trans_company_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[user_agency]
-- ----------------------------
ALTER TABLE [dbo].[user_agency] ADD FOREIGN KEY ([agency_id]) REFERENCES [dbo].[agency] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[user_agency] ADD FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[user_transcompany]
-- ----------------------------
ALTER TABLE [dbo].[user_transcompany] ADD FOREIGN KEY ([transcompany_id]) REFERENCES [dbo].[trans_company] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[user_transcompany] ADD FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[user_warehouse]
-- ----------------------------
ALTER TABLE [dbo].[user_warehouse] ADD FOREIGN KEY ([user_id]) REFERENCES [dbo].[adm_user] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[user_warehouse] ADD FOREIGN KEY ([warehouse_id]) REFERENCES [dbo].[warehouse] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO
