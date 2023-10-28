<?php
/**
 * @author : José Luis Villaronga
 * @copyright : 2014
 */
class Db
{
	/***********************************************************************************
	 * Método constructor "privado" para evitar instancias de esta clase ...           *
	 ***********************************************************************************/
	private function __construct(){}
	/***********************************************************************************
	 * Lista todas las filas del Query que le pase como parametro ...                  *
	 ***********************************************************************************/
	static function listar($query){
		$con = Conexion::conectar();
		$sql = "SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;".$query."; SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ;";
		$stmt = $con->prepare($query);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchALL();
	}
	/***********************************************************************************
	 * Lista todas las filas del Query que le pase como parametro ...                  *
	 ***********************************************************************************/
	static function listarLocal($query){
		$con = Conexion::conectarLocal();
		$sql = "SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;".$query."; SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ;";
		$stmt = $con->prepare($query);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchALL();
	}
	/***********************************************************************************
	 * Lista todas las filas del Query que le pase como parametro en el SERVIDOR ...                  *
	 ***********************************************************************************/
	static function listarServer($query){
		$con = Conexion::conectarServer();
		$sql = $query;
		$stmt = $con->prepare($query);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchALL();
	}
	/***********************************************************************************
	 * Lista todas las filas del Query que le pase como parametro en CDR ...                  *
	 ***********************************************************************************/
	static function listarCDR($query){
		$con = Conexion::conectarCDR();
		$sql = $query;
		$stmt = $con->prepare($query);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchALL();
	}
	/***********************************************************************************
	 * Lista la vista "articulos_vista" filtrando por parametro el campo "nombre"...   *
	 ***********************************************************************************/
	static function listarArtPorNombre($query){
		$con = Conexion::conectarCDR();
		$sql = "SELECT art_id,articulo
				FROM articulos_vista
				WHERE articulo = '$query'
				ORDER BY articulo";
		$stmt = $con -> prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt -> execute();
		return $stmt -> fetchALL();
	}
	/***********************************************************************************
	 * Lista la vista "articulos_vista" filtrando por parametro el campo "nombre"...   *
	 ***********************************************************************************/
	static function listarArtPorNombre2($query){
		$con = Conexion::conectarCDR();
		$sql = "SELECT art_id,articulo
				FROM articulos_rp_vista
				WHERE articulo = '$query'
				ORDER BY articulo";
		$stmt = $con -> prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt -> execute();
		return $stmt -> fetchALL();
	}
	/**
	 * 
	 */
	static function listaRepaArt(){
		return self::listarCDR(Query::$qRepaArt);
	}
	/***********************************************************************************
	 * Lista campos "art_id" y "articulo" de la vista "articulos_vista" ...            *
	 ***********************************************************************************/
	static function listaRepaArticulo(){
		return $q=self::listarCDR(Query::$qRepaArticulo);
	}
	/***********************************************************************************
	 * Lista campos "emp_id" y "emp_razon_social" de la tabla "empresas" ...           *
	 ***********************************************************************************/
	static function listaEmpresas(){
		return $q=self::listarCDR(Query::$qEmpresas);
	}
	/***********************************************************************************
	 * Lista campos "falla_id" y "falla_nombre" de la tabla "fallas" ...               *
	 ***********************************************************************************/
	static function listaFallas(){
		return $q=self::listarCDR(Query::$qFallas);
	}
	/***********************************************************************************
	 * Lista campos "cat_id", "cat_nombre", "falla_id" y " falla_nombre" de las tablas *
	 * "fallas" y "categoria" filtrando las categorias "Todas" y la que le pase por    *
	 * parametro ...                                                                   *
	 ***********************************************************************************/
	static function listarFallaDeCategoria($cat){
		$con = Conexion::conectarCDR();
		if(empty($cat)){ $cat=0; }
		$query = "SELECT categoria.cat_id,cat_nombre,falla_id,falla_nombre 
					FROM fallas,categoria
					WHERE fallas.cat_id=categoria.cat_id
					AND categoria.cat_id IN(11,$cat)
					ORDER BY falla_nombre";
		$sql = $query;
		$stmt = $con -> prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt -> execute();
		return $stmt -> fetchALL();
	}
	/***********************************************************************************
	 * Lista campos "cli_grupo" (id) y "gru_nombre" de tabla "grupos" ...              *
	 ***********************************************************************************/
	static function listaGrupos(){
		return $q=self::listarCDR(Query::$qGrupo);
	}
	/***********************************************************************************
	 * Lista la tabla "grupos" filtrando por "cli_grupo" usando parametro como valor ..*
	 ***********************************************************************************/
	static function listaGrupoPorId($g){
		$query = "SELECT * FROM grupos WHERE cli_grupo = $g";
		return self::listarCDR($query);
	}
	/***********************************************************************************
	 * Lista tabla "empresas" filtrando por parametro "emp_razon_social" ...           *
	 ***********************************************************************************/
	static function listaEmpresaPorNombre($rSocial){
		$query = "SELECT * 
				FROM empresas
				WHERE emp_razon_social='$rSocial'";
		return self::listarCDR($query);
	}
	/***********************************************************************************
	 * Lista tabla "empresas" filtrando por parametro "emp_id" ...           *
	 ***********************************************************************************/
	static function listaEmpresaId($id){
		$query = "SELECT * 
				FROM empresas
				WHERE emp_id='$id'";
		return self::listarCDR($query);
	}
	/***********************************************************************************
	 * Lista la tabla "tarea" filtrando por "tar_id" usando parametro como valor ..*
	 ***********************************************************************************/
	static function listaTareaPorId($t){
		$query = "SELECT * FROM tarea WHERE tar_id = $t";
		return self::listarCDR($query);
	}
}
