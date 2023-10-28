<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class PruebaEstado
{
	/**
	 * Propiedades
	 */
	private $id;
	private $nombre;
	private $color;
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
	public function __construct($g){
		if(empty($g)){
			return $this;
		}else{
			$query="SELECT * FROM prueba_estado WHERE ps_id = ".$g;
			$res=Db::listarServer($query);
			if(count($res) > 0){
				$this->id=$res[0]['ps_id'];
				$this->nombre=$res[0]['ps_nombre'];
				$this->color=$res[0]['ps_color'];
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
	public function getColor(){
		return $this->color;
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
	public function setColor($nC){
		$this->color=$nC;
	}
	/**
	 * Actualiza la tabla "prueba_estado" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=Conexion::conectarServer();
		$query = "UPDATE `teccam`.`prueba_estado`
					SET
					`ps_id` = :id,
					`ps_nombre` = :nombre,
					`ps_color` = :color
					WHERE `ps_id` = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt->bindParam(':color', $this->color, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	/**
	 * Inserta nuevo registro a la tabla "prueba_estado" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectarServer();
		$query = "INSERT INTO `teccam`.`prueba_estado`
					(`ps_nombre`,
					`ps_color`)
					VALUES
					(:nombre,
					:color)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt->bindParam(':color', $this->color, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "prueba_estado" filtrado por ID ...
	 */
	public function borraPorId($ID){
		if(!isset($ID)){
			return $this;
		}
		$con=Conexion::conectarServer();
		$query = "DELETE FROM prueba_estado WHERE ps_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}
