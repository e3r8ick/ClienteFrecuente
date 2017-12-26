<?php  

//funcion que se llama para cargar las cias
function getCia(){
	//se instancia la clase de metodos y se retorna
	$metodos = new Metodos();
	return $metodos->get_ListaCodCia();
}

?>