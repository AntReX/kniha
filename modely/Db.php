<?php

class Db {

    private static $spojeni;
	
	private static $nastaveni = Array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function pripoj($host, $uzivatel, $heslo, $databaze) {
		if (!isset(self::$spojeni)) {
			self::$spojeni = @new PDO(
				"mysql:host=$host;dbname=$databaze",
				$uzivatel,
				$heslo,
				self::$nastaveni
			);
		}
	}

    public static function dotaz($sql, $parametry = array()) 
	{		
		$dotaz = self::$spojeni->prepare($sql);
		$dotaz->execute($parametry);
		return $dotaz;

    }

	//Dotaz na jeden řádek !
	public static function dotazJeden($dotaz, $parametry = array())
	{
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
	}
	
	//Dotaz na více řádků
	public static function dotazVsechny($dotaz, $parametry = array()) 
	{
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
	}
	
	//Dotaz na jeden sloupec
	public static function dotazSamotny($dotaz, $parametry = array()) 
	{
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
	}
	
	//Dotaz na poslední ID
	public static function getLastId()
    {
		return self::$spojeni->lastInsertId();
    }
	
	// Spustí dotaz a vrátí počet ovlivněných řádků
	public static function dotazPocet($dotaz, $parametry = array()) 
	{
		$navrat = self::$spojeni->prepare($dotaz);
		$navrat->execute($parametry);
		return $navrat->rowCount();
	}
	
	// Zamezí opakovanému dotazu.
	public static function beginTrans()
	{
		return self::$spojeni->beginTransaction();
	}
	
	public static function commitDB()
	{
		return self::$spojeni->commit();
	}
}
