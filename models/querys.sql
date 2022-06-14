ALTER TABLE `facturas` ADD `c_exportacion` VARCHAR(10) NULL AFTER `timbrado`;

ALTER TABLE `facturas`  ADD `dom_receptor` VARCHAR(40) NULL  AFTER `c_exportacion`,  ADD `nombre_receptor` VARCHAR(200) NULL  AFTER `dom_receptor`;

ALTER TABLE `facturas` ADD `regimen_fiscal_rec` VARCHAR(200) NULL AFTER `nombre_receptor`;

ALTER TABLE `facturas` ADD `emisor` VARCHAR(200) NULL AFTER `id`;

ALTER TABLE `facturas_detalle` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

ALTER TABLE `facturas_detalle`  ADD `clave_unidad` VARCHAR(20) NULL  AFTER `total`,  ADD `unidad` VARCHAR(100) NULL  AFTER `clave_unidad`,  ADD `descripcion` VARCHAR(200) NULL  AFTER `unidad`,  ADD `c_objetoimp` VARCHAR(10) NULL  AFTER `descripcion`;

ALTER TABLE `clientes` ADD `regimen_fiscal` VARCHAR(200) NULL AFTER `email_adicional4`;

ALTER TABLE `productos` ADD `mat_pel_clave` VARCHAR(100) NULL AFTER `updated_at`;

ALTER TABLE `productos` ADD `tipo_embalaje` VARCHAR(100) NULL AFTER `mat_pel_clave`;

ALTER TABLE `productos` ADD `c_objetoimp` VARCHAR(100) NULL AFTER `tipo_embalaje`;

ALTER TABLE `facturas` CHANGE `metodo_pago` `metodo_pago` VARCHAR(10) NOT NULL;

ALTER TABLE `facturas_detalle` ADD `c_claveprodserv` VARCHAR(100) NOT NULL AFTER `c_objetoimp`;

ALTER TABLE `productos`  ADD `clave_unida` VARCHAR(20) NOT NULL  AFTER `c_objetoimp`,  ADD `unidad` VARCHAR(20) NOT NULL  AFTER `clave_unida`;

ALTER TABLE `traslados`  ADD `rem_id` VARCHAR(50) NOT NULL  AFTER `type_rem2`,  ADD `dest_id` VARCHAR(50) NOT NULL  AFTER `rem_id`;

ALTER TABLE `traslados` CHANGE `metodo_pago` `metodo_pago` VARCHAR(10) NOT NULL;

ALTER TABLE `traslados` CHANGE `venta_id` `factura_id` INT(10) UNSIGNED ZEROFILL NOT NULL;


CREATE TABLE `facturation_test`.`pagos_facturas` ( `id` INT NOT NULL AUTO_INCREMENT ,  `factura` INT NOT NULL ,  `folio` VARCHAR(20) NULL ,  `method` INT NULL ,  `method_id` INT NULL ,  `import` DOUBLE NULL ,  `compensations` DOUBLE NULL ,  `date` DATE NULL ,  `comment` TEXT NULL ,  `tipo_moneda` INT NULL ,  `status` INT NULL ,  `registred_on` TIMESTAMP NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;

ALTER TABLE `pagos_facturas` CHANGE `method` `method` VARCHAR(11) NULL DEFAULT NULL;

ALTER TABLE `pagos_facturas` CHANGE `tipo_moneda` `tipo_moneda` VARCHAR(11) NULL DEFAULT NULL;

ALTER TABLE `pagos_facturas` ADD `pagos_relacionados` INT NULL AFTER `status`;

ALTER TABLE `pagos_facturas` CHANGE `pagos_relacionados` `pagos_relacionados` VARCHAR(200) NULL DEFAULT NULL;

ALTER TABLE `pagos_facturas` ADD `uuid_factura` VARCHAR(100) NULL AFTER `pagos_relacionados`;

ALTER TABLE `pagos_facturas` ADD `cliente` VARCHAR(20) NOT NULL AFTER `factura`;

ALTER TABLE `pagos_facturas` CHANGE `factura` `factura` VARCHAR(100) NOT NULL;

ALTER TABLE `pagos_facturas` ADD `serie` VARCHAR(20) NOT NULL AFTER `folio`;