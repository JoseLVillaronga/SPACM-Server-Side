<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class LotePrueba
{
	/**
	 * Propiedades
	 */
	private $id;
	private $pId;
	private $ovId;
	private $fecha;
	private $estado;
	private $usuario;
	public $historico;
	public $lote;
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
		$this->pId=$g;
		$this->usuario=$_SESSION['usuario'];
		$query="SELECT lp_id,p_id,lo_id,lp_fecha,cli_usuario,p.ps_id,ps_color,ps_nombre FROM lote_prueba AS p,prueba_estado AS pe WHERE p.ps_id = pe.ps_id AND p_id = ".$g;
		foreach(Db::listar($query) as $fila){
			$this->lote[]=array(
				"lp_id"=>$fila['lp_id'],
				"p_id"=>$fila['p_id'],
				"lo_id"=>$fila['lo_id'],
				"lp_fecha"=>$fila['lp_fecha'],
				"cli_usuario"=>$fila['cli_usuario'],
				"ps_id"=>$fila['ps_id'],
				"ps_color"=>$fila['ps_color'],
				"ps_nombre"=>$fila['ps_nombre']
			);
			array_multisort($this->lote);
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getPId(){
		return $this->pId;
	}
	public function getOVId(){
		return $this->ovId;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	public function getEstado(){
		return $this->estado;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setPId($nPId){
		$this->pId=new TipoPrueba($nPId);
	}
	public function setOVId($nOVI){
		$this->ovId=$nOVI;
	}
	public function setFecha($nF){
		if(empty($nF)){
			$this->fecha=date("Y-m-d H:i:s");
		}else{
			$this->fecha=$nF;
		}
	}
	public function setUsuario($nU){
		$this->usuario=$nU;
	}
	public function setEstado($nE){
		$this->estado=$nE;
	}
	public function setLote(){
		unset($this->lote);
		$query="SELECT lp_id,p_id,lo_id,lp_fecha,cli_usuario,p.ps_id,ps_color,ps_nombre FROM lote_prueba AS p,prueba_estado AS pe WHERE p.ps_id = pe.ps_id AND p_id = ".$this->pId;
		foreach(Db::listar($query) as $fila){
			$this->lote[]=array(
				"lp_id"=>$fila['lp_id'],
				"p_id"=>$fila['p_id'],
				"lo_id"=>$fila['lo_id'],
				"lp_fecha"=>$fila['lp_fecha'],
				"cli_usuario"=>$fila['cli_usuario'],
				"ps_id"=>$fila['ps_id'],
				"ps_color"=>$fila['ps_color'],
				"ps_nombre"=>$fila['ps_nombre']
			);
			array_multisort($this->lote);
		}
	}
	public function setLotePorId($id){
		$query="SELECT * FROM lote_prueba WHERE lp_id = ".$id;
		$res=Db::listar($query);
		if(count($res) > 0){

			$this->id=$res[0]['lp_id'];
			$this->pId=$res[0]['p_id'];
			$this->ovId=$res[0]['lo_id'];
			$this->fecha=$res[0]['lp_fecha'];
			$this->usuario=$res[0]['cli_usuario'];
			$this->estado=$res[0]['ps_id'];

			$this->setLote();
			array_multisort($this->lote);
			$this->historico=new HistoryPrueba($id);
			$this->historico->setLPId($this->id);
			$this->historico->setEstado($this->estado);
			$this->historico->setFecha(date("Y-m-d H:i:s"));
			$this->historico->setUsuario($_SESSION['usuario']);
			$this->historico->setLote($id);
		}
	}
	/**
	 * Actualiza la tabla "lote_prueba" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
		$query = "UPDATE `lote_prueba`
					SET
					`lp_id` = ".$this->id.",
					`p_id` = ".$this->pId.",
					`lo_id` = ".$this->ovId.",
					`lp_fecha` = '".$this->fecha."',
					`cli_usuario` = '".$this->usuario."',
					`ps_id` = ".$this->estado."
					WHERE `lp_id` = ".$this->id;
		mysqli_query($con, $query);
		$this->errorSql = mysqli_error($con);
		$con->close();
		$this->historico=new HistoryPrueba($this->id);
		$this->historico->setLPId($this->id);
		$this->historico->setEstado($this->estado);
		$this->historico->setFecha(date("Y-m-d H:i:s"));
		$this->historico->setUsuario($_SESSION['usuario']);
		$this->historico->agregaADb();
	}
	/**
	 * Inserta nuevo registro a la tabla "lote_prueba" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
		$query="INSERT INTO `lote_prueba`
				(`lp_id`,
				`p_id`,
				`lo_id`,
				`lp_fecha`,
				`cli_usuario`,
				`ps_id`)
				VALUES
				(null,
				".$this->pId.",
				".$this->ovId.",
				'".$this->fecha."',
				'".$this->usuario."',
				".$this->estado.")";
		mysqli_query($con, $query);
		$this->errorSql = mysqli_error($con);
		$this->uFilaIns=mysqli_insert_id($con);
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "lote_prueba" filtrado por ID ...
	 */
	public function borraPorId($ID){
		if(!isset($ID)){
			return $this;
		}
		$con=Conexion::conectar();
		$query = "DELETE FROM lote_prueba WHERE lp_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}
