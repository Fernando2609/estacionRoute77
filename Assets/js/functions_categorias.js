let tableCategorias;
let rowTable = "";

document.addEventListener('DOMContentLoaded',function(){
    tableCategorias = $('#tableCategorias').dataTable(  {
        "aProcessing":true, 
        "aServerSide":true,
        "language": {   
             "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
           },
        
           "ajax":{
            "url": " "+base_url+"/Categorias/getCategorias",
            "dataSrc":""
              },
        
                "columns": [
                    {"data":"COD_CATEGORIA"},
                    {"data":"NOMBRE"},
                    {"data":"DESCRIPCION"},
                    {"data":"status"},
                    {"data":"options"}
                   
                  ],
                    'dom': "<'row d-flex'<'col-sm-12 mb-2 col-md-5'l B><'col-md-7 mb-2 align-self-end'f>>"+ "<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    'buttons': [
                        {
                            "extend": "copyHtml5",
                            "text": "<i class='far-copy'></i> Copiar",
                            "titleAttr": "Copiar",
                            "className": "btn btn-secondary mr-1 mb-2",
                            
                           
                            exportOptions: {

                                margin: [0, 20,20,20],
                                columns: [ 0, 1, 2, 3],
                                  modifier: {
                                  }
                              }
                        }, {
                            "extend": "excelHtml5",
                            "text": "<i class='fas fa-file-excel'></i> Excel",
                            "titleAttr": "Exportar a Excel",
                            "className": "btn btn-success mr-1 mb-2",
                            "excelStyles": [
                                {
                                    "template": "green_medium"
                                },
                                {
                                    "cells": "2",
                                    "style": {
                                        "fill": {
                                            "pattern": {
                                                "type": "solid",
                                                "color": "3c6a8c"
                                            }
                                        }
                                    }
                                }
                            ],
                            exportOptions: {
                   
                                margin: [0, 20,20,20],
                                columns: [ 0, 1, 2, 3],
                                  modifier: {
                                  }
                              },
                              
                        }, {
                            "extend": "pdfHtml5",
                            "text": "<i class='fas fa-file-pdf'></i> PDF",
                            "titleAttr": "Exportar a PDF",
                            "className": "btn btn-danger mr-1 mb-2",
                            filename:'CATEGORIAS',
                            download:'open',
                            //orientation: 'landscape',
                            pageSize:'letter',
                            title:'Reporte de Categorías',
                            customize: function ( doc ) {
                                doc.content[1].margin = [ 0, 40, 120, 20 ]
                                doc.content[0].margin = [ 0, 20, 0, 0 ]
                                doc.content[0].alignment = 'center'
                                doc.content[1].alignment = 'left'
                                //orientacion vertical 
                                //doc.content[1].table.widths = [ '5%', '25%', '20%', '40%', '20%', '20%', '11%']
                                //orientacion Horizontal 
                                doc.content[1].table.widths = [ '5%', '35%', '60%', '30%']
                                doc.content[1].table.body[0].forEach(function(h){
                                  h.alignment='left';  
                                  h.fillColor = '#81ae39';
                                  h.color='white';
                                  h.fontSize=12;
                                })
                                let cols = [];
                                  cols[0] = { 
                                    image: imgB64                
                                    , alignment: 'left', margin:[20,5,10,20],width:100 };
                                  const fecha = new Date();
                                  cols[1] = {fontSize: 11,text: 'ROUTE 77' , alignment: 'right', margin:[0,20,20,100] };
                                  cols[2] = {fontSize: 11,text: fecha.toLocaleDateString('es-hn',{ weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' }) , alignment: 'right', margin:[0,20,20,0] }
                                  let objheader = {};
                                  objheader['columns'] = cols;
                                  doc['header']=function(page) { 
                                  if (page == 1) 
                                    return objheader
                                else
                                    return cols[2] = {fontSize: 11,text: fecha.toLocaleDateString() , alignment: 'right', margin:[0,20,20,0] }
                                 };
                                  // Splice the image in after the header, but before the table
                                  
                                  /* let cols2 = [];
                                  cols2[0] = {fontSize: 13,text:  , alignment: 'center', margin:[0,0,0,0] };
                                  
                                  let objfooter = {};
                                  objfooter['columns'] = cols2;*/
                                  doc['footer']= function(currentPage, pageCount) {
                                  return {
                                    margin:10,
                                    columns: [{
                                        fontSize: 10,
                                        text:[{
                                        text: '--------------------------------------------------------------------------'+'\n',
                                        margin: [0, 20]
                                        },
                                        {
                                        text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                                        }],
                                        alignment: 'center'
                                    }]
                                };
                    
                             }
                            }, exportOptions: {
                            
                                margin: [0, 20,20,20],
                                columns: [ 0, 1, 2, 3],
                                modifier: {
                                }
                            },
                                 
                        }, {
                            "extend": "csvHtml5",
                            "text": "<i class='fas fa-file-csv'></i> CSV",
                            "titleAttr": "Exportar a CSV",
                            "className": "btn btn-info mr-1 mb-2",
                            exportOptions: {

                                margin: [0, 20,20,20],
                                columns: [ 0, 1, 2, 3],
                                  modifier: {
                                  }
                              }
                        }, {
                            "extend": "print",
                            "text": "<i class='fa fa-print'></i> Imprimir",
                            "titleAttr": "Imprimir",
                            "className": "btn btn-warning mr-1 mb-2",
                            exportOptions: {

                                margin: [0, 20,20,20],
                                columns: [ 0, 1, 2, 3],
                                  modifier: {

                                  }
                              }
                        }
                    ],
                  "responsive":true,
                  "bDestroy":true,
                  "iDisplayLength": 10,
                  "order":[[0,"desc"]],
                  "autoWidth": false,
                  lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 ', '25 ', '50 ', 'Todo']
                ],
                
                
                  });
    if(document.querySelector("#foto")){
        let foto = document.querySelector("#foto");
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#foto").value;
            let fileimg = document.querySelector("#foto").files;
            let nav = window.URL || window.webkitURL;
            let contactAlert = document.querySelector('#form_alert');
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    foto.value="";
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        if(document.querySelector('#img')){
                            document.querySelector('#img').remove();
                        }
                        document.querySelector('.delPhoto').classList.remove("notBlock");
                        let objeto_url = nav.createObjectURL(this.files[0]);
                        document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
                    }
            }else{
                alert("No selecciono foto");
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }
    
    if(document.querySelector(".delPhoto")){
        let delPhoto = document.querySelector(".delPhoto");
        delPhoto.onclick = function(e) {
            document.querySelector("#foto_remove").value= 1; 
            removePhoto();
            
        }
    }
    //Nueva Categoria
    let formCategoria = document.querySelector("#formCategoria");
          formCategoria.onsubmit = function(e){
            e.preventDefault();

             let strNombre = document.querySelector('#txtNombre').value;
             let strDescripcion = document.querySelector('#txtDescripcion').value;
             let intStatus = document.querySelector('#listStatus').value;        
             if(strNombre == '' || strDescripcion == '' || intStatus == ''){
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
             }
                divLoading.style.display="flex";  
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');;
                let ajaxUrl = base_url+'/Categorias/setCategorias'; 
                let formData = new FormData(formCategoria);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                  if(request.readyState == 4 && request.status == 200){
                    //console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                   
                    //console.log(objData.status);
                    if(objData.status){

                        if(rowTable == ""){
                            tableCategorias.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ?
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                          
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strDescripcion;
                            rowTable.cells[3].innerHTML = htmlStatus;
                            rowTable = "";


                        }

                    $('#modalFormCategorias').modal("hide");
                    formCategoria.reset();
                    swal.fire("Categoría", objData.msg ,"success");
                    removePhoto();
                    
                    //toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                }else{
                      swal.fire("Error", objData.msg , "error");

                    }
                  }
                  divLoading.style.display = "none";
                  return false;
              }           
        }
     
},false);

