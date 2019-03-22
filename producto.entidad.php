<?php
class producto
{
	private $id;
	private $bodega;
	private $nombreproducto;
	private $cantidad;


	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}