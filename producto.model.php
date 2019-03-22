<?php
class ProductoModel
{
	private $pdo;
// conexión a la BD
	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		        
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
//Función para mostrar productos
	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM productos");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$produc = new producto();

				$produc->__SET('id', $r->id);
		
				$produc->__SET('bodega', $r->bodega);
				$produc->__SET('nombreproducto', $r->nombreproducto);
				$produc->__SET('cantidad', $r->cantidad);
		

				$result[] = $produc;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
// función para traer los productos al momento de editar
	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM productos WHERE id = ?");
			          

			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$produc = new producto();

			$produc->__SET('id', $r->id);
			$produc->__SET('bodega', $r->bodega);
			$produc->__SET('nombreproducto', $r->nombreproducto);
			$produc->__SET('cantidad', $r->cantidad);

			return $produc;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
// Función para borrar los productos
	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM productos WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
//función para actualizar los productos
	public function Actualizar(producto $data)
	{
		try 
		{
			$sql = "UPDATE productos SET 
						bodega            = ?, 
						nombreproducto = ?,
						cantidad = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('bodega'),
					$data->__GET('nombreproducto'),
					$data->__GET('cantidad'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
//Función para crear productos
	public function Registrar(producto $data)
	{
		try 
		{
		$sql = "INSERT INTO productos (bodega,nombreproducto,cantidad) 
		        VALUES (?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('bodega'),
				$data->__GET('nombreproducto'),
				$data->__GET('cantidad')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}