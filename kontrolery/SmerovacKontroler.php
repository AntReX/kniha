<?php
class SmerovacKontroler extends Kontroler
{
	// Instance controlleru
	protected $kontroler;
	
	// Metoda převede pomlčkovou variantu controlleru na název třídy
	private function pomlkyURL($text){
		$veta = str_replace('-', ' ', $text);
		$veta = ucwords($veta);
		$veta = str_replace(' ', '', $veta);
		return $veta;
	}
	
	// Naparsuje URL adresu podle lomítek a vrátí pole parametrů
	private function parsujURL($url){
		
		// Naparsuje jednotlivé části URL adresy do asociativního pole
		$naparsovanaURL = parse_url($url);
		// Odstranění počátečního lomítka
		$naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
		// Odstranění bílých znaků kolem adresy
		$naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
		// Rozbití řetězce podle lomítek
		$rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
		
		return $rozdelenaCesta;
	}

    // Naparsování URL adresy a vytvoření příslušného controlleru
    public function zpracuj($parametry){	
	
		$naparsovanaURL = $this->parsujURL($parametry[0]);
		$this->data['stranka'] = $naparsovanaURL[0];
		
		if(!empty($_SESSION['uzivatel']) && $_SESSION['uzivatel']['jmeno'] == Conf::LOGIN_NAME && $_SESSION['uzivatel']['heslo'] == Conf::LOGIN_NAME){
			if(empty($naparsovanaURL[0])){
				$naparsovanaURL[0] = "hlavniStranka";
				$this->kontroler = new HlavniStrankaKontroler;
			}
			
			// pristup bez omezeni
		}else{
			$naparsovanaURL[0] = "prihlaseni";
			$this->kontroler = new PrihlaseniKontroler;
		}
		
		// kontroler je 1. parametr URL
		$tridaKontroleru = $this->pomlkyURL(array_shift($naparsovanaURL)) . 'Kontroler';
		
		if(file_exists('kontrolery/' . $tridaKontroleru . '.php')){
			$this->kontroler = new $tridaKontroleru;
		}else{
			$this->kontroler = new HlavniStrankaKontroler;
		}
		
		// Volání controlleru
		$this->kontroler->zpracuj($naparsovanaURL);
		
		// Nastavení proměnných pro šablonu
		$this->data['titulek']  = $this->kontroler->hlavicka['titulek'];
		$this->data['popis'] = $this->kontroler->hlavicka['popis'];
		$this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];

		$this->pohled = Conf::NAME_INDEX;
	}
}