
$(".js-select2").each(function(){
    $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
    });
});
$('.parallax100').parallax100();
$('.gallery-lb').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled:true
        },
        mainClass: 'mfp-fade'
    });
});
$(".js-addcart-detail").on("click", function (e) {
  e.preventDefault();
});


$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		swal.fire(nameProduct, "¡Se agrego al carrito!", "success");
		//$(this).addClass('js-addedwish-b2');
		//$(this).off('click');
	});
});

$('.js-addwish-detail').each(function(){
    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function(){
        swal.fire(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-detail');
        $(this).off('click');
    });
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){
	let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
	let cant = 1;
	$(this).on('click', function(){
		let id = this.getAttribute('id');
		if(document.querySelector('#cant-product')){
			cant = document.querySelector('#cant-product').value;
		}
		if(this.getAttribute('pr')){
			cant = this.getAttribute('pr');
		}

		if(isNaN(cant) || cant < 1){
			swal.fire ("","La cantidad debe ser mayor o igual que 1" , "error");
			return;
		} 
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/addCarrito'; 
	    let formData = new FormData();
	    formData.append('id',id);
	    formData.append('cant',cant);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
        request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
                let objData=JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#productoCarrito").innerHTML=objData.htmlCarrito;
                   /*  document.querySelector(".cantCarrito").setAttribute("data-notify",objData.cantCarrito); */
                   const cants = document.querySelectorAll(".cantCarrito");
					cants.forEach(element => {
						element.setAttribute("data-notify",objData.cantCarrito)
					});
                    swal.fire(nameProduct, "Se agrego al carrito", "success");
                    
                }else{
                    swal.fire(nameProduct, objData.msg, "error");
                }
             }
             return false;
            }
    });
});
$('.js-pscroll').each(function(){
    $(this).css('position','relative');
    $(this).css('overflow','hidden');
    var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
    });

    $(window).on('resize', function(){
        ps.update();
    })
});

 /*==================================================================
    [ +/- num product ]*/
    $('.btn-num-product-down').on('click', function(){
        let numProduct = Number($(this).next().val());
        let idpr=this.getAttribute('idpr');
        if(numProduct > 0) $(this).next().val(numProduct - 1);
        let cant=$(this).next().val();
        if (idpr!=null) {
            fntUpdateCant(idpr,cant)
        }
    });

    $('.btn-num-product-up').on('click', function(){
        let numProduct = Number($(this).prev().val());
        let idpr=this.getAttribute('idpr');
        $(this).prev().val(numProduct + 1);
        let cant=$(this).prev().val();
        if (idpr!=null) {
            fntUpdateCant(idpr,cant)
        }
    });
//Actualizar producto
if(document.querySelector(".num-product")){
	let inputCant = document.querySelectorAll(".num-product");
	inputCant.forEach(function(inputCant) {
		inputCant.addEventListener('keyup', function(){
			let idpr = this.getAttribute('idpr');
			let cant = this.value;
			if(idpr != null){
		    	fntUpdateCant(idpr,cant);
		    }
		});
	});
};

/* REGISTRO POR MODAL */
if (document.querySelector("#formRegisterModal")) {
    let formRegisterModal = document.querySelector("#formRegisterModal");
    formRegisterModal.onsubmit=function(e){
        e.preventDefault();
      
        let strNombre = document.querySelector("#txtNombreModal").value;
        let strApellido = document.querySelector("#txtApellidoModal").value;
        let strEmail = document.querySelector("#txtEmailClienteModal").value;
        let intTelefono = document.querySelector("#txtTelefonoModal").value;
        /* let intTipousuario = document.querySelector('#listRolid').value; */
       /*  let intNacionalidad = document.querySelector('#listNacionalidadCliente').value;
        let intGenero = document.querySelector('#listGenero').value;
        let intEstadoC = document.querySelector('#listEstadoC').value;
        let strFechaN = document.querySelector('#fechaNacimiento').value;
         */

        if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '')
            {
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) {
            if (elementsValid[i].classList.contains('is-invalid')) {
                swal.fire("Atención", "Por favor verifique los campos en rojo.", "error");
                return false;
            }
        }
        
        divLoading.style.display="flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + "/Tienda/registroModal"; 
        let formData = new FormData(formRegisterModal);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){ 
            if(request.readyState == 4 && request.status == 200){
               /*  console.log(request.responseText); */
                let objData = JSON.parse(request.responseText); 
                
                if(objData.status)
                { 

                    $("#modalRegistro").modal("hide");

                    /* //window.location.reload(false);
                     swal.fire("Revisa tu Correo","Hemos enviado una contraseña a tu correo, verifica e inicia sesión con ella" , "success"); */
                    
                    swal
                      .fire({
                        title: "Revisa tu Correo",
                        text: "Hemos enviado una contraseña a tu correo, verifica e inicia sesión con ella",
                        icon: "success",
                        /* showCancelButton: true,
                                confirmButtonText: "Si, eliminar!",
                                cancelButtonText: "No, cancelar!", */
                        //closeOnConfirm: false,
                        //closeOnCancel: true,
                      })
                      .then((result) => {
                        if (result.isConfirmed) {
                          location.reload();
                        }
                      });
                      
                }else{
                    swal.fire("Error", objData.msg , "error");
                }
            
            }else{
                console.log('Error');
            }
            divLoading.style.display = "none";
            return false;
        }
    }
};


