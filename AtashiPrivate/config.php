<?php
$config = array (
		'public_html' => dirname ( __FILE__ ) . '/../public_html/',
		'globals' => array (
				'adminUrl' => 'http://localhost/admin' 
		),
		'ErrorHandler' => '\private\Controllers\EH',
		'twig' => array (
				'TemplatesFolder' => dirname ( __FILE__ ) . '/templates',
				'TemplatesCacheFolder' => dirname ( __FILE__ ) . '/templates_cache' 
		),
		'mail' => array (
				'server' => 'ssl://smtp.gmail.com',
				'port' => 465,
				'username' => 'user@site.com',
				'pass' => 'pass',
				'sender' => 'admin@site.com',
				'senderName' => 'adminName' 
		),
		'dbase' => array (
				'driver' => 'pdo_mysql',
				
				'host' => 'dbhost',
				'user' => 'dbuser',
				'password' => 'dbpass',
				'dbname' => 'dbname',
				'charset' => 'utf8mb4',
				'driverOptions' => array (
						1002 => 'SET NAMES utf8mb4' 
				) 
		),
		//Set all routes (static or dynamic)
		'routes' => array (
				'@Page' => 'page/?value:INT',
				
				'@Home' => '',
				'@Contact' => 'contact',
				// admin
				'@Admin' => 'admin'
		),
		//Set controllers for routes
		'routes2Ctrl' => array (
				// Blog Routes
				'@Home' => '\private\Controllers\Main::home',
				'@Page' => '\private\Controllers\Main::pag',
				'@Admin' => '\private\Controllers\Main::admin',
				// Contactar
				'GET@Contact' => '\private\Controllers\Contact::form',
				'POST@Contact' => '\private\Controllers\Contact::submit' 
		) 
);
    
