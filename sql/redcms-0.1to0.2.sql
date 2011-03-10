
ALTER TABLE  `redcms_block` ADD  `number1` INT( 255 ) NULL AFTER  `date2`;

ALTER TABLE  `redcms_block` ADD  `publicRead` TINYINT NOT NULL DEFAULT  '1',
ADD  `publicWrite` INT NOT NULL DEFAULT  '0';

UPDATE  `redcms_block` SET  `publicRead` =  0 WHERE `read` = 0
UPDATE  `redcms_block` SET  `publicWrite` =  1 WHERE `write` = 1


#positon managment
INSERT INTO  `redcms_default`.`redcms_block` (`id` ,`parentId` ,`link` ,`type` ,`text1` ,`text2` ,`text3` ,`text4` ,`text5` ,`longtext1` ,
`date1` ,`date2` ,`number1` ,`template` ,`cache` ,`owner` ,`dateadded` ,`dateupdated` ,`read` ,`write` ,`publicread` ,`publicwrite`
)
VALUES (
'111',  '110', NULL ,  'FormField',  'number1', NULL , NULL ,  'HiddenField',  '0', NULL , NULL , NULL , NULL , NULL ,  '0',  '1',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00',  '1',  '0',  '1',  '0'
),('118', '115', NULL, 'FormField', 'number1', NULL, NULL, 'HiddenField', '0', NULL, NULL, NULL, NULL, NULL, '0', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0', '1', '0');

#should be done for every menu
UPDATE `redcms_block` SET `number1` = '0' WHERE `parentId` = 2000;