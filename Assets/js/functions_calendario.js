//FULLCALENDAR V5
document.addEventListener('DOMContentLoaded', function() {
  //Div con el id Calendaar
  let formulario=document.querySelector("form");  
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    //Maximo de eventos por dia
    dayMaxEventRows: true, 
    views: {
      dayGridMonth: {
        dayMaxEventRows: 4 // 4 eventos maximo
      }
    },
    //Configuración Vista semanal
    slotDuration:'00:30:00',
    selectMirror:true,
    //Mostrar Hora final del evento
    displayEventEnd:true,
    //Zona America, Tegucigalpa
    timeZone: 'America/Tegucigalpa',
    //Eventos Arrastables=true  
    editable:true,
    //VIsta inicial
    initialView: 'dayGridMonth',
    //Seleccionar dias = true
    selectable: true,
   
    locale:"es", //Idioma
    //Encabezado
    headerToolbar:{
        left:"prev,next today",
        center:"title",
        right:"dayGridMonth,timeGridWeek,listWeek"
    },
    
    //Click en una fecha especifica
    dateClick:function(info,jsEvent,view){
        // titulo del evento más la fecha Seleccionada
        $('#tituloEvento').html("Nuevo Evento "+ info.dateStr);
        //Botones, Habilitar Guardar,Desabilitar modificar y eliminar
        $('#btnGuardar').prop("disabled",false);
        $('#btnModificar').prop("disabled",true);
        $('#btnEliminar').prop("disabled",true);
        //Resetar formulario del modal
        document.querySelector("#formCaledario").reset();
        //Inicializacion de fecha seleccionada
        document.querySelector("#inicio").value = info.dateStr+"T00:00:00";
        document.querySelector("#end").value = info.dateStr+"T23:59:00";
        //Pruebas de consola
         console.log(info);
        console.log(info.dateStr); 
        //Mostrar Modal de eventos
        $("#modalFormCalendar").modal("show");
    },
    //Extraer eventos desde el controlador
    events: 'http://localhost:8080/route77/Calendario/mostrarCalendario',
   
    //Click en un evento
   eventClick:function(calEvent,jsEvent,view){
        //Titulo del evento seleccionado
        $('#tituloEvento').html(calEvent.event.title);
        //Prueba de consola
        console.log(calEvent.event);
        //Botones, Deshabilitar Guardar,habilitar modificar y eliminar
        $('#btnGuardar').prop("disabled",true);
        $('#btnModificar').prop("disabled",false);
        $('#btnEliminar').prop("disabled",false);
     
       //Inicializar Variables con StartStr y EndStr
       inicio=calEvent.event.startStr;
       final=calEvent.event.endStr;
       //Ya no se utiliza gracias a la Zona Horaria America/Tegucigalpa
       /* //Se separa en un array año[0], el mes[1] y el dia con la hora[2]
       const arrayfechaInicio=inicio.split("-");
       const arrayfechaFinal=final.split("-");
       //Se inicializa la variable fecha inicio con 
       fechaFin=arrayfechaFinal[0]+"-"+arrayfechaFinal[1]+"-"+ arrayfechaFinal[2];
       fechaInicio=arrayfechaInicio[0]+"-"+arrayfechaInicio[1]+"-"+ arrayfechaInicio[2]; */
       //Enviar a los inputs del formulario los datos
       $('#id').val(calEvent.event.id);
       $('#title').val(calEvent.event.title);
       $('#descripcion').val(calEvent.event.extendedProps.descripcion);
       $('#end').val(final);
       document.querySelector("#inicio").value = inicio ;
       $('#color').val(calEvent.event.backgroundColor);
       $('#colorText').val(calEvent.event.textColor);
       $('#start').val(calEvent.event.start);
       //Mostrar el modal
       $("#modalFormCalendar").modal("show");
       //Prueba de consola, fecha inicial y final String
       console.log(calEvent.event.startStr);
       console.log(calEvent.event.endStr);
       
       //Cuanndo se de click al boton modificar 
       $("#btnModificar").click(function(){
        //Se envia los parametros a update eventos
        updateEvento(calEvent.event.id,calEvent.event.title);
      });
      //Cuanndo se de click al boton modificar 
      $("#btnEliminar").click(function(){
        //Se envia los parametros a update eventos
        deleteEvento(calEvent.event.id,calEvent.event.title);
      });
        
   },
   eventDrop:function(calEvent){
        //Inicializar Variables con StartStr y EndStr
       inicio=calEvent.event.startStr;
       final=calEvent.event.endStr;
       //Ya no se utiliza gracias a la Zona Horaria America/Tegucigalpa
       /* //Se separa en un array año[0], el mes[1] y el dia con la hora[2]
       const arrayfechaInicio=inicio.split("-");
       const arrayfechaFinal=final.split("-");
       //Se inicializa la variable fecha inicio con 
       fechaFin=arrayfechaFinal[0]+"-"+arrayfechaFinal[1]+"-"+ arrayfechaFinal[2];
       fechaInicio=arrayfechaInicio[0]+"-"+arrayfechaInicio[1]+"-"+ arrayfechaInicio[2]; */
        //Enviar a los inputs del formulario los datos
       $('#id').val(calEvent.event.id);
       $('#title').val(calEvent.event.title);
       $('#descripcion').val(calEvent.event.extendedProps.descripcion);
       $('#end').val(final);
       document.querySelector("#inicio").value = inicio ;
       $('#color').val(calEvent.event.backgroundColor);
       $('#colorText').val(calEvent.event.textColor);
       $('#start').val(calEvent.event.start);
        //Funcion Actualiazr eventos (Parametro ID del evento)
       updateEvento(calEvent.event.id,calEvent.event.title);
   },
   select:function(info,jsEvent,view) {
     //Botones, habilitar Guardar,Deshabilitar modificar y eliminar
     $('#btnGuardar').prop("disabled",false);
     $('#btnModificar').prop("disabled",true);
     $('#btnEliminar').prop("disabled",true);
     //Prueba de escritorio
    console.log(info.view.type);
    //Si la vista es mes
       if (info.view.type=='dayGridMonth') {
           
        console.log(info);
        //Inicializacion de fecha seleccionada
        $('#tituloEvento').html("Nuevo Evento "+ info.startStr + " Hasta "+ info.endStr);
        document.querySelector("#inicio").value = info.startStr+"T00:00:00";
        document.querySelector("#end").value = info.endStr+"T00:00:00";

       }else if(info.view.type=='timeGridWeek'){//Sino, si la vista es semana
        console.log(info);
        inicio=info.startStr;
        final=info.endStr;
        //Ya no se utiliza gracias a la Zona Horaria America/Tegucigalpa
        /* //Se separa en un array año[0], el mes[1] y el dia con la hora[2]
        const arrayfechaInicio=inicio.split("-06:00");
        const arrayfechaFinal=final.split("-06:00");
        //Se inicializa la variable fecha inicio con 
        fechaFin=arrayfechaFinal[0];
        fechaInicio=arrayfechaInicio[0]; */
        const arrayHoraInicio=inicio.split("T");
        const arrayHoraFinal=final.split("T");
        console.log(arrayHoraInicio);
        console.log(arrayHoraFinal);
         //Inicializacion de fecha seleccionada
         $('#tituloEvento').html("Nuevo Evento "+ arrayHoraInicio[0]+" a las "+arrayHoraInicio[1] + " Hasta "+ arrayHoraFinal[0]+" a las "+arrayHoraFinal[1]);
         document.querySelector("#inicio").value = inicio;
         document.querySelector("#end").value = final;
         
    }
     //Mostrar Modal de eventos
     $("#modalFormCalendar").modal("show");
  }
   
  });
  calendar.render();
});
//Boton nuevo Abrir modal
function openModal()
{
    //Resetear Modal
    $('#tituloEvento').html("Nuevo Evento");
    document.querySelector("#formCaledario").reset();
    //Botones, Habilitar Guardar,Desabilitar modificar y eliminar
    $('#btnGuardar').prop("disabled",false);
    $('#btnModificar').prop("disabled",true);
    $('#btnEliminar').prop("disabled",true);
    //Abrir modal
    $('#modalFormCalendar').modal('show');
}
//Nuevo Evento Función
function agregarEvento(){
    var formUsuario=document.querySelector("#formCaledario");
        let strtitle = document.querySelector('#title').value;
        let strDescripcion = document.querySelector('#descripcion').value;
        let strStart= document.querySelector('#inicio').value;
        let strEnd = document.querySelector('#end').value;

        if(strtitle == '' || strDescripcion == '' || strStart == '' )
        {
            swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Calendario/setCalendario'; 
        let formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){ 
            console.log(request);
            if(request.readyState == 4 && request.status == 200){
                console.log(request.responseText);
                let objData = JSON.parse(request.responseText); 
                
                if(objData.status)
                { 
                    $('#modalFormCalendar').modal("hide");
                        formUsuario.reset();
                        swal.fire({
                            title: "Evento",
                            text: objData.msg,
                            icon: "success",
                           /*  showClass: {
                              popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                              popup: 'animate__animated animate__fadeOutUp'
                            }, */
                            showCancelButton: false,
                            confirmButtonText: "Aceptar",
                            //cancelButtonText: "No, cancelar!",
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            allowOutsideClick: false
                        }).then((result) => {
                          if (result.isConfirmed) {  
                            location.reload();
                          }});
                      
                    }else{
                        swal.fire("Error", objData.msg , "error");
                }
            
            }else{
                console.log('Error');
            }
        }  
    
}
//Actualizar Evento
function updateEvento(idEvento,nameEvent) {
    var formUsuario=document.querySelector("#formCaledario");
        let strtitle = document.querySelector('#title').value;
        let strDescripcion = document.querySelector('#descripcion').value;
        let strStart= document.querySelector('#inicio').value;
        let strEnd = document.querySelector('#end').value;

        if(strtitle == '' || strDescripcion == '' || strStart == '' )
        {
            swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Calendario/updateCalendario/'+idEvento; 
        let formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){ 
           /*  console.log(request); */
            if(request.readyState == 4 && request.status == 200){
                /* console.log(request.responseText); */
                let objData = JSON.parse(request.responseText); 
                
                if(objData.status)
                { 
                    $('#modalFormCalendar').modal("hide");
                        formUsuario.reset();
                        
                        
                        swal.fire({
                            title: nameEvent,
                            text: objData.msg,
                            icon: "success",
                           /*  showClass: {
                              popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                              popup: 'animate__animated animate__fadeOutUp'
                            }, */
                            showCancelButton: false,
                            confirmButtonText: "Aceptar",
                            //cancelButtonText: "No, cancelar!",
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            allowOutsideClick: false
                        }).then((result) => {
                          if (result.isConfirmed) {  
                            location.reload();
                          }});
                      
                    }else{
                        swal.fire("Error", objData.msg , "error");
                }
            
            }/* else{
                console.log('Error');
            } */
        }  
}
//Función Eliminar Evento
function deleteEvento(idEvento,nameEvent) {
    var formUsuario=document.querySelector("#formCaledario");
        let strtitle = document.querySelector('#title').value;
        let strDescripcion = document.querySelector('#descripcion').value;
        let strStart= document.querySelector('#inicio').value;
        let strEnd = document.querySelector('#end').value;

        if(strtitle == '' || strDescripcion == '' || strStart == '' )
        {
            swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Calendario/delCalendario/'+idEvento; 
        let formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){ 
            console.log(request);
            if(request.readyState == 4 && request.status == 200){
                console.log(request.responseText);
                let objData = JSON.parse(request.responseText); 
                
                if(objData.status)
                { 
                    $('#modalFormCalendar').modal("hide");
                        formUsuario.reset();

                        swal.fire({
                            title: nameEvent,
                            text: objData.msg,
                            icon: "success",
                            showClass: {
                              popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                              popup: 'animate__animated animate__fadeOutUp'
                            },
                            showCancelButton: false,
                            confirmButtonText: "Aceptar",
                            //cancelButtonText: "No, cancelar!",
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            allowOutsideClick: false
                        }).then((result) => {
                          if (result.isConfirmed) {  
                            location.reload();
                          }});
                      
                    }else{
                        swal.fire("Error", objData.msg , "error");
                }
            
            }else{
                console.log('Error');
            }
        }  
}
//Cargar las clases desde el load

