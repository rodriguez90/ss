USE [master]
GO
/****** Object:  Database [sgt]    Script Date: 14/05/2018 07:35:56 a. m. ******/
CREATE DATABASE [sgt]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'sgt', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.SQLEXPRESS\MSSQL\DATA\sgt.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'sgt_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.SQLEXPRESS\MSSQL\DATA\sgt_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [sgt] SET COMPATIBILITY_LEVEL = 130
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [sgt].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [sgt] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [sgt] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [sgt] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [sgt] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [sgt] SET ARITHABORT OFF 
GO
ALTER DATABASE [sgt] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [sgt] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [sgt] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [sgt] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [sgt] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [sgt] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [sgt] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [sgt] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [sgt] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [sgt] SET  DISABLE_BROKER 
GO
ALTER DATABASE [sgt] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [sgt] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [sgt] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [sgt] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [sgt] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [sgt] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [sgt] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [sgt] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [sgt] SET  MULTI_USER 
GO
ALTER DATABASE [sgt] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [sgt] SET DB_CHAINING OFF 
GO
ALTER DATABASE [sgt] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [sgt] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [sgt] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [sgt] SET QUERY_STORE = OFF
GO
USE [sgt]
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET LEGACY_CARDINALITY_ESTIMATION = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET MAXDOP = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET PARAMETER_SNIFFING = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET QUERY_OPTIMIZER_HOTFIXES = PRIMARY;
GO
USE [sgt]
GO
/****** Object:  Table [dbo].[adm_user]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[adm_user](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](max) NOT NULL,
	[auth_key] [varchar](max) NULL,
	[password] [varchar](max) NOT NULL,
	[email] [varchar](max) NOT NULL,
	[nombre] [varchar](max) NOT NULL,
	[apellidos] [varchar](max) NOT NULL,
	[creado_por] [varchar](max) NULL,
	[status] [smallint] NOT NULL,
	[created_at] [bigint] NULL,
	[updated_at] [bigint] NULL,
	[password_reset_token] [varbinary](max) NULL,
	[cedula] [varchar](50) NOT NULL,
 CONSTRAINT [PK_adm_user] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[agency]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[agency](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](max) NOT NULL,
	[code_oce] [varchar](10) NOT NULL,
	[ruc] [varchar](13) NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_agency] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_assignment]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_assignment](
	[item_name] [varchar](64) NOT NULL,
	[user_id] [varchar](64) NOT NULL,
	[created_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[item_name] ASC,
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_item]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_item](
	[name] [varchar](64) NOT NULL,
	[type] [smallint] NOT NULL,
	[description] [text] NULL,
	[rule_name] [varchar](64) NULL,
	[data] [varchar](64) NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_item_child]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_item_child](
	[parent] [varchar](64) NOT NULL,
	[child] [varchar](64) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[parent] ASC,
	[child] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_rule]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_rule](
	[name] [varchar](64) NOT NULL,
	[data] [varchar](64) NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[container]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[container](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](max) NOT NULL,
	[code] [varchar](3) NOT NULL,
	[tonnage] [int] NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_container] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[migration]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[migration](
	[version] [varchar](180) NOT NULL,
	[apply_time] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[version] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[reception]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[reception](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[bl] [varchar](max) NOT NULL,
	[trans_company_id] [int] NOT NULL,
	[agency_id] [int] NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_reception] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[process_transaction]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[process_transaction](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[reception_id] [bigint] NOT NULL,
	[container_id] [int] NOT NULL,
	[register_truck] [varchar](50) NOT NULL,
	[register_driver] [varchar](50) NOT NULL,
	[delivery_date] [date] NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_reception_transaction] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ticket]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ticket](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[delivery_date] [timestamp] NOT NULL,
	[reception_transaction_id] [int] NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_ticket] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[trans_company]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[trans_company](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](max) NOT NULL,
	[ruc] [varchar](13) NOT NULL,
	[address] [text] NOT NULL,
	[active] [bit] NOT NULL,
 CONSTRAINT [PK_trans_company] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[trans_company_phone]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[trans_company_phone](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[phone_number] [varbinary](12) NOT NULL,
	[trans_company_id] [int] NOT NULL,
 CONSTRAINT [PK_trans_company_phone] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_agency]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_agency](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[agency_id] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_transcompany]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_transcompany](
	[id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[transcompany_id] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_warehouse]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_warehouse](
	[id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[warehouse_id] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[warehouse]    Script Date: 14/05/2018 07:35:56 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[warehouse](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[code_oce] [varchar](50) NOT NULL,
	[name] [varchar](max) NOT NULL,
	[active] [bit] NOT NULL,
	[ruc] [varchar](13) NOT NULL,
 CONSTRAINT [PK_warehouse] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [auth_assignment_user_id_idx]    Script Date: 14/05/2018 07:35:56 a. m. ******/
