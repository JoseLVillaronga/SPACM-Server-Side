<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2017
 */
class EventoSRV
{
	/**
	 * Propiedades ...
	 */
	private $id;
	private $usu;
	private $activo;
	private $ajax;
	private $fecha;
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
	public function __construct(){
		//$auth=new Usuario($_SESSION['usuario']);
		$query="SELECT * FROM evento_srv WHERE usu_id = ".$_SESSION["usu_id"]." ORDER BY ev_id DESC LIMIT 1";
		$res=Db::listarServer($query);
		$this->id=$res[0]['ev_id'];
		$this->activo=$res[0]['ev_activo'];
		$this->ajax=$res[0]['ax_id'];
		$this->fecha=$res[0]['ev_fecha'];
		$this->usu=$_SESSION["usu_id"];
		if($this->activo==1){
			$this->desactivar();
		}
	}
	public function desactivar(){
		$con=Conexion::conectarServer();
		$fecha=date('Y-m-d H:i:s');
		$query="INSERT INTO evento_srv
				(ev_id,
				ev_activo,
				ax_id,
				ev_fecha,
				usu_id)
				VALUES
				(null,
				0,
				1,
				:fecha,
				:usu)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
		$stmt->bindParam(':usu', $this->usu, PDO::PARAM_INT);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	public function activar($ax,$usu=array()){
		foreach($usu as $key => $value){
			$con=Conexion::conectarServer();
			$fecha=date('Y-m-d H:i:s');
			$query="INSERT INTO evento_srv
					(ev_id,
					ev_activo,
					ax_id,
					ev_fecha,
					usu_id)
					VALUES
					(null,
					1,
					:ajax,
					:fecha,
					:usu)";
			$stmt = $con -> prepare($query);
			$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
			$stmt->bindParam(':ajax', $ax, PDO::PARAM_INT);
			$stmt->bindParam(':usu', $value, PDO::PARAM_INT);
			$stmt -> execute();
			$this->errorSql = $stmt->errorInfo();
		}
	}
	public function ejecutar(){
		if($this->activo==1){
			$accion=new AjaxSRV($this->ajax);
			$accion->ejecutar();
		}
	}
}
