create TABLE CATEGORIE
	(cat_code VARCHAR(3) NOT NULL ,
    cat_libelle VARCHAR(50),
    
    CONSTRAINT PK_CAT PRIMARY KEY(cat_code)
    )ENGINE=innodb;

 create TABLE PRODUIT
	(pdt_ref VARCHAR(3) NOT NULL ,
    pdt_designation VARCHAR(50),
    pdt_prix DECIMAL(4,2),
    pdt_image VARCHAR(50),
    cat_code VARCHAR(3),
    CONSTRAINT PK_PROD PRIMARY KEY(pdt_ref)
    )ENGINE=innodb;

    create TABLE CLIENT
    (clt_code VARCHAR(10) NOT NULL,
    clt_nom VARCHAR(25),
    rue VARCHAR(25),
    cp INT(5),
    ville VARCHAR(25),
    clt_tel VARCHAR(25),
    clt_email VARCHAR(25) NOT NULL,
    clt_motPasse VARCHAR(25),
    CONSTRAINT PK_CLI PRIMARY KEY(clt_code)
    )ENGINE=innodb;

    create table COMMANDE
    (numCom VARCHAR(25) NOT NULL,
    dateCom VARCHAR(25) NOT NULL,
    clt_code VARCHAR(10) NOT NULL,
    CONSTRAINT PK_FACT PRIMARY KEY(numCom)
    )ENGINE=innodb;

    create table CONTENIR
    (numCom VARCHAR(25) NOT NULL,
     pdt_ref VARCHAR(3) NOT NULL,
     qte INT(4),
     CONSTRAINT PK_CONT_COM_PROD_REF PRIMARY KEY (numCom,pdt_ref)
    )ENGINE=innodb;

