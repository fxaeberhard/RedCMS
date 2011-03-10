DROP TABLE IF EXISTS redcms_block;

CREATE TABLE `redcms_block` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(100) NOT NULL,
  `link` varchar(200) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `text1` varchar(255) DEFAULT NULL,
  `text2` varchar(255) DEFAULT NULL,
  `text3` varchar(255) DEFAULT NULL,
  `text4` varchar(255) DEFAULT NULL,
  `text5` varchar(255) DEFAULT NULL,
  `longtext1` text,
  `date1` datetime DEFAULT NULL,
  `date2` datetime DEFAULT NULL,
  `number1` int(255) DEFAULT NULL,
  `template` varchar(200) DEFAULT NULL,
  `cache` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int(100) unsigned NOT NULL DEFAULT '1',
  `dateadded` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `write` tinyint(1) NOT NULL DEFAULT '0',
  `publicread` tinyint(4) NOT NULL DEFAULT '1',
  `publicwrite` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `parentId` (`parentId`)
) ENGINE=MyISAM AUTO_INCREMENT=2771 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO redcms_block VALUES("2","0","pageManager","TreeStructure",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"treeview-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","0","0","0","0");

INSERT INTO redcms_block VALUES("3","2","HomePage","PageBlock",NULL,NULL,NULL,NULL,NULL,"Welcome on RedCMS. ",NULL,NULL,NULL,"page-2cols.tpl","0","1","0000-00-00 00:00:00","2011-03-08 01:01:00","1","0","1","0");

