let tableProductos;
let rowTable = "";
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);


$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
      e.stopImmediatePropagation();
    }
  });

window.addEventListener('load',function(){
    //datatables
    tableProductos = $('#tableProductos').dataTable(  {
        "aProcessing":true, 
        "aServerSide":true,
        "language": {   
             "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
           },
        
           "ajax":{
            "url": " "+base_url+"/Productos/getProductos",
            "dataSrc":""
              },
        
                "columns": [
                    {"data":"COD_PRODUCTO"},
                    {"data":"COD_BARRA"},
                    {"data":"NOMBRE"},
                    {"data":"STOCK"},
                    {"data":"PRECIO"},
                    {"data":"status"},
                    {"data":"options"}
                        
                  ],
                  "columnDefs": [
                    { 'className': "textcenter", "targets": [ 3 ] },
                    { 'className': "textright", "targets": [ 4 ] },
                    { 'className': "textcenter", "targets": [ 5 ] }
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
                                columns: [ 0, 1, 2, 3,4,5],
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
                                columns: [ 0, 1, 2, 3,4,5],
                                  modifier: {
                                  }
                              },
                              
                        }, {
                            "extend": "pdfHtml5",
                            "text": "<i class='fas fa-file-pdf'></i> PDF",
                            "titleAttr": "Exportar a PDF",
                            "className": "btn btn-danger mr-1 mb-2",
                            filename:'PRODUCTOS',
                            download:'open',
                            orientation: 'landscape',
                            pageSize:'letter',
                            title:'Reporte de Productos',
                            customize: function ( doc ) {
                                doc.content[1].margin = [ 0, 40, 120, 20 ]
                                doc.content[0].margin = [ 0, 20, 0, 0 ]
                                doc.content[0].alignment = 'center'
                                doc.content[1].alignment = 'left'
                                //orientacion vertical 
                                //doc.content[1].table.widths = [ '5%', '25%', '20%', '40%', '20%', '20%', '11%']
                                //orientacion Horizontal 
                                doc.content[1].table.widths = [ '5%', '25%', '45%', '15%', '20%', '15%']
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
                               columns: [ 0, 1, 2, 3,4,5],
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
                               columns: [ 0, 1, 2, 3,4,5],
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
                               columns: [ 0, 1, 2, 3,4,5],
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
    //Guardar Producto
    if(document.querySelector("#formProductos")){
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let intCodigo = document.querySelector('#txtCodigo').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            let intStatus = document.querySelector('#listStatus').value;
            if(strNombre == ''  || strPrecio == '' || intStock == '' )
            {
                swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            if(intCodigo.length < 5){
                swal.fire("Atención", "El código debe ser mayor que 5 dígitos." , "error");
                return false;
            }
            divLoading.style.display = "flex";
            tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto'; 
            let formData = new FormData(formProductos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    
                     let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal.fire("", objData.msg ,"success");
                        
                        document.querySelector("#idProducto").value = objData.idproducto;
                        
                        document.querySelector("#containerGallery").classList.remove("notBlock");

                        if(rowTable == ""){
                            tableProductos.api().ajax.reload();
                            
                        }else{
                           htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = intCodigo;
                            rowTable.cells[2].textContent = strNombre;
                           // rowTable.cells[3].textContent = intStock;
                            rowTable.cells[4].textContent = smony+strPrecio;
                            rowTable.cells[5].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                    }else{
                        swal.fire("Error", objData.msg , "error");
                    } 
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    if (document.querySelector(".btnAddImage")) {
        let btnAddImage =document.querySelector(".btnAddImage");
        btnAddImage.onclick=function (e) {
            let key=Date.now();
            let newElement=document.createElement("div");
            newElement.id="div"+key;
            newElement.innerHTML=  `
          
                <div class="prevImage">

                </div>
                <input type="file" name="foto" id="img${key}" class="inputUploadfile">
                <label for="img${key}" class="btnUploadfile"><i class="fa fa-upload"></i></label>
                <button class="btnDeleteImage notBlock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
        document.querySelector("#containerImage").appendChild(newElement);
        document.querySelector("#div"+key+" .btnUploadfile").click();
        fntInputFile();
        }
    }
    fntCategorias();
},false);
if(document.querySelector("#txtCodigo")){
    let inputCodigo = document.querySelector("#txtCodigo");
    inputCodigo.onkeyup = function() {
        if(inputCodigo.value.length >= 5){
            document.querySelector('#divBarCode').classList.remove("notBlock");
            fntBarcode();
       }else{
            document.querySelector('#divBarCode').classList.add("notBlock");
       }
    };
}
tinymce.init({
    selector: '#txtDescripcion',
    language: 'es_419',
    width: "100%",
    skin:(localStorage.getItem('dark')==='true' ? 'oxide-dark' : 'oxide'),
    content_css: (localStorage.getItem('dark')==='true' ? 'dark' : 'default'),
    height: 400,    
    statubar: true,

    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table advtable contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",


  });
function fntInputFile() {
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idProducto = document.querySelector("#idProducto").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loadingRoute.gif" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Productos/setImage'; 
                    let formData = new FormData();
                    formData.append('idproducto',idProducto);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                   request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notBlock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock"); 
                            } else{
                                swal.fire("Error", objData.msg , "error");
                            } 
                        }
                    } 

                }
            }

        });
    });
}
function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idProducto = document.querySelector("#idProducto").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/delFile'; 

    let formData = new FormData();
    formData.append('idproducto',idProducto);
    formData.append("file",nameImg);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }
}
function fntViewInfo(idProducto){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.table(objData);
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                let estadoProducto = objProducto.COD_STATUS == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celCodigo").innerHTML = objProducto.COD_BARRA;
                document.querySelector("#celNombre").innerHTML = objProducto.NOMBRE;
                document.querySelector("#celPrecio").innerHTML = objProducto.PRECIO;
                document.querySelector("#celStock").innerHTML = objProducto.CANT_MINIMA;
                document.querySelector("#celCategoria").innerHTML = objProducto.CATEGORÍA;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                document.querySelector("#celDescripcion").innerHTML = objProducto.DESCRIPCION;

                if(objProducto.images.length > 0){
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        htmlImage +=`<img src="${objProductos[p].url_image}"></img>`;
                    }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage;
                $('#modalViewProducto').modal('show');

            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }
    } 
}
function fntEditInfo(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    
    document.querySelector('#titleModal').innerHTML ="Actualizar Categoria";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-warning");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.COD_PRODUCTO;
                document.querySelector("#txtNombre").value = objProducto.NOMBRE;
                document.querySelector("#txtDescripcion").value = objProducto.DESCRIPCION;
                document.querySelector("#txtCodigo").value = objProducto.COD_BARRA;
                document.querySelector("#txtPrecio").value = objProducto.PRECIO;
                document.querySelector("#txtStock").value = objProducto.CANT_MINIMA;
                document.querySelector("#listCategoria").value = objProducto.COD_CATEGORIA;
                document.querySelector("#listStatus").value = objProducto.COD_STATUS;
                tinymce.activeEditor.setContent(objProducto.DESCRIPCION); 
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
                if (objProducto.COD_BARRA!='') {
                    fntBarcode();
                    document.querySelector("#divBarCode").classList.remove("notBlock");
                }else{
                    document.querySelector("#divBarCode").classList.add("notBlock");
                }

                if(objProducto.images.length > 0){
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objProductos[p].url_image}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].IMG}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                }
                document.querySelector("#containerImage").innerHTML = htmlImage; 
               
                document.querySelector("#containerGallery").classList.remove("notBlock");           
                $('#modalFormProductos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
function fntDelInfo(idProducto){
    swal.fire({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/delProducto';
            let strData = "idProducto="+idProducto;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal.fire("Eliminar!", objData.msg , "success");
                        tableProductos.api().ajax.reload();
                    }else{
                        swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}
function fntCategorias(){
    if (document.querySelector('#listCategoria')) {
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }   
    }
}


function fntBarcode(){
    let codigo = document.querySelector("#txtCodigo").value;
    JsBarcode("#barcode", codigo,{
        
    });
}

function fntPrintBarcode(area){
    let elemntArea = document.querySelector(area);
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
    vprint.document.write(elemntArea.innerHTML );
    vprint.document.close();
    vprint.print();
    vprint.close();
}

function openModal()
{
    rowTable = "";

    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-success");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector("#formProductos").reset();
    document.querySelector("#divBarCode").classList.add("notBlock");
    document.querySelector("#containerGallery").classList.add("notBlock");
    document.querySelector("#containerImage").innerHTML="";
    $('#modalFormProductos').modal('show');
    
}