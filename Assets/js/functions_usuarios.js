let tableUsuarios;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.all
document.addEventListener('DOMContentLoaded',function () {
    tableUsuarios = $("#tableUsuarios").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },

      ajax: {
        url: " " + base_url + "/Usuarios/getUsuarios",
        dataSrc: "",
      },

      columns: [
        { data: "COD_USUARIO" },
        { data: "NOMBRES" },
        { data: "APELLIDOS" },
        { data: "EMAIL" },
        { data: "TELEFONO" },
        { data: "ROL" },
        { data: "status" },
        { data: "options" },
      ],
      dom:
        "<'row d-flex'<'col-sm-12 mb-2 col-md-5'l B><'col-md-7 mb-2 align-self-end'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: [
        {
          extend: "copyHtml5",
          text: "<i class='far-copy'></i> Copiar",
          titleAttr: "Copiar",
          className: "btn btn-secondary mr-1 mb-2",

          exportOptions: {
            margin: [0, 20, 20, 20],
            columns: [0, 1, 2, 3, 4, 5, 6],
            modifier: {},
          },
        },
        {
          extend: "excelHtml5",
          text: "<i class='fas fa-file-excel'></i> Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success mr-1 mb-2",
          excelStyles: [
            {
              template: "green_medium",
            },
            {
              cells: "2",
              style: {
                fill: {
                  pattern: {
                    type: "solid",
                    color: "3c6a8c",
                  },
                },
              },
            },
          ],
          exportOptions: {
            margin: [0, 20, 20, 20],
            columns: [0, 1, 2, 3, 4, 5, 6],
            modifier: {},
          },
        },
        {
          extend: "pdfHtml5",
          text: "<i class='fas fa-file-pdf'></i> PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger mr-1 mb-2",
          filename: "USUARIOS",
          download: "open",
          orientation: "landscape",
          pageSize: "letter",
          title: "Reporte de Usuarios",
          customize: function (doc) {
            doc.content[1].margin = [0, 40, 120, 20];
            doc.content[0].margin = [0, 20, 0, 0];
            doc.content[0].alignment = "center";
            //orientacion vertical
            //doc.content[1].table.widths = [ '5%', '25%', '20%', '40%', '20%', '20%', '11%']
            //orientacion Horizontal
            doc.content[1].table.widths = [
              "5%",
              "20%",
              "20%",
              "30%",
              "15%",
              "20%",
              "11%",
            ];
            doc.content[1].table.body[0].forEach(function (h) {
              //h.alignment='left';
              h.fillColor = "#81ae39";
              h.color = "white";
              h.fontSize = 12;
            });
            let cols = [];
            cols[0] = {
              image: imgB64,
              alignment: "left",
              margin: [20, 5, 10, 20],
              width: 100,
            };
            const fecha = new Date();
            cols[1] = {
              fontSize: 11,
              text: "ROUTE 77",
              alignment: "right",
              margin: [0, 20, 20, 100],
            };
            cols[2] = {
              fontSize: 11,
              text: fecha.toLocaleDateString("es-hn", {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric",
              }),
              alignment: "right",
              margin: [0, 20, 20, 0],
            };
            let objheader = {};
            objheader["columns"] = cols;
            doc["header"] = function (page) {
              if (page == 1) return objheader;
              else
                return (cols[2] = {
                  fontSize: 11,
                  text: fecha.toLocaleDateString(),
                  alignment: "right",
                  margin: [0, 20, 20, 0],
                });
            };
            // Splice the image in after the header, but before the table

            /* var cols2 = [];
                                  cols2[0] = {fontSize: 13,text:  , alignment: 'center', margin:[0,0,0,0] };
                                  
                                  var objfooter = {};
                                  objfooter['columns'] = cols2;*/
            doc["footer"] = function (currentPage, pageCount) {
              return {
                margin: 10,
                columns: [
                  {
                    fontSize: 10,
                    text: [
                      {
                        text:
                          "--------------------------------------------------------------------------" +
                          "\n",
                        margin: [0, 20],
                      },
                      {
                        text:
                          "Página " +
                          currentPage.toString() +
                          " de " +
                          pageCount,
                      },
                    ],
                    alignment: "center",
                  },
                ],
              };
            };
          },
          exportOptions: {
            margin: [0, 20, 20, 20],
            columns: [0, 1, 2, 3, 4, 5, 6],
            modifier: {},
          },
        },
        {
          extend: "csvHtml5",
          text: "<i class='fas fa-file-csv'></i> CSV",
          titleAttr: "Exportar a CSV",
          className: "btn btn-info mr-1 mb-2",
          exportOptions: {
            margin: [0, 20, 20, 20],
            columns: [0, 1, 2, 3, 4, 5, 6],
            modifier: {},
          },
        },
        {
          extend: "print",
          text: "<i class='fa fa-print'></i> Imprimir",
          titleAttr: "Imprimir",
          className: "btn btn-warning mr-1 mb-2",
          exportOptions: {
            margin: [0, 20, 20, 20],
            columns: [0, 1, 2, 3, 4, 5, 6],
            modifier: {},
          },
        },
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
      autoWidth: false,
      lengthMenu: [
        [10, 25, 50, -1],
        ["10 ", "25 ", "50 ", "Todo"],
      ],
    });
     if (document.querySelector("#formUsuario")) {
        let formUsuario=document.querySelector("#formUsuario");
        formUsuario.onsubmit=function(e){
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let intTipousuario = document.querySelector('#listRolid').value;
           
            let intGenero = document.querySelector('#listGenero').value;
            
            let strPassword = document.querySelector('#txtPassword').value;
            let intStatus = document.querySelector('#listStatus').value;
    
            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTipousuario == '' || intGenero == '' )
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
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){ 
                if(request.readyState == 4 && request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText); 
                    
                    if(objData.status)
                    { 
                        if (rowTable ==""){
                            tableUsuarios.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent=strNombre;
                            rowTable.cells[2].textContent=strApellido;
                            rowTable.cells[3].textContent=strEmail;
                            rowTable.cells[4].textContent=intTelefono;
                            rowTable.cells[5].textContent=document.querySelector("#listRolid").selectedOptions[0].text
                            rowTable.cells[6].innerHTML=htmlStatus;
                            rowTable = ""; 
                        }   
                        $('#modalFormUsuario').modal("hide");
                            formUsuario.reset();
                            swal.fire("Usuarios", objData.msg ,"success");
                            //tableUsuarios.api().ajax.reload();
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
    }
    //Actulizar desde perfil
    if (document.querySelector("#formPerfil")) {
        let formPerfil=document.querySelector("#formPerfil");
        formPerfil.onsubmit=function(e){
            e.preventDefault();
           // let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
  
            let intTelefono = document.querySelector('#txtTelefono').value;
           
           
            //let intGenero = document.querySelector('#listGenero').value;
         
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
           
    
            if(strApellido == '' || strNombre == '' ||  intTelefono == '')
                {
                    swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                    return false;
            }
            if(strPassword != "" || strPasswordConfirm != "")
            {   
                if( strPassword != strPasswordConfirm ){
                    swal.fire("Atención", "Las contraseñas no son iguales." , "info");
                    return false;
                }           
                if(strPassword.length < 5 ){
                    swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
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
            let ajaxUrl = base_url+'/Usuarios/putPerfil'; 
            let formData = new FormData(formPerfil);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){ 
                if(request.readyState != 4) return;
                if(request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText); 
                    
                    if(objData.status)
                    { 
                        $('#modalFormPerfil').modal("hide");
                         
                        swal.fire({
                            title: "",
                            text: objData.msg,
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }).then((result) => {
                            if (result.isConfirmed) {  
                                location.reload();
                            }
                        })
                        }else{
                            swal.fire("Error", objData.msg , "error");
                    }
                
                }
                divLoading.style.display = "none";
				return false;
            }
        }
        
    }
},false)

