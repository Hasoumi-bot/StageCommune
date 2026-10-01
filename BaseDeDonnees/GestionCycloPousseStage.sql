/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  30/09/2026 21:12:12                      */
/*==============================================================*/


drop table if exists COMMUNE;

drop table if exists CONTOLER;

drop table if exists CONTROLE;

drop table if exists CYCLO_POUSSE;

drop table if exists NOTIFICATION;

drop table if exists PERSONNE;

drop table if exists SIGNALER;

drop table if exists UTILISATEUR;

drop table if exists VIGNETTE;

drop table if exists VISITE_TECHNIQUE;

/*==============================================================*/
/* Table : COMMUNE                                              */
/*==============================================================*/
create table COMMUNE
(
   IDENTIFIANTCOMMUNE   bigint not null,
   NOMCOMMUNE           char(50) not null,
   EMAILCOMMUNE         char(60) not null,
   TELEPHONECOMMUNE     char(10) not null,
   DATECREATIONCOMMUNE  datetime,
   DATEDERNIEREMODIFICATION datetime,
   primary key (IDENTIFIANTCOMMUNE)
);

/*==============================================================*/
/* Table : CONTOLER                                             */
/*==============================================================*/
create table CONTOLER
(
   NUMEROUTILISATEUR    bigint not null,
   IMMATRICULATION      char(20) not null,
   IDENTIFIANTCONTROLE  bigint not null,
   DATEDECONTROLE       datetime,
   OBSERVATIONCONTROLE  longtext,
   DATEDEMODIFICATION   datetime,
   primary key (NUMEROUTILISATEUR, IMMATRICULATION)
);

/*==============================================================*/
/* Table : CONTROLE                                             */
/*==============================================================*/
create table CONTROLE
(
   IDENTIFIANT_CONTROLE int not null,
   NUMEROUTILISATEUR    bigint not null,
   IMMATRICULATION      char(20) not null,
   IDENTIFIANTVISITETECHNIQUE int,
   VIS_IDENTIFIANTVISITETECHNIQUE int,
   IDENTIFIANTVIGNETTE  int,
   VIG_IDENTIFIANTVIGNETTE int,
   DATECONTROLE         datetime,
   OBSERVATIONCONTROLE  longtext,
   DATEDEMODIFICATIONCONTROLE datetime,
   primary key (IDENTIFIANT_CONTROLE)
);

/*==============================================================*/
/* Table : CYCLO_POUSSE                                         */
/*==============================================================*/
create table CYCLO_POUSSE
(
   IMMATRICULATION      char(20) not null,
   IDENTIFIANTPROPRIETAIRE int not null,
   IDENTIFIANTCOMMUNE   bigint not null,
   DATEDECREATIONCP     datetime,
   DERNIERDATEDEMODIFICATIONCP datetime,
   NBSIGNALCP           int,
   primary key (IMMATRICULATION)
);

/*==============================================================*/
/* Table : NOTIFICATION                                         */
/*==============================================================*/
create table NOTIFICATION
(
   IDENTIFIANTNOTIFICATION int not null,
   MOTIFNOTIFICATION    char(30),
   DESCRIPTIONNOTIFICATION longtext,
   DATENOTIFICATION     datetime,
   primary key (IDENTIFIANTNOTIFICATION)
);

/*==============================================================*/
/* Table : PERSONNE                                             */
/*==============================================================*/
create table PERSONNE
(
   IDENTIFIANTPROPRIETAIRE int not null,
   IDENTIFIANTPERSONNE  int not null,
   DATEAJOUTPROPRIETAIRE datetime,
   CINPROPRIETAIRE      char(20),
   PRO_DATEDERNIEREMODIFICATION datetime,
   NOMPERSONNE          char(256) not null,
   PRENOMPERSONNE       char(256),
   DATEAJOUTPERSONNE    datetime,
   DATEDERNIEREMODIFICATION datetime,
   TELEPHONEPERSONNE    char(10) not null,
   primary key (IDENTIFIANTPROPRIETAIRE, IDENTIFIANTPERSONNE)
);

/*==============================================================*/
/* Table : SIGNALER                                             */
/*==============================================================*/
create table SIGNALER
(
   IMMATRICULATION      char(20) not null,
   IDENTIFIANTPROPRIETAIRE int not null,
   IDENTIFIANTPERSONNE  int not null,
   MOTIFSIGNAL          char(100) not null,
   DESCRIPTIONSIGNAL    longtext,
   DATESIGNAL           datetime,
   DERNIEREDATEMODIFICATION datetime,
   primary key (IMMATRICULATION, IDENTIFIANTPROPRIETAIRE, IDENTIFIANTPERSONNE)
);

/*==============================================================*/
/* Table : UTILISATEUR                                          */
/*==============================================================*/
create table UTILISATEUR
(
   NUMEROUTILISATEUR    bigint not null,
   IDENTIFIANTCOMMUNE   bigint not null,
   NOMUTILISATEUR       longtext not null,
   PRENOMUTILISATEUR    longtext,
   EMAILUTILISATEUR     longtext not null,
   MDPUTILISATEUR       char(30) not null,
   STATUTUTILISATEUR    char(20),
   TELEPHONEUTILISATEUR char(10),
   DATECREATIONUTILISATEUR datetime,
   DATEDERNIEREMODIFICATIONUTILISATEUR datetime,
   primary key (NUMEROUTILISATEUR)
);

