
create table if not exists b_moosecalc_rows (
   ID int(10) not null auto_increment,
   DEAL_ID int(10) not null,
   WIDTH int(10) not null,
   HEIGHT int(10) not null,
   MOOSE_ID int(10) not null,
   OFFER_ID int(10) not null,
   FRAME_ID int(10) not null,
   MOOSE_PRICE decimal(10,2) not null,
   FRAME_PRICE decimal(10,2) not null,
   INSTALL bool DEFAULT false,
   INSTALL_PRICE decimal(10,2),
   primary key (ID)
);
ALTER TABLE b_moosecalc_rows
MODIFY FRAME_ID int(10),
MODIFY FRAME_PRICE decimal(10,2),
MODIFY FRAME_COST decimal(10,2);

create table if not exists b_moosecalc_plants_rows (
   ID int(10) not null auto_increment,
   DEAL_ID int(10) not null,
   QUANTITY int(10) not null,
   PRODUCT_ID int(10) not null,
   OFFER_ID int(10) not null,
   PRICE decimal(10,2) not null,
   CARE_COSTS decimal(10,2),
   LEASING_RATE decimal(10,2),
   primary key (ID)
);

-- ALTER TABLE b_moosecalc_plants_rows ADD COLUMN ROOM varchar(255);
ALTER TABLE b_moosecalc_rows ADD COLUMN MOOSE_QUANTITY decimal(10,2) not null;
ALTER TABLE b_moosecalc_rows ADD COLUMN FRAME_QUANTITY decimal(10,2) not null;
ALTER TABLE b_moosecalc_rows ADD COLUMN INSTALL_QUANTITY decimal(10,2);
ALTER TABLE b_moosecalc_rows ADD COLUMN MOOSE_COST decimal(10,2) not null;
ALTER TABLE b_moosecalc_rows ADD COLUMN FRAME_COST decimal(10,2) not null;
ALTER TABLE b_moosecalc_rows ADD COLUMN INSTALL_COST decimal(10,2);