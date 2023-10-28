<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2018
 */
class CMDocsis
{
	/**
	 * Propiedades
	 */
	private $id;
	private $modelo;
	private $firmware;
	private $firmware2;
	private $firmwareFile;
	private $firmwareFile2;
	private $empId;
	private $wifi5g;
	private $wifi2g;
	private $mta;
	private $oid1;
	private $oid1Value;
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
			$query="SELECT * FROM cable_modem_docsis WHERE cmd_id = ".$g;
			$res=Db::listar($query)[0];
			$this->id=$res['cmd_id'];
			$this->modelo=$res['cmd_modelo'];
			$this->firmware=$res['cmd_firmware'];
			$this->firmware2=$res['cmd_firmware2'];
			$this->firmwareFile=$res['cmd_firmware_file'];
			$this->firmwareFile2=$res['cmd_firmware_file2'];
			$this->empId=$res['emp_id'];
			$this->wifi5g=$res['cmd_wifi_5g'];
			$this->wifi2g=$res['cmd_wifi_2g'];
			$this->mta=$res['cmd_mta'];
			$this->oid1=$res['cmd_oid1'];
			$this->oid1Value=$res['cmd_oid1_value'];
		}
	}
	/**
	 * Getters ..
	 */
	public function getId(){
	 	return $this->id;
	}
	public function getModelo(){
		return $this->modelo;
	}
	public function getFirmware(){
		return $this->firmware;
	}
	public function getFirmware2(){
		return $this->firmware2;
	}
	public function getFirmwareFile(){
		return $this->firmwareFile;
	}
	public function getFirmwareFile2(){
		return $this->firmwareFile2;
	}
	public function getEmpId(){
		return $this->empId;
	}
	public function getWifi5G(){
		return $this->wifi5g;
	}
	public function getWifi2G(){
		return $this->wifi2g;
	}
	public function getMTA(){
		return $this->mta;
	}
	public function getOID1(){
		return $this->oid1;
	}
	public function getOID1Value(){
		return $this->oid1Value;
	}
	/**
	 * Setters ...
	 */
	public function setId($id){
		$this->id=$id;
	}
	public function setModelo($nM){
		$this->modelo=$nM;
	}
	public function setFirmware($nF){
		$this->firmware=$nF;
	}
	public function setFirmware2($nF2){
		$this->firmware2=$nF2;
	}
	public function setFirmwareFile($nFF){
		$this->firmwareFile=$nFF;
	}
	public function setFirmwareFile2($nFF2){
		$this->firmwareFile2=$nFF2;
	}
	public function setEmpId($nEI){
		$this->empId=$nEI;
	}
	public function setWifi5G($nWF5){
		$this->wifi5g=$nWF5;
	}
	public function setWifi2G($nWF2){
		$this->wifi2g=$nWF2;
	}
	public function setMTA($nMTA){
		$this->mta=$nMTA;
	}
	public function setOID1($nOID1){
		$this->oid1=$nOID1;
	}
	public function setOID1Value($nOID1V){
		$this->oid1Value=$nOID1V;
	}
	/**
	 * Actualiza la tabla "cable_modem_docsis" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=Conexion::conectar();
		$query="UPDATE `cable_modem_docsis`
				SET
				`cmd_modelo` = :modelo,
				`cmd_firmware` = :firmware,
				`cmd_firmware2` = :firmware2,
				`cmd_firmware_file` = :firmwareFile,
				`cmd_firmware_file2` = :firmwareFile2,
				`emp_id` = :empId,
				`cmd_wifi_5g` = :wifi5g,
				`cmd_wifi_2g` = :wifi2g,
				`cmd_mta` = :mta,
				`cmd_oid1` = :oid1,
				`cmd_oid1_value` = :oid1value
				WHERE `cmd_id` = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':modelo', $this->modelo, PDO::PARAM_STR);
		$stmt->bindParam(':firmware', $this->firmware, PDO::PARAM_STR);
		$stmt->bindParam(':firmware2', $this->firmware2, PDO::PARAM_STR);
		$stmt->bindParam(':firmwareFile', $this->firmwareFile, PDO::PARAM_STR);
		$stmt->bindParam(':firmwareFile2', $this->firmwareFile2, PDO::PARAM_STR);
		$stmt->bindParam(':empId', $this->empId, PDO::PARAM_INT);
		$stmt->bindParam(':wifi5g', $this->wifi5g, PDO::PARAM_INT);
		$stmt->bindParam(':wifi2g', $this->wifi2g, PDO::PARAM_INT);
		$stmt->bindParam(':mta', $this->mta, PDO::PARAM_INT);
		$stmt->bindParam(':oid1', $this->oid1, PDO::PARAM_STR);
		$stmt->bindParam(':oid1value', $this->oid1Value, PDO::PARAM_INT);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	/**
	 * Inserta nuevo registro a la tabla "cable_modem_docsis" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectar();
		$query="INSERT INTO `cable_modem_docsis`
				(`cmd_modelo`,
				`cmd_firmware`,
				`cmd_firmware2`,
				`cmd_firmware_file`,
				`cmd_firmware_file2`,
				`emp_id`,
				`cmd_wifi_5g`,
				`cmd_wifi_2g`,
				`cmd_mta`,
				`cmd_oid1`,
				`cmd_oid1_value`)
				VALUES
				(:modelo,
				:firmware,
				:firmware2,
				:firmwareFile,
				:firmwareFile2,
				:empId,
				:wifi5g,
				:wifi2g,
				:mta,
				:oid1,
				:oid1value)";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':modelo', $this->modelo, PDO::PARAM_STR);
		$stmt->bindParam(':firmware', $this->firmware, PDO::PARAM_STR);
		$stmt->bindParam(':firmware2', $this->firmware2, PDO::PARAM_STR);
		$stmt->bindParam(':firmwareFile', $this->firmwareFile, PDO::PARAM_STR);
		$stmt->bindParam(':firmwareFile2', $this->firmwareFile2, PDO::PARAM_STR);
		$stmt->bindParam(':empId', $this->empId, PDO::PARAM_INT);
		$stmt->bindParam(':wifi5g', $this->wifi5g, PDO::PARAM_INT);
		$stmt->bindParam(':wifi2g', $this->wifi2g, PDO::PARAM_INT);
		$stmt->bindParam(':mta', $this->mta, PDO::PARAM_INT);
		$stmt->bindParam(':oid1', $this->oid1, PDO::PARAM_STR);
		$stmt->bindParam(':oid1value', $this->oid1Value, PDO::PARAM_INT);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "cable_modem_docsis" filtrado por ID ...
	 */
	public function borraPorId($ID){
		$con=Conexion::conectar();
		$query = "DELETE FROM cable_modem_docsis WHERE cmd_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
	}
}