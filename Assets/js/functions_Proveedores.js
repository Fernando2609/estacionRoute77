let tableProveedores;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function () { 

    tableProveedores = $("#tableProveedores").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
          url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
  
        ajax: {
          url: " " + base_url + "/Proveedores/getProveedores",
          dataSrc: "",
        },
  
        columns: [
          { data: "COD_PROVEEDOR" },
          { data: "RTN" },
          { data: "NOMBRES" },
          { data: "APELLIDOS" },
          { data: "EMAIL" },
          { data: "NOMBRE_EMPRESA" },
          { data: "TELEFONO" },
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
              columns: [1, 2, 3, 4, 5, 6, 7],
              modifier: {},
            },
          },
          {
            extend: "pdfHtml5",
            text: "<i class='fas fa-file-pdf'></i> PDF",
            titleAttr: "Exportar a PDF",
            className: "btn btn-danger mr-1 mb-2",
            filename: "PROVEEDORES",
            download: "open",
            orientation: "landscape",
            pageSize: "letter",
            title: "Reporte de Proveedores",
            customize: function (doc) {
              doc.content[1].margin = [0, 40, 120, 20];
              doc.content[0].margin = [0, 20, 0, 0];
              doc.content[0].alignment = "center";
              //orientacion vertical
              //doc.content[1].table.widths = [ '5%', '25%', '20%', '40%', '20%', '20%', '11%']
              //orientacion Horizontal
              doc.content[1].table.widths = [
                "15%",
                "20%",
                "20%",
                "30%",
                "17%",
                "10%",
                "7%",
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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










    if (document.querySelector("#formProveedores")) {
        let formProveedores=document.querySelector("#formProveedores");
        formProveedores.onsubmit=function(e){
            e.preventDefault();
            let strRTN = document.querySelector('#txtRTN').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strEmpresa = document.querySelector('#txtEmpresa').value;
            let strUbicacion = document.querySelector('#txtUbicacion').value;
           
    
            let intStatus = document.querySelector('#listStatus').value;
    
            if(strRTN == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || strEmpresa == '' || strUbicacion == '' )
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
            let ajaxUrl = base_url+'/Proveedores/setProveedores'; 
            let formData = new FormData(formProveedores);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){ 
                if(request.readyState == 4 && request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText); 
                    
                    if(objData.status)
                    { 
                        if (rowTable ==""){
                            tableProveedores.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent=strRTN;
                            rowTable.cells[2].textContent=strNombre;
                            rowTable.cells[3].textContent=strApellido;
                            rowTable.cells[4].textContent=strEmail;
                            rowTable.cells[5].textContent=strEmpresa;
                            rowTable.cells[6].textContent=intTelefono;
                            rowTable.cells[7].innerHTML=htmlStatus;
                            rowTable = ""; 
                        }   
                        $('#modalFormProveedores').modal("hide");
                            formProveedores.reset();
                            swal.fire("Proveedores", objData.msg ,"success");
                            //tableProveedores.api().ajax.reload();
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



},false);


 function fntViewInfo(idProveedores){
  console.log(idProveedores);  
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + "/Proveedores/getProveedor/" + idProveedores;
  request.open("GET",ajaxUrl,true);
  request.send();
   request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);
          //console.log(objData);
          if(objData.status)
          {
              /*console.log(objData.data.status); */
              let estadoUsuario = objData.data.COD_STATUS == 1 ? 
              '<span class="badge badge-success">Activo</span>' : 
              '<span class="badge badge-danger">Inactivo</span>'; 

              document.querySelector("#celRTN").innerHTML = objData.data.RTN;
              document.querySelector("#celNombre").innerHTML = objData.data.NOMBRES;
              document.querySelector("#celApellido").innerHTML = objData.data.APELLIDOS;
              document.querySelector("#celTelefono").innerHTML = objData.data.TELEFONO;
              document.querySelector("#celEmail").innerHTML = objData.data.EMAIL;
              document.querySelector("#celEmpresa").innerHTML = objData.data.NOMBRE_EMPRESA;
              document.querySelector("#celUbicacion").innerHTML = objData.data.UBICACION;
              document.querySelector("#celEstado").innerHTML = estadoUsuario;
              document.querySelector("#celFechaModificacion").innerHTML = objData.data.FECHA_MODIFICACION;
              document.querySelector("#celModificadoPor").innerHTML = objData.data.MODIFICADO_POR;
              document.querySelector("#celFechaCreacion").innerHTML = objData.data.FECHA_CREACION;
              document.querySelector("#celCreadoPor").innerHTML = objData.data.CREADO_POR;
              $('#modalViewProveedor').modal('show');
          }else{
              swal.fire("Error", objData.msg , "error");
          }
      }
  }  
}

function fntEditInfo(element,idProveedores){
  rowTable=element.parentNode.parentNode.parentNode;
  document.querySelector('#titleModal').innerHTML ="Actualizar Proveedor";
  document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
  document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-warning");
  document.querySelector('#btnText').innerHTML ="Actualizar";
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'/Proveedores/getProveedor/'+idProveedores;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);

          if(objData.status)
          {

              document.querySelector("#idProveedores").value = objData.data.COD_PERSONA;
              document.querySelector("#txtRTN").value = objData.data.RTN;
              document.querySelector("#txtNombre").value = objData.data.NOMBRES;
              document.querySelector("#txtApellido").value = objData.data.APELLIDOS;
              document.querySelector("#txtTelefono").value = objData.data.TELEFONO;
              document.querySelector("#txtEmpresa").value = objData.data.NOMBRE_EMPRESA;
              document.querySelector("#txtUbicacion").value = objData.data.UBICACION;
              document.querySelector("#txtEmail").value = objData.data.EMAIL;
    



               if(objData.data.COD_STATUS == 1){
                 document.querySelector("#listStatus").value = 1;
              }else{
                 document.querySelector("#listStatus").value = 2;
             }
              $('#listStatus').selectpicker('render'); 
          }
      }
      $('#modalFormProveedores').modal('show');
  } 
}


function fntDelInfo(idProveedores){

  swal.fire({
      title: "Eliminar el proveedor",
      text: "¿Realmente quiere eliminar el proveedor?",
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
          let ajaxUrl = base_url + '/Proveedores/delProveedor/';
          let strData = "idProveedores=" + idProveedores;
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
                      tableProveedores.api().ajax.reload();
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
    document.querySelector('#idProveedores').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-success");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Proveedor";
    document.querySelector("#formProveedores").reset();
    $('#modalFormProveedores').modal('show');
}

