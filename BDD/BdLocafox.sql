drop database if exists BdLocafox;
create database BdLocafox;
  use BdLocafox;



  create table Client
    ( NumClient smallint (5),
      NomClient varchar (20) not null,
      AdClient varchar (45) not null,
      VilleClient varchar (20) not null,
      CPClient varchar (10) not null,
      TelClient varchar (20) not null,
      MailClient varchar (20) not null,
      MdpClient varchar (60) not null,
      constraint pk_Client primary key (NumClient)
    );

  create table Particulier
    ( CodePart smallint (5),
      PrenomPart varchar (20) not null,
      Sexe char (1) not null,
      FidPart smallint (5),
      constraint pk_Particulier primary key (CodePart),
      constraint ck_Sexe check (Sexe in ('F','H')),
      constraint fk_Particulier_Client foreign key (CodePart) references Client (NumClient)
    );

  create table Professionnel
    ( CodePro smallint (5),
      Siret varchar (14) not null,
      constraint pk_Professionnel primary key (CodePro),
      constraint fk_Professionnel_Client foreign key (CodePro) references Client (NumClient)
    );

  create table Categorie
    ( NumCat varchar (2),
      NomCat varchar (45) not null,
      constraint pk_Categorie primary key (NumCat)
    );

  create table SousCategorie
    ( NumsousCat varchar (4),
      NomsousCat varchar (45) not null,
      NumCat varchar (2),
      constraint pk_SousCategorie primary key (NumsousCat),
      constraint fk_SousCategorie_Categorie foreign key (Numcat) references Categorie (NumCat)
    );

  create table Produit
    ( NumProd varchar (8),
      NomProd varchar (45) not null,
      PrixHT decimal (6,2) not null,
      NumsousCat varchar (4),
      constraint pk_Produit primary key (NumProd),
      constraint fk_Produit_SousCategorie foreign key (NumsousCat) references SousCategorie (NumSousCat)
    );

  create table Agence
    ( NumAgence smallint (3),
      NomAgence varchar (20) not null,
      AdAgence varchar (45) not null,
      VilleAgence varchar (20) not null,
      CPAgence varchar (5) not null,
      TelAgence varchar (20) not null,
      HorairesAgence varchar (10) not null,
      NomResp varchar (20) not null,
      constraint pk_Agence primary key (NumAgence)
    );

  create table Devis
    ( NumDevis smallint (5),
      NumAgence smallint (3),
      NumClient smallint (5),
      NumProd varchar (8),
      DateDevis date not null,
      DebLoc date not null,
      FinLocPrev date not null,
      MontantHTPrev decimal (7,2) not null,
      constraint pk_Devis primary key (NumDevis, NumAgence, NumClient, NumProd),
      constraint fk_Devis_Agence foreign key (NumAgence) references Agence (NumAgence),
      constraint fk_Devis_Client foreign key (NumClient) references Client (NumClient),
      constraint fk_Devis_Produit foreign key (NumProd) references Produit (NumProd)
    );

  create table Facture
    ( NumFacture smallint (5),
      DateFacture date not null,
      NumDevis smallint (5),
      FinLocReel date not null,
      MontantHTReel decimal (7,2) not null,
      Reglement varchar (2) not null,
      constraint pk_Facture primary key (NumFacture),
      constraint ck_Reglement check (Reglement in ('CB', 'CH', 'MO')),
      constraint fk_Facture_Devis foreign key (NumDevis) references Devis (NumDevis)
    );

  create table Stocker
    ( NumAgence smallint (3),
      NumProd varchar (8),
      QtStock smallint (5),
      constraint pk_Stocker primary key (NumAgence, NumProd),
      constraint fk_Stocker_Produit foreign key (NumProd) references Produit (NumProd),
      constraint fk_Stocker_Agence foreign key (NumAgence) references Agence (NumAgence)
    );

  create table Concerner
    ( NumProd varchar (8),
      NumDevis smallint (5),
      QtCommande smallint (5),
      constraint pk_Concerner primary key (NumProd, NumDevis),
      constraint fk_Concerner_Produit foreign key (NumProd) references Produit (NumProd),
      constraint fk_Concerner_Devis foreign key (NumDevis) references Devis (NumDevis)
    );

  create table Parametre
    ( TVA decimal (4,2)
    );