CREATE NONCLUSTERED INDEX [auth_assignment_user_id_idx] ON [dbo].[auth_assignment]
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [FK__auth_item__child]    Script Date: 14/05/2018 07:35:56 a. m. ******/
CREATE UNIQUE NONCLUSTERED INDEX [FK__auth_item__child] ON [dbo].[auth_item]
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [idx-auth_item-type]    Script Date: 14/05/2018 07:35:56 a. m. ******/
CREATE NONCLUSTERED INDEX [idx-auth_item-type] ON [dbo].[auth_item]
(
	[type] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[container] ADD  CONSTRAINT [DF_container_active]  DEFAULT ((0)) FOR [active]
GO
ALTER TABLE [dbo].[trans_company] ADD  CONSTRAINT [DF_trans_company_active]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[warehouse] ADD  CONSTRAINT [DF_warehouse_active]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[auth_assignment]  WITH CHECK ADD  CONSTRAINT [FK__auth_assi__item___5BE2A6F2] FOREIGN KEY([item_name])
REFERENCES [dbo].[auth_item] ([name])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[auth_assignment] CHECK CONSTRAINT [FK__auth_assi__item___5BE2A6F2]
GO
ALTER TABLE [dbo].[auth_item]  WITH CHECK ADD FOREIGN KEY([rule_name])
REFERENCES [dbo].[auth_rule] ([name])
GO
ALTER TABLE [dbo].[auth_item_child]  WITH NOCHECK ADD  CONSTRAINT [FK__auth_item__child] FOREIGN KEY([child])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[auth_item_child] CHECK CONSTRAINT [FK__auth_item__child]
GO
ALTER TABLE [dbo].[auth_item_child]  WITH CHECK ADD  CONSTRAINT [FK__auth_item__parent] FOREIGN KEY([parent])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[auth_item_child] CHECK CONSTRAINT [FK__auth_item__parent]
GO
ALTER TABLE [dbo].[reception]  WITH CHECK ADD  CONSTRAINT [FK_reception_agency] FOREIGN KEY([agency_id])
REFERENCES [dbo].[agency] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[reception] CHECK CONSTRAINT [FK_reception_agency]
GO
ALTER TABLE [dbo].[reception]  WITH CHECK ADD  CONSTRAINT [FK_reception_trans_company] FOREIGN KEY([trans_company_id])
REFERENCES [dbo].[trans_company] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[reception] CHECK CONSTRAINT [FK_reception_trans_company]
GO
ALTER TABLE [dbo].[process_transaction]  WITH CHECK ADD  CONSTRAINT [FK_reception_transaction_container] FOREIGN KEY([container_id])
REFERENCES [dbo].[container] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[process_transaction] CHECK CONSTRAINT [FK_reception_transaction_container]
GO
ALTER TABLE [dbo].[process_transaction]  WITH CHECK ADD  CONSTRAINT [FK_reception_transaction_reception] FOREIGN KEY([reception_id])
REFERENCES [dbo].[reception] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[process_transaction] CHECK CONSTRAINT [FK_reception_transaction_reception]
GO
ALTER TABLE [dbo].[ticket]  WITH CHECK ADD  CONSTRAINT [FK_ticket_reception_transaction] FOREIGN KEY([reception_transaction_id])
REFERENCES [dbo].[process_transaction] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ticket] CHECK CONSTRAINT [FK_ticket_reception_transaction]
GO
ALTER TABLE [dbo].[trans_company_phone]  WITH CHECK ADD  CONSTRAINT [FK_trans_company_phone_trans_company] FOREIGN KEY([trans_company_id])
REFERENCES [dbo].[trans_company] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[trans_company_phone] CHECK CONSTRAINT [FK_trans_company_phone_trans_company]
GO
ALTER TABLE [dbo].[user_agency]  WITH NOCHECK ADD  CONSTRAINT [FK_agency_id] FOREIGN KEY([agency_id])
REFERENCES [dbo].[agency] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_agency] CHECK CONSTRAINT [FK_agency_id]
GO
ALTER TABLE [dbo].[user_agency]  WITH CHECK ADD  CONSTRAINT [FK_user_agency_id] FOREIGN KEY([user_id])
REFERENCES [dbo].[adm_user] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_agency] CHECK CONSTRAINT [FK_user_agency_id]
GO
ALTER TABLE [dbo].[user_transcompany]  WITH CHECK ADD  CONSTRAINT [FK_transcompany_id] FOREIGN KEY([transcompany_id])
REFERENCES [dbo].[trans_company] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_transcompany] CHECK CONSTRAINT [FK_transcompany_id]
GO
ALTER TABLE [dbo].[user_transcompany]  WITH CHECK ADD  CONSTRAINT [FK_user_transcompany_id] FOREIGN KEY([user_id])
REFERENCES [dbo].[adm_user] ([id])
GO
ALTER TABLE [dbo].[user_transcompany] CHECK CONSTRAINT [FK_user_transcompany_id]
GO
ALTER TABLE [dbo].[user_warehouse]  WITH CHECK ADD  CONSTRAINT [FK_user_warehouse_id] FOREIGN KEY([user_id])
REFERENCES [dbo].[adm_user] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_warehouse] CHECK CONSTRAINT [FK_user_warehouse_id]
GO
ALTER TABLE [dbo].[user_warehouse]  WITH CHECK ADD  CONSTRAINT [FK_warehouse_id] FOREIGN KEY([warehouse_id])
REFERENCES [dbo].[warehouse] ([id])
GO
ALTER TABLE [dbo].[user_warehouse] CHECK CONSTRAINT [FK_warehouse_id]
GO
USE [master]
GO
ALTER DATABASE [sgt] SET  READ_WRITE 
GO
