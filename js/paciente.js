
	function hideSidebar(){

		var main =document.getElementById('pacienteMain');
		main.className = "";
		main.style.border=0;
		var sidebar=document.getElementById('pacienteSidebar');
		sidebar.className = "";
		sidebar.style.display='none';
		document.getElementById('hideButton').style.display='none';
		document.getElementById('showButton').style.display='block';
	}
	function showSidebar(){

		var main =document.getElementById('pacienteMain');
		main.className = "three_fourth";
		main.style.borderRight="2px dashed #5A7691";
		var sidebar=document.getElementById('pacienteSidebar');
		sidebar.className = "one_fourth last";
		sidebar.style.display='block';
		document.getElementById('showButton').style.display='none';
		document.getElementById('hideButton').style.display='block';
	}


	function cambiar(f){
		parent.jQuery.fancybox.close();
		document.getElementById('cambiar').style.display = "block";
		var formPopup = document.getElementById('popup-cambiar');
		var inputFotoName = document.createElement("input");
		inputFotoName.type = "hidden";
		inputFotoName.name = "info";
		inputFotoName.value = f;
		formPopup.appendChild(inputFotoName);

		popupDimmer = document.createElement("div");

		popupDimmer.style.width =  window.innerWidth + 'px';
		popupDimmer.style.height = window.innerHeight + 'px';
		popupDimmer.className = 'dimmer';

		popupDimmer.onclick = function(){
       		 document.body.removeChild(this);
	   		 document.getElementById('cambiar').style.display = "none";
    	}

    	document.body.appendChild(popupDimmer);
	}

	function div_hide(){
		document.getElementById('cambiar').style.display = "none";
		document.body.removeChild(popupDimmer);
	}
function loadEstudio(){

		cubre = document.createElement("div");

		cubre.style.width =  window.innerWidth + 'px';
		cubre.style.height = window.innerHeight + 'px';
		cubre.className = 'dimmer';

		var cambiar = document.getElementById('cargando').style.display = "block";
		document.body.appendChild(cubre);
}
function editEstado(id, editorB, val, cancel)
{
	var editor = document.getElementById(id);
	editor.isContentEditable;
	editor.style.outline="2px dashed #0090D2";
	editor.contentEditable = true;
	var botonEditar = document.getElementById(editorB);
	var botonValidar = document.getElementById(val);
	var botonCancelar = document.getElementById(cancel);
	botonValidar.style.display="inline-block";
	botonCancelar.style.display="inline-block";
	botonEditar.style.display="none";

}

function deleteLinea(id, num){

	var linea=document.getElementById(num).style;
	linea.visibility="hidden";
	linea.opacity=0;
	$.ajax({
               	 url: '/deleteLinea.php',
               	 data: {
               	 'id': id
               	 },
               	 type: 'POST'
               	  });

}
function editCancel(id, editorB, val, cancel){

	      document.execCommand('undo');
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

}

