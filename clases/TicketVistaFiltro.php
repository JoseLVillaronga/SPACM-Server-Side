<?php
class TicketVistaFiltro
{
	public $Titulo;
	public $notas;
	public $recursos;
	public $estado;
	
	public function __construct($Titulo,$notas,$recursos,$estado){
		$this->Titulo=$Titulo;
		$this->notas=$notas;
		$this->recursos=$recursos;
		$this->estado=$estado;
	}
}
