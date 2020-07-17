<?php
class HlavniStrankaKontroler extends Kontroler
{
	public function zpracuj($parametry){
		if(isset($_POST['vytvorit-knihu'])){
			$knihy = new Knihy($_POST['autor'], $_POST['rok-vydani'], $_POST['nazev-knihy']);
			
			$this->data['form']['autor'] 		= $_POST['autor'];
			$this->data['form']['rok_vydani'] 	= $_POST['rok-vydani'];
			$this->data['form']['nazev_knihy'] 	= $_POST['nazev-knihy'];

			if(empty($knihy->error)){
				if($knihy->vytvorKnihu()){	
					$this->data['msg'] = "Kniha byla v pořádku vytvořena";
					unset($this->data['form']);
				}
			}
			
			$this->data['error'] = $knihy->error;
		}else{
			$knihy = new Knihy();
		}
		
		$this->data['knihy'] = $knihy->ukazKnihy();
		$this->pohled = 'hlavni-stranka';
    }
}