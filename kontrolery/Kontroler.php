<?php

abstract class Kontroler
{
	protected $data = array();
	// Název šablony bez přípony
    protected $pohled = "";
	protected $pohled2 = "";
	// Hlavička HTML stránky
	protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');
	
	// Ošetří proměnnou pro výpis do HTML stránky
	private function osetri($x = null)
	{
		if (!isset($x))
			return null;
		elseif (is_string($x)){
			$htmlspec = htmlspecialchars($x, ENT_QUOTES);
			//$htmlspec = $this->zkontrolujVulgaritu($htmlspec);
			return $htmlspec;
		}
		elseif (is_array($x))
		{
			foreach($x as $k => $v)
			{
				$x[$k] = $this->osetri($v);
			}
			return $x;
		}
		else 
			return $x;
	}
	
    public function vypisPohled()
    {
		if($this->pohled)
        {
			if(!$this->data['novinky']){
				extract($this->osetri($this->data));
			}else
				extract($this->data);
			
			extract($this->data, EXTR_PREFIX_ALL, "");
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }
	
	// Přesměruje na dané URL
	public function presmeruj($url)
	{
		header("Location: /$url");
		header("Connection: close");
        exit;
	}
	
	public function captcha()
	{
		$this->data['captcha1'] = rand(1, 9);
		$this->data['captcha2'] = rand(1, 9);
		$this->data['captcha3'] = $this->data['captcha1'] + $this->data['captcha2'];
		return $this->data['captcha3'];
	}
	
	public static function msg($msg)
	{
		$_SESSION['msg']['info'] = $msg;
	}
	
	// Přidá zprávu pro uživatele
	public function pridejZpravu($zprava)
	{
		if (isset($_SESSION['zpravy']))
			$_SESSION['zpravy'][] = $zprava;
		else
			$_SESSION['zpravy'] = array($zprava);
	}
	
	// Vrátí zprávy pro uživatele
	public static function vratZpravy()
	{
		if (isset($_SESSION['zpravy']))
		{
			$zpravy = $_SESSION['zpravy'];
			unset($_SESSION['zpravy']);
			return $zpravy;
		}
		else
			return array();
	}
	
	
	public function zkontrolujVulgaritu($text)
	{
		$slova = array(blbec, buzerant, buzna, čarák, čubka, čurák, čůrák, debil, dement, děvka, sex, dylina, feťák, feťačka, hovnoksicht, hovnoxicht, hovno, hovňous, idiot, kedra, kokot, koňomrd, kráva, kretén, kripl,krypl, kunda, kurva, kurvo, kurvák, kuřbuřt, mrdůch, píča, pičus, poser, posrat, posera, pošuk, prdele, prdeloid, prsatice, smažka, sračka, sračky, úchyl, úchylák, zmrd, mrdat, mrdka, zik, zoofil, kretenizmus, kretenismus, ksicht, xicht, prdel, úchylka, zoofilie, debilní, dementní, zasraný, zkurvený, skurvený, buzerovat, čurat, čůrat, močit, fetovat, drogy, chcát, chyndit, jebat, kurvit, zkurvit, kurvit, mrdat, šukat, pochcat, pomočit, srát, šoustat, vypíčit, zkundyzmrd, zkurvyzmrd);

		$ochrana = str_replace($slova, ' [Jsem Vulgární] ', $text);
		return $ochrana;
	}
	
	abstract function zpracuj($parametry);
}