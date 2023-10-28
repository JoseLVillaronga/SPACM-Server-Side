<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class TipoPrueba
{
	/**
	 * Propiedades
	 */
	private $id;
	private $nombre;
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
	/**
	 * Metodo constructor ..
	 */
	public function __construct($g=null){
		if(empty($g)){
			return $this;
		}else{
			$query="SELECT * FROM tipo_prueba WHERE tp_id = ".$g;
			$res=Db::listar($query);
			if(count($res)=="0"){
				return $this;
			}else{
				foreach($res as $fila){
					$this->id=$fila['tp_id'];
					$this->nombre=$fila['tp_nombre'];
				}
			}
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setNombre($nN){
		$this->nombre=$nN;
	}
	/**
	 * Actualiza la tabla "tipo_prueba" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=Conexion::conectarCDR();
		$query = "UPDATE `tipo_prueba`
					SET
					`tp_id` = :id,
					`tp_nombre` = :nombre
					WHERE `tp_id` = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	/**
	 * Inserta nuevo registro a la tabla "tipo_prueba" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectarCDR();
		$query="INSERT INTO `tipo_prueba`
				(`tp_id`,
				`tp_nombre`)
				VALUES
				(null,
				:nombre)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "tipo_prueba" filtrado por ID ...
	 */
	public function borraPorId($ID){
		if(!isset($ID)){
			return $this;
		}
		$con=Conexion::conectarCDR();
		$query = "DELETE FROM tipo_prueba WHERE tp_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}