if (document.querySelector("#formRegister")) {
    let formRegister=document.querySelector("#formRegister");
    formRegister.onsubmit=function(e){
        e.preventDefault();
      
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmailCliente').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        /* let intTipousuario = document.querySelector('#listRolid').value; */
       /*  let intNacionalidad = document.querySelector('#listNacionalidadCliente').value;
        let intGenero = document.querySelector('#listGenero').value;
        let intEstadoC = document.querySelector('#listEstadoC').value;
        let strFechaN = document.querySelector('#fechaNacimiento').value;
         */

        if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '')
            {
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) {
            if (elementsValid[i].classList.contains('is-invalid')) {
                swal.fire("Atención", "Por favor verifique los campos en rojo.", "error");
                return false;
            }
        }
        
        divLoading.style.display="flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tienda/registro'; 
        let formData = new FormData(formRegister);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){ 
            if(request.readyState == 4 && request.status == 200){
               /*  console.log(request.responseText); */
                let objData = JSON.parse(request.responseText); 
                
                if(objData.status)
                {
                  //window.location.reload(false);
                  /* swal.fire(
                    "Revisa tu Correo",
                    "Se ha enviado una contraseña a tu correo, verifica e inicia sesión con ella para continuar con el pedido.",
                    "success"
                  ); */

                  swal
                    .fire({
                      title: "Revisa tu Correo",
                      text: "Hemos enviado una contraseña a tu correo, verifica e inicia sesión con ella",
                      icon: "success",
                      /* showCancelButton: true,
                                confirmButtonText: "Si, eliminar!",
                                cancelButtonText: "No, cancelar!", */
                      //closeOnConfirm: false,
                      //closeOnCancel: true,
                    })
                    .then((result) => {
                      if (result.isConfirmed) {
                        location.reload();
                      }
                    });
                }else{
                    swal.fire("Error", objData.msg , "error");
                }
            
            }else{
                console.log('Error');
            }
            divLoading.style.display = "none";
            return false;
        }
    }
};
/* //Funcion para traer la nacionalidad 
function fntNacionalidadCliente(){
    
    let ajaxUrl = base_url+'/Tienda/getSelectNacionalidadCliente';

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listNacionalidadCliente').innerHTML = request.responseText;
            document.querySelector('#listNacionalidadCliente').value=1;
            $('#listNacionalidadCliente').selectpicker('render');
        }
    }

}

//Funcion para traer el genero
function fntGeneroCliente(){
  
    let ajaxUrl = base_url+'/Tienda/getSelectGeneroCliente';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listGenero').innerHTML = request.responseText;
            document.querySelector('#listGenero').value=1;
            $('#listGenero').selectpicker('render');
        }
    }

}
//Funcion para traer el Estado Civil
function fnEstadoCCliente(){
  
    let ajaxUrl = base_url+'/Tienda/getSelectEstadoCCliente';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listEstadoC').innerHTML = request.responseText;
            document.querySelector('#listEstadoC').value=1;
            $('#listEstadoC').selectpicker('render');
        }
    }

}; */
if(document.querySelector(".methodpago")){

	let optmetodo = document.querySelectorAll(".methodpago");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
        	if(this.value == "Paypal"){
        		document.querySelector("#divpaypal").classList.remove("notBlock");
        		document.querySelector("#divtipopago").classList.add("notBlock");
        	}else{
        		document.querySelector("#divpaypal").classList.add("notBlock");
        		document.querySelector("#divtipopago").classList.remove("notBlock");
        	}
        });
    });
}

