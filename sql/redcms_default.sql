-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 01 Mars 2011 à 22:41
-- Version du serveur: 5.1.37
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `redcms_default`
--

-- --------------------------------------------------------

--
-- Structure de la table `redcms_block`
--
-- Création: Mar 01 Mars 2011 à 21:03
-- Dernière modification: Mar 01 Mars 2011 à 21:03
-- Dernière vérification: Mar 01 Mars 2011 à 21:03
--

CREATE TABLE IF NOT EXISTS `redcms_block` (
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
  `template` varchar(200) DEFAULT NULL,
  `cache` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int(100) unsigned NOT NULL DEFAULT '1',
  `dateadded` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `write` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `parentId` (`parentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=2091 ;

--
-- RELATIONS POUR LA TABLE `redcms_block`:
--   `owner`
--       `redcms_user` -> `id`
--   `parentId`
--       `redcms_block` -> `id`
--

--
-- Contenu de la table `redcms_block`
--

INSERT INTO `redcms_block` (`id`, `parentId`, `link`, `type`, `text1`, `text2`, `text3`, `text4`, `text5`, `longtext1`, `date1`, `date2`, `template`, `cache`, `owner`, `dateadded`, `dateupdated`, `read`, `write`) VALUES
(2, 1, 'pageManager', 'TreeStructure', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'treeview-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(3, 2, 'HomePage2', 'PageBlock', NULL, NULL, NULL, NULL, NULL, 'Welcome on RedCMS.', NULL, NULL, 'page-smag.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(4, 0, 'modulemanager', 'ModuleManagerBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(6, 0, 'fileManager', 'TreeStructure', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'treeview-files.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(7, 0, NULL, 'PictureManager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(8, 0, NULL, 'PictureProxyBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(9, 0, NULL, 'UserManagerBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'treeview-users.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(10, 0, 'LoginManager', 'LoginManagerBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(11, 0, 'backupManager', 'BackupManager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'treeview-files.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(12, 0, NULL, 'GroupManagerBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'treeview-groups.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(13, 0, NULL, 'MailFormBlock', 'Group Mailing List Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(14, 13, NULL, 'GroupSelectFormField', 'dest_group', 'Destination Group', '1', 'SelectField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(15, 13, NULL, 'FormField', 'msg_title', 'Mail Title', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(16, 13, NULL, 'FormField', 'msg_content', 'Mail Content', '1', 'TextareaField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(20, 0, NULL, 'EditGroupMembershipFormBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-editgroupsmembership.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(21, 0, 'combo', 'ComboBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(50, -2, NULL, 'MenuBlock', 'Admin menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menu-horizontal.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(51, 50, NULL, 'Action', 'File', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(52, 51, NULL, 'OpenPanelAction', 'Page Library', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(53, 51, NULL, 'OpenPanelAction', 'File Library', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(54, 51, NULL, 'OpenPanelAction', 'Site Backups', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(59, 51, NULL, 'LoginAction', 'Login', 'Logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(60, 50, NULL, 'Action', 'Users', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(61, 60, NULL, 'OpenPanelAction', 'Users', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(64, 60, NULL, 'OpenPanelAction', 'Groups', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(68, 60, NULL, 'OpenPanelAction', 'Mailing List', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(70, 50, NULL, 'Action', 'Help', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(71, 70, NULL, 'OpenPanelAction', 'License', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(72, 70, NULL, 'OpenPanelAction', 'About', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(99, 100, NULL, 'OpenPanelAction', 'Edit category', 'editCurrent', 'Action', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(100, 0, NULL, 'MenuBlock', 'Default Menu Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(101, 100, NULL, 'OpenPanelAction', 'Edit link', 'editCurrent', 'PageLinkAction', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(102, 103, NULL, 'OpenPanelAction', 'Link', 'addSibling', 'LoginAction|PageLinkAction|Action', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(103, 100, NULL, 'Action', 'New', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(104, 103, NULL, 'OpenPanelAction', 'Link in sub-level', 'addChild', 'Action', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(105, 103, NULL, 'OpenPanelAction', 'Category', 'addSibling', 'Action|PageLinkAction|LoginAction', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(108, 100, NULL, 'DeleteBlockAction', 'Delete', 'editCurrent', 'PageLinkAction|Action', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(109, 0, NULL, 'EditRightsFormBlock', 'Default Rights Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-editrights.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(110, 0, NULL, 'EditBlockFormBlock', 'Default Menu Item Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(112, 110, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'PageLinkAction', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(113, 110, NULL, 'BlockSelectFormField', 'redcms_link_target', 'Target Pages', '1', 'SelectField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(114, 110, NULL, 'FormField', 'text1', 'Label', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(115, 0, NULL, 'EditBlockFormBlock', 'Default Menu Category Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(116, 115, NULL, 'FormField', 'text1', 'Label', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(117, 115, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'Action', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(119, 120, NULL, 'PageLinkAction', 'Open', 'replaceHref', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(120, 0, NULL, 'MenuBlock', 'Default PageManager Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(121, 120, NULL, 'OpenPanelAction', 'Edit page', 'editCurrent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(122, 120, NULL, 'Action', 'New', 'editCurrent', 'PageBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(123, 122, NULL, 'OpenPanelAction', 'Page', 'addSibling', 'PageBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(125, 120, NULL, 'DeleteBlockAction', 'Delete', 'editCurrent', 'PageBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(130, 0, NULL, 'EditBlockFormBlock', 'Default Page Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(131, 130, NULL, 'FormField', 'link', 'Link', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(132, 130, NULL, 'FormField', 'type', NULL, '0', 'HiddenField', 'PageBlock', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(133, 130, NULL, 'FormField', 'template', NULL, '0', 'HiddenField', 'page-default.tpl', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(135, 130, NULL, 'FormField', 'longtext1', 'Content', '0', 'EditorField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(136, 130, NULL, 'FormField', 'redcms_link_admin', NULL, '0', 'HiddenField', '230', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(137, 130, NULL, 'FormField', 'parentId', NULL, '0', 'HiddenField', '2', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(140, 0, NULL, 'MenuBlock', 'Default User Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(141, 140, NULL, 'OpenPanelAction', 'Edit user', 'editCurrent', 'User', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(142, 140, NULL, 'OpenPanelAction', 'Edit groups', 'editCurrent', 'User', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(145, 140, NULL, 'OpenPanelAction', 'Create user', 'addSibling', 'User', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(149, 140, NULL, 'DeleteUserAction', 'Delete', 'editCurrent', 'User', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(150, 0, NULL, 'EditUserFormBlock', 'Default User Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(151, 150, NULL, 'FormField', 'userName', 'Username', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(152, 150, NULL, 'FormField', 'name', 'Firstname', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(153, 150, NULL, 'FormField', 'surname', 'Surname', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(154, 150, NULL, 'FormField', 'password', 'Password', '0', 'PasswordField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(155, 150, NULL, 'FormField', 'email', 'E-mail', '0', 'EmailField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(159, 160, NULL, 'NewWindowHrefAction', 'Download', 'replaceHref', 'FileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(160, 0, NULL, 'MenuBlock', 'Default File Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(161, 160, NULL, 'OpenPanelAction', 'Edit', 'editCurrent', 'FileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(162, 160, NULL, 'OpenPanelAction', 'Upload new file', 'addChildToRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(169, 160, NULL, 'DeleteBlockAction', 'Delete', 'editCurrent', 'FileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(170, 0, NULL, 'EditBlockFormBlock', 'Default File Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(171, 170, NULL, 'FormField', 'text1', 'File', '0', 'FileField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(172, 170, NULL, 'FormField', 'text2', 'Label', NULL, 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(173, 170, NULL, 'FormField', 'type', NULL, NULL, 'HiddenField', 'FileBlock', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(179, 180, NULL, 'NewWindowHrefAction', 'Download backup', 'replaceHref', 'BackupFileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(180, 0, NULL, 'MenuBlock', 'Default Backups Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(181, 180, NULL, 'AsyncRequestAction', 'Load backup', 'editCurrent', 'BackupFileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(182, 180, NULL, 'AsyncRequestAction', 'Create backup', 'addChildToRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(183, 180, NULL, 'DeleteBlockAction', 'Delete', 'editCurrent', 'BackupFileBlock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(190, 0, NULL, 'MenuBlock', 'Default Group Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(191, 190, NULL, 'OpenPanelAction', 'Edit group', 'editCurrent', 'Group', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(192, 190, NULL, 'OpenPanelAction', 'New group', 'addSibling', 'Group', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(195, 190, NULL, 'DeleteGroupAction', 'Delete', 'editCurrent', 'Group', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(200, 0, NULL, 'EditGroupFormBlock', 'Default Group Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(201, 200, NULL, 'FormField', 'name', 'Name', '0', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(210, 0, NULL, 'EditBlockFormBlock', 'Default Block Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(211, 210, NULL, 'FormField', 'type', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(212, 210, NULL, 'FormField', 'text1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(213, 210, NULL, 'FormField', 'text2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(214, 210, NULL, 'FormField', 'text3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(215, 210, NULL, 'FormField', 'text4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(216, 210, NULL, 'FormField', 'text5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(217, 210, NULL, 'FormField', 'link', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(218, 210, NULL, 'FormField', 'template', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(219, 210, NULL, 'FormField', 'longtext1', NULL, NULL, 'TextareaField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(230, 0, NULL, 'MenuBlock', 'Default Page Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(231, 230, NULL, 'OpenPanelAction', 'Edit page', 'editRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(232, 230, NULL, 'OpenPanelAction', 'Create page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(235, 230, NULL, 'DeleteBlockAction', 'Delete page', 'editRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(250, 0, NULL, 'TextBlock', NULL, NULL, NULL, NULL, NULL, 'Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.<br />\r\nAll rights reserved.<br /><br />\r\n\r\nRedistribution and use of this software in source and binary forms, with or without modification, are permitted provided that the following conditions are met:\r\n<br /><br />\r\n    Redistributions of source code must retain the above copyright notice, this list of conditions and the\r\n    following disclaimer.<br />\r\n    Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.<br />\r\n    Neither the name of RedCMS nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission of Yahoo! Inc.<br /><br />\r\n\r\nTHIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(251, 0, NULL, 'TextBlock', NULL, NULL, NULL, NULL, NULL, '<b>RedCMS</b> v0.2<br /><br />\r\n\r\nCopyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.<br />\r\nAll rights reserved.<br /><br />', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(260, 0, NULL, 'MenuBlock', 'Default Conversation Admin Menu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(261, 260, NULL, 'OpenPanelAction', 'Edit event', 'editCurrent', 'EventField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(262, 260, NULL, 'OpenPanelAction', 'Edit reply', 'editCurrent', 'ReplyField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(263, 260, NULL, 'OpenPanelAction', 'Edit topic', 'editCurrent', 'TopicField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(264, 260, NULL, 'OpenPanelAction', 'Edit news', 'editCurrent', 'NewsField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(265, 260, NULL, 'Action', 'New', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(266, 265, NULL, 'OpenPanelAction', 'Topic', 'addChildToRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(267, 265, NULL, 'OpenPanelAction', 'News', 'addChildToRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(268, 265, NULL, 'OpenPanelAction', 'Event', 'addChildToRoot', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(269, 260, NULL, 'DeleteBlockAction', 'Delete', 'editCurrent', 'NewsField|TopicField|EventField|ReplyField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(270, 265, NULL, 'OpenPanelAction', 'Reply', 'addChild', 'NewsField|TopicField|EventField|ReplyField', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(280, 0, NULL, 'EditBlockFormBlock', 'Default Event Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(281, 280, NULL, 'FormField', 'text1', 'Title', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(282, 280, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'EventField', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(283, 280, NULL, 'FormField', 'longtext1', 'Content', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(290, 0, NULL, 'EditBlockFormBlock', 'Default Conversation Reply Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(291, 290, NULL, 'FormField', 'text1', 'Title', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(292, 290, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'ReplyField', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(293, 290, NULL, 'FormField', 'longtext1', 'Content', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(300, 0, NULL, 'EditBlockFormBlock', 'Default Topic Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(301, 300, NULL, 'FormField', 'text1', 'Title', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(302, 300, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'TopicField', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(303, 300, NULL, 'FormField', 'longtext1', 'Content', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(310, 0, NULL, 'EditBlockFormBlock', 'Default News Admin Form', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(311, 310, NULL, 'FormField', 'text1', 'Title', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(312, 310, NULL, 'FormField', 'type', NULL, '1', 'HiddenField', 'NewsField', NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(313, 310, NULL, 'FormField', 'longtext1', 'Content', '1', 'TextField', NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2000, -1, NULL, 'MenuBlock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menu-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2001, 2000, NULL, 'PageLinkAction', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2002, 2000, NULL, 'PageLinkAction', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2003, 2000, NULL, 'LoginAction', 'Login', 'Logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2010, 2, 'Forum', 'PageBlock', NULL, NULL, NULL, NULL, NULL, 'Welcome on RedCMS''s forum.', NULL, NULL, 'page-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2011, 2010, NULL, 'TreeStructure', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'conversation-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2082, 2, 'ttes', 'PageBlock', NULL, NULL, NULL, NULL, NULL, 'test', NULL, NULL, 'page-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2084, 2, 'zrdz', 'PageBlock', NULL, NULL, NULL, NULL, NULL, 'zrdzdz', NULL, NULL, 'page-default.tpl', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2085, 2000, NULL, 'Action', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2086, 2011, NULL, 'TopicField', 'test', NULL, NULL, NULL, NULL, 'title', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2087, 2011, NULL, 'NewsField', 'test', NULL, NULL, NULL, NULL, 'test', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2088, 2011, NULL, 'EventField', 'test', NULL, NULL, NULL, NULL, 'test', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2089, 2086, NULL, 'ReplyField', 'uu', NULL, NULL, NULL, NULL, 'uu', NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2090, 2085, NULL, 'PageLinkAction', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `redcms_blockxblock`
--
-- Création: Mar 01 Mars 2011 à 21:04
-- Dernière modification: Mar 01 Mars 2011 à 21:04
--

CREATE TABLE IF NOT EXISTS `redcms_blockxblock` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `blockId` int(100) unsigned NOT NULL,
  `subBlockId` int(100) unsigned NOT NULL,
  `relationType` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blockId` (`blockId`),
  KEY `subBlockId` (`subBlockId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001 ;

--
-- RELATIONS POUR LA TABLE `redcms_blockxblock`:
--   `blockId`
--       `redcms_block` -> `id`
--   `subBlockId`
--       `redcms_block` -> `id`
--

--
-- Contenu de la table `redcms_blockxblock`
--

INSERT INTO `redcms_blockxblock` (`id`, `blockId`, `subBlockId`, `relationType`) VALUES
(1, 3, 120, 'target'),
(2, 3, 230, 'admin'),
(3, 6, 160, 'admin'),
(4, 9, 140, 'admin'),
(5, 11, 180, 'admin'),
(6, 12, 190, 'admin'),
(7, 52, 2, 'target'),
(8, 53, 6, 'target'),
(9, 54, 11, 'target'),
(10, 61, 9, 'target'),
(11, 64, 12, 'target'),
(12, 68, 13, 'target'),
(13, 71, 250, 'target'),
(14, 72, 251, 'target'),
(15, 99, 115, 'target'),
(16, 101, 110, 'target'),
(17, 102, 110, 'target'),
(18, 104, 110, 'target'),
(19, 105, 115, 'target'),
(20, 121, 130, 'target'),
(21, 123, 130, 'target'),
(22, 141, 150, 'target'),
(23, 142, 20, 'target'),
(24, 145, 150, 'target'),
(25, 161, 170, 'target'),
(26, 162, 170, 'target'),
(27, 181, 11, 'target'),
(28, 182, 11, 'target'),
(29, 191, 200, 'target'),
(30, 192, 200, 'target'),
(31, 231, 130, 'target'),
(32, 232, 130, 'target'),
(33, 261, 280, 'target'),
(34, 262, 290, 'target'),
(35, 263, 300, 'target'),
(36, 264, 310, 'target'),
(37, 266, 300, 'target'),
(38, 267, 310, 'target'),
(39, 268, 280, 'target'),
(40, 270, 290, 'target'),
(41, 2000, 100, 'admin'),
(42, 2001, 3, 'target'),
(43, 2002, 2010, 'target'),
(44, 2009, 2002, 'target'),
(45, 2010, 230, 'admin'),
(46, 2011, 260, 'admin'),
(47, 2061, 2002, 'target'),
(48, 2064, 3, 'target'),
(49, 2073, 2002, 'target'),
(50, 2074, 2002, 'target'),
(51, 2082, 230, 'admin'),
(52, 2083, 230, 'admin'),
(53, 2084, 230, 'admin'),
(54, 2090, 2010, 'target'),
(55, 2, 120, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `redcms_dico`
--
-- Création: Mar 01 Mars 2011 à 21:04
-- Dernière modification: Mar 01 Mars 2011 à 21:04
--

CREATE TABLE IF NOT EXISTS `redcms_dico` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `en` varchar(255) NOT NULL,
  `fr` varchar(255) NOT NULL,
  `de` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `redcms_dico`
--


-- --------------------------------------------------------

--
-- Structure de la table `redcms_group`
--
-- Création: Mar 01 Mars 2011 à 21:04
-- Dernière modification: Mar 01 Mars 2011 à 21:04
--

CREATE TABLE IF NOT EXISTS `redcms_group` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Contenu de la table `redcms_group`
--

INSERT INTO `redcms_group` (`id`, `name`, `title`) VALUES
(1, 'Administrators', NULL),
(2, 'testt7', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `redcms_groupxblock`
--
-- Création: Mar 01 Mars 2011 à 21:04
-- Dernière modification: Mar 01 Mars 2011 à 21:04
--

CREATE TABLE IF NOT EXISTS `redcms_groupxblock` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `idBlock` int(100) unsigned NOT NULL,
  `idGroup` int(100) unsigned NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `write` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idBlock` (`idBlock`),
  KEY `idGroup` (`idGroup`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=16 ;

--
-- RELATIONS POUR LA TABLE `redcms_groupxblock`:
--   `idBlock`
--       `redcms_block` -> `id`
--   `idGroup`
--       `redcms_group` -> `id`
--

--
-- Contenu de la table `redcms_groupxblock`
--

INSERT INTO `redcms_groupxblock` (`id`, `idBlock`, `idGroup`, `read`, `write`) VALUES
(5, 2016, 2, 1, 0),
(12, 2016, 1, 1, 1),
(13, 2009, 1, 0, 0),
(14, 2009, 2, 0, 1),
(15, 50, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `redcms_log`
--
-- Création: Mar 01 Mars 2011 à 21:04
-- Dernière modification: Mar 01 Mars 2011 à 21:04
--

CREATE TABLE IF NOT EXISTS `redcms_log` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Contenu de la table `redcms_log`
--


-- --------------------------------------------------------

--
-- Structure de la table `redcms_user`
--
-- Création: Mar 01 Mars 2011 à 20:44
-- Dernière modification: Mar 01 Mars 2011 à 20:44
--

CREATE TABLE IF NOT EXISTS `redcms_user` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- Contenu de la table `redcms_user`
--

INSERT INTO `redcms_user` (`id`, `name`, `surname`, `password`, `email`, `userName`, `text1`, `anniversary`, `profession`, `adress`, `adress_zip`, `adress_city`, `adress_country`, `pPhone`, `prPhone`, `poPhone`, `fax`, `skypeCtct`, `icqCtct`, `aimCtct`, `yahooCtct`, `society`, `adresspro`, `adresspro_zip`, `adresspro_city`) VALUES
(1, 'Administrator', '', '486c92b4d5cc7d998f176d2988f0927fafd736168fc707d65', 'fx@red-agent.com', 'root', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', ''),
(3, 'uu', 'uu', '9ca8af758d34e48679520572a70f251741d98cd3dc22c4715', '', 'uuu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', ''),
(4, '', '', NULL, '', 'ww', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `redcms_userlog`
--
-- Création: Jeu 24 Février 2011 à 17:14
-- Dernière modification: Jeu 24 Février 2011 à 17:14
--

CREATE TABLE IF NOT EXISTS `redcms_userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=1 ;

--
-- RELATIONS POUR LA TABLE `redcms_userlog`:
--   `idUser`
--       `redcms_user` -> `id`
--

--
-- Contenu de la table `redcms_userlog`
--


-- --------------------------------------------------------

--
-- Structure de la table `redcms_userxgroup`
--
-- Création: Mar 01 Mars 2011 à 21:03
-- Dernière modification: Mar 01 Mars 2011 à 21:03
--

CREATE TABLE IF NOT EXISTS `redcms_userxgroup` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(100) unsigned NOT NULL,
  `idGroup` int(100) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `idGroup` (`idGroup`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- RELATIONS POUR LA TABLE `redcms_userxgroup`:
--   `idGroup`
--       `redcms_group` -> `id`
--   `idUser`
--       `redcms_user` -> `id`
--

--
-- Contenu de la table `redcms_userxgroup`
--

INSERT INTO `redcms_userxgroup` (`id`, `idUser`, `idGroup`) VALUES
(2, 1, 2),
(3, 1, 1);
