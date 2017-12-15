/*==============================================================*/
/* DBMS name:      ORACLE Version 11g                           */
/* Created on:     15/12/2017 11:56:55                          */
/*==============================================================*/


drop table FREBITACORA cascade constraints;

drop table FRECLIENTE cascade constraints;

drop table FRECOMPANIAS cascade constraints;

drop table FREFACTORES cascade constraints;

drop table FREPARAMETRO cascade constraints;

drop table FREPUNTOS cascade constraints;

drop table FRESUCURSAL cascade constraints;

drop table INV_ARTICULO cascade constraints;

/*==============================================================*/
/* Table: FREBITACORA                                           */
/*==============================================================*/
create table FREBITACORA 
(
   COD_CIA              CHAR(3 BYTE)         not null,
   COD_SUCURSAL         CHAR(3 BYTE)         not null,
   DOCUMENTO            NUMBER(10,0)         not null,
   CLIENTE              VARCHAR2(25 BYTE)    not null,
   ARTICULO             VARCHAR2(25 BYTE)    not null,
   TIPO_TRANSACCION     CHAR(1 BYTE),
   ORIGEN               VARCHAR2(2 BYTE),
   FECHA                DATE,
   MONTO                NUMBER(14,2),
   PUNTOS               NUMBER14,2,
   constraint PK_FREBITACORA primary key (COD_CIA, COD_SUCURSAL, DOCUMENTO, CLIENTE, ARTICULO)
);

/*==============================================================*/
/* Table: FRECLIENTE                                            */
/*==============================================================*/
create table FRECLIENTE 
(
   COD_CIA              CHAR(3 BYTE)         not null,
   COD_CLIENTE          VARCHAR2(25 BYTE)    not null,
   COD_CLASE            VARCHAR2(3 BYTE),
   TIP_CLIENTE          VARCHAR2(1 BYTE),
   SUCURSAL             CHAR(3 BYTE),
   COD_CIACLIENTE       CHAR(3 BYTE),
   CEDULA               VARCHAR2(20 BYTE),
   NOM_CLIENTE          VARCHAR2(50 BYTE),
   DES_DIRECCION        VARCHAR2(200 BYTE),
   CONTACTO             VARCHAR2(35 BYTE),
   NUM_APARTADO         VARCHAR2(20 BYTE),
   NUM_TELEFONO1        VARCHAR2(16 BYTE),
   NUM_TELEFONO2        VARCHAR2(16 BYTE),
   NUM_FAX              VARCHAR2(16 BYTE),
   DES_RAZSOCIAL        VARCHAR2(50 BYTE),
   NOM_RESPONSABLE      VARCHAR2(30 BYTE),
   COD_PROVINCIA        VARCHAR2(2 BYTE),
   COD_CANTON           VARCHAR2(3 BYTE),
   COD_DISTRITO         VARCHAR2(3 BYTE),
   IND_PAGACONSM        CHAR(1 BYTE),
   IND_MOROSO           CHAR(1 BYTE),
   POR_MAXDESCUE        NUMBRE(5,2),
   IND_CREDITCER        CHAR(1 BYTE),
   DES_RECIBOFACT       VARCHAR2(50 BYTE),
   DES_PAGOFACTR        VARCHAR2(50 BYTE),
   IND_RECIBCORR        CHAR(1 BYTE),
   COD_ZONA             VARCHAR2(2 BYTE),
   COD_SUBZONA          VARCHAR2(2 BYTE),
   LISTA_PRECIO         CHAR(3 BYTE),
   LISTA_DESCUENTO      CHAR(3 BYTE),
   DIRECCION_ENVIO      VARCHAR2(200 BYTE),
   ESTADO               CHAR(2 BYTE),
   CONSIGNATORIO        VARCHAR2(10 BYTE),
   POR_EXOVENTA         NUMBER(5,2),
   CLASE_CATALOGO       CHAR(3 BYTE),
   EMAIL                VARCHAR2(60 BYTE),
   FECHANACIMIENTO      DATE,
   TARJETA              VARCHAR2(13 BYTE),
   DIAVISITA            CHAR(1 BYTE),
   FRECUENCIAVISITA     CHAR(1 BYTE),
   TRAMITAFACTURA       CHAR(1 BYTE),
   constraint PK_FRECLIENTE primary key (COD_CIA, COD_CLIENTE),
   constraint AK_COD_CIA_FRECLIEN unique (COD_CIA, COD_CLIENTE)
);

comment on table FRECLIENTE is
'TABLA DE LOS CLIENTES';

/*==============================================================*/
/* Table: FRECOMPANIAS                                          */
/*==============================================================*/
create table FRECOMPANIAS 
(
   COD_CIA              CHAR(3 BYTE)         not null,
   DES_CIA              VARCHAR2(30 BYTE),
   DES_RAZONSOC         VARCHAR2(30 BYTE),
   COD_PAIS             VARCHAR2(3 BYTE)fined>,
   DES_PROVINCIA        VARCHAR2(20 BYTE),
   DES_CANTON           VARCHAR2(20 BYTE),
   DIR_CIA              VARCHAR2(50 BYTE),
   COD_POSTAL           VARCHAR2(20 BYTE),
   NUM_TELEFONO1        VARCHAR2(15 BYTE),
   NUM_TELEFONO2        VARCHAR2(15 BYTE),
   NUM_FAX              VARCHAR2(15 BYTE),
   CIACONSOLIDADA       CHAR(3 BYTE),
   DES_NOMCOMERCIAL     VARCHAR2(100 BYTE),
   constraint PK_FRECOMPANIAS primary key (COD_CIA)
);

