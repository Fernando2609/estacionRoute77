    let tablePedidos;
    let rowTable;
tablePedidos = $('#tablePedidos').dataTable({
        "aProcessing":true, 
        "aServerSide":true,
        "language": {   
             "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
           },
        
           "ajax":{
            "url": " "+base_url+"/Pedidos/getPedidos",
            "dataSrc":"",
            /* success: function(data, textStatus, jqXHR)
            {
                console.log(data); //*** returns correct json data
            } */
                      },
        
                "columns": [
                    {"data":"COD_PEDIDO"},
                    {"data":"transaccion"},
                    {"data":"FECHA"},
                    {"data":"MONTO"},
                    {"data":"TIPO_PAGO"},
                    {"data":"TIPOESTADO"},
                    {"data":"options"}
                        
                  ],
                  "columnDefs": [
                    { 'className': "textcenter", "targets": [ 3 ] },
                    { 'className': "textcenter", "targets": [ 4 ] },
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
                            filename:'PEDIDOS',
                            download:'open',
                            orientation: 'landscape',
                            pageSize:'letter',
                            title:'Reporte de Pedidos',
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
    function fntTransaccion(idtransaccion){
        let request = (window.XMLHttpRequest) ? 
                        new XMLHttpRequest() : 
                        new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Pedidos/getTransaccion/'+idtransaccion;
        divLoading.style.display = "flex";
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){   
                    document.querySelector("#divModal").innerHTML = objData.html;
                    $('#modalReembolso').modal('show');
                }else{
                    swal("Error", objData.msg , "error");
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    function fntReembolsar(){
       let idtransaccion = document.querySelector("#idtransaccion").value;
       let observacion = document.querySelector("#txtObservacion").value;
       if(idtransaccion=='' || observacion==''){
           swal.fire("", "Complete los datos para continuar.", "error");
           return false;
       }
        swal.fire({
            title: "Hacer Reembolso",
            text: "¿Realmente quiere realizar el reembolso?",
            icon: "warning",
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            showCancelButton: true,
            confirmButtonText: "Si, Reembolsar!",
            cancelButtonText: "No, cancelar!",
            closeOnConfirm: true,
            closeOnCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                 $('#modalReembolso').modal('hide');
                 divLoading.style.display = "flex";
                let request = (window.XMLHttpRequest) ? 
                         new XMLHttpRequest() : 
                         new ActiveXObject('Microsoft.XMLHTTP');
                 let ajaxUrl = base_url+'/Pedidos/setReembolso';
                let formData = new FormData();
               
                formData.append('idtransaccion',idtransaccion);
                formData.append('observacion',observacion);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                         let objData = JSON.parse(request.responseText);
                        if(objData.status){  
                            window.location.reload();
                         }else{
                            swal("Error", objData.msg , "error");
                        }
                        divLoading.style.display = "none";
                        return false; 
                    }
                }
            }
    });
}
function fntEditInfo(element,idpedido){
    rowTable = element.parentNode.parentNode.parentNode;
    let request = (window.XMLHttpRequest) ? 
                         new XMLHttpRequest() : 
                         new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Pedidos/getPedido/'+idpedido;
    divLoading.style.display = "flex";
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){  
                //window.location.reload();
                document.querySelector("#divModal").innerHTML=objData.html;
                $('#modalFormPedido').modal('show');
                $('select').selectpicker();
                fntUpdateInfo();
             }else{
                swal("Error", objData.msg , "error");
            }
            divLoading.style.display = "none";
            return false; 
        }
    }
}

function fntUpdateInfo(){
    let formUpdatePedido = document.querySelector("#formUpdatePedido");
    formUpdatePedido.onsubmit= function(e){
        e.preventDefault();
        let transaccion;
        if(document.querySelector("#txtTransaccion")){
            transaccion = document.querySelector("#txtTransaccion").value;
            
        }
        let request = (window.XMLHttpRequest) ? 
                         new XMLHttpRequest() : 
                         new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Pedidos/setPedido/';
    divLoading.style.display = "flex";
    let formData = new FormData(formUpdatePedido);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange=function(){
        if(request.readyState !=4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                swal.fire("",objData.msg,"success");
                $('#modalFormPedido').modal('hide');
                if(document.querySelector("#txtTransaccion")){
                    rowTable.cells[1].textContent = document.querySelector("#txtTransaccion").value;
                    rowTable.cells[4].textContent =document.querySelector("#listTipopago").selectedOptions[0].innerText;
                    rowTable.cells[5].textContent =document.querySelector("#listEstado").selectedOptions[0].innerText;
                }else{
                    rowTable.cells[5].textContent =document.querySelector("#listEstado").selectedOptions[0].innerText;
                }
            }else{
                swal.fire("Error", objData.msg, "error");
            }
            
            divLoading.style.display="none";
            return false;
        }
    }
    }
}