function validation(thisform){
   with(thisform)
   {
      if(validateFileExtension(fileToUpload, "valid_msg", "Solo se aceptan archivos JPG y PNG.",
      new Array("jpg","jpeg","png")) == false)
      {
         return false;
      }
      if(validateFileSize(fileToUpload,7548576, "valid_msg", "El archivo debe pesar menos de 7MB!")==false)
      {
         return false;
      }
   }
}
function validateFileExtension(component,msg_id,msg,extns)
{
   var flag=0;
   with(component)
   {
      var ext=value.substring(value.lastIndexOf('.')+1);
      for(i=0;i<extns.length;i++)
      {
         if(ext==extns[i])
         {
            flag=0;
            break;
         }
         else
         {
            flag=1;
         }
      }
      if(flag!=0)
      {
         document.getElementById(msg_id).innerHTML=msg;
         component.value="";
         component.style.backgroundColor="#eab1b1";
         component.style.border="thin solid #000000";
         component.focus();
         return false;
      }
      else
      {
         return true;
      }
   }
}
function validateFileSize(component,maxSize,msg_id,msg)
{
   if(navigator.appName=="Microsoft Internet Explorer")
   {
      if(component.value)
      {
         var oas=new ActiveXObject("Scripting.FileSystemObject");
         var e=oas.getFile(component.value);
         var size=e.size;
      }
   }
   else
   {
      if(component.files[0]!=undefined)
      {
         size = component.files[0].size;
      }
   }
   if(size!=undefined && size>maxSize)
   {
      document.getElementById(msg_id).innerHTML=msg;
      component.value="";
      component.style.backgroundColor="#eab1b1";
      component.style.border="thin solid #000000";
      component.focus();
      return false;
   }
   else
   {
      return true;
   }
}
function details_shim(a){if(!(a&&"nodeType"in a&&"tagName"in a))return details_shim.init();var b;if("details"==a.tagName.toLowerCase())b=a.getElementsByTagName("summary")[0];else if(a.parentNode&&"summary"==a.tagName.toLowerCase())b=a,a=b.parentNode;else return!1;if("boolean"==typeof a.open)return a.getAttribute("data-open")||(a.className=a.className.replace(/\bdetails_shim_open\b|\bdetails_shim_closed\b/g," ")),!1;var c=a.outerHTML||(new XMLSerializer).serializeToString(a),c=c.substring(0,c.indexOf(">")),
c=-1!=c.indexOf("open")&&-1==c.indexOf('open=""')?"open":"closed";a.setAttribute("data-open",c);a.className+=" details_shim_"+c;b.addEventListener?b.addEventListener("click",function(){details_shim.toggle(a)}):b.attachEvent&&b.attachEvent("onclick",function(){details_shim.toggle(a)});Object.defineProperty(a,"open",{get:function(){return"open"==this.getAttribute("data-open")},set:function(a){details_shim.toggle(this,a)}});for(b=0;b<a.childNodes.length;b++)if(3==a.childNodes[b].nodeType&&/[^\s]/.test(a.childNodes[b].data)){var c=
document.createElement("span"),d=a.childNodes[b];a.insertBefore(c,d);a.removeChild(d);c.appendChild(d)}}details_shim.toggle=function(a,b){b="undefined"===typeof b?"open"==a.getAttribute("data-open")?"closed":"open":b?"open":"closed";a.setAttribute("data-open",b);a.className=a.className.replace(/\bdetails_shim_open\b|\bdetails_shim_closed\b/g," ")+" details_shim_"+b};details_shim.init=function(){for(var a=document.getElementsByTagName("summary"),b=0;b<a.length;b++)details_shim(a[b])};
window.addEventListener?window.addEventListener("load",details_shim.init,!1):window.attachEvent&&window.attachEvent("onload",details_shim.init);

function showGal(){

var gal = document.getElementById("galFotos");
if(gal.style.display!="block"){
gal.style.display = "block";
}else{gal.style.display = "none";}
}
function openImage(e){

	var gal = document.getElementById("galFotos");
	document.getElementById("ttt").style.display="none";
	f = jQuery(e).clone().prop('id',"appendedImage");

	jQuery(f).prop( "onclick", null );
		jQuery(f).prop( "class", "picbig" );


	jQuery(f).appendTo(gal);


}
function closeGal(){

	document.getElementById("ttt").style.display="block";

	var gal = document.getElementById("galFotos");
	gal.style.display = "none";
	var appendedImage = document.getElementById('appendedImage');
	jQuery(appendedImage).remove();
	
}
function previousImage(){
		var appendedImage = document.getElementById('appendedImage');
		 var src=jQuery(appendedImagend).attr('src');
		var lastChar = src.substr(id.length - 1);
  if(lastChar > 1){
    lastChar--;
    src.slice(id.length - 1);
    jQuery(src).attr('src'+lastChar);
    }
  }
function nextImage(){
		var appendedImage = document.getElementById('appendedImage');
		 var src=jQuery(appendedImagend).attr('src');
		var lastChar = src.substr(id.length - 1);
  if(lastChar < 8){
    lastChar++;
    src.slice(id.length - 1);
    jQuery(src).attr('src'+lastChar);
    }
  }
