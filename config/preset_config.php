<?php
	/**********************************************************
	* Lidiun PHP Framework 4.0 - (http://www.lidiun.com)
	*
	* @Created in 26/08/2013
	* @Author  Dyon Enedi <dyonenedi@hotmail.com>
	* @Modify in 04/08/2014
	* @By Dyon Enedi <dyonenedi@hotmail.com>
	* @Contributor Gabriela A. Ayres Garcia <gabriela.ayres.garcia@gmail.com>
	* @Contributor Rodolfo Bulati <rbulati@gmail.com>
	* @License: free
	*
	**********************************************************/
	
	// Set presets for your application
	return [
		// Application
		'app_name' => 'AI2I',
		'domain' => 'dyonenedi.com',
		
		// Html tags to SEO
		'description' => "I's a Robo AI2I that can lear with you and talk too.",
		'key_word' => 'Robo, AI, Artificail Inteligence, AI2I',
		'author' => 'Dyon Enedi',
		'author_email' => 'dyonenedi@hotmail.com',
		
		// Defalt render when request haven't parameter
		'default_render' => 'ihm',

		// Translator
		'language_default' => 'en-us',
		
		// SCookie parameters
		'cookie_lifetime' => 3600,
		'cookie_path' => '/',
		'cookie_secure' => false,
		'cookie_httponly' => true,
		
		// Security code use in your system
		'security_code' => 'Av4r5Typ',
		
		// Default config
		'timezone' => 'America/Sao_Paulo',
		'support' => false,

		// Deploy
		'force_debug' => true,
	];
