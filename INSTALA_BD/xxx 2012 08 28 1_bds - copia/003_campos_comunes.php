<?php

$sqlComunes="
Observaciones text,
PrimaryKeyMD5 varchar(100),
EsPredeterminado tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
Revisado tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
Publicar tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
VigenteDesde datetime NOT NULL,
VigenteHasta datetime NOT NULL,
CreatedBy int(4) NOT NULL,
CreatedAt datetime NOT NULL,
ModifiedBy int(4) NOT NULL,
ModifiedAt datetime NOT NULL,
Deleted tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
DeletedBy int(4),
DeletedAt datetime,
Privacidad tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresPrivacidad,IDTipo',
Orden bigint(11),
FechaPublicacion datetime,
UrlAmigable varchar(250),
MetatagTitle varchar(250),
MetatagKeywords varchar(250),
MetatagDescription varchar(250),
MetatagTitleSimple tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresSN,IDTipo',
MetatagTitlePosicion tinyint(1) DEFAULT '0' COMMENT 'Abstract,ValoresDchaIzq,IDTipo',
MostrarEnMapaWeb tinyint(1) DEFAULT '1' COMMENT 'Abstract,ValoresSN,IDTipo',
ImportanciaMapaWeb varchar(5) DEFAULT '0,5',
ChangeFreqMapaWeb varchar(25) DEFAULT 'monthly' COMMENT 'Abstract,ValoresChangeFreq,IDTipo',";

$clavesComunes="
UNIQUE KEY PrimaryKeyMD5 (PrimaryKeyMD5),
KEY Revisado (Revisado),
KEY Publicar (Publicar),
KEY Deleted (Deleted),
KEY Privacidad (Privacidad),
KEY Orden (Orden),
KEY EsPredeterminado (EsPredeterminado),
KEY MetatagTitleSimple (MetatagTitleSimple),
KEY MetatagTitlePosicion (MetatagTitlePosicion),
KEY MostrarEnMapaWeb (MostrarEnMapaWeb),
KEY ChangeFreqMapaWeb (ChangeFreqMapaWeb),
";
?>
