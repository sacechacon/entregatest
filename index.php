<?php
//llamamos a los archivos .php externos
require_once 'producto.entidad.php';
require_once 'producto.model.php';

// Logica
$produc = new producto();
$model = new ProductoModel();

//condicionales y un switch con las funciones a realizar
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$produc->__SET('id',              $_REQUEST['id']);
			$produc->__SET('bodega',            $_REQUEST['bodega']);
			$produc->__SET('nombreproducto',   $_REQUEST['nombreproducto']);
			$produc->__SET('cantidad', 		$_REQUEST['cantidad']);

			$model->Actualizar($produc);
			header('Location: index.php');
			break;

		case 'registrar':

			$produc->__SET('bodega',            $_REQUEST['bodega']);
			$produc->__SET('nombreproducto', $_REQUEST['nombreproducto']);
			$produc->__SET('cantidad', $_REQUEST['cantidad']);

			$model->Registrar($produc);
			header('Location: index.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: index.php');
			break;

		case 'editar':
			$produc = $model->Obtener($_REQUEST['id']);
			break;
	}
}

?>
<!-- Dibujamos el formulario -->
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Anexsoft</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $produc->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id" value="<?php echo $produc->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                 
                        <tr>
                            <th style="text-align:left;">Bodega</th>
                            <td>
                                <select name="bodega" style="width:100%;">
                                    <option value="1" <?php echo $produc->__GET('bodega') == 1 ? 'selected' : ''; ?>>Bodega 1</option>
                                    <option value="2" <?php echo $produc->__GET('bodega') == 2 ? 'selected' : ''; ?>>Bodega 2</option>
                                </select>
                            </td>
                        </tr>
						<tr>
                            <th style="text-align:left;">Producto</th>
                            <td><input type="text" name="nombreproducto" value="<?php echo $produc->__GET('nombreproducto'); ?>" style="width:100%;" /></td>
                        </tr>
						<tr>
                            <th style="text-align:left;">Cantidad</th>
                            <td><input type="text" name="cantidad" value="<?php echo $produc->__GET('cantidad'); ?>" style="width:100%;" /></td>
                        </tr>
					
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
           
                            <th style="text-align:left;">Bodega</th>
							<th style="text-align:left;">Producto</th>
							<th style="text-align:left;">Cantidad</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>

                            <td><?php echo $r->__GET('bodega'); ?></td>
							<td><?php echo $r->__GET('nombreproducto'); ?></td>
							<td><?php echo $r->__GET('cantidad'); ?></td>
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
              
            </div>
        </div>

    </body>
</html>