<h2>This is ZF2 module to create and storage events logs in database</h2>

Module allow you to create 4 type of logs (info, edit, warning and error). You can add each of this log in any place of controller as you want.

Each log contains title and date. Also additional informations like framework message, url or file.

This module automatically catch and save in database all dispatch and render errors with information generated by zf2 like message, file and url to help you debug errors created by other person

<h2>Instalation</h2>

1. copy all files to yours ZF2 application module folder. For example /www/my-website.com/module/LogWriter (don't forget to turn on this module in main application.config.php file)
2. create logs table in your database using command from database-structure.sql
3. Now you can use LogWriter service in entire application

<h2>How to use from controller actions (examples)</h2>

// add new information log<br/>
$this->getServiceLocator()->get('LogWriter')->addInfoLog($title);

// add new edit log<br/>
$this->getServiceLocator()->get('LogWriter')->addEditLog($title);   	

// add new warning log<br/>
$this->getServiceLocator()->get('LogWriter')->addWarningLog($title);   	

// add new error log<br/>
$this->getServiceLocator()->get('LogWriter')->addErrorLog($title);   	

// get logs (default 100 positions)<br/>
$this->getServiceLocator()->get('LogWriter')->getLogs();  

<h2>Future plans</h2>

- add integration with authentication service to catch who is logged in when creating log