<?php
// Template Name: perfil
	get_header();
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

//create MENU
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
header('Location: http://siodental.com/mobile');

do_action('wp_menubar','menu');
?>
<br>
<br>
<?php
//connect with wp global constants
//output error
global $wpdb;
//use WP commands to retrieve logged user

$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();

//get current user role

global $current_user;
$userRole = ($current_user->roles);
$role = current($userRole);

//ADMIN PAGE-----------------------------------------------------------

if($role=='administrator'){
$isAdmin=true;
}

if($isAdmin){
$query_admin = $wpdb->get_results("SELECT nombre,apellido1,apellido2,clinica,paginaCliente FROM Cliente");

$rowNum=count($query_admin);
//table with ALL clientes
echo '<h2 style="color:red"><u>Administrador</u></h2><h2><br><br><b>Listado de todos los Clientes:</b></h2><h4 style="float:right">'.$rowNum.' Clientes</h4><br><br>';

//TABLE
?>
<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable" ><thead>
<tr><th><u>Clinica</u></th>
<th><u>P. Apellido</u></th>
<th><u>S. Apellido</u></th>
<th><u>Nombre</u></th>
<th><u>Necesita atención</u></th></tr></thead><tbody>
<?php
for($i=0;$i<$rowNum;$i++){
//if ($result_admin_array[$i]['atencion']==1){$result_admin_array[$i]['atencion']="Si";}else{$result_admin_array[$i]['atencion']="No";}

$user_page=get_page_link($query_admin[$i]->paginaCliente);

echo '<tr style="cursor:pointer;cursor:hand" onclick='.'"document.location='."'$user_page'".'">';

echo "<td>".ucfirst($query_admin[$i]->clinica)."</td>";
echo "<td>".ucfirst($query_admin[$i]->apellido1)."</td>";
echo "<td>".ucfirst($query_admin[$i]->apellido2)."</td>";
echo "<td>".ucfirst($query_admin[$i]->nombre)."</td>";
echo "<td>"."N/D"."</td></tr>";
}
echo '</tbody></table>';
}

//USER PAGE------------------------------------------------------------

else{

//check if info form is needed to be filled

if(!($resultado_form = $wpdb->get_results("SELECT * FROM Cliente WHERE idCliente='$current_user_id'")))
{
    echo '<h2>Bienvenido a SIO. </br>Para proporcionar respuestas adecuadas necesitamos más datos, por favor rellene el siguiente formulario.</h2>';
    echo '<form action="http://siodental.com/formulario-de-alta-de-cliente/"><input class="button small default comment-submit blue" name="submit" type="submit" id="submit" value="Formulario"></form>';

}else{
	
$nombre_apellidos=$wpdb->get_results("SELECT nombre, apellido1 FROM Cliente WHERE idCliente='$current_user_id'");

//Greeting
echo '<br><h2>Bienvenido a tu dashboard, </h2><h2 style="color:#3B5998;">'.ucfirst($resultado_form[0]->nombre) ." ".ucfirst($nombre_apellidos[0]->apellido1).".</h2><br>";

echo '<hr>';
//query data from table PACIENTE with given id
$query = "SELECT * FROM Paciente WHERE clienteID='$current_user_id'";

//store two results for title and content in table

$row0=$wpdb->get_results($query);
$result_array=$wpdb->get_results($query);

//calculte rowlength and numrows

$numRows=count($row0);

//Tell whether he has pacientes or not
if($numRows<1){
    echo '<h3>Todavia no has añadido a ningun paciente.</h3>';
}
else{
echo '<br><h2>Tus pacientes con tratamiento en curso:</h2><h4 style="float:right">'.$numRows.' Pacientes</h4><br><br>';

//open table and save it to variable to insert inside a tab

//TAB 1 => estado=1 => en tratamiento
//TAB 2 => estado=2 => accion req
//TAB 3 => estado=3 => arch

$tab1 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';
$tab2 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';
$tab3 = '<table cellpadding="10" cellspacing="0" class="table table-striped table-hover sortable"><thead><tr>';

//table head, title row, row0

$tab1.='<th><u>Nombre</u></th><th><u>P. Apellido</u></th><th><u>S. Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab1.= '</tr></thead><tbody>';
$tab2.='<th><u>Nombre</u></th><th><u>P. Apellido</u></th><th><u>S. Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab2.= '</tr></thead><tbody>';
$tab3.='<th><u>Nombre</u></th><th><u>P. Apellido</u></th><th><u>S. Apellido</u></th><th><u>Fecha de Alta</u></th><th><u>Estado actual</u></th>';
$tab3.= '</tr></thead><tbody>';

for($i=0;$i<$numRows;$i++){
	$tmp=$result_array[$i]->estado;
	switch ($tmp){
		case 1:
			// Where to go when clicked
			$user_page=get_page_link($result_array[$i]->pageID);

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

echo do_shortcode('[fusion_tabs layout="horizontal" justified="no" backgroundcolor="" inactivecolor=""]
		'.'[fusion_tab title="<b>En Tratamiento</b>"]'.$tab1.'[/fusion_tab]'.'[fusion_tab title="<b> Acción Requerida </b>"]'.$tab2.'[/fusion_tab]'.'[fusion_tab title="<b>Archivados</b>"]'.$tab3.'[/fusion_tab]'.'[/fusion_tabs]');

//Add a new Paciente button

echo '<form style="float:right" action="http://siodental.com/formulario-de-alta-paciente/"><input class="button small default comment-submit blue" name="submit" type="submit" id="submit" value="Añadir un nuevo Paciente"></form>';
}
}
}

get_footer();
?>
