
ALTER TABLE  `redcms_block` ADD  `number1` INT( 255 ) NULL AFTER  `date2`;

ALTER TABLE  `redcms_block` ADD  `publicRead` TINYINT NOT NULL DEFAULT  '1',
ADD  `publicWrite` INT NOT NULL DEFAULT  '0';

UPDATE  `redcms_block` SET  `publicRead` =  0 WHERE `read` = 0
UPDATE  `redcms_block` SET  `publicWrite` =  1 WHERE `write` = 1