//Cargar las clases desde el load
window.addEventListener('load', function() {
    fntRolesUsuario();
     
     fntGeneroUsuario();
    
     fnSucursalUsuario();
}, false);
//Funcion para traer los roles de usuario
function fntRolesUsuario(){
    if ( document.querySelector('#listRolid')) {
        let ajaxUrl = base_url+'/Roles/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                
                document.querySelector('#listRolid').innerHTML = request.responseText;
                /* document.querySelector('#listRolid').value = 1; */
                $('#listRolid').selectpicker('render');
            }
        }
                    
    }
    
}

/* //Funcion para traer la nacionalidad 
function fntNacionalidadUsuario(){
  
    let ajaxUrl = base_url+'/Roles/getSelectNacionalidad';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listNacionalidad').innerHTML = request.responseText;
            document.querySelector('#listNacionalidad').value=1;
            $('#listNacionalidad').selectpicker('render');
        }
    }

} */
 if (document.querySelector("#listGenero")) {
//Funcion para traer el genero
function fntGeneroUsuario(){
  
    let ajaxUrl = base_url+'/Roles/getSelectGenero';
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

}}
/* //Funcion para traer el Estado Civil
function fnEstadoCUsuario(){
  
    let ajaxUrl = base_url+'/Roles/getSelectEstadoC';
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

} */

