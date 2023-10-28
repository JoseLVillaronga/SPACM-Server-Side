<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2017
 */
class Ajax
{
	/**
	 * Propiedades ...
	 */
	private $id;
	private $nombre;
	private $codigo;
	/**
	 * Array con error de la ultima transacción (INSERT,UPDATE), se puede imprimir con "print_r($this->errorSql)" ...
	 */
	public $errorSql=array();
	/**
	 * String con el ID de la ultima fila insertada (INSERT) ...
	 */
	public $uFilaIns;
	/**
	 * Array con los errores de los setters ...
	 */
	public $errores=array();
	/***************************
	 * Metodo constructor ...  *
	 ***************************/
	public function __construct($g){
		$this->id=$g;
		$query="SELECT * FROM ajax WHERE ax_id = ".$g;
		$res=Db::listarServer($query);
		$this->nombre=$res[0]['ax_nombre'];
		$this->codigo=$res[0]['ax_codigo'];
	}
	/**
	 * Ejecutar AJAX
	 */
	public function ejecutar(){
		$ret=exec($this->codigo);
		return $ret;
	}
}