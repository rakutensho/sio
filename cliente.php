<?php
// Template Name: cliente
get_header();

	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';

	?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<?php


//use WP commands to retrieve logged user

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
//get current page ID to get Cliente

$page_id= get_the_ID();

global $current_user;
$userRole = ($current_user->roles);
$role = current($userRole);

//CHECK FOR USER PACIENTES OR ADMIN 
if($role!='administrator'){
	echo '<h2><br><strong>Lo sentimos</strong>, no puedes acceder a esta página. <br> Contacta con soporte si se trata de un error</h2>';
}
else{
do_action('wp_menubar','menu');
//get Paciente Info
$query1="SELECT * FROM Cliente WHERE paginaCliente='$page_id'";
$row0=$wpdb->get_results($query1);


//start writing page
//Name
echo '<h2><br><br><b>Cliente: </b>'.ucfirst($row0[0]->nombre)." ".ucfirst($row0[0]->apellido1)." ".ucfirst($row0[0]->apellido2).'<br>';
echo '<h2><br><b>Clinica: </b>'.ucfirst($row0[0]->clinica).'</h2><br>';

$resumen= '<h2><br><u><b>Resumen Cliente:</b></u></h2><br><br>';

$resumen.= '<div style="background-color:#fbfbfa;border-radius: 6px; box-shadow: 0 0 5px #ccc; border:1px solid grey; padding:0 8px"><h4 class="big">Experiencia:<strong> '.$row0[0]->dato1.'</strong> </h4><h4 class="big">';
#fffdf5
$resumen.= 'Observa todos los casos:<strong> '.$row0[0]->dato6.' </strong>   </h4> <h4 class="big">';

$resumen.= 'Deriva: <strong>'.$row0[0]->dato8.' </strong> </h4> <h4 class="big">';

$resumen.= 'Da el servicio: <strong>'.$row0[0]->dato2.'</strong>  </h4><h4 class="big">';

if ($row0[0]->dato2=='Si'){

$resumen.= 'El servicio cuenta con: <strong> '.$row0[0]->dato4.'</strong> </h4> <h4 class="big">';

$resumen.= 'Visita a: <strong> '.$row0[0]->dato5.' </strong> </h4> <h4 class="big">';

$resumen.= 'Se realizan tratamientos: <strong> '.$row0[0]->dato7.' </h4><h4 class="big"></strong>';


$resumen.= 'Los problemas más frecuentes son:  <strong> '.$row0[0]->dato9.' </strong> </h4> <h4 class="big">';

$resumen.= 'Trabaja con especialista desde: <strong> '.$row0[0]->dato10.' </strong></h4> <h4 class="big">';

$resumen.= 'Cambió de ortodoncista: <strong>'.$row0[0]->dato12.' </strong> </h4> <h4 class="big">';

$resumen.= 'Razón de cambio: <strong> '.$row0[0]->dato13.' </strong> </h4> <h4 class="big">';}

$resumen.= 'Objetivos: <strong> '.$row0[0]->dato14.' </strong> </h4></div>';

echo do_shortcode('[three_fourth last="yes"]'.$resumen.'[/three_fourth]');






//query data from table PACIENTE with given id
$pCliente=$row0[0]->idCliente;
$query = "SELECT * FROM Paciente WHERE clienteID='$pCliente'";

//store two results for title and content in table

$result_array=$wpdb->get_results($query);

	//calculte rowlength and numrows

$numRows=count($result_array);

//Tell whether he has pacientes or not
if($numRows<1){
	echo '<h3 style="color:red;">Todavia no tiene pacientes.</h3>';
}
else{

echo '<h2><br><b><u>Lista pacientes:</u></b></h2><h4 style="float:right">'.$numRows.' Pacientes</h4><br><br>';

//open table and save it to variable to insert inside a tab

//TAB 1 => estado=1 => en tratamiento
//TAB 2 => estado=2 => accion req
//TAB 3 => estado=3 => arch

$tab1 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';
$tab2 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';
$tab3 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';

//table head, title row, row0

$tab1.='<th><u>Nombre</u></th><th><u>1er Apellido</u></th><th><u>2o Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab1.= '</tr></thead><tbody>';
$tab2.='<th><u>Nombre</u></th><th><u>1er Apellido</u></th><th><u>2o Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab2.= '</tr></thead><tbody>';
$tab3.='<th><u>Nombre</u></th><th><u>1er Apellido</u></th><th><u>2o Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab3.= '</tr></thead><tbody>';

for($i=0;$i<$numRows;$i++){
	$tmp=$result_array[$i]->estado;
	switch ($tmp){
		case 1:
			// Where to go when clicked
			if($result_array[$i]->firstCheck=='3'){
				$user_page='http://siodental.com/detalles-paciente/';
				$user_page.='?id='.$result_array[$i]->pageID.'&ref='.get_page_link($result_array[$i]->pageID);
			}else{
			$user_page=get_page_link($result_array[$i]->pageID);
				}

			$tab1.= '<tr style="cursor:pointer;cursor:hand" onclick='.'"document.location='."'$user_page'".'">';
			//nombre
			$tab1.= '<td>'.ucfirst($result_array[$i]->nombre).'</td>';
			//P. Ap
			$tab1.= '<td>'.ucfirst($result_array[$i]->apellido1).'</td>';
			//S. Ap
			$tab1.= '<td>'.ucfirst($result_array[$i]->apellido2).'</td>';
			//F. Alta
			$tab1.= '<td>'.$result_array[$i]->fechaAlta.'</td>';
			//Estado
			$tab1.= '<td>N/D</td>';
			//Close
			$tab1.= "</tr>";
			break;

		case 2:
			// Where to go when clicked
			$user_page=get_page_link($result_array[$i]->pageID);

			$tab2.= '<tr style="cursor:pointer;cursor:hand" onclick='.'"document.location='."'$user_page'".'">';
			//nombre
			$tab2.= '<td>'.ucfirst($result_array[$i]->nombre).'</td>';
			//P. Ap
			$tab2.= '<td>'.ucfirst($result_array[$i]->apellido1).'</td>';
			//S. Ap
			$tab2.= '<td>'.ucfirst($result_array[$i]->apellido2).'</td>';
			//F. Alta
			$tab2.= '<td>'.$result_array[$i]->fechaAlta.'</td>';
			//Estado
			$tab2.= '<td>N/D</td>';
			//Close
			$tab2.= "</tr>";
			break;

		case 3:
			// Where to go when clicked
			$user_page=get_page_link($result_array[$i]->pageID);

			$tab3.= '<tr style="cursor:pointer;cursor:hand" onclick='.'"document.location='."'$user_page'".'">';
			//nombre
			$tab3.= '<td>'.ucfirst($result_array[$i]->nombre).'</td>';
			//P. Ap
			$tab3.= '<td>'.ucfirst($result_array[$i]->apellido1).'</td>';
			//S. Ap
			$tab3.= '<td>'.ucfirst($result_array[$i]->apellido2).'</td>';
			//F. Alta
			$tab3.= '<td>'.$result_array[$i]->fechaAlta.'</td>';
			//Estado
			$tab3.= '<td>N/D</td>';
			//Close
			$tab3.= "</tr>";
			break;
	}

}
//table contents for given query, result_array

//close table

$tab1.= '</tbody></table>';
$tab2.= '</tbody></table>';
$tab3.= '</tbody></table>';



//do shortcode with vars storing tables

echo do_shortcode('[fusion_tabs layout="horizontal" justified="yes" backgroundcolor="" inactivecolor=""]
		'.'[fusion_tab title="<b> Acción de SIO Requerida </b>"]'.$tab1.'[/fusion_tab]'.'[fusion_tab title="<b>En Tratamiento</b>"]'.$tab2.'[/fusion_tab]'.'[fusion_tab title="<b> Archivados </b>"]'.$tab3.'[/fusion_tab]'.'[/fusion_tabs]');

}
}
echo'</br></br></br>';
get_footer();


?>