function fntViewInfo(idcategoria){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.table(objData);
            if(objData.status)
            {
                let estado = objData.data.COD_STATUS == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celId").innerHTML = objData.data.COD_CATEGORIA;
                document.querySelector("#celNombre").innerHTML = objData.data.NOMBRE;
                document.querySelector("#celDescripcion").innerHTML = objData.data.DESCRIPCION;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';
                $('#modalViewCategoria').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
    }

function fntEditInfo(element,idcategoria){
    rowTable = element.parentNode.parentNode.parentNode;
    
    document.querySelector('#titleModal').innerHTML ="Actualizar Categoria";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-warning");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    
       
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl  =base_url+'/Categorias/getCategoria/'+idcategoria;
        request.open("GET",ajaxUrl,true);
        request.send();
        //console.log(request);
        request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
            
              let objData = JSON.parse(request.responseText);
              //console.log(request.responseText);
              if(objData.status)
              {
                  document.querySelector("#idCategoria").value = objData.data.COD_CATEGORIA;
                  document.querySelector("#txtNombre").value = objData.data.NOMBRE;
                  document.querySelector("#txtDescripcion").value = objData.data.DESCRIPCION;
                  document.querySelector("#foto_actual").value = objData.data.PORTADA;
                  document.querySelector("#foto_remove").value= 0;
                  
                  if(objData.data.COD_STATUS == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            
                    if(document.querySelector('#img')){ 
                      document.querySelector('#img').src = objData.data.url_portada;
                  }else{
                    document.querySelector('.prevPhoto div ').innerHTML = "<img id='img' src="+objData.data.url_portada+">";
                }     
                if(objData.data.portada =='portada_categoria.png'){ 
                    document.querySelector('.delPhoto').classList.add("notBlock");
                }else{
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                }                  
                $('#modalFormCategorias').modal('show');
              }else{
                  swal("Error", objData.msg , "error");
              }
          }
      }
        $('#ModalFormCategorias').modal('show'); 
        
    }

    function fntDelInfo(idcategoria){
        
        swal.fire({
            title: "Eliminar Categoria",
            text: "¿Realmente quiere eliminar la categoria?",
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
                  let ajaxUrl = base_url+'/Categorias/delcategoria/';
                  let strData = "idcategoria="+idcategoria;
                  request.open("POST",ajaxUrl,true);
                  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  request.send(strData);
                  request.onreadystatechange = function(){
                    let objData = JSON.parse(request.responseText);
                          if(objData.status)
                          {
                              swal.fire({ title:"Eliminar!", 
                              text: objData.msg,
                              icon:"success",
                              showClass: {
                                popup: 'animate__animated animate__flipInY'
                              },
                              hideClass: {
                                popup: 'animate__animated animate__flipOutY'
                              }});
                              tableCategorias.api().ajax.reload(function(){
                                
                                fntEdel();
                                fntPermisos()
                              });
                  } else{
                    swal.fire("Atención!", objData.msg , "error");
                  }
          
                }
             }
          })
        };
      

function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){ 
        document.querySelector('#img').remove();
 

 }
}
function openModal()
{
    rowTable = "";
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-success");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
    removePhoto();

}
 