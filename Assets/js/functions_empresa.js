let tableEmpresa;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {
      tableEmpresa = $("#tableEmpresa").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
          url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },

        ajax: {
          url: " " + base_url + "/Empresa/getEmpresas",
          dataSrc: "",
        },

        columns: [
          { data: "COD_EMPRESA" },
          { data: "NOMBRE_EMPRESA" },
          { data: "DIRECCION_FACTURA" },
          { data: "COSTO_ENVIO" },
          { data: "EMAIL_EMPRESA" },
          { data: "GERENTE_GENERAL" },
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
            filename: "EMPRESA",
            download: "open",
            orientation: "landscape",
            pageSize: "letter",
            title: "Reporte de Empresa",
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



if (document.querySelector("#formEmpresa")) {
        let formUsuario=document.querySelector("#formEmpresa");
        formEmpresa.onsubmit=function(e){
            e.preventDefault();
            let strNombreEmpresa = document.querySelector('#txtNombreEmpresa').value;
            let strDireccion = document.querySelector('#txtDireccion').value;
            let strRazonSocial = document.querySelector('#txtRazonSocial').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let strGerenteGeneral = document.querySelector('#txtGerenteGeneral').value;
           let strCatBanner = document.querySelector("#txtCatBanner").value;
            let strCatSlider = document.querySelector("#txtCatSlider").value;
          banner = strCatBanner.substring(strCatBanner.length - 1,strCatBanner.length);
          slider = strCatBanner.substring(strCatBanner.length - 1, strCatBanner.length);

          if (isNaN(banner)) {
              swal.fire(
                "Atención",
                "Erro en Categorías Banner",
                "error"
              );
            return false;
          }
          if (isNaN(slider)) {
            swal.fire("Atención", "Erro en Categorías Slider", "error");
            return false;
          }
           
    
            if(strNombreEmpresa == '' || strDireccion == '' || strRazonSocial == '' || strEmail == '' || strGerenteGeneral == '' )
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
            let ajaxUrl = base_url+'/Empresa/setEmpresa'; 
            let formData = new FormData(formEmpresa);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){ 
                if(request.readyState == 4 && request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText); 
                    
                    if(objData.status)
                    { 
                      tableEmpresa.api().ajax.reload();
                        /* if (rowTable ==""){
                            tableEmpresa.api().ajax.reload();
                        }else{
                            
                            rowTable.cells[1].textContent=strNombre;
                            rowTable.cells[2].textContent=strApellido;
                            rowTable.cells[3].textContent=strEmail;
                            rowTable.cells[4].textContent=intTelefono;
                            rowTable.cells[5].textContent=document.querySelector("#listRolid").selectedOptions[0].text
                            rowTable.cells[6].innerHTML=htmlStatus;
                            rowTable = ""; 
                        }  */  
                        $('#modalFormEmpresa').modal("hide");
                            formEmpresa.reset();
                            swal.fire("Empresa", objData.msg ,"success");
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


},false)



function fntEditInfo(element,idUsuario){
    rowTable=element.parentNode.parentNode.parentNode;
    //console.log(rowTable);
    document.querySelector('#titleModal').innerHTML ="Actualizar Empresa";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-warning");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Empresa/getEmpresa/'+idUsuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status)
            {

                document.querySelector("#idUsuario").value = objData.data.COD_EMPRESA;
                 document.querySelector("#txtNombreEmpresa").value =
                   objData.data.NOMBRE_EMPRESA;
                 document.querySelector("#txtDireccion").value =
                   objData.data.DIRECCION_FACTURA;
                 document.querySelector("#txtRazonSocial").value =
                   objData.data.RAZON_SOCIAL;
                 document.querySelector("#txtEmail").value =
                   objData.data.EMAIL_EMPRESA;
                 document.querySelector("#txtGerenteGeneral").value =
                   objData.data.GERENTE_GENERAL;
                 document.querySelector("#txtCostoEnvio").value =
                   objData.data.COSTO_ENVIO;
                 document.querySelector("#txtRTN").value = objData.data.RTN;
                 document.querySelector("#txtEmailPedidos").value =
                   objData.data.EMAIL_PEDIDOS;
                 document.querySelector("#txtTelEmpresa").value =
                   objData.data.TEL_EMPRESA;
                 document.querySelector("#txtCelEmpresa").value =
                   objData.data.CEL_EMPRESA;
                 /* document.querySelector("#celDirecciónFactura").value =
                   objData.data.DIRECCION_FACTURA; */
                 document.querySelector("#txtCatSlider").value =
                   objData.data.CATEGORIAS_SLIDER;
                 document.querySelector("#txtCatBanner").value =
                   objData.data.CATEGORIAS_BANNER;
              
               
              
            }
        }
        $('#modalFormEmpresa').modal('show');
    } 
}
function fntViewInfo(idpersona) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Empresa/getEmpresa/" + idpersona;
  request.open("GET", ajaxUrl, true);
  request.send();
  $("#modalViewUser").modal("show");
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      console.log(objData);
      if (objData.status) {
        document.querySelector("#celNombreEmpresa").innerHTML =
          objData.data.NOMBRE_EMPRESA;
        document.querySelector("#celDireccion").innerHTML =
          objData.data.DIRECCION_FACTURA;
        document.querySelector("#celRazonSocial").innerHTML =
          objData.data.RAZON_SOCIAL;
        document.querySelector("#celEmail").innerHTML = objData.data.EMAIL_EMPRESA;
        document.querySelector("#celGerenteGeneral").innerHTML =
          objData.data.GERENTE_GENERAL;
          document.querySelector("#celCostoEnvio").innerHTML =
            objData.data.COSTO_ENVIO;
             document.querySelector("#celRTN").innerHTML =
               objData.data.RTN;
             document.querySelector("#celEmailPedidos").innerHTML =
               objData.data.EMAIL_PEDIDOS;
           document.querySelector("#celTelefonoEmpresa").innerHTML =
             objData.data.TEL_EMPRESA;
           document.querySelector("#celCelularEmpresa").innerHTML =
             objData.data.CEL_EMPRESA;
               document.querySelector("#celCatSlider").innerHTML =
                 objData.data.CATEGORIAS_SLIDER;
                 document.querySelector("#celCatBanner").innerHTML =
                   objData.data.CATEGORIAS_BANNER;
        $("#modalViewEmpresa").modal("show");
      } else {
        swal.fire("Error", objData.msg, "error");
      }
    }
  };
}
function fntDelInfo(idUsuario){

    swal.fire({
        title: "Eliminar Empresa",
        text: "¿Realmente quiere eliminar la Empresa?",
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
            let ajaxUrl = base_url + '/Empresa/delEmpresa/';
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
                        tableEmpresa.api().ajax.reload();
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
    document.querySelector('#titleModal').innerHTML = "Nueva Empresa";
    document.querySelector("#formEmpresa").reset();
    $('#modalFormEmpresa').modal('show');
}