comment on table FRECOMPANIAS is
'Tabla de las companias';

/*==============================================================*/
/* Table: FREFACTORES                                           */
/*==============================================================*/
create table FREFACTORES 
(
   CIA                  CHAR(3 BYTE)         not null,
   ARTICULO             VARCHAR2(25 BYTE)    not null,
   FACTOR               NUMBER(5,2),
   constraint PK_FREFACTORES primary key (CIA, ARTICULO)
);

/*==============================================================*/
/* Table: FREPARAMETRO                                          */
/*==============================================================*/
create table FREPARAMETRO 
(
   CIA                  CHAR(3 BYTE)         not null,
   LIMITEACUM           DATE,
   LIMITECAMBIO         DATE,
   OBTMONTOCON          NUMBER(14,2),
   OBTPUNTOSCON         NUMBER(7,0),
   OBTMONTOOTR          NUMBER(14,2),
   OBPUNTOSOTR          NUMBER(7,0),
   CAMMONTO             NUMBER(14,2),
   CAMPUNTOS            NUMBER(7,0),
   MINIMOPUNTOS         NUMBRE(7,0),
   DIASINICAMBIO        NUMBER(3,0),
   PUNTOSISV            CHAR(1 BYTE),
   PLAZOCAMBIO          NUMBER(2,0),
   MODOVENCE            CHAR(1 BYTE),
   constraint PK_FREPARAMETRO primary key (CIA)
);

/*==============================================================*/
/* Table: FREPUNTOS                                             */
/*==============================================================*/
create table FREPUNTOS 
(
   CIA                  CHAR(3 BYTE)         not null,
   SUCURSAL             CHAR(3 BYTE)         not null,
   DOCUMENTO            NUMBER(10,0)         not null,
   ORIGEN               VARCHAR2(2 BYTE)     not null,
   FECHA                DATE,
   CLIENTE              VARCHAR2(25 BYTE),
   ARTICULO             VARCHAR2(25 BYTE)    not null,
   LINEA                CHAR(3 BYTE),
   MONTO                NUMBER(14,2),
   PUNTOS               NUMBER(14,2),
   PUNTOSTRA            NUMBER(14,2),
   MONTOPAGO            NUMBER(14,2),
   MONTOPAGACU          NUMBER(14,2),
   PUNTOSUSA            NUMBER(14,2),
   VENCE                DATE,
   constraint PK_FREPUNTOS primary key (CIA, SUCURSAL, DOCUMENTO, ORIGEN, ARTICULO)
);

/*==============================================================*/
/* Table: FRESUCURSAL                                           */
/*==============================================================*/
create table FRESUCURSAL 
(
   COD_CIA              CHAR(3 BYTE)         not null,
   SUCURSAL             CHAR(3 BYTE)         not null,
   DESCRIPCION          VARCHAR2(60 BYTE),
   DES_DIRECCION        VARCHAR2(50 BYTE),
   NUM_TELEFONO1        VARCHAR2(16 BYTE),
   NUM_TELEFONO2        VARCHAR2(16 BYTE),
   EMAIL                VARCHAR2(30 BYTE),
   AREA                 NUMBER(12,2),
   MTS_EXHIBE           NUMBER(12,2),
   CARACTERISTICA       VARCHAR2(256 BYTE),
   constraint PK_FRESUCURSAL primary key (COD_CIA),
   constraint AK_COD_CIA_FRESUCUR unique (COD_CIA, SUCURSAL)
);

comment on table FRESUCURSAL is
'Sucursales de cada compania ';

/*==============================================================*/
/* Table: INV_ARTICULO                                          */
/*==============================================================*/
create table INV_ARTICULO 
(
   COD_CIA              CHAR(3 BYTE)         not null,
   COD_ARTICULO         VARCHAR2(25 BYTE)    not null,
   TIPO_INV             VARCHAR2(3 BYTE),
   COD_LINEA            VARCHAR2(5 BYTE),
   COD_CLASE            VARCHAR2(5 BYTE),
   COD_MARCA            VARCHAR2(5 BYTE),
   DES_ARTICULO         VARCHAR2(50 BYTE),
   IND_BLOQUEADO        CHAR(1 BYTE),
   MEDIDA               VARCHAR2(5 BYTE),
   COD_MONEDA           VARCHAR2(3 BYTE),
   MIN_VENTA            NUMBER(8,4),
   CLASE_ABC            CHAR(1 BYTE),
   RFACCION             CHAR(1 BYTE),
   FEC_ULTMOD           DATE,
   COD_DEPTO            VARCHAR2(3 BYTE),
   DES_BLOQUEADO        VARCHAR2(30 BYTE),
   COD_TABCOMSN         VARCHAR2(2 BYTE),
   IMPTOCONS            VARCHAR2(5 BYTE),
   IMPTOVTAS            VARCHAR2(5 BYTE),
   PESO                 NUMBER(8,2,
   COD_PARTIDA          VARCHAR2(10 BYTE),
   PROVEEDOR_TITULAR    VARCHAR2(25 BYTE),
   MAXDESCUENTO         NUMBER(5,2,
   EMBALAJE             VARCHAR2(30 BYTE),
   DESC_CORTA           VARCHAR2(20 BYTE),
   PREFERENCIA          VARCHAR2(25 BYTE),
   CTLDESPACHO          CHAR(1 BYTE),
   IND_SERIE            CHAR(1 BYTE),
   constraint PK_INV_ARTICULO primary key (COD_CIA, COD_ARTICULO)
);