//Funcion para traer Las sucursales
function fnSucursalUsuario(){
  
    let ajaxUrl = base_url+'/Roles/getSelectSucursal';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listSucursal').innerHTML = request.responseText;
            document.querySelector('#listSucursal').value=1;
            $('#listSucursal').selectpicker('render');
        }
    }

}


function fntViewUsuario(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    $('#modalViewUser').modal('show');
     request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status)
            {
              let CREADO_POR =
                objData.data.CREADO_POR == null
                  ? "Registro en Tienda"
                  : objData.data.CREADO_POR;
              let MODIFICADO_POR =
                objData.data.MODIFICADO_POR == null
                  ? "Sin Modificar"
                  : objData.data.MODIFICADO_POR;
               let estadoUsuario = objData.data.COD_STATUS == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celIdentificacion").innerHTML = objData.data.DNI;
                document.querySelector("#celNombre").innerHTML = objData.data.NOMBRES;
                document.querySelector("#celApellido").innerHTML = objData.data.APELLIDOS;
                document.querySelector("#celTelefono").innerHTML = objData.data.TELEFONO;
                document.querySelector("#celEmail").innerHTML = objData.data.EMAIL;
                document.querySelector("#celTipoUsuario").innerHTML = objData.data.ROL;
                
                document.querySelector("#celGenero").innerHTML = objData.data.GENERO;
                document.querySelector("#celSucursal").innerHTML = objData.data.SUCURSAL;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.FECHA_CREACION;
                document.querySelector("#celCreadoPor").innerHTML = objData.data.CREADO_POR;
                document.querySelector("#celDateModificado").innerHTML = objData.data.FECHA_MODIFICACION;
                document.querySelector("#celModPor").innerHTML = objData.data.MODIFICADO_POR; 
                document.querySelector("#celDateLogin").innerHTML = objData.data.DATE_LOGIN;  
                $('#modalViewUser').modal('show');
            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }
    } 
}
function fntEditUsuario(element,idUsuario){
    rowTable=element.parentNode.parentNode.parentNode;
    //console.log(rowTable);
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-warning");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idUsuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {

                document.querySelector("#idUsuario").value = objData.data.COD_PERSONA;
                document.querySelector("#txtIdentificacion").value = objData.data.DNI;
                document.querySelector("#txtNombre").value = objData.data.NOMBRES;
                document.querySelector("#txtApellido").value = objData.data.APELLIDOS;
                document.querySelector("#txtTelefono").value = objData.data.TELEFONO;
                document.querySelector("#txtEmail").value = objData.data.EMAIL;
                document.querySelector("#listRolid").value =objData.data.COD_ROL;
                document.querySelector("#listSucursal").value =objData.data.COD_SUCURSAL;
                document.querySelector("#listGenero").value =objData.data.COD_GENERO;
              
               
                $('#listRolid').selectpicker('render');
                $('#listGenero').selectpicker('render');
                $('#listGenero').selectpicker('render');
                $('#listSucursal').selectpicker('render');
                if(objData.data.COD_STATUS == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
        $('#modalFormUsuario').modal('show');
    } 
}

function fntDelUsuario(idUsuario){

    swal.fire({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar el Usuario?",
        icon: "warning",
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        },
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Usuarios/delUsuario/';
            let strData = "idUsuario=" + idUsuario;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal.fire({
                            title: "Eliminar!",
                            text: objData.msg,
                            icon: "success",
                            showClass: {
                                popup: 'animate__animated animate__flipInY'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__flipOutY'
                            }
                        });
                        tableUsuarios.api().ajax.reload();
                    } else {
                        swal.fire("Atención!", objData.msg, "error");
                    }
    
                }
            }
        }
    });
 }
 


function openModal()
{
    rowTable = "";
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-success");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}
function openModalPerfil() {
    $('#modalFormPerfil').modal('show');
}
