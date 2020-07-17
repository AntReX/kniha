<?php

class Knihy
{
	private $autor;
	private $rok_vydani;
	private $nazev;
	
	public $error = [];
	
	public function __construct($autor = false, $rok_vydani = false, $nazev = false){
		$this->kontrola($autor, $rok_vydani, $nazev); // kdyby toho bylo vice, udelal bych funkci, ktera by zpracovala array()
	}
	
	private function kontrola($autor, $rok_vydani, $nazev){
		if(!empty($rok_vydani) && is_numeric($rok_vydani) && mb_strlen($rok_vydani) <= 4){
			$this->rok_vydani = $rok_vydani;
		}else{
			$this->error[] = "Rok neodpovídá našemu letopočtu";
		}
		
		if(!empty(trim($autor)) && mb_strlen($autor) <= 50){
			$this->autor = trim($autor);
		}else{
			$this->error[] = "Autor má delší název než je povoleno, nebo je prázdný";
		}
		
		if(!empty(trim($nazev)) && mb_strlen($nazev) <= 100){
			$this->nazev = trim($nazev);
		}else{
			$this->error[] = "Název knihy je delší než je povoleno, nebo je prázdný";
		}
	}
	
	public function vytvorKnihu(){
		
		if(!$this->zkontrolujZdaKnihaExistuje()){
			try{
				$vysledek = Db::dotaz("INSERT INTO knihy (autor, rok_vydani, nazev) VALUES (?,?,?)", array($this->autor, $this->rok_vydani, $this->nazev));
				
				if($vysledek){
					return true;
				}else{
					return false;
				}
			}catch(PDOException $e){
				$this->debugerSQL($e);
			}
		}else{
			$this->error[] = "Kniha již v této kombinaci existuje";
			return false;
		}
	}
	
	private function zkontrolujZdaKnihaExistuje(){
		try{
			$vysledek = Db::dotazJeden("SELECT * FROM knihy WHERE autor = ? AND rok_vydani = ? AND nazev = ?", array($this->autor, $this->rok_vydani, $this->nazev));
			
			if(empty($vysledek)){
				return false;
			}else{
				return true;
			}
		
		}catch(PDOException $e){
			$this->debugerSQL($e);
		}	
	}
	
	public function ukazKnihy($limit = 50){
		try{
			return Db::dotazVsechny("SELECT * FROM knihy ORDER BY rok_vydani DESC LIMIT ?", array($limit));
		}catch(PDOException $e){
			$this->debugerSQL($e);
		}	
	}
	
	public function smazatKnihu($id){
		Db::dotaz("DELETE FROM knihy WHERE id=?", array($id));
	}
	
	private function debugerSQL($e){
		if(Conf::DEBUG){
			var_dump($e); exit;
		}
	}
}