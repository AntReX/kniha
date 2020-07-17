<?php

class PrihlaseniKontroler extends Kontroler
{
	public function zpracuj($parametry){
		
		// jedna se pouze o primitivni prihlaseni
		if(isset($_POST['prihlaseni'])){
			if($_POST['jmeno'] == Conf::LOGIN_NAME && $_POST['heslo'] == Conf::LOGIN_PASS){
				$_SESSION['uzivatel']['jmeno'] = $_POST['jmeno'];
				$_SESSION['uzivatel']['heslo'] = $_POST['heslo'];
				
				header("Location: ./");
			}else{
				$this->data['msg'] = "* Přihlášení se nezdařilo";
			}
		}
		
		$this->pohled		= 'prihlaseni';
	}	
}