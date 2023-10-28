<?php
/**
 * @author : José Luis Villaronga
 * @copyright : 2015
 */
class ReporteReparacionVistaFiltro
{
	/**
	 * Propiedades
	 */
	public $id;
	public $estado;
	public $empId;
	public $categoria;
	public $falla;
	public $tarea;
	public $usuario;
	public $fecha;
	public $to;
	public $artIdb;
	public $serie;
	public $mac;
	public $observaciones;
	/**
	 * Metodo constructor ..
	 */
	public function __construct($id,$estado,$empId,$categoria,$falla,$tarea,$usuario,$fecha,$to,$artIdb,$serie,$mac,$observaciones){
		$this->id=$id;
		$this->estado=$estado;
		$this->empId=$empId;
		$this->categoria=$categoria;
		$this->falla=$falla;
		$this->tarea=$tarea;
		$this->fecha=$fecha;
		$this->to=$to;
		$this->artIdb=$artIdb;
		$this->serie=$serie;
		$this->mac=$mac;
		$this->observaciones=$observaciones;
	}
}