INSERT INTO redcms_block VALUES("4","0","modulemanager","ModuleManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("6","0","fileManager","TreeStructure",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"treeview-files.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("7","0",NULL,"PictureManager",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("8","0",NULL,"PictureProxyBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("9","0",NULL,"UserManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"treeview-users.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("10","0","LoginManager","LoginManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("11","0","backupManager","BackupManager",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"treeview-files.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("12","0",NULL,"GroupManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"treeview-groups.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("13","0",NULL,"MailFormBlock","Group Mailing List Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("14","13",NULL,"GroupSelectFormField","dest_group","Destination Group","1","SelectField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("15","13",NULL,"FormField","msg_title","Mail Title","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("16","13",NULL,"FormField","msg_content","Mail Content","1","EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("20","0",NULL,"EditGroupMembershipFormBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-editgroupsmembership.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("21","0","combo","ComboBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("22","2012",NULL,"WrapperBlock",NULL,NULL,NULL,NULL,NULL,"{\"type\":\"EditCurrentUserFormBlock\"}",NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("23","0","User Profile","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("24","23",NULL,"UserManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"users-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("49","-2",NULL,"Block","Admin context menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"admin-contextmenu.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","0","0","0","0");

INSERT INTO redcms_block VALUES("50","-2",NULL,"MenuBlock","Admin menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"menu-horizontal.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","0","0","0","0");

INSERT INTO redcms_block VALUES("51","50",NULL,"Action","File",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("52","51",NULL,"OpenPanelAction","Page Library",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("53","51",NULL,"OpenPanelAction","File Library",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("54","51",NULL,"OpenPanelAction","Site Backups",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("59","51",NULL,"LoginAction","Login","Logout",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("60","50",NULL,"Action","Users",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("61","60",NULL,"OpenPanelAction","Users",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("64","60",NULL,"OpenPanelAction","Groups",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("68","60",NULL,"OpenPanelAction","Mailing List",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("70","50",NULL,"Action","Help",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("71","70",NULL,"OpenPanelAction","License",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("72","70",NULL,"OpenPanelAction","About",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("99","100",NULL,"OpenPanelAction","Edit category","editCurrent","Action",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("100","0",NULL,"MenuBlock","Default Menu Admin",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("101","100",NULL,"OpenPanelAction","Edit link","editCurrent","PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("102","103",NULL,"OpenPanelAction","Link","addSibling","LoginAction|PageLinkAction|Action",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("103","100",NULL,"Action","New",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("104","103",NULL,"OpenPanelAction","Link in sub-level","addChild","Action",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("105","103",NULL,"OpenPanelAction","Category","addSibling","Action|PageLinkAction|LoginAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("108","100",NULL,"DeleteBlockAction","Delete","editCurrent","PageLinkAction|Action",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("109","0",NULL,"EditRightsFormBlock","Default Rights Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-editrights.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("110","0",NULL,"EditBlockFormBlock","Default Menu Item Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("112","110",NULL,"FormField","type",NULL,"1","HiddenField","PageLinkAction",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("113","110",NULL,"BlockSelectFormField","redcms_link_target","Target page","1","SelectField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("114","110",NULL,"FormField","text1","Label","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("115","0",NULL,"EditBlockFormBlock","Default Menu Category Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("116","115",NULL,"FormField","text1","Label","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("117","115",NULL,"FormField","type",NULL,"1","HiddenField","Action",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("119","120",NULL,"PageLinkAction","Open","replaceHref",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("120","0",NULL,"MenuBlock","Default PageManager Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("121","120",NULL,"OpenPanelAction","Edit page","editCurrent",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("122","120",NULL,"Action","New","editCurrent","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("123","122",NULL,"OpenPanelAction","Page","addSibling","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("125","120",NULL,"DeleteBlockAction","Delete","editCurrent","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("130","0",NULL,"EditBlockFormBlock","Default Page Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("131","130",NULL,"FormField","link","Link","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("132","130",NULL,"FormField","type",NULL,"0","HiddenField","PageBlock",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("133","130",NULL,"FormField","template",NULL,"0","HiddenField","page-default.tpl",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("135","130",NULL,"FormField","longtext1","Content","0","EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("136","130",NULL,"FormField","redcms_link_admin",NULL,"0","HiddenField","230",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("137","130",NULL,"FormField","parentId",NULL,"0","HiddenField","2",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("140","0",NULL,"MenuBlock","Default User Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("141","140",NULL,"OpenPanelAction","Edit user","editCurrent","User",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("142","140",NULL,"OpenPanelAction","Edit groups","editCurrent","User",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("145","140",NULL,"OpenPanelAction","Create user","addSibling","User",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("149","140",NULL,"DeleteUserAction","Delete","editCurrent","User",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("150","0",NULL,"EditUserFormBlock","Default User Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("151","150",NULL,"FormField","userName","Username","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("152","150",NULL,"FormField","name","Firstname","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("153","150",NULL,"FormField","surname","Surname","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("154","150",NULL,"FormField","password","Password","0","PasswordField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("155","150",NULL,"FormField","email","E-mail","0","EmailField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("159","160",NULL,"NewWindowHrefAction","Download","replaceHref","FileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("160","0",NULL,"MenuBlock","Default File Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("161","160",NULL,"OpenPanelAction","Edit","editCurrent","FileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("162","160",NULL,"OpenPanelAction","Upload new file","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("169","160",NULL,"DeleteBlockAction","Delete","editCurrent","FileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("170","0",NULL,"EditBlockFormBlock","Default File Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("171","170",NULL,"FormField","text1","File","0","FileField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("172","170",NULL,"FormField","text2","Label",NULL,"TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("173","170",NULL,"FormField","type",NULL,NULL,"HiddenField","FileBlock",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("179","180",NULL,"NewWindowHrefAction","Download backup","replaceHref","BackupFileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("180","0",NULL,"MenuBlock","Default Backups Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("181","180",NULL,"AsyncRequestAction","Load backup","editCurrent","BackupFileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("182","180",NULL,"AsyncRequestAction","Create backup","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("183","180",NULL,"OpenPanelAction","Upload backup","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("185","180",NULL,"DeleteBlockAction","Delete","editCurrent","BackupFileBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("190","0",NULL,"MenuBlock","Default Group Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("191","190",NULL,"OpenPanelAction","Edit group","editCurrent","Group",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("192","190",NULL,"OpenPanelAction","New group","addSibling","Group",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("195","190",NULL,"DeleteGroupAction","Delete","editCurrent","Group",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("200","0",NULL,"EditGroupFormBlock","Default Group Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("201","200",NULL,"FormField","name","Name","0","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("210","0",NULL,"EditBlockFormBlock","Default Block Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("211","210",NULL,"FormField","type",NULL,"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("212","210",NULL,"FormField","text1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("213","210",NULL,"FormField","text2",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("214","210",NULL,"FormField","text3",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("215","210",NULL,"FormField","text4",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("216","210",NULL,"FormField","text5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("217","210",NULL,"FormField","link",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("218","210",NULL,"FormField","template",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("219","210",NULL,"FormField","longtext1",NULL,NULL,"TextareaField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("230","0",NULL,"MenuBlock","Default Page Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("231","230",NULL,"OpenPanelAction","Edit page","editRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("232","230",NULL,"OpenPanelAction","Create page",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("235","230",NULL,"DeleteBlockAction","Delete page","editRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("250","0",NULL,"TextBlock",NULL,NULL,NULL,NULL,NULL,"Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.<br />\nAll rights reserved.<br /><br />\n\nRedistribution and use of this software in source and binary forms, with or without modification, are permitted provided that the following conditions are met:\n<br /><br />\n    Redistributions of source code must retain the above copyright notice, this list of conditions and the\n    following disclaimer.<br />\n    Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.<br />\n    Neither the name of RedCMS nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission of Yahoo! Inc.<br /><br />\n\nTHIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS \"AS IS\" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.",NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("251","0",NULL,"TextBlock",NULL,NULL,NULL,NULL,NULL,"<b>RedCMS</b> v0.2<br /><br />\n\nCopyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.<br />\nAll rights reserved.<br /><br />",NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("260","0",NULL,"MenuBlock","Default Conversation Admin Menu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("261","260",NULL,"OpenPanelAction","Edit event","editCurrent","EventField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("262","260",NULL,"OpenPanelAction","Edit reply","editCurrent","ReplyField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("263","260",NULL,"OpenPanelAction","Edit topic","editCurrent","TopicField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("264","260",NULL,"OpenPanelAction","Edit news","editCurrent","NewsField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("265","260",NULL,"Action","New",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("266","265",NULL,"OpenPanelAction","Topic","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("267","265",NULL,"OpenPanelAction","News","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("268","265",NULL,"OpenPanelAction","Event","addChildToRoot",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("269","260",NULL,"DeleteBlockAction","Delete","editCurrent","NewsField|TopicField|EventField|ReplyField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("270","265",NULL,"OpenPanelAction","Reply","addChild","NewsField|TopicField|EventField|ReplyField",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("280","0",NULL,"EditBlockFormBlock","Default Event Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("281","280",NULL,"FormField","text1","Title","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("282","280",NULL,"FormField","type",NULL,"1","HiddenField","EventField",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("283","280",NULL,"FormField","date1","Date","1","DateField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("284","280",NULL,"FormField","text2","Lieu","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("289","280",NULL,"FormField","longtext1","Description",NULL,"EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("290","0",NULL,"EditBlockFormBlock","Default Conversation Reply Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("291","290",NULL,"FormField","text1","Title","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("292","290",NULL,"FormField","type",NULL,"1","HiddenField","ReplyField",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("293","290",NULL,"FormField","longtext1","Content","0","EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("300","0",NULL,"EditBlockFormBlock","Default Topic Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("301","300",NULL,"FormField","text1","Title","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("302","300",NULL,"FormField","type",NULL,"1","HiddenField","TopicField",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("303","300",NULL,"FormField","longtext1","Content","0","EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("310","0",NULL,"EditBlockFormBlock","Default News Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("311","310",NULL,"FormField","text1","Title","1","TextField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("312","310",NULL,"FormField","type",NULL,"1","HiddenField","NewsField",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("313","310",NULL,"FormField","longtext1","Content",NULL,"EditorField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("320","0",NULL,"EditBlockFormBlock","Default Backup Admin Form",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"form-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("321","320",NULL,"FormField","text1","File","0","FileField",NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("322","320",NULL,"FormField","type",NULL,NULL,"HiddenField","BackupFileBlock",NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2000","-1",NULL,"MenuBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"menu-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2001","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","2011-03-08 01:10:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2002","2000",NULL,"LoginAction","Login","Logout",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2003","2000",NULL,"PageLinkAction","Profile",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 01:10:00","2011-03-08 03:54:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2004","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 01:10:00","2011-03-08 01:33:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2005","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 01:10:00","2011-03-08 01:33:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2006","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 01:10:00","2011-03-08 02:23:00","1","0","0","0");

INSERT INTO redcms_block VALUES("2007","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 02:35:00","2011-03-08 02:43:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2010","2","Forum","PageBlock",NULL,NULL,NULL,NULL,NULL,"Welcome on RedCMS\'s forum.",NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","2011-03-04 12:25:00","0","0","0","0");

INSERT INTO redcms_block VALUES("2011","2010",NULL,"ConversationBlock",NULL,NULL,NULL,NULL,"conversation-topic.tpl",NULL,NULL,NULL,NULL,"conversation-topiclist.tpl","0","1","0000-00-00 00:00:00","2011-03-08 02:37:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2012","2","Edit Profile","PageBlock",NULL,NULL,NULL,NULL,NULL,"Edit your account parameters here.",NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","2011-03-08 02:31:00","1","1","0","0");

INSERT INTO redcms_block VALUES("2013","2","Calendar","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2014","2013",NULL,"TreeStructure",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"conversation-calendar.tpl","0","1","2011-03-08 02:27:00","2011-03-08 02:27:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2020","2","News","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2021","2020",NULL,"TreeStructure",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"conversation-default.tpl","0","1","2011-03-08 02:35:00","2011-03-08 02:35:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2759","0","ee",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2758","2011",NULL,"TopicField","General Discussion",NULL,NULL,NULL,NULL,"<div style=\"padding-top: 7px; padding-right: 7px; padding-bottom: 7px; padding-left: 7px; background-color: #ffffff; font: normal normal normal 13px/1.22 arial, helvetica, clean, sans-serif; font-family: \'Times New Roman\'; line-height: normal; font-size: medium; \">Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;Ipsem lorum es. Ipsem lorum es.&nbsp;",NULL,NULL,NULL,NULL,"0","1","2011-03-08 02:52:00","2011-03-08 03:56:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2030","3",NULL,"DigestBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"conversation-reader.tpl","0","1","2011-03-08 01:39:00","2011-03-08 01:39:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2757","2014",NULL,"EventField","RedCMS v0.1","-",NULL,NULL,NULL,NULL,"2011-03-08 00:00:00",NULL,NULL,NULL,"0","1","2011-03-08 02:51:00","2011-03-08 02:51:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2760","2758",NULL,"ReplyField","ear",NULL,NULL,NULL,NULL,"srarse",NULL,NULL,NULL,NULL,"0","0","2011-03-08 03:31:00","2011-03-08 03:31:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2761","2758",NULL,"ReplyField","rtrtrt",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","0","2011-03-08 03:38:00","2011-03-08 03:38:00","1","0","1","0");

INSERT INTO redcms_block VALUES("25","0","Profile","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("26","25",NULL,"CurrentUserManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"users-default.tpl","0","1","0000-00-00 00:00:00","0000-00-00 00:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2762","2021",NULL,"NewsField","Test de news",NULL,NULL,NULL,NULL,"Ma première news...",NULL,NULL,NULL,NULL,"0","1","2011-03-08 03:55:00","2011-03-08 03:55:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2763","2011",NULL,"TopicField","sdds",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 03:56:00","2011-03-08 03:58:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2764","6",NULL,"FileBlock","files/public/6/Claude Magnin.jpg",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 04:35:00","2011-03-08 04:35:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2765","6",NULL,"FileBlock","files/public/6/Daniel_Adler_6.1.2009.pdf",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 04:40:00","2011-03-08 04:40:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2766","11",NULL,"BackupFileBlock","files/private/11/Backup-08.Mar.11-05.00.sql",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 05:00:00","2011-03-08 05:00:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2767","11",NULL,"BackupFileBlock","files/private/11/Backup-08.Mar.11-05.04.sql",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-08 05:04:00","2011-03-08 05:04:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2025","2","Members List","PageBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"page-default.tpl","0","1","2011-03-09 11:15:00","2011-03-09 11:15:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2008","2000",NULL,"PageLinkAction",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"0","1","2011-03-09 11:15:00","2011-03-09 11:25:00","1","0","1","0");

INSERT INTO redcms_block VALUES("2026","2025",NULL,"UserManagerBlock",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"accordion-users.tpl","0","1","2011-03-09 11:17:00","2011-03-09 11:17:00","1","0","1","0");




DROP TABLE IF EXISTS redcms_blockxblock;

CREATE TABLE `redcms_blockxblock` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `blockId` int(100) unsigned NOT NULL,
  `subBlockId` int(100) unsigned NOT NULL,
  `relationType` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blockId` (`blockId`),
  KEY `subBlockId` (`subBlockId`)
) ENGINE=MyISAM AUTO_INCREMENT=1173 DEFAULT CHARSET=utf8;

INSERT INTO redcms_blockxblock VALUES("1","3","120","target");

INSERT INTO redcms_blockxblock VALUES("2","3","230","admin");

INSERT INTO redcms_blockxblock VALUES("3","6","160","admin");

INSERT INTO redcms_blockxblock VALUES("4","9","140","admin");

INSERT INTO redcms_blockxblock VALUES("5","11","180","admin");

INSERT INTO redcms_blockxblock VALUES("6","12","190","admin");

INSERT INTO redcms_blockxblock VALUES("7","52","2","target");

INSERT INTO redcms_blockxblock VALUES("8","53","6","target");

INSERT INTO redcms_blockxblock VALUES("9","54","11","target");

INSERT INTO redcms_blockxblock VALUES("10","61","9","target");

INSERT INTO redcms_blockxblock VALUES("11","64","12","target");

INSERT INTO redcms_blockxblock VALUES("12","68","13","target");

INSERT INTO redcms_blockxblock VALUES("13","71","250","target");

INSERT INTO redcms_blockxblock VALUES("14","72","251","target");

INSERT INTO redcms_blockxblock VALUES("15","99","115","target");

INSERT INTO redcms_blockxblock VALUES("16","101","110","target");

INSERT INTO redcms_blockxblock VALUES("17","102","110","target");

INSERT INTO redcms_blockxblock VALUES("18","104","110","target");

INSERT INTO redcms_blockxblock VALUES("19","105","115","target");

INSERT INTO redcms_blockxblock VALUES("20","121","130","target");

INSERT INTO redcms_blockxblock VALUES("21","123","130","target");

INSERT INTO redcms_blockxblock VALUES("22","141","150","target");

INSERT INTO redcms_blockxblock VALUES("23","142","20","target");

INSERT INTO redcms_blockxblock VALUES("24","145","150","target");

INSERT INTO redcms_blockxblock VALUES("25","161","170","target");

INSERT INTO redcms_blockxblock VALUES("26","162","170","target");

INSERT INTO redcms_blockxblock VALUES("27","181","11","target");

INSERT INTO redcms_blockxblock VALUES("28","182","11","target");

INSERT INTO redcms_blockxblock VALUES("29","191","200","target");

INSERT INTO redcms_blockxblock VALUES("30","192","200","target");

INSERT INTO redcms_blockxblock VALUES("31","231","130","target");

INSERT INTO redcms_blockxblock VALUES("32","232","130","target");

INSERT INTO redcms_blockxblock VALUES("33","261","280","target");

INSERT INTO redcms_blockxblock VALUES("34","262","290","target");

INSERT INTO redcms_blockxblock VALUES("35","263","300","target");

INSERT INTO redcms_blockxblock VALUES("36","264","310","target");

INSERT INTO redcms_blockxblock VALUES("37","266","300","target");

INSERT INTO redcms_blockxblock VALUES("38","267","310","target");

INSERT INTO redcms_blockxblock VALUES("39","268","280","target");

INSERT INTO redcms_blockxblock VALUES("40","270","290","target");

INSERT INTO redcms_blockxblock VALUES("41","2000","100","admin");

INSERT INTO redcms_blockxblock VALUES("42","2001","3","target");

INSERT INTO redcms_blockxblock VALUES("43","2002","2010","target");

INSERT INTO redcms_blockxblock VALUES("44","22","150","target");

INSERT INTO redcms_blockxblock VALUES("46","2011","260","admin");

INSERT INTO redcms_blockxblock VALUES("55","2","120","admin");

INSERT INTO redcms_blockxblock VALUES("1172","2008","2025","target");

INSERT INTO redcms_blockxblock VALUES("58","2026","140","admin");

INSERT INTO redcms_blockxblock VALUES("45","2010","230","admin");

INSERT INTO redcms_blockxblock VALUES("1171","2769","2768","target");

INSERT INTO redcms_blockxblock VALUES("56","23","230","admin");

INSERT INTO redcms_blockxblock VALUES("54","3","230","admin");

INSERT INTO redcms_blockxblock VALUES("53","2020","230","admin");

INSERT INTO redcms_blockxblock VALUES("52","2013","230","admin");

INSERT INTO redcms_blockxblock VALUES("51","2012","230","admin");

INSERT INTO redcms_blockxblock VALUES("57","2025","230","admin");

INSERT INTO redcms_blockxblock VALUES("47","183","320","target");

INSERT INTO redcms_blockxblock VALUES("49","2021","260","admin");

INSERT INTO redcms_blockxblock VALUES("48","2014","260","admin");

INSERT INTO redcms_blockxblock VALUES("1169","2007","2020","target");

INSERT INTO redcms_blockxblock VALUES("1168","2755","2020","target");

INSERT INTO redcms_blockxblock VALUES("1164","2004","2013","target");

INSERT INTO redcms_blockxblock VALUES("1165","2005","2010","target");

INSERT INTO redcms_blockxblock VALUES("1166","2003","25","target");

INSERT INTO redcms_blockxblock VALUES("1167","2006","2012","target");




DROP TABLE IF EXISTS redcms_dico;

CREATE TABLE `redcms_dico` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `en` varchar(255) NOT NULL,
  `fr` varchar(255) NOT NULL,
  `de` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS redcms_group;

CREATE TABLE `redcms_group` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO redcms_group VALUES("1","Super Administrators",NULL);

INSERT INTO redcms_group VALUES("2","Site Administrators",NULL);




DROP TABLE IF EXISTS redcms_groupxblock;

CREATE TABLE `redcms_groupxblock` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `idBlock` int(100) unsigned NOT NULL,
  `idGroup` int(100) unsigned NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `write` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idBlock` (`idBlock`),
  KEY `idGroup` (`idGroup`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO redcms_groupxblock VALUES("15","50","1","1","1");

INSERT INTO redcms_groupxblock VALUES("20","50","2","1","1");

INSERT INTO redcms_groupxblock VALUES("23","49","1","1","1");

INSERT INTO redcms_groupxblock VALUES("24","49","2","1","1");

INSERT INTO redcms_groupxblock VALUES("47","2010","1","1","1");

INSERT INTO redcms_groupxblock VALUES("48","2010","2","1","1");




DROP TABLE IF EXISTS redcms_log;

CREATE TABLE `redcms_log` (
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `verbose` varchar(50) DEFAULT NULL,
  `message` text,
  `dateAdded` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `position` int(255) DEFAULT '0',
  `adminLevel` int(255) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;




DROP TABLE IF EXISTS redcms_user;

CREATE TABLE `redcms_user` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `text1` text,
  `anniversary` datetime DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `adress_zip` varchar(255) DEFAULT NULL,
  `adress_city` varchar(255) DEFAULT NULL,
  `adress_country` varchar(255) DEFAULT NULL,
  `pPhone` varchar(255) DEFAULT NULL,
  `prPhone` varchar(255) DEFAULT NULL,
  `poPhone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `skypeCtct` varchar(255) DEFAULT NULL,
  `icqCtct` varchar(255) DEFAULT NULL,
  `aimCtct` varchar(255) DEFAULT NULL,
  `yahooCtct` varchar(255) DEFAULT NULL,
  `society` varchar(255) DEFAULT NULL,
  `adresspro` varchar(255) NOT NULL,
  `adresspro_zip` varchar(50) NOT NULL,
  `adresspro_city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO redcms_user VALUES("1","Root Administrator",NULL,"bc9775ee610f930c2d132c5e7a438fc2744063c57d69c4a43","fx@red-agent.com","root",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"","","");

INSERT INTO redcms_user VALUES("2","Site Administrator",NULL,"5481b84134305d731a26ea443d4d2f2903b26574b3514e8b8","fx@red-agent.com","root",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"","","");




DROP TABLE IF EXISTS redcms_userlog;

CREATE TABLE `redcms_userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;




DROP TABLE IF EXISTS redcms_userxgroup;

CREATE TABLE `redcms_userxgroup` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(100) unsigned NOT NULL,
  `idGroup` int(100) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `idGroup` (`idGroup`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

INSERT INTO redcms_userxgroup VALUES("1","2","2");

INSERT INTO redcms_userxgroup VALUES("3","1","1");

INSERT INTO redcms_userxgroup VALUES("2","2","1");




