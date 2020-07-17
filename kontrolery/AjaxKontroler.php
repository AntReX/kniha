<?php
class AjaxKontroler extends Kontroler
{
	public function zpracuj($parametry){
		if(isset($_POST['action'])){
			if($_POST['action'] == "ajax_search"){

				$vyhledavani = new Vyhledavani();
				$data = $vyhledavani->vyhledejKnihy($_POST['rok_vydani'],$_POST['autor'],$_POST['nazev_knihy']);
				
				$this->vystupJSON($data, "ok");
			}
		}else{
			header("Location: ./");
		}
    }
	
	public function vystupJSON($msg, $status = 'error'){
	    header('Content-Type: application/json');
	    
	    echo json_encode(array(
	        'data' => $msg,
	        'status' => $status,
	    ));
		exit;
	}
}