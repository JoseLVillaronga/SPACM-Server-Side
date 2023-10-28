<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2015
 */
class Proveedor
{
	/**
	 * Propiedades
	 */
	public $id;
	private $nombre;
	private $rubro;
	private $direccion;
	private $telefono;
	private $fax;
	private $email;
	private $contacto;
	private $observaciones;
	private $fecha;
	public $usuario;
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
	public function __construct($c){
		if(empty($c)){
			$this->usuario=new Usuario($_SESSION['usuario']);
			return $this;
		}else{
			$query="SELECT * FROM repu_proveedores WHERE pr_id = $c";
			foreach(Db::listar($query) as $fila){
				$this->id=$fila['pr_id'];
				$this->nombre=$fila['pr_nombre'];
				$this->rubro=$fila['pr_rubro'];
				$this->direccion=$fila['pr_direccion'];
				$this->telefono=$fila['pr_tel'];
				$this->fax=$fila['pr_fax'];
				$this->email=$fila['pr_email'];
				$this->contacto=$fila['pr_contacto'];
				$this->observaciones=$fila['pr_observaciones'];
				$this->fecha=$fila['pr_fecha'];
				$this->usuario=new Usuario($fila['cli_usuario']);
			}
		}
	}
	/**
	 * Getters ...
	 */
	public function getId(){
		return $this->id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getRubro(){
		return $this->rubro;
	}
	public function getDireccion(){
		return $this->direccion;
	}
	public function getTelefono(){
		return $this->telefono;
	}
	public function getFax(){
		return $this->fax;
	}
	public function getEMail(){
		return $this->email;
	}
	public function getContacto(){
		return $this->contacto;
	}
	public function getObservaciones(){
		return $this->observaciones;
	}
	public function getFecha(){
		return $this->fecha;
	}
	/**
	 * Setters ...
	 */
	public function setId($nId){
		$this->id=$nId;
	}
	public function setNombre($nN){
		if(empty($nN)){
			$this->errores['nombre']="Hay que ingresar nombre ...";
			$this->errores['gen'] = "harError";
		}else{
			$this->nombre=$nN;
		}
	}
	public function setRubro($nR){
		if(empty($nR)){
			$this->rubro=NULL;
		}else{
			$this->rubro=$nR;
		}
	}
	public function setDireccion($nD){
		if(empty($nD)){
			$this->direccion=NULL;
		}else{
			$this->direccion=$nD;
		}
	}
	public function setTelefono($nT){
		if(empty($nT)){
			$this->telefono=NULL;
		}else{
			$this->telefono=$nT;
		}
	}
	public function setFax($nF){
		if(empty($nF)){
			$this->fax=NULL;
		}else{
			$this->fax=$nF;
		}
	}
	public function setEMail($nEM){
		if(empty($nEM)){
			$this->email=NULL;
		}else{
			$this->email=$nEM;
		}
	}
	public function setContacto($nC){
		if(empty($nC)){
			$this->contacto=NULL;
		}else{
			$this->contacto=$nC;
		}
	}
	public function setObservaciones($nO){
		if(empty($nO)){
			$this->observaciones=NULL;
		}else{
			$this->observaciones=$nO;
		}
	}
	public function setFecha($nF){
		$this->fecha=$nF;
	}
	/**
	 * Actualiza la tabla "repu_proveedores" con las propiedades actuales del objeto ...
	 */
	public function actualizaDb(){
		$con=Conexion::conectar();
		$query="UPDATE repu_proveedores
				SET
				pr_id = :id,
				pr_nombre = :nombre,
				pr_rubro = :rubro,
				pr_direccion = :direccion,
				pr_tel = :telefono,
				pr_fax = :fax,
				pr_email = :email,
				pr_contacto = :contacto,
				pr_observaciones = :observaciones,
				pr_fecha = :fecha,
				cli_usuario = :usuario
				WHERE pr_id = :id";
		$stmt = $con -> prepare($query);
		$usu = $this->usuario->getUsuario();
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt->bindParam(':rubro', $this->rubro, PDO::PARAM_STR);
		$stmt->bindParam(':direccion', $this->direccion, PDO::PARAM_STR);
		$stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
		$stmt->bindParam(':fax', $this->fax, PDO::PARAM_STR);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':contacto', $this->contacto, PDO::PARAM_STR);
		$stmt->bindParam(':observaciones', $this->observaciones, PDO::PARAM_STR);
		$stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
		$stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
	}
	/**
	 * Inserta nuevo registro a la tabla "repu_proveedores" usando las propiedades del Objeto ...
	 */
	public function agregaADb(){
		$con=Conexion::conectar();
		$query="INSERT INTO repu_proveedores
				(pr_id,
				pr_nombre,
				pr_rubro,
				pr_direccion,
				pr_tel,
				pr_fax,
				pr_email,
				pr_contacto,
				pr_observaciones,
				pr_fecha,
				cli_usuario)
				VALUES
				(null,
				:nombre,
				:rubro,
				:direccion,
				:telefono,
				:fax,
				:email,
				:contacto,
				:observaciones,
				:fecha,
				:usuario)";
		$stmt = $con -> prepare($query);
		$usu = $this->usuario->getUsuario();
		$stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
		$stmt->bindParam(':rubro', $this->rubro, PDO::PARAM_STR);
		$stmt->bindParam(':direccion', $this->direccion, PDO::PARAM_STR);
		$stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
		$stmt->bindParam(':fax', $this->fax, PDO::PARAM_STR);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':contacto', $this->contacto, PDO::PARAM_STR);
		$stmt->bindParam(':observaciones', $this->observaciones, PDO::PARAM_STR);
		$stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
		$stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
		$stmt -> execute();
		$this->errorSql = $stmt->errorInfo();
		$this->uFilaIns=$con->lastInsertId();
		$this->setId($this->uFilaIns);
	}
	/**
	 * Borra registro de la tabla "repu_proveedores" filtrado por ID ...
	 */
	public function borraPorId($ID){
		if(!isset($ID)){
			return $this;
		}
		$con=Conexion::conectar();
		$query = "DELETE FROM repu_proveedores WHERE pr_id = :id";
		$stmt = $con -> prepare($query);
		$stmt->bindParam(':id', $ID, PDO::PARAM_STR);
		$stmt -> execute();
		$this->uFilaIns=$con->lastInsertId();
	}
}