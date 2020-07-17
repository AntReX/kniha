<?php

class Vyhledavani
{
	public $data = [];
	
	private $data_sql = [];
	private $data_val = [];
	
	public function vyhledejKnihy($rok_vydani, $autor, $nazev){
		$this->data['rok_vydani'] 	= $rok_vydani;
		$this->data['autor'] 		= $autor;
		$this->data['nazev'] 		= $nazev;
		
		return $this->vyhledejKnihySQL();
	}
	
	public function vyhledejKnihySQL(){
		
		$this->syntaxeSQL();
		
		if(!empty($this->data_sql)){
			try{
				return Db::dotazVsechny("SELECT * FROM knihy WHERE ".implode(" AND ", $this->data_sql), $this->data_val);
			}catch(PDOException $e){
				return "Chyba SQL";
			}
		}else{
			$knihy = new Knihy();
			return $knihy->ukazKnihy();
		}
	}
	
	private function syntaxeSQL(){
		
		if(trim($this->data['rok_vydani'])){
			$this->data_sql[] = "rok_vydani = ?";
			$this->data_val[] = trim($this->data['rok_vydani']);
		}
		
		if(trim($this->data['autor'])){
			$this->data_sql[] = "autor LIKE CONCAT('%', ?, '%')";
			$this->data_val[] = trim($this->data['autor']);
		}
		
		if(trim($this->data['nazev'])){
			$this->data_sql[] = "MATCH(nazev) AGAINST(?)";
			$this->data_val[] = trim($this->data['nazev']);
		}
	}
}