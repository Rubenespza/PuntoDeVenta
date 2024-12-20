USE [master]
GO
/****** Object:  Database [PuntoDeVenta]    Script Date: 6/17/2024 2:55:35 AM ******/
CREATE DATABASE [PuntoDeVenta]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'PuntoDeVenta', FILENAME = N'C:\Program Files\Microsoft SQL Server NEW\MSSQL16.MSSQLSERVERNEW\MSSQL\DATA\PuntoDeVenta.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'PuntoDeVenta_log', FILENAME = N'C:\Program Files\Microsoft SQL Server NEW\MSSQL16.MSSQLSERVERNEW\MSSQL\DATA\PuntoDeVenta_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT, LEDGER = OFF
GO
ALTER DATABASE [PuntoDeVenta] SET COMPATIBILITY_LEVEL = 160
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [PuntoDeVenta].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [PuntoDeVenta] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET ARITHABORT OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [PuntoDeVenta] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [PuntoDeVenta] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET  DISABLE_BROKER 
GO
ALTER DATABASE [PuntoDeVenta] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [PuntoDeVenta] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET RECOVERY FULL 
GO
ALTER DATABASE [PuntoDeVenta] SET  MULTI_USER 
GO
ALTER DATABASE [PuntoDeVenta] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [PuntoDeVenta] SET DB_CHAINING OFF 
GO
ALTER DATABASE [PuntoDeVenta] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [PuntoDeVenta] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [PuntoDeVenta] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [PuntoDeVenta] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'PuntoDeVenta', N'ON'
GO
ALTER DATABASE [PuntoDeVenta] SET QUERY_STORE = ON
GO
ALTER DATABASE [PuntoDeVenta] SET QUERY_STORE (OPERATION_MODE = READ_WRITE, CLEANUP_POLICY = (STALE_QUERY_THRESHOLD_DAYS = 30), DATA_FLUSH_INTERVAL_SECONDS = 900, INTERVAL_LENGTH_MINUTES = 60, MAX_STORAGE_SIZE_MB = 1000, QUERY_CAPTURE_MODE = AUTO, SIZE_BASED_CLEANUP_MODE = AUTO, MAX_PLANS_PER_QUERY = 200, WAIT_STATS_CAPTURE_MODE = ON)
GO
USE [PuntoDeVenta]
GO
/****** Object:  Table [dbo].[Clientes]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Clientes](
	[ID_Cliente] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Cliente] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Compras]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Compras](
	[ID_Compra] [int] IDENTITY(1,1) NOT NULL,
	[ID_Proveedor] [int] NULL,
	[Fecha] [date] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Compra] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Detalles_Compra]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Detalles_Compra](
	[ID_Compra] [int] NOT NULL,
	[ID_Producto] [int] NOT NULL,
	[Cantidad] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Compra] ASC,
	[ID_Producto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Detalles_Venta]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Detalles_Venta](
	[ID_Venta] [int] NOT NULL,
	[ID_Producto] [int] NOT NULL,
	[Cantidad] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Venta] ASC,
	[ID_Producto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Empresas]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Empresas](
	[ID_Empresa] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Empresa] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Productos]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Productos](
	[ID_Producto] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
	[Precio] [decimal](10, 2) NULL,
	[ID_Empresa] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Producto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Proveedores]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Proveedores](
	[ID_Proveedor] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
	[Empresa] [nvarchar](100) NULL,
	[ID_Empresa] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Proveedor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Roles]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Roles](
	[ID_Rol] [int] NOT NULL,
	[Descripcion] [nvarchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Rol] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Usuarios]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Usuarios](
	[ID_Usuario] [int] IDENTITY(1,1) NOT NULL,
	[ID_Empresa] [int] NULL,
	[ID_Rol] [int] NULL,
	[Nombre] [nvarchar](100) NULL,
	[Correo] [nvarchar](100) NULL,
	[Contraseña] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Usuario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Ventas]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Ventas](
	[ID_Venta] [int] IDENTITY(1,1) NOT NULL,
	[ID_Cliente] [int] NULL,
	[Fecha] [date] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Venta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[Clientes] ON 

INSERT [dbo].[Clientes] ([ID_Cliente], [Nombre]) VALUES (1, N'María García')
INSERT [dbo].[Clientes] ([ID_Cliente], [Nombre]) VALUES (2, N'José Martínez')
INSERT [dbo].[Clientes] ([ID_Cliente], [Nombre]) VALUES (3, N'Ana Rodríguez')
INSERT [dbo].[Clientes] ([ID_Cliente], [Nombre]) VALUES (6, N'Carlos Martínez')
SET IDENTITY_INSERT [dbo].[Clientes] OFF
GO
SET IDENTITY_INSERT [dbo].[Compras] ON 

INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (1, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (2, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (3, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (4, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (5, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (6, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (7, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (8, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (9, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (10, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (11, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (12, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (13, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (14, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (15, 1, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Compras] ([ID_Compra], [ID_Proveedor], [Fecha]) VALUES (16, 1, CAST(N'2024-06-17' AS Date))
SET IDENTITY_INSERT [dbo].[Compras] OFF
GO
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (1, 3, 50)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (2, 3, 70)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (3, 3, 20)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (4, 3, 30)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (5, 2, 70)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (6, 3, 100)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (7, 5, 30)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (8, 4, 5)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (9, 3, 15)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (10, 1, 15)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (11, 4, 12)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (12, 4, 13)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (13, 5, 1)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (14, 2, 4)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (15, 1, 3)
INSERT [dbo].[Detalles_Compra] ([ID_Compra], [ID_Producto], [Cantidad]) VALUES (16, 3, 5)
GO
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (1, 2, 1)
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (2, 3, 2)
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (3, 1, 5)
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (4, 3, 2)
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (5, 4, 5)
INSERT [dbo].[Detalles_Venta] ([ID_Venta], [ID_Producto], [Cantidad]) VALUES (6, 2, 2)
GO
SET IDENTITY_INSERT [dbo].[Empresas] ON 

INSERT [dbo].[Empresas] ([ID_Empresa], [Nombre]) VALUES (1, N'TechSolutions')
INSERT [dbo].[Empresas] ([ID_Empresa], [Nombre]) VALUES (2, N'GreenGreens')
INSERT [dbo].[Empresas] ([ID_Empresa], [Nombre]) VALUES (3, N'FashionHouse')
SET IDENTITY_INSERT [dbo].[Empresas] OFF
GO
SET IDENTITY_INSERT [dbo].[Productos] ON 

INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (1, N'Laptop Pro', CAST(1200.00 AS Decimal(10, 2)), 1)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (2, N'Smartphone X', CAST(800.00 AS Decimal(10, 2)), 1)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (3, N'Wireless Mouse', CAST(25.00 AS Decimal(10, 2)), 1)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (4, N'Mechanical Keyboard', CAST(70.00 AS Decimal(10, 2)), 1)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (5, N'Noise Cancelling Headphones', CAST(150.00 AS Decimal(10, 2)), 1)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (6, N'Lechuga Fresca', CAST(2.50 AS Decimal(10, 2)), 2)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (7, N'Tomate Orgánico', CAST(3.00 AS Decimal(10, 2)), 2)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (8, N'Pepino', CAST(1.75 AS Decimal(10, 2)), 2)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (9, N'Zanahoria', CAST(2.00 AS Decimal(10, 2)), 2)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (10, N'Brócoli', CAST(2.80 AS Decimal(10, 2)), 2)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (11, N'Camisa Elegante', CAST(35.00 AS Decimal(10, 2)), 3)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (12, N'Pantalón de Vestir', CAST(50.00 AS Decimal(10, 2)), 3)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (13, N'Vestido de Noche', CAST(120.00 AS Decimal(10, 2)), 3)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (14, N'Zapatos de Cuero', CAST(80.00 AS Decimal(10, 2)), 3)
INSERT [dbo].[Productos] ([ID_Producto], [Nombre], [Precio], [ID_Empresa]) VALUES (15, N'Bolso de Mano', CAST(60.00 AS Decimal(10, 2)), 3)
SET IDENTITY_INSERT [dbo].[Productos] OFF
GO
SET IDENTITY_INSERT [dbo].[Proveedores] ON 

INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (1, N'John Doe', N'Tech Innovators Inc.', 1)
INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (2, N'Jane Smith', N'Silicon Solutions LLC', 1)
INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (3, N'Emily Johnson', N'Eco Friendly Supplies', 2)
INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (4, N'Michael Brown', N'Green Earth Resources', 2)
INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (5, N'Sophia Davis', N'Fashion Fabrics Co.', 3)
INSERT [dbo].[Proveedores] ([ID_Proveedor], [Nombre], [Empresa], [ID_Empresa]) VALUES (6, N'James Wilson', N'StyleTextiles Ltd.', 3)
SET IDENTITY_INSERT [dbo].[Proveedores] OFF
GO
INSERT [dbo].[Roles] ([ID_Rol], [Descripcion]) VALUES (1, N'Administrador')
INSERT [dbo].[Roles] ([ID_Rol], [Descripcion]) VALUES (2, N'Empleado')
GO
SET IDENTITY_INSERT [dbo].[Usuarios] ON 

INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (11, 1, 1, N'Diego Cedillo', N'dcedillo@techsolutions.com', N'$2y$10$oe1KPfmRy.7XiUiK7.1BgetxWnZib9OzFsHNbSgIfWv3sRwk466GC')
INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (12, 1, 2, N'Roselin Portella', N'rportella@techsolutions.com', N'$2y$10$.jerhV/03AwBXAUmtP1dm.YI8xXxsIC.WORDq8fA8runtON4xk19.')
INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (13, 2, 1, N'Israel Guevara', N'iguevara@greengreens.com', N'$2y$10$fcltALn2npQuQBpdEI6sku70iaelGa0vF.3BG.jcZcYpsn2A41NjS')
INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (14, 2, 2, N'César Sanchez', N'csanchez@greengreens.com', N'$2y$10$Vch7B.9AGd43ERfJYTGVE.Thc9dWSZ2wJLa46BVLFP.c2MX1JK6zq')
INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (15, 3, 1, N'Leslee García', N'lgarcia@fashionhouse.com', N'$2y$10$YAMwx.pbjfUHmC8hyFK6aO6yZR4ZxaNnOXjNidmUTNW6IYzMNQQSm')
INSERT [dbo].[Usuarios] ([ID_Usuario], [ID_Empresa], [ID_Rol], [Nombre], [Correo], [Contraseña]) VALUES (16, 3, 2, N'Fátima Reyes', N'freyes@fashionhouse.com', N'$2y$10$wXmjXCVryIXKHralsdfXo.DTBs3UrtR5atFIAYaYqrdhad2FWYvlW')
SET IDENTITY_INSERT [dbo].[Usuarios] OFF
GO
SET IDENTITY_INSERT [dbo].[Ventas] ON 

INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (1, 1, CAST(N'2024-06-16' AS Date))
INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (2, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (3, 2, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (4, 3, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (5, 6, CAST(N'2024-06-17' AS Date))
INSERT [dbo].[Ventas] ([ID_Venta], [ID_Cliente], [Fecha]) VALUES (6, 6, CAST(N'2024-06-17' AS Date))
SET IDENTITY_INSERT [dbo].[Ventas] OFF
GO
ALTER TABLE [dbo].[Compras]  WITH CHECK ADD FOREIGN KEY([ID_Proveedor])
REFERENCES [dbo].[Proveedores] ([ID_Proveedor])
GO
ALTER TABLE [dbo].[Detalles_Compra]  WITH CHECK ADD FOREIGN KEY([ID_Compra])
REFERENCES [dbo].[Compras] ([ID_Compra])
GO
ALTER TABLE [dbo].[Detalles_Compra]  WITH CHECK ADD FOREIGN KEY([ID_Producto])
REFERENCES [dbo].[Productos] ([ID_Producto])
GO
ALTER TABLE [dbo].[Detalles_Venta]  WITH CHECK ADD FOREIGN KEY([ID_Producto])
REFERENCES [dbo].[Productos] ([ID_Producto])
GO
ALTER TABLE [dbo].[Detalles_Venta]  WITH CHECK ADD FOREIGN KEY([ID_Venta])
REFERENCES [dbo].[Ventas] ([ID_Venta])
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [FK_Productos_Empresas] FOREIGN KEY([ID_Empresa])
REFERENCES [dbo].[Empresas] ([ID_Empresa])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [FK_Productos_Empresas]
GO
ALTER TABLE [dbo].[Proveedores]  WITH CHECK ADD FOREIGN KEY([ID_Empresa])
REFERENCES [dbo].[Empresas] ([ID_Empresa])
GO
ALTER TABLE [dbo].[Usuarios]  WITH CHECK ADD FOREIGN KEY([ID_Empresa])
REFERENCES [dbo].[Empresas] ([ID_Empresa])
GO
ALTER TABLE [dbo].[Usuarios]  WITH CHECK ADD FOREIGN KEY([ID_Rol])
REFERENCES [dbo].[Roles] ([ID_Rol])
GO
ALTER TABLE [dbo].[Ventas]  WITH CHECK ADD FOREIGN KEY([ID_Cliente])
REFERENCES [dbo].[Clientes] ([ID_Cliente])
GO
/****** Object:  StoredProcedure [dbo].[sp_AñadirCompra]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_AñadirCompra]
    @ID_Proveedor INT,
    @Fecha DATE,
    @ID_Producto INT,
    @Cantidad INT,
    @ID_Compra INT OUTPUT
AS
BEGIN
    SET NOCOUNT ON;

    -- Insertar la compra en la tabla Compras
    INSERT INTO Compras (ID_Proveedor, Fecha)
    VALUES (@ID_Proveedor, @Fecha);

    -- Obtener el ID de la compra recién insertada
    SET @ID_Compra = SCOPE_IDENTITY();

    -- Insertar el detalle de la compra en la tabla Detalles_Compra
    INSERT INTO Detalles_Compra (ID_Compra, ID_Producto, Cantidad)
    VALUES (@ID_Compra, @ID_Producto, @Cantidad);
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_AñadirVenta]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_AñadirVenta]
    @ID_Cliente INT,
    @Fecha DATE,
    @ID_Producto INT,
    @Cantidad INT,
    @ID_Venta INT OUTPUT
AS
BEGIN
    SET NOCOUNT ON;

    -- Insertar la venta en la tabla Ventas
    INSERT INTO Ventas (ID_Cliente, Fecha)
    VALUES (@ID_Cliente, @Fecha);

    -- Obtener el ID de la venta recién insertada
    SET @ID_Venta = SCOPE_IDENTITY();

    -- Insertar el detalle de la venta en la tabla Detalles_Venta
    INSERT INTO Detalles_Venta (ID_Venta, ID_Producto, Cantidad)
    VALUES (@ID_Venta, @ID_Producto, @Cantidad);
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_CrearCliente]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_CrearCliente]
    @Nombre NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    INSERT INTO Clientes (Nombre)
    VALUES (@Nombre);
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_CrearProveedor]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_CrearProveedor]
    @Nombre NVARCHAR(100),
    @Empresa NVARCHAR(100),
    @ID_Empresa INT
AS
BEGIN
    SET NOCOUNT ON;

    INSERT INTO Proveedores (Nombre, Empresa, ID_Empresa)
    VALUES (@Nombre, @Empresa, @ID_Empresa);
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_CrearUsuario]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_CrearUsuario]
    @ID_Empresa INT,
    @ID_Rol INT,
    @Nombre NVARCHAR(100),
    @Correo NVARCHAR(100),
    @Contraseña NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    INSERT INTO Usuarios (ID_Empresa, ID_Rol, Nombre, Correo, Contraseña)
    VALUES (@ID_Empresa, @ID_Rol, @Nombre, @Correo, @Contraseña);
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_EditarCliente]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EditarCliente]
    @ID_Cliente INT,
    @Nombre NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE Clientes
    SET Nombre = @Nombre
    WHERE ID_Cliente = @ID_Cliente;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_EditarProveedor]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EditarProveedor]
    @ID_Proveedor INT,
    @Nombre NVARCHAR(100),
    @Empresa NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE Proveedores
    SET Nombre = @Nombre,
        Empresa = @Empresa
    WHERE ID_Proveedor = @ID_Proveedor;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_EditarUsuario]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EditarUsuario]
    @ID_Usuario INT,
    @Nombre NVARCHAR(100),
    @Correo NVARCHAR(100),
    @ID_Rol INT
AS
BEGIN
    UPDATE Usuarios
    SET Nombre = @Nombre,
        Correo = @Correo,
        ID_Rol = @ID_Rol
    WHERE ID_Usuario = @ID_Usuario;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_EliminarClientes]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EliminarClientes]
    @ID_Cliente INT
AS
BEGIN
    SET NOCOUNT ON;

    DELETE FROM Clientes WHERE ID_Cliente = @ID_Cliente;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_EliminarProveedores]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EliminarProveedores]
    @ID_Proveedor INT
AS
BEGIN
    SET NOCOUNT ON;

    DELETE FROM Proveedores WHERE ID_Proveedor = @ID_Proveedor;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_EliminarUsuarios]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_EliminarUsuarios]
    @ID_Usuario INT
AS
BEGIN
    SET NOCOUNT ON;

    DELETE FROM Usuarios WHERE ID_Usuario = @ID_Usuario;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerAniosCompras]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerAniosCompras]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT DISTINCT YEAR(Fecha) AS Anio
    FROM Compras
    ORDER BY Anio;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerAniosVentas]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerAniosVentas]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT DISTINCT YEAR(Fecha) AS Anio
    FROM Ventas
    ORDER BY Anio;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerClientes]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerClientes]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT ID_Cliente, Nombre
    FROM Clientes;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerDatosCompra]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerDatosCompra]
    @ID_Compra INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
        c.ID_Compra,
        c.Fecha,
        p.Nombre AS Proveedor,
        pr.Nombre AS Producto,
        pr.Precio,
        dc.Cantidad
    FROM 
        Compras c
    JOIN 
        Detalles_Compra dc ON c.ID_Compra = dc.ID_Compra
    JOIN 
        Proveedores p ON c.ID_Proveedor = p.ID_Proveedor
    JOIN 
        Productos pr ON dc.ID_Producto = pr.ID_Producto
    WHERE 
        c.ID_Compra = @ID_Compra;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerDatosVenta]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerDatosVenta]
    @ID_Venta INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
        v.ID_Venta,
        v.Fecha,
        c.Nombre AS Cliente,
        pr.Nombre AS Producto,
        pr.Precio,
        dv.Cantidad,
        (dv.Cantidad * pr.Precio) AS Total
    FROM 
        Ventas v
    JOIN 
        Detalles_Venta dv ON v.ID_Venta = dv.ID_Venta
    JOIN 
        Clientes c ON v.ID_Cliente = c.ID_Cliente
    JOIN 
        Productos pr ON dv.ID_Producto = pr.ID_Producto
    WHERE 
        v.ID_Venta = @ID_Venta;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerHistorialCompras]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerHistorialCompras]
    @Ano INT,
    @ID_Proveedor INT = NULL
AS
BEGIN
    SET NOCOUNT ON;

    SELECT Proveedor, 
           ISNULL([1], 0) AS Enero, 
           ISNULL([2], 0) AS Febrero, 
           ISNULL([3], 0) AS Marzo, 
           ISNULL([4], 0) AS Abril, 
           ISNULL([5], 0) AS Mayo, 
           ISNULL([6], 0) AS Junio, 
           ISNULL([7], 0) AS Julio, 
           ISNULL([8], 0) AS Agosto, 
           ISNULL([9], 0) AS Septiembre, 
           ISNULL([10], 0) AS Octubre, 
           ISNULL([11], 0) AS Noviembre, 
           ISNULL([12], 0) AS Diciembre
    FROM 
    (
        SELECT 
            p.Nombre AS Proveedor,
            MONTH(c.Fecha) AS Mes,
            dc.Cantidad * pr.Precio AS TotalCosto
        FROM 
            Compras c
        JOIN 
            Detalles_Compra dc ON c.ID_Compra = dc.ID_Compra
        JOIN 
            Proveedores p ON c.ID_Proveedor = p.ID_Proveedor
        JOIN 
            Productos pr ON dc.ID_Producto = pr.ID_Producto
        WHERE 
            YEAR(c.Fecha) = @Ano
            AND (@ID_Proveedor IS NULL OR c.ID_Proveedor = @ID_Proveedor)
    ) AS SourceTable
    PIVOT
    (
        SUM(TotalCosto)
        FOR Mes IN ([1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12])
    ) AS PivotTable
    ORDER BY Proveedor;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerHistorialVentas]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerHistorialVentas]
    @Ano INT,
    @ID_Cliente INT = NULL
AS
BEGIN
    SET NOCOUNT ON;

    SELECT Cliente, 
           ISNULL([1], 0) AS Enero, 
           ISNULL([2], 0) AS Febrero, 
           ISNULL([3], 0) AS Marzo, 
           ISNULL([4], 0) AS Abril, 
           ISNULL([5], 0) AS Mayo, 
           ISNULL([6], 0) AS Junio, 
           ISNULL([7], 0) AS Julio, 
           ISNULL([8], 0) AS Agosto, 
           ISNULL([9], 0) AS Septiembre, 
           ISNULL([10], 0) AS Octubre, 
           ISNULL([11], 0) AS Noviembre, 
           ISNULL([12], 0) AS Diciembre
    FROM 
    (
        SELECT 
            cl.Nombre AS Cliente,
            MONTH(v.Fecha) AS Mes,
            dv.Cantidad * pr.Precio AS TotalIngreso
        FROM 
            Ventas v
        JOIN 
            Detalles_Venta dv ON v.ID_Venta = dv.ID_Venta
        JOIN 
            Clientes cl ON v.ID_Cliente = cl.ID_Cliente
        JOIN 
            Productos pr ON dv.ID_Producto = pr.ID_Producto
        WHERE 
            YEAR(v.Fecha) = @Ano
            AND (@ID_Cliente IS NULL OR v.ID_Cliente = @ID_Cliente)
    ) AS SourceTable
    PIVOT
    (
        SUM(TotalIngreso)
        FOR Mes IN ([1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12])
    ) AS PivotTable
    ORDER BY Cliente;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerProductosPorEmpresa]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerProductosPorEmpresa]
    @ID_Empresa INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT ID_Producto, Nombre, Precio, Stock
    FROM Productos
    WHERE ID_Empresa = @ID_Empresa;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerProveedores]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerProveedores]
    @ID_Empresa INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT ID_Proveedor, Nombre, Empresa
    FROM Proveedores
    WHERE ID_Empresa = @ID_Empresa;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerUsuarios]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_ObtenerUsuarios]
    @ID_Empresa INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT u.ID_Usuario, u.Nombre, u.Correo, r.Descripcion AS Rol 
    FROM Usuarios u
    JOIN Roles r ON u.ID_Rol = r.ID_Rol
    WHERE u.ID_Empresa = @ID_Empresa;
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_VerificarCredenciales]    Script Date: 6/17/2024 2:55:35 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_VerificarCredenciales]
    @Correo NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;
    SELECT ID_Usuario, Nombre, Correo, Contraseña, ID_Rol
    FROM Usuarios
    WHERE Correo = @Correo;
END;
GO
USE [master]
GO
ALTER DATABASE [PuntoDeVenta] SET  READ_WRITE 
GO