function fntdelItem(element) {
    //console.log(element);
    //Opcion 1 eliminar desde el modal
    //Opcion 2 eliminar desde el carrito
    let option=element.getAttribute("op");
    let idpr=element.getAttribute("idpr");
    if (option==1 || option==2) {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/delCarrito'; 
	    let formData = new FormData();
	    formData.append('id',idpr);
	    formData.append('option',option);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
        request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
                let objData=JSON.parse(request.responseText);
                 if (objData.status) {
                    if (option==1) {
                        document.querySelector("#productoCarrito").innerHTML=objData.htmlCarrito;
                        //document.querySelector(".cantCarrito").setAttribute("data-notify",objData.cantCarrito);
                       const cants = document.querySelectorAll(".cantCarrito");
                        cants.forEach(element => {
                            element.setAttribute("data-notify",objData.cantCarrito)
                        });
                        Swal.fire({
                            toast:true,
                            iconColor: 'white',
                            customClass: {
                              popup: 'colored-toast'
                            },
                            position: 'top-right',
                            icon: 'info',
                            title: objData.msg,
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                          })
                    }else{
                        element.parentNode.parentNode.remove();
                        document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
	        			document.querySelector("#totalCompra").innerHTML = objData.total;
                        document.querySelector("#envio").innerHTML = objData.envio;
                        if(document.querySelectorAll("#tblCarrito tr").length == 1){
	            			window.location.href = base_url;
	            		}
                        Swal.fire({
                            toast:true,
                            iconColor: 'white',
                            customClass: {
                              popup: 'colored-toast'
                            },
                            position: 'top-right',
                            icon: 'info',
                            title: objData.msg,
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                          })
                    }
                    //swal.fire(nameProduct, "Se agrego al carrito", "success");
                }else{
	        		swal("", objData.msg , "error");
                } 
             }
             return false;
            }
    }
}
function fntUpdateCant(pro,cant) {
  
    if(cant <= 0){
		document.querySelector("#btnComprar").classList.add("notBlock");
	}else{
		document.querySelector("#btnComprar").classList.remove("notBlock");
	 	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/updCarrito'; 
	    let formData = new FormData();
	    formData.append('id',pro);    
	   	formData.append('cantidad',cant);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	            let objData = JSON.parse(request.responseText);
	    		if(objData.status){
                    
	    			let colSubtotal = document.getElementsByClassName(pro)[0];
	    			colSubtotal.cells[4].textContent = objData.totalProducto;
	    			document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
	    			document.querySelector("#totalCompra").innerHTML = objData.total;
                    document.querySelector("#envio").innerHTML = objData.envio;
                    //swal.fire("",  , "success");
                    Swal.fire({
                        toast:true,
                        iconColor: 'white',
                        customClass: {
                          popup: 'colored-toast'
                        },
                        position: 'top-right',
                        icon: 'success',
                        title: objData.msg,
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                      })
	    		}else{
	    			swal.fire("", objData.msg , "error");
	    		}
	    	}

	    } 
	}
	return false; 
}

