<?php
// Template Name: paciente
get_header();

//get current page ID to get Paciente

$page_id= get_the_ID();
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="<?php bloginfo(template_url); ?>/js/paciente.js"></script>

<script>
function editValidate(id, editorB, val, cancel){

	var editor = document.getElementById(id);

	editor.isContentEditable;
	editor.style.outline="0";

	editor.contentEditable = false;
	var botonEditar = document.getElementById(editorB);
	var botonValidar = document.getElementById(val);
	var botonCancelar = document.getElementById(cancel);
	botonValidar.style.display="none";
	botonEditar.style.display="inline-block";
	botonCancelar.style.display="none";
		switch(id){
			case 'EstadoEditable':
				var content=$('#' + id).html();
					$.ajax({
						type: 'POST',
               	 		url: '/estado.php',
			   	 		data: {
			   	 		'change': content, 'id': <?php echo $page_id;?>
			   		 	}

			   		 });
			break;

			case 'editDiagnostico':
				var content=$('#diagText').html();
				$.ajax({
						type: 'POST',
               	 		url: '/box.php',
			   	 		data: {
			   	 		'change': content, 'id': <?php echo $page_id;?>, 'box': 'diagFicha'
			   		 	}

			   		 });

			break;

			case 'editTratamiento':
				var content=$('#tratText').html();
				$.ajax({
						type: 'POST',
               	 		url: '/box.php',
			   	 		data: {
			   	 		'change': content, 'id': <?php echo $page_id;?>, 'box': 'tratFicha'
			   		 	}

			   		 });
			break;

			case 'editAvisos':
				var content=$('#avisosText').html();
				$.ajax({
						type: 'POST',
               	 		url: '/box.php',
			   	 		data: {
			   	 		'change': content, 'id': <?php echo $page_id;?>, 'box': 'avisosFicha'
			   		 	}

			   		 });
			break;

		}


}

</script>

<style>details,summary{display:block}details.details_shim_closed>*{display:none}details.details_shim_closed>summary,details.details_shim_open>summary{display:block}details.details_shim_closed>summary:before{display:none;}details.details_shim_open>summary:before{display:none;}</style>
	<?php
//paciente template
//connect with wp global constants
//output error
global $wpdb;
//use WP commands to retrieve logged user

session_start();

//get current Page URL
$currentPage = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

//STORE PACIENTE ID FOR ESTUDIO

$_SESSION['pageID'] = $page_id;
$current_user_id = wp_get_current_user()->ID;
$_SESSION['c']=$current_user_id;
session_write_close();
//check rights to see this Paciente

$query0="SELECT * FROM Paciente WHERE pageID='$page_id' AND clienteID='$current_user_id'";
$result0=$wpdb->get_results($query0);



global $current_user;
$userRole = ($current_user->roles);
$role = current($userRole);



if($role=='administrator'){
$isAdmin=true;
}


if(!empty($result0)&&!$isAdmin){
	echo '<h2><br><br><br><hr><strong>Lo sentimos</strong>, no puedes acceder a esta página... <hr><br> <br>Contacta con soporte si crees que se trata de un error: <br><br><a href="http://siodental.com/contacto">Haz click AQUÍ</a></h2>';

}
else{

do_action('wp_menubar','menu');
//get Paciente Info
$query1="SELECT * FROM Paciente WHERE pageID='$page_id'";
$row0=$wpdb->get_results($query1);


setlocale(LC_ALL, 'es_ES.UTF8');
$clean1=iconv('UTF-8', 'ASCII//TRANSLIT', $row0[0]->nombre);
$clean2=iconv('UTF-8', 'ASCII//TRANSLIT', $row0[0]->apellido1);
$clean3=iconv('UTF-8', 'ASCII//TRANSLIT', $row0[0]->apellido2);
$clean1 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean1);
$clean2 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean2);
$clean3 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean3);

//define images names

