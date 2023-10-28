<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class DOCSIS
{
	/**
	 * Propiedades
	 */
	private $id;
	private $Uptime;
	private $mac;
	private $serie;
	private $tx;
	private $rx;
	private $mer;
	private $frecUs;
	private $frecDs;
	private $sysName;
	private $sysDescr;
	private $firmware;
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
		
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getUptime(){
		return $this->Uptime;
	}
	public function getMac(){
		return $this->mac;
	}
	public function getSerie(){
		return $this->serie;
	}
	public function getTx(){
		return $this->tx;
	}
	public function getRx(){
		return $this->rx;
	}
	public function getMer(){
		return $this->mer;
	}
	public function getFrecUs(){
		return $this->frecUs;
	}
	public function getFrecDs(){
		return $this->frecDs;
	}
	public function getSysName(){
		return $this->sysName;
	}
	public function getSysDescr(){
		return $this->sysDescr;
	}
	public function getFirmware(){
		return $this->firmware;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setUptime($nU){
		$this->Uptime=$nU;
	}
	public function setMac($nM){
		$this->mac=$nM;
	}
	public function setSerie($nS){
		$this->serie=$nS;
	}
	public function setTx($nT){
		$this->tx=$nT;
	}
	public function setRx($nR){
		$this->rx=$nR;
	}
	public function setMer($nM){
		$this->mer=$nM;
	}
	public function setFrecUs($nFU){
		$this->frecUs=$nFU;
	}
	public function setFrecDs($nFD){
		$this->frecDs=$nFD;
	}
	public function setSysName($nSN){
		$this->sysName=$nSN;
	}
	public function setSysDescr($nSD){
		$this->sysDescr=$nSD;
	}
	public function setFirmware($nF){
		$this->firmware=$nF;
	}
	/**
	 * Inserta nuevo registro a la tabla "docsis" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectarCDR();
		$query="INSERT INTO `grupos`
				(`cli_grupo`,
				`gru_nombre`)
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
	 * Borra registro de la tabla "docsis" filtrado por ID ...
	 */
	public function borraPorId($ID){
		if(!isset($ID)){
			return $this;
		}
		$con=Conexion::conectarCDR();
		$query = "DELETE FROM grupos WHERE cli_grupo = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}