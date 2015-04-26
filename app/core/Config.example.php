<?php

/*
 *	To create a Config file that dosent give plain text passwords and usernames to github
 *	we create an Config.EXAMPLE.php file. You clone this file into -> Config.php
 * 	Config.php will be ingored by git and never pushed online. But it will always stay on the location it was created
 *
 * .gitignore controlls what files should be ignored by git
 */
 
$config['mysql']['address']	    = "adress";
$config['mysql']['database']	= "database";
$config['mysql']['username']	= "user";
$config['mysql']['password'] 	= "pass";
