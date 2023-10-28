<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2016
 */
class Precio
{
	/**
	 * Propiedades
	 */
	private $id;
	private $artId;
	private $nuevo;
	private $precio;
	private $fecha;
	private $usuario;
	private $artNombre;
	public $historico;
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
	public function __construct($ai,$n=null){
		if(empty($ai) AND is_null($n)){
			
		}elseif(is_null($n)){
			$query="SELECT artp_id,a.art_id,articulo,artp_nuevo,artp_precio,artp_fecha,cli_usuario 
					FROM articulos_precio AS a,articulos_rp_vista AS av 
					WHERE a.art_id = av.art_id AND artp_id = $ai 
					ORDER BY artp_id DESC";
			$res=Db::listar($query);
			$this->id=$res[0]['artp_id'];
			$this->artId=$res[0]['art_id'];
			$this->nuevo=$res[0]['artp_nuevo'];
			$this->precio=$res[0]['artp_precio'];
			$this->fecha=$res[0]['artp_fecha'];
			$this->usuario=$res[0]['cli_usuario'];
			$this->artNombre=$res[0]['articulo'];
			$a=$res[0]['art_id'];
			$nu=$res[0]['artp_nuevo'];
			$query2="SELECT artp_id,a.art_id,articulo,artp_nuevo,artp_precio,artp_fecha,cli_usuario 
						FROM articulos_precio AS a,articulos_rp_vista AS av 
						WHERE a.art_id = av.art_id AND a.art_id = ".$a." AND artp_nuevo = ".$nu." 
						ORDER BY artp_id DESC";
			$this->historico=Db::listar($query2);
			if(count($this->historico) > 0){
				unset($this->historico[0]);
			}
		}else{
			$query="SELECT * FROM
					(
					SELECT artp_id,a.art_id,articulo,artp_nuevo,artp_precio,artp_fecha,cli_usuario 
					FROM articulos_precio AS a,articulos_rp_vista AS av 
					WHERE a.art_id = av.art_id 
					AND a.art_id = $a
					AND artp_nuevo = $n
					ORDER BY artp_id DESC
					) AS ap
					GROUP BY art_id,artp_nuevo";
			$res=Db::listar($query);
			$this->id=$res[0]['artp_id'];
			$this->artId=$res[0]['art_id'];
			$this->nuevo=$res[0]['artp_nuevo'];
			$this->precio=$res[0]['artp_precio'];
			$this->fecha=$res[0]['artp_fecha'];
			$this->usuario=$res[0]['cli_usuario'];
			$this->artNombre=$res[0]['articulo'];
			$a=$res[0]['art_id'];
			$nu=$res[0]['artp_nuevo'];
			$query2="SELECT artp_id,a.art_id,articulo,artp_nuevo,artp_precio,artp_fecha,cli_usuario 
						FROM articulos_precio AS a,articulos_rp_vista AS av 
						WHERE a.art_id = av.art_id AND a.art_id = ".$a." AND artp_nuevo = ".$nu." 
						ORDER BY artp_id DESC";
			$this->historico=Db::listar($query2);
			if(count($this->historico) > 0){
				unset($this->historico[0]);
			}
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getArtId(){
		return $this->artId;
	}
	public function getNuevo(){
		return $this->nuevo;
	}
	public function getPrecio(){
		return $this->precio;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	public function getArtNombre(){
		return $this->artNombre;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setArtId($AI){
		$this->artId=$AI;
	}
	public function setNuevo($nN){
		$this->nuevo=$nN;
	}
	public function setPrecio($nP){
		$this->precio=$nP;
	}
	public function setFecha($nF){
		$this->fecha=$nF;
	}
	public function setUsuario($nU){
		$this->usuario=$nU;
	}
	public function setArtNombre($nAN){
		$this->artNombre=$nAN;
	}
	/**
	 * Inserta nuevo registro a la tabla "articulos_precio" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectar();
		$query="INSERT INTO `articulos_precio`
				(`artp_id`,
				`art_id`,
				`artp_nuevo`,
				`artp_precio`,
				`artp_fecha`,
				`cli_usuario`)
				VALUES
				(null,
				:artId,
				:nuevo,
				:precio,
				:fecha,
				:usuario)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':artId', $this->artId, PDO::PARAM_INT);
		$stmt->bindParam(':nuevo', $this->nuevo, PDO::PARAM_INT);
		$stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
		$stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
		$stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
}
