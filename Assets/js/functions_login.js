$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});

//Capturar los datos del formulario
//document.addEventListener: Índica que se van a agregar todos los eventos que irán dentro de la función al moemnto de cargar todo el documento
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
//valida si existe el formulario del login
    if (document.querySelector("#formLogin")){

        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;
        
            if(strEmail=="" || strPassword=="")
            {
                swal.fire("Por favor", "Escribe usuario y contraseña.", "error");
                return false;
            }else{
				divLoading.style.display="flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/LoginUser';
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							//window.location = base_url+'/dashboard';
							window.location.reload(false);
						}else{
							swal.fire("Atención", objData.msg, "error");
							document.querySelector('#txtPassword').value = "";
						}
					}else{
						swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
            }            
        }     
    }
    if(document.querySelector("#formRecetPass")){		
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function(e) {
			e.preventDefault();

            let strEmail = document.querySelector('#txtEmailReset').value;
			if(strEmail == "")
			{
				swal.fire("Por favor", "Escribe tu correo electrónico.", "error");
				return false;
			}else{
				divLoading.style.display="flex";
                var request = (window.XMLHttpRequest) ? 
								new XMLHttpRequest() : 
								new ActiveXObject('Microsoft.XMLHTTP');
								
				var ajaxUrl = base_url+'/Login/resetPass'; 
				var formData = new FormData(formRecetPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
                    //console.log(request);
					if(request.readyState != 4) return;

					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal.fire({
								title: "Revisa tú Correo",
								text: objData.msg,
								//showDenyButton: true,
								icon: "success",
								confirmButtonText: "Aceptar",
								closeOnConfirm: false,
							}).then((result)=>{
								if (result.isConfirmed) {
									window.location = base_url;
									
								}
							});
						}else{
							swal.fire("Atención", objData.msg, "error");
						}
					}else{
						swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}	
            }
        } 
    }
	if(document.querySelector("#formCambiarPass")){
		let formCambiarPass = document.querySelector("#formCambiarPass");
		formCambiarPass.onsubmit = function(e) {
			e.preventDefault(); 
			let strPassword = document.querySelector('#txtPassword').value;
			let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
			let idUsuario = document.querySelector('#idUsuario').value;
			if(strPassword == "" || strPasswordConfirm == ""){
				swal.fire("Por favor", "Escribe la nueva contraseña." , "error");
				return false;
			}else{
				if(strPassword.length < 3 ){
					swal.fire("Atención", "La contraseña debe tener un mínimo de 3 caracteres." , "info");
					return false;
				}
				if(strPassword != strPasswordConfirm){
					swal.fire("Atención", "Las contraseñas no son iguales." , "error");
					return false;
				}
				divLoading.style.display="flex";
				var request = (window.XMLHttpRequest) ? 
							new XMLHttpRequest() : 
							new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url+'/Login/setPassword'; 
				var formData = new FormData(formCambiarPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal.fire({
								title: "Contraseña Actualizada",
								text: objData.msg,
								//showDenyButton: true,
								icon: "success",
								confirmButtonText: "Iniciar sessión",
								closeOnConfirm: false,
							}).then((result)=>{
								if (result.isConfirmed) {
									window.location = base_url+'/login';	
								}
							});
						}else{
							swal.fire("Atención",objData.msg, "error");
						}
					}else{
						swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
				}
			}
		}
	}
}, false);