$prefix=$row0[0]->clienteID.'/'.$page_id.'/';
$prefixI=$prefix.'Iniciales/';
$prefixM=$prefix.'Modelos/';
$prefixR=$prefix.'Radiografias/';


//--------------------------- Start writing page
?>
<!-- POPUP FOR CHANGING IMAGES -->

<div id="cambiar">
	<form enctype="multipart/form-data" action="/upload.php?ref=<?php echo $currentPage;?>" id="popup-cambiar" method="post" name="form" onsubmit="return validation(this)">
	<img class="closeForm" src="/images/close.png" onclick ="div_hide()">
	<h2>Sube la nueva fotografía</h2>
	<hr>
	<input type="file" name="fileToUpload" id="fileToUpload">
	<br>
    <button class="btn btn-default" type="submit"  name="submit">Subir</button>
    <br>
    <div id="valid_msg"></div>
</form>
</div>
<div id="cargando">
	<img class="cargando" src= "http://siodental.com/wp-content/themes/Avada/images/loading.gif">
</div>




<!-- END OF POPUP -->
<?php
//--------------------------- ADMIN
//Name, clinic, Resumen
if ($role!='subscriber'){

?>



		<div id="pacienteMain" style="border-right:2px dashed #5A7691; height:100%; padding-right:12px;" class="three_fourth">
		<button class="btn btn-default" id="hideButton" onclick="hideSidebar()"></button>
		<button class="btn btn-default" id="showButton" onclick="showSidebar()"></button>
		<br><br><div style="float:left;"><a href=""><img src="/img.php?show=<?php echo $prefixI; ?>/1/A2" style="max-height:160px;max-width:160px;" ></a></div><div style="margin-left:160px;">

<?php
		echo '<div style="display:inline-block; margin-left:15px;"><h2 style="color:#3B5998;"><b>Paciente: </b></h2><h2>   '.ucfirst($row0[0]->nombre)." ".ucfirst($row0[0]->apellido1)." ".ucfirst($row0[0]->apellido2).'<br>';
		echo '<br><b>Clinica: </b>'.ucfirst($row0[0]->nClinica).'  <b><br><br>Edad: </b>'.$row0[0]->age.'<br>';


//Resumen (180 chars)
//Default value for resumen has to be changed to "A la espera de SIO."
		echo '</h2><h2 style="color:#3B5998;"><b><br>Estado: </b></h2><h2 id="EstadoEditable">'.$row0[0]->resumen.'</h2>';?>
		<button class="btn btn-default btn-pencilEditor" id="editorBtn" type="button" onclick="editEstado('EstadoEditable', 'editorBtn', 'validarBtn', 'cancelarBtn')"></button>
		<button class="btn btn-default btn-validarEditor" id="validarBtn" type="button" onclick="editValidate('EstadoEditable', 'editorBtn', 'validarBtn', 'cancelarBtn')"></button>
		<button class="btn btn-default btn-cancelarEditor" id="cancelarBtn" type="button" onclick="editCancel('EstadoEditable', 'editorBtn', 'validarBtn', 'cancelarBtn')"></button>


<?php
		echo '</div></div><br><br>';
//Gallery

		echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-2">';

?>
	<table id="registros" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'A';
			$k=0;
			for($i=0; $i<3; $i++){
				echo '<tr>';
				for($j=0; $j<3; $j++){
					$k++;
					if($k==5){
						$j++;
						echo '<td class="fg_thumbnail">';
						echo '<img src="/centerP.png"/></td>';
					}
					echo '<td class="fg_thumbnail">';
					echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$k.'">';
					echo '<img src="/img.php?show='.$prefixA.$k.'"/></a>';
					echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$k.')" ></button></td>';

				}
				echo '</tr>';
			}

		?>
	</table>

		<?php

		echo '</div></div><a href="#fancyboxID-2" class="fancybox-inline"><input class="button small default comment-submit blue" name="submit" type="submit" id="submit" value="Registros inciales"></a>';
		?>


<!--FOTOS INICIALES
	PHP- contar num folders dentro de prefixI
	PHP- crear loop for en funcion del tamaño 
	cada paso crea una table prefixI.'/1', prefixI.'/2' ...
	COMO SE ESCONDE Y MUESTRA??
	bottom links basados en $i counter
	-->

<div id="galFotos">

<button class="btn btn-default" onclick="renderGallery(<?php echo $current_user_id.', '.$page_id.', \'Iniciales\', \'1\', \'A\'';?>)">GAL</button>

	<button class="closeButton" onclick="closeGal()">close</button>
</div>
<button class="btn btn-default" onclick="previousImage()">prev</button>
<button class="btn btn-default" onclick="nextImage()">next</button>



		<?php
		echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-3">';

	?>
		<table id="modelos" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'A';
			$k=0;
			for($i=0; $i<3; $i++){
				echo '<tr>';
				for($j=0; $j<3; $j++){
					$k++;
					if($k==5){
						$j++;
						echo '<td class="fg_thumbnail">';
						echo '<img src="/centerP.png"/></td>';
					}
					echo '<td class="fg_thumbnail">';
					echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$k.'">';
					echo '<img src="/img.php?show='.$prefixA.$k.'"/></a>';
					echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$k.')" ></button></td>';

				}
				echo '</tr>';
			}

		?>
	</table>

		<?php
		echo '</div></div><a href="#fancyboxID-3" class="fancybox-inline"><input class="button small default comment-submit blue" style="margin-left:10px;" name="submit" type="submit" id="submit" value="Fotos de Modelos"></a>';

		echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-4">';

	?>
		<table id="radiografias" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'B';
			echo '<tr>';
			for($i=1; $i<3; $i++){
				echo '<td class="fg_thumbnail">';
				echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$i.'">';
				echo '<img src="/img.php?show='.$prefixA.$i.'"/></a>';
				echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$i.')" ></button></td>';

			}
			echo '</tr>';


		?>
	</table>

		<?php
		echo '</div></div><a href="#fancyboxID-4" class="fancybox-inline"><input class="button small default comment-submit blue" style="margin-left:10px;" name="submit" type="submit" id="submit" value="Radiografías"></a>';

		//separador cool
		echo '<div class="fusion-separator fusion-full-width-sep sep-shadow" style="background:radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-webkit-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-moz-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-o-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);margin-left: auto;margin-right: auto;margin-top:10px;margin-bottom:10px;"></div>';


		//creation study
if ($row0[0]->pdfTratamiento!=NULL){
    echo '<h2><br><b>Estudio disponible:</b>&nbsp&nbsp&nbsp</h2><a href="'.$row0[0]->pdfTratamiento.'"><input class="button small default    comment-submit blue" name="submit" type="submit" id="submit" value="Ver Estudio" onclick="loadEstudio()"></a>';
    echo ' ';
}

elseif ($row0[0]->pdfTratamiento==NULL){

    //Boton creacion estudio
    echo'<br><b>Solo admins:</b><br><a href="http://siodental.com/creacion-estudio/"><input class="button small default comment-submit blue" name="submit" type="submit" id="submit" value="Crear Estudio"></a>';
      }


?>
<br>
<br>
		<details>
		<summary style="padding:6px;">
			<h2>Resumen</h2>
		</summary><hr style="margin:6px;">

		<div class="insideDetails">

			<div style="background-color:white; width:47%; float:left; margin: 0 5px 8px 0;border:1px solid grey; padding:6px 6px 20px 6px;">
				<h2 style="color:#3B5998;"><b>Breve diagnóstico: </b></h2><h2><br><?php echo $row0[0]->problemas;?></h2>
			</div>
			<div style="background-color:white; width:47%; margin-botton:8px; float:left;border:1px solid grey; padding:6px 6px 20px 6px;">
				<h2 style="color:#3B5998;"><b>Resumen de tratamiento: </b></h2><h2><br><?php echo $row0[0]->tratamiento;?></h2>
			</div>
		</div>
		</details>

		<details ><summary style="padding:12px 6px;"><h2>Ficha</h2></summary><hr style="margin:3px 0;">
	<?php

		//Box titles
		echo '<div class="insideDetails">';
		echo '<div class="editableBoxTitle" style="margin-bottom:5px">Diagnóstico</div>';
		echo '<div class="editableBoxTitle" style="margin:0 8px 5px 8px">Tratamiento</div>';
		echo '<div class="editableBoxTitle" style="margin-bottom:5px">Avisos</div><br>';

		//First Box

		//text
		echo '<div class="editableBox" style="margin-bottom:5px" id="editDiagnostico"><p id="diagText">'.	$row0[0]->diagFicha;
		//buttons - edit, validate, cancel
		echo '</p><button class="btn btn-default btn-pencil" id="editBtnA" onclick="editEstado(\'editDiagnostico\',\'editBtnA\',\'validarBtnA\',\'cancelarBtnA\')"></button>
		<button style="position:absolute;top:0;right:22px;" class="btn btn-default btn-validarEditor" id="validarBtnA" type="button" onclick="editValidate(\'editDiagnostico\', \'editBtnA\', \'validarBtnA\', \'cancelarBtnA\')"></button>
		<button style="position:absolute;top:0;right:0;" class="btn btn-default btn-cancelarEditor" id="cancelarBtnA" type="button" onclick="editCancel(\'editDiagnostico\', \'editBtnA\', \'validarBtnA\', \'cancelarBtnA\')"></button></div>';


		//Second Box

		//text
		echo '<div class="editableBox" style="margin:0 8px 5px 8px;" id="editTratamiento"><p id="tratText">'.	$row0[0]->tratFicha;
		//buttons - edit, validate, cancel
		echo '</p><button class="btn btn-default btn-pencil" id="editBtnB" onclick="editEstado(\'editTratamiento\',\'editBtnB\',\'validarBtnB\',\'cancelarBtnB\')"></button>
		<button style="position:absolute;top:0;right:22px;" class="btn btn-default btn-validarEditor" id="validarBtnB" type="button" onclick="editValidate(\'editTratamiento\', \'editBtnB\', \'validarBtnB\', \'cancelarBtnB\')"></button>
		<button style="position:absolute;top:0;right:0;" class="btn btn-default btn-cancelarEditor" id="cancelarBtnB" type="button" onclick="editCancel(\'editTratamiento\', \'editBtnB\', \'validarBtnB\', \'cancelarBtnB\')"></button></div>';


		//Third Box

		//text
		echo '<div class="editableBox" style="margin-bottom:5px" id="editAvisos"><p id="avisosText">'.	$row0[0]->avisosFicha;
		//buttons - edit, validate, cancel
		echo '</p><button class="btn btn-default btn-pencil" id="editBtnC" onclick="editEstado(\'editAvisos\',\'editBtnC\',\'validarBtnC\',\'cancelarBtnC\')"></button>
		<button style="position:absolute;top:0;right:22px;"class="btn btn-default btn-validarEditor" id="validarBtnC" type="button" onclick="editValidate(\'editAvisos\', \'editBtnC\', \'validarBtnC\', \'cancelarBtnC\')"></button>
		<button style="position:absolute;top:0;right:0;"class="btn btn-default btn-cancelarEditor" id="cancelarBtnC" type="button" onclick="editCancel(\'editAvisos\', \'editBtnC\', \'validarBtnC\', \'cancelarBtnC\')"></button></div>';



			//lineas
			$query3 = "SELECT * FROM Ficha WHERE pacienteID='$page_id' ORDER BY STR_TO_DATE( fecha, '%d/%m/%y' ) ASC";
			$lineaCounter=0;

			//title
			$result2=$wpdb->get_results($query3);
			if(!empty($result2)){
				?>
				<table class="table table-condensed" style="width:100%;">
					<thead>
						<tr>
							<th>Fecha</th><th>Elást</th><th>Visita</th><th>Próxima Visita</th>
						</tr>
					</thead>
					<tbody>

				<?php
				foreach($result2 as $ficha){
					$lineaCounter++;
					if ($ficha->urgencia==1){
						echo '<tr id="linea'.$lineaCounter.'" style="color:red; transition: visibility 0.6s, opacity 0.6s linear;">';
					}else{
						echo '<tr id="linea'.$lineaCounter.'" style="transition: visibility 0.6s, opacity 0.6s linear;">';
					}
					echo '<td style="width:10%">'.$ficha->fecha.'</td>';
					echo '<td class="elasticosRow">'.$ficha->dato3.'</td>';
					echo '<td class="visitaRow">'.$ficha->dato1.'</td>';
					echo '<td>'.$ficha->dato2.'</td>';
					echo '<td><button style="float:right; display:block;" class="btn btn-default btn-cancelarEditor" type="button" onclick="deleteLinea('.$ficha->idPaso.', \'linea'.$lineaCounter.'\')"></button></tr>';
					}
				echo '</tbody></table>';
			}
	echo do_shortcode('[gravityform id=15  title=false]');

	?>

	</div>
	</details>
	</div>

	<div id="pacienteSidebar" class="one_fourth last">
			<br>
			<h2 style="color:#3B5998;"><b><u>Detalles del Paciente:</u></b></h2>
			<br>
			<br>
			<h4><?php echo $row0[0]->detalle;?></h4>
			<a class="button small default comment-submit blue" href="<?php echo $row0[0]->pdfDatos;?>">Mostrar más</a>

	</div>



<?php
//---------------------CLIENTE
}else{
?>
		<br><br><div style="display:inline-block"><a href=""><img src="/img.php?show=<?php echo $row0[0]->clienteID.'_'.$clean1.'_'.$clean2.'_'.$clean3; ?>_A2" style="max-height:160px;max-width:160px;" ></a>

<?php
		echo '<div style="display:inline-block; margin-left:15px;"><h2><b style="color:#3B5998;">Paciente: </b>   '.ucfirst($row0[0]->nombre)." ".ucfirst($row0[0]->apellido1)." ".ucfirst($row0[0]->apellido2).'<br>';
		echo '<br><b>Clinica: </b>'.ucfirst($row0[0]->nClinica).'  <b style="color:#3B5998;"><br><br>Edad: </b>'.$row0[0]->age.'<br>';

//Resumen (180 chars)
//Default value for resumen has to be changed to "A la espera de SIO."
		echo '<b><br>Estado: </b>'.$row0[0]->resumen.'</h2>';

		echo '</div></div><br><br>';
//Gallery

		echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-2">';

?>
	<table id="registros" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'A';
			$k=0;
			for($i=0; $i<3; $i++){
				echo '<tr>';
				for($j=0; $j<3; $j++){
					$k++;
					if($k==5){
						$j++;
						echo '<td class="fg_thumbnail">';
						echo '<img src="/centerP.png"/></td>';
					}
					echo '<td class="fg_thumbnail">';
					echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$k.'">';
					echo '<img src="/img.php?show='.$prefixA.$k.'"/></a>';
					echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$k.')" ></button></td>';

				}
				echo '</tr>';
			}

		?>
		<tr>
				<p><b><u>Aviso</u>: </b>Al cambiar un registro se notificará a un Administrador de SIO.</p>

		</tr>
	</table>

		<?php

		echo '</div></div><a href="#fancyboxID-2" class="fancybox-inline"><input class="button small default comment-submit blue" name="submit" type="submit" id="submit" value="Registros inciales"></a>';

	echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-3">';

	?>
		<table id="modelos" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'A';
			$k=0;
			for($i=0; $i<3; $i++){
				echo '<tr>';
				for($j=0; $j<3; $j++){
					$k++;
					if($k==5){
						$j++;
						echo '<td class="fg_thumbnail">';
						echo '<img src="/centerP.png"/></td>';
					}
					echo '<td class="fg_thumbnail">';
					echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$k.'">';
					echo '<img src="/img.php?show='.$prefixA.$k.'"/></a>';
					echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$k.')" ></button></td>';

				}
				echo '</tr>';
			}

		?>
		<tr>
				<p><b><u>Aviso</u>: </b>Al cambiar un registro se notificará a un Administrador de SIO.</p>

		</tr>
	</table>

		<?php
		echo '</div></div><a href="#fancyboxID-3" class="fancybox-inline"><input class="button small default comment-submit blue" style="margin-left:10px;" name="submit" type="submit" id="submit" value="Fotos de Modelos"></a>';

		echo '<div style="display:none" class="fancybox-hidden"><div id="fancyboxID-4">';


	?>
		<table id="radiografias" border="2" cellspacing="3" width="470">
		<col width="150">
		<col width="150">
		<col width="150">
		<?php
			$prefixA=$prefix.'B';
			echo '<tr>';
			for($i=1; $i<3; $i++){
				echo '<td class="fg_thumbnail">';
				echo '<a class="fancybox image" href="/img.php?show='.$prefixA.$i.'" onclick="">';
				echo '<img src="/img.php?show='.$prefixA.$i.'"/></a>';
				echo '<button class="btn btn-default btn-pencil"  onclick="cambiar('.$prefixA.$i.')" ></button></td>';

			}
			echo '</tr>';


		?>
		<tr>
				<p><b><u>Aviso</u>: </b>Al cambiar un registro se notificará a un Administrador de SIO.</p>

		</tr>
	</table>

		<?php
		echo '</div></div><a href="#fancyboxID-4" class="fancybox-inline"><input class="button small default comment-submit blue" style="margin-left:10px;" name="submit" type="submit" id="submit" value="Radiografías"></a>';

		//separador cool
		echo '<div class="fusion-separator fusion-full-width-sep sep-shadow" style="background:radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-webkit-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-moz-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-o-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);margin-left: auto;margin-right: auto;margin-top:40px;margin-bottom:40px;"></div>';
		if ($row0[0]->pdfTratamiento==NULL){
			echo'<h2>Estamos revisando el caso y le avisaremos cuando el diagnóstico esté listo.</h2><br><br>';
			echo'<h2><b>Gracias por confiar en SIO.</b></h2></br>';
		}

		//For both Clientes and admins
		//PDF estudio paciente (if exists)
		if ($row0[0]->pdfTratamiento!=NULL){
		echo '<h2><br><b>Estudio disponible:</b>&nbsp&nbsp&nbsp</h2><a href="'.$row0[0]->pdfTratamiento.'"><input class="button small 			default comment-submit blue" name="submit" type="submit" id="submit" value="Ver Estudio" onclick="loadEstudio()"></a>';
		echo ' ';

		}
		echo '<div class="fusion-separator fusion-full-width-sep sep-shadow" style="background:radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-webkit-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-moz-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);background:-o-radial-gradient(ellipse at 50% -50% , #e0dede 0px, rgba(255, 255, 255, 0) 80%) repeat scroll 0 0 rgba(0, 0, 0, 0);margin-left: auto;margin-right: auto;margin-top:40px;margin-bottom:40px;"></div>';
?>	<br>
		<div style="border-radius: 6px; box-shadow: 0 0 5px #ccc;width:45%; float:left; margin-right:5px;border:1px solid grey; padding:6px 6px 20px 6px">
			<h2 style="color:#3B5998;"><b>Breve diagnóstico: </b></h2><h2><br><?php echo $row0[0]->problemas;?></h2>
		</div>
		<div style="border-radius: 6px; box-shadow: 0 0 5px #ccc;width:45%; float:left;border:1px solid grey; padding:6px 6px 20px 6px">
			<h2 style="color:#3B5998;"><b>Resumen de tratamiento: </b></h2><h2><br><?php echo $row0[0]->tratamiento;?></h2>

		</div>
		<br>

<?php

	}
//----------------------- Fin página
}

?>

<?php
get_footer();




?>
