<?php
mb_internal_encoding("UTF-8");
session_start();

spl_autoload_register(function ($class) {
	
	if(file_exists("./kontrolery/" . $class . ".php")){
		if(preg_match('/Kontroler$/', $class)){
			require("kontrolery/" . $class . ".php");
		}
	}
	
	if(file_exists("modely/" . $class . ".php")){
		require("modely/" . $class . ".php");
	}
});

try{
	Db::pripoj(Conf::DB_IP, Conf::DB_USER, Conf::DB_PASS, Conf::DB_NAME);
}catch(PDOException $e){
	echo "Chyba MySQL..";
	exit;
}

$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));

// Vyrenderování šablony
$smerovac->vypisPohled();
		