if(document.querySelector("#txtDireccion")){
	let direccion = document.querySelector("#txtDireccion");
	direccion.addEventListener('keyup', function(){
		let dir = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#txtCiudad")){
	let ciudad = document.querySelector("#txtCiudad");
	ciudad.addEventListener('keyup', function(){
		let c = this.value;
		fntViewPago();
	});
}
if(document.querySelector("#condiciones")){
	let opt = document.querySelector("#condiciones");
	opt.addEventListener('click', function(){
		let opcion = this.checked;
		if(opcion){
			document.querySelector('#optMetodoPago').classList.remove("notBlock");
		}else{
			document.querySelector('#optMetodoPago').classList.add("notBlock");
		}
	});
}
function fntViewPago(){
	let direccion = document.querySelector("#txtDireccion").value;
	let ciudad = document.querySelector("#txtCiudad").value;
	if(direccion == "" ||  ciudad == ""){
		document.querySelector('#divMetodoPago').classList.add("notBlock");
	}else{
		document.querySelector('#divMetodoPago').classList.remove("notBlock");
	}
}

if(document.querySelector("#btnComprar")){
	let btnPago = document.querySelector("#btnComprar");
	btnPago.addEventListener('click',function() { 
		let dir = document.querySelector("#txtDireccion").value;
	    let ciudad = document.querySelector("#txtCiudad").value;
	    let inttipopago = document.querySelector("#listtipopago").value; 
	    if( txtDireccion == "" || txtCiudad == "" || inttipopago =="" ){
			swal("", "Complete datos de envío" , "error");
			return;
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarVenta';
			let formData = new FormData();
		    formData.append('direccion',dir);    
		   	formData.append('ciudad',ciudad);
			formData.append('inttipopago',inttipopago);
		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/tienda/confirmarpedido/";
		    		}else{
		    			swal.fire("", objData.msg , "error");
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}

	},false);
   
}

    if(document.querySelector("#frmSuscripcion")){
        let frmSuscripcion = document.querySelector("#frmSuscripcion");
        frmSuscripcion.addEventListener('submit',function(e) { 
            e.preventDefault();
    
            let nombre = document.querySelector("#nombreSuscripcion").value;
            let email = document.querySelector("#emailSuscripcion").value;
           
    
            if(nombre == ""){
                swal.fire("", "El nombre es obligatorio" ,"error");
                return false;
            }
    
            if(!fntEmailValidate(email)){
                swal.fire("", "El email no es válido." ,"error");
                return false;
            }	
            
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? 
                        new XMLHttpRequest() : 
                        new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tienda/suscripcion';
            let formData = new FormData(frmSuscripcion);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return;
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal.fire("", objData.msg , "success");
                        document.querySelector("#frmSuscripcion").reset();
                    }else{
                        swal.fire("", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            
            } 
    
        },false);
    }

//FUncion de entero y longitud Telefono
function testEnteroTel(intCant) {
    var intCantidad = new RegExp(/^([0-9]{8})$/);
    if (intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email) {
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }  
}
function testText(txtString) {
  var stringText = new RegExp(
    /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü]+(\s[a-zA-ZÑñÁáÉéÍíÓóÚúÜü]+)*$/
  );
  if (stringText.test(txtString)) {
    return true;
  } else {
    return false;
  }
}function fntValidText() {
  let validText = document.querySelectorAll(".validText");
  validText.forEach(function (validText) {
    validText.addEventListener("keyup", function () {
      let inputValue = this.value;
      if (!testText(inputValue)) {
        this.classList.add("is-invalid");
        /*  this.classList.remove('is-valid'); */
      } else {
        this.classList.remove("is-invalid");
        /*       this.classList.add('is-valid'); */
      }
    });
  });
}
function fntValidEmail() {
  let validEmail = document.querySelectorAll(".validEmail");
  validEmail.forEach(function (validEmail) {
    validEmail.addEventListener("keyup", function () {
      let inputValue = this.value;
      if (!fntEmailValidate(inputValue)) {
        this.classList.add("is-invalid");
      } else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
      }
    });
  });
}
//Funcion validacion telefono
function fntValidNumberTel(){
    let validNumberTel = document.querySelectorAll(".validNumberTel");
    validNumberTel.forEach(function(validNumberTel) {
        validNumberTel.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testEnteroTel(inputValue)){
                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            
            }
        });
    });
}

   if (document.querySelector("#frmContacto")) {
     let frmContacto = document.querySelector("#frmContacto");
     frmContacto.addEventListener(
       "submit",
       function (e) {
         e.preventDefault();

         let nombre = document.querySelector("#nombreContacto").value;
         let email = document.querySelector("#emailContacto").value;
         let mensaje = document.querySelector("#mensaje").value;

         if (nombre == "") {
           swal.fire("", "El nombre es obligatorio", "error");
           return false;
         }

         if (!fntEmailValidate(email)) {
           swal.fire("", "El email no es válido.", "error");
           return false;
         }
        if (nombre=="") {
            swal.fire("", "Porfavor Escribe el mensaje", "error");
            return false;
        }
         divLoading.style.display = "flex";
         let request = window.XMLHttpRequest
           ? new XMLHttpRequest()
           : new ActiveXObject("Microsoft.XMLHTTP");
         let ajaxUrl = base_url + "/Tienda/contacto";
         let formData = new FormData(frmContacto);
         request.open("POST", ajaxUrl, true);
         request.send(formData);
         request.onreadystatechange = function () {
           if (request.readyState != 4) return;
           if (request.status == 200) {
             let objData = JSON.parse(request.responseText);
             if (objData.status) {
               swal.fire("", objData.msg, "success");
               document.querySelector("#frmContacto").reset();
             
             } else {
               swal.fire("", objData.msg, "error");
             }
            
           }
           divLoading.style.display = "none";
           return false;
         };
       },
       false
     );
   }
   
window.addEventListener(
  "load",
  function () {
    /*fnSucursalUsuario(); */

    fntEmailValidate();
    fntValidEmail();
    fntValidNumberTel();
    fntValidText();
  },
  false
);