/*==============================================================*/
/* Table : VIGNETTE                                             */
/*==============================================================*/
create table VIGNETTE
(
   IDENTIFIANTVIGNETTE  int not null,
   IDENTIFIANT_CONTROLE int,
   CON_IDENTIFIANT_CONTROLE int not null,
   ANNEEVIGNETTE        date,
   STATUTVIGNETTE       char(10),
   primary key (IDENTIFIANTVIGNETTE)
);

/*==============================================================*/
/* Table : VISITE_TECHNIQUE                                     */
/*==============================================================*/
create table VISITE_TECHNIQUE
(
   IDENTIFIANTVISITETECHNIQUE int not null,
   IMMATRICULATION      char(20) not null,
   IDENTIFIANT_CONTROLE int,
   CON_IDENTIFIANT_CONTROLE int,
   NUMEROTRIMESTRE      int,
   ANNEEVISITE          date,
   STATUTVISITE         char(10),
   primary key (IDENTIFIANTVISITETECHNIQUE)
);

alter table CONTOLER add constraint FK_CONTOLER foreign key (IMMATRICULATION)
      references CYCLO_POUSSE (IMMATRICULATION) on delete restrict on update restrict;

alter table CONTOLER add constraint FK_CONTOLER2 foreign key (NUMEROUTILISATEUR)
      references UTILISATEUR (NUMEROUTILISATEUR) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_CONCERNER foreign key (IMMATRICULATION)
      references CYCLO_POUSSE (IMMATRICULATION) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_CONTENIR_2 foreign key (VIS_IDENTIFIANTVISITETECHNIQUE)
      references VISITE_TECHNIQUE (IDENTIFIANTVISITETECHNIQUE) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_CONTENIR_4 foreign key (IDENTIFIANTVISITETECHNIQUE)
      references VISITE_TECHNIQUE (IDENTIFIANTVISITETECHNIQUE) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_CONTENIR_6 foreign key (IDENTIFIANTVIGNETTE)
      references VIGNETTE (IDENTIFIANTVIGNETTE) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_CONTENIR_8 foreign key (VIG_IDENTIFIANTVIGNETTE)
      references VIGNETTE (IDENTIFIANTVIGNETTE) on delete restrict on update restrict;

alter table CONTROLE add constraint FK_EFFECTUER foreign key (NUMEROUTILISATEUR)
      references UTILISATEUR (NUMEROUTILISATEUR) on delete restrict on update restrict;

alter table CYCLO_POUSSE add constraint FK_APPARTENIR foreign key (IDENTIFIANTPROPRIETAIRE)
      references PERSONNE (IDENTIFIANTPROPRIETAIRE) on delete restrict on update restrict;

alter table CYCLO_POUSSE add constraint FK_RELIER foreign key (IDENTIFIANTCOMMUNE)
      references COMMUNE (IDENTIFIANTCOMMUNE) on delete restrict on update restrict;

alter table SIGNALER add constraint FK_SIGNALER foreign key (IDENTIFIANTPROPRIETAIRE, IDENTIFIANTPERSONNE)
      references PERSONNE (IDENTIFIANTPROPRIETAIRE, IDENTIFIANTPERSONNE) on delete restrict on update restrict;

alter table SIGNALER add constraint FK_SIGNALER2 foreign key (IMMATRICULATION)
      references CYCLO_POUSSE (IMMATRICULATION) on delete restrict on update restrict;

alter table UTILISATEUR add constraint FK_ETRE_MEMBRE foreign key (IDENTIFIANTCOMMUNE)
      references COMMUNE (IDENTIFIANTCOMMUNE) on delete restrict on update restrict;

alter table VIGNETTE add constraint FK_CONTENIR_5 foreign key (IDENTIFIANT_CONTROLE)
      references CONTROLE (IDENTIFIANT_CONTROLE) on delete restrict on update restrict;

alter table VIGNETTE add constraint FK_CONTENIR_7 foreign key (CON_IDENTIFIANT_CONTROLE)
      references CONTROLE (IDENTIFIANT_CONTROLE) on delete restrict on update restrict;

alter table VISITE_TECHNIQUE add constraint FK_CONTENIR_1 foreign key (CON_IDENTIFIANT_CONTROLE)
      references CONTROLE (IDENTIFIANT_CONTROLE) on delete restrict on update restrict;

alter table VISITE_TECHNIQUE add constraint FK_CONTENIR_3 foreign key (IDENTIFIANT_CONTROLE)
      references CONTROLE (IDENTIFIANT_CONTROLE) on delete restrict on update restrict;

alter table VISITE_TECHNIQUE add constraint FK_FAIRE foreign key (IMMATRICULATION)
      references CYCLO_POUSSE (IMMATRICULATION) on delete restrict on update restrict;

