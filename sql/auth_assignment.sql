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

Date: 2018-06-14 10:26:00
*/


-- ----------------------------
-- Table structure for [dbo].[auth_assignment]
-- ----------------------------
DROP TABLE [dbo].[auth_assignment]
GO
CREATE TABLE [dbo].[auth_assignment] (
[item_name] varchar(64) NOT NULL ,
[user_id] varchar(64) NOT NULL ,
[created_at] int NULL 
)


GO

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Administracion', N'1', N'1526360000');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Administrador_depósito', N'1027', N'1528944689');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Agencia', N'1028', N'1528944895');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Cia_transporte', N'1021', N'1526360998');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Depósito', N'1026', N'1528944380');
GO
INSERT INTO [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'Importador_Exportador', N'1022', N'1526361116');
GO

-- ----------------------------
-- Table structure for [dbo].[auth_item]
-- ----------------------------
DROP TABLE [dbo].[auth_item]
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
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'Importador_Exportador', N'1', N'Serán aquellos usuarios que entrarán al sistema a solicitar que una compañía de transporte X retire (Despacho) o entregue (Recepción) contenedores al TPG.', null, null, N'1526269359', N'1526269359');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'reception_create', N'2', N'Crear recepción', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'reception_delete', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'reception_list', N'2', N'', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'reception_update', N'2', N'Actualizar recepción', null, null, N'1528983960', N'1528983960');
GO
INSERT INTO [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'reception_view', N'2', N'', null, null, N'1528983960', N'1528983960');
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
DROP TABLE [dbo].[auth_item_child]
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
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'reception_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'reception_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'reception_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administracion', N'reception_view');
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
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Administrador_depósito', N'reception_view');
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
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Agencia', N'reception_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Agencia', N'reception_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Agencia', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Agencia', N'reception_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Agencia', N'reception_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Cia_transporte', N'reception_view');
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
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Depósito', N'reception_view');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador_Exportador', N'reception_create');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador_Exportador', N'reception_delete');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador_Exportador', N'reception_list');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador_Exportador', N'reception_update');
GO
INSERT INTO [dbo].[auth_item_child] ([parent], [child]) VALUES (N'Importador_Exportador', N'reception_view');
GO

-- ----------------------------
-- Table structure for [dbo].[auth_rule]
-- ----------------------------
DROP TABLE [dbo].[auth_rule]
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
DROP TRIGGER [dbo].[trigger_auth_item_child]
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
-- Foreign Key structure for table [dbo].[auth_assignment]
-- ----------------------------
ALTER TABLE [dbo].[auth_assignment] ADD FOREIGN KEY ([item_name]) REFERENCES [dbo].[auth_item] ([name]) ON DELETE CASCADE ON UPDATE CASCADE
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
