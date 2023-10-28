<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class Prueba
{
	/**
	 * Propiedades
	 */
	private $id;
	public $tipoPrueba;
	private $fechaInicio;
	private $usuario;
	private $fechaFinal;
	private $habilitado;
	private $remito;
	public $lotePrueba;
	private $controlCalidad=0;
	private $cantidadEthernet=4;
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
		$query="SELECT * FROM prueba WHERE p_id = ".$g;
		$res=Db::listarServer($query);
		if(count($res)=="0"){
			$this->tipoPrueba=new TipoPrueba();
			$this->lotePrueba=new LotePrueba();
		}else{
			foreach($res as $fila){
				$this->id=$fila['p_id'];
				$this->tipoPrueba=new TipoPrueba($fila['tp_id']);
				$this->fechaInicio=$fila['p_fecha_inicio'];
				$this->usuario=$fila['cli_usuario'];
				$this->fechaFinal=$fila['p_fecha_final'];
				$this->habilitado=$fila['p_habilitado'];
				$this->remito=$fila['stk_id'];
				$this->lotePrueba=new LotePrueba($fila['p_id']);
				$this->controlCalidad=$fila['p_cc'];
				$this->cantidadEthernet=$fila['p_cant_ether'];
			}
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getTipoPruebaId(){
		return $this->tipoPrueba->getId();
	}
	public function getFechInicio(){
		return $this->fechaInicio;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	public function getFechaFinal(){
		return $this->fechaFinal;
	}
	public function getHabilitado(){
		return $this->habilitado;
	}
	public function getRemito(){
		return $this->remito;
	}
	public function getControlCalidad(){
		return $this->controlCalidad;
	}
	public function getCantidadEthernet(){
		return $this->cantidadEthernet;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setFechaInicio($nFI){
		if(empty($nFI)){
			$this->fechaInicio=date("Y-m-d H:i:s");
		}else{
			$this->fechaInicio=$nFI;
		}
	}
	public function setUsuario($nU){
		$this->usuario=$nU;
	}
	public function setFechaFinal($nFF){
		if(empty($nFF)){
			$this->fechaFinal=date("Y-m-d H:i:s");
		}else{
			$this->fechaFinal=$nFF;
		}
	}
	public function setRemito($nR){
		$this->remito=$nR;
	}
	public function setHabilitado($nH){
		if(in_array($nH, array(0,1))){
			$this->habilitado=$nH;
		}else{
			$this->errores['habilitado']="No es un valor permitido ...";
			$this->errores['gen'] = "harError";
		}
	}
	public function setControlCalidad($nCC){
		$this->controlCalidad=$nCC;
	}
	public function setCantidadEthernet($nCE){
		$this->cantidadEthernet=$nCE;
	}
	/**
	 * Actualiza la tabla "prueba" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=Conexion::conectarServer();
		$tp=$this->getTipoPruebaId();
		$query="UPDATE `prueba`
				SET
				`p_id` = :id,
				`tp_id` = :tpId,
				`p_fecha_inicio` = :fechaInicio,
				`cli_usuario` = :usuario,
				`p_fecha_final` = :fechaFinal,
				`p_habilitado` = :habilitado,
				`stk_id` = :remito,
				`p_cc` = :controlCalidad,
				`p_cant_ether` = :cantidadEthernet
				WHERE `p_id` = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':tpId', $tp, PDO::PARAM_INT);
		$stmt->bindParam(':fechaInicio', $this->fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
		$stmt->bindParam(':fechaFinal', $this->fechaFinal, PDO::PARAM_STR);
		$stmt->bindParam(':habilitado', $this->habilitado, PDO::PARAM_INT);
		$stmt->bindParam(':remito', $this->remito, PDO::PARAM_INT);
		$stmt->bindParam(':controlCalidad', $this->controlCalidad, PDO::PARAM_INT);
		$stmt->bindParam(':cantidadEthernet', $this->cantidadEthernet, PDO::PARAM_INT);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	/**
	 * Inserta nuevo registro a la tabla "prueba" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectarServer();
		$tp=$this->getTipoPruebaId();
		$query="INSERT INTO `prueba`
				(`tp_id`,
				`p_fecha_inicio`,
				`cli_usuario`,
				`p_fecha_final`,
				`p_habilitado`,
				`stk_id`,
				`p_cc`,
				`p_cant_ether`)
				VALUES
				(:tpId,
				:fechaInicio,
				:usuario,
				:fechaFinal,
				:habilitado,
				:remito,
				:controlCalidad,
				:cantidadEthernet)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':tpId', $tp, PDO::PARAM_INT);
		$stmt->bindParam(':fechaInicio', $this->fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
		$stmt->bindParam(':fechaFinal', $this->fechaFinal, PDO::PARAM_STR);
		$stmt->bindParam(':habilitado', $this->habilitado, PDO::PARAM_INT);
		$stmt->bindParam(':remito', $this->remito, PDO::PARAM_INT);
		$stmt->bindParam(':controlCalidad', $this->controlCalidad, PDO::PARAM_INT);
		$stmt->bindParam(':cantidadEthernet', $this->cantidadEthernet, PDO::PARAM_INT);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "prueba" filtrado por ID ...
	 */
	public function borraPorId($ID){
		$con=Conexion::conectarServer();
		$query = "DELETE FROM prueba WHERE p_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}
