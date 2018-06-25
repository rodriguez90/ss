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

 Date: 11/06/2018 00:18:32
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

