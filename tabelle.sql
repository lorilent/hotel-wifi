CREATE TABLE `tbl_users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`creato_da` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`stato` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`data` DATETIME NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=17
;

CREATE TABLE `tbl_registrazioni` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`cognome` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`telefono` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`sesso` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`nazionalita` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`stato` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`data` DATETIME NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;
