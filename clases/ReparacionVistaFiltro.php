<?php
class ReparacionVistaFiltro
{
	public $artId;
	public $mac;
	public $serie;
	public $ot;
	
	public function __construct($artId,$mac,$serie,$ot){
		$this->artId=$artId;
		$this->mac=$mac;
		$this->ot=$ot;
		$this->serie=$serie;
		return $this;
	}
	public function verEnPantalla(){
		echo "<br />".$this->artId."<br />".$this->mac."<br />".$this->ot."<br />".$this->serie;
	}
}
