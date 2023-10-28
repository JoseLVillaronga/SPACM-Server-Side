<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class HistoryPrueba
{
	/**
	 * Propiedades
	 */
	private $id;
	private $lpId;
	private $estado;
	private $fecha;
	private $usuario;
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
	public function __construct($g){
		if(!empty($q)){
			$query2="SELECT * FROM lote_prueba WHERE lp_id = ".$g;
			$res2=Db::listar($query2);
			$this->lpId=$res2[0]['lp_id'];
			$this->estado=$res2[0]['ps_id'];
			$this->fecha=date("Y-m-d H:i:s");
			$this->usuario=$_SESSION['usuario'];
			$query="SELECT * FROM prueba_historico WHERE lp_id = ".$g;
			$res=Db::listar($query);
			if($res > 0){
				foreach($res as $fila){
					$this->lote[]=array(
					"lp_id"=>$fila['lp_id'],
					"ps_id"=>$fila['ps_id'],
					"ph_fecha"=>$fila['ph_fecha'],
					"cli_usuario"=>$fila['cli_usuario']
					);
				}
			}else{
				$this->lote=array();
			}
				
		}else{
			return $this;
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getLPId(){
		return $this->lpId;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setLPId($nLPI){
		$this->lpId=$nLPI;
	}
	public function setEstado($nE){
		$this->estado=$nE;
	}
	public function setFecha($nF){
		$this->fecha=$nF;
	}
	public function setUsuario($nU){
		$this->usuario=$nU;
	}
	public function setLote($g){
		$query="SELECT * FROM prueba_historico WHERE lp_id = ".$g;
		$res=Db::listar($query);
		if($res > 0){
			foreach($res as $fila){
				$this->lote[]=array(
				"lp_id"=>$fila['lp_id'],
				"ps_id"=>$fila['ps_id'],
				"ph_fecha"=>$fila['ph_fecha'],
				"cli_usuario"=>$fila['cli_usuario']
				);
			}
		}else{
			$this->lote=array();
		}
	}
	/**
	 * Inserta nuevo registro a la tabla "prueba_historico" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
		$query="INSERT INTO `prueba_historico`
				(`lp_id`,
				`ps_id`,
				`ph_fecha`,
				`cli_usuario`)
				VALUES
				(".$this->lpId.",
				".$this->estado.",
				'".$this->fecha."',
				'".$this->usuario."')";
		mysqli_query($con, $query);
		$this->errorSql = mysqli_error($con);
		$this->uFilaIns=mysqli_insert_id($con);
		$this->setId($this->uFilaIns);
		$con->close();
	}
}