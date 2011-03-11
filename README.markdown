RedCMS
=================

Welcome to the [RedCMS](http://redcms.red-agent.com). RedCMS is a lightweight CMS created with asynchronous page design in mind. It allows to manage server-side data objects (PHP, PDO), view them (Smarty) and make them interactive (JS).


Next Steps
----------

* Got any question, remark... contact me at fx(AT)red-agent.com

Contributing & Details
----------------------

Visit the official RedCMS repository at GitHub: <http://github.com/fxaeberhard/RedCMS>. Follow it for updates. Fork RedCMS and submit your improvements!  ([Forking Instructions](http://help.github.com/forking/))

Credits
----------------------

Copyright (c) 2011 Francois-Xavier Aeberhard. All rights reserved.
Code licensed under the BSD License:
[http://redcms.red-agent.com/license.html](http://redcms.red-agent.com/license.html)

Contributors
----------------------

* [YUI3](http://developer.yahoo.com/yui/3/)
* [YUI3-Gallery](http://yuilibrary.com/gallery/)
* [YUI Builder](http://yuilibrary.com/gallery/)
* [PHP](http://www.php.net/)
* [Smarty 3](http://www.smarty.net/)
* [FirePHP](http://www.firephp.org/)
* [PHPMailer](http://phpmailer.worxware.com/)
* [Refresh Cl Icons by TpdkDesign.net](http://www.iconarchive.com/category/system/refresh-cl-icons-by-tpdkdesign.net.html)
	
Install
----------------------
	
1. Requirements
	1. Required Apache Module: mod-rewrite
	2. Optional Apache Module: mod-curl, tidy
2. Install
	1. Create a new database 
	2. Query the content of the file *sql/redcms-default.sql*
	3. Edit config file *index.php* to provide db connection settings and the relative path to RedCMS
	4. If you are using RedCMS in a subdirectory of your webserver, open *.htaccess* file, and change:
		"RewriteBase /"
	to
		"RewriteBase *yourdirectory*"

Build
----------------------
1. Requirements
	1. Apache Ant
	2. [YUI Builder](http://yuilibrary.com/projects/builder) (copy this at the root directory of your RedCMS install)
2. Build
	1. Type *ant* in the command line at the root directory of your RedCMS install
	2. You can build individual moduls by going in there directory and running *ant all* command