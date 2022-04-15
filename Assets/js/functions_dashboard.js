function fntSearchVmes(){
    let fecha = document.querySelector(".ventasMes").value;
    if (fecha == ""){ 
        swal.fire("", "Seleccione mes y año" , "error");
        return false;
    }else{
        let request =(window.XMLHttpRequest) ?
        new  XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Dashboard/ventasMes';
        divLoading.style.display= "flex";
        let formData = new FormData();
        formData.append('fecha',fecha);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
 
                $("#graficaMes").html(request.responseText);
                 divLoading.style.display= "none";
                return false;
            }
        }
    }
}
function fntSearchVanio(){
    let anio = document.querySelector(".ventasAnio").value;
    if (anio == ""){ 
        swal.fire("", "Ingrese año" , "error");
        return false;
    }else{
        let request =(window.XMLHttpRequest) ?
        new  XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Dashboard/ventasAnio';
        divLoading.style.display= "flex";
        let formData = new FormData();
        formData.append('anio',anio);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
 
                $("#graficaAnio").html(request.responseText);
                 divLoading.style.display= "none";
                return false;
            }
        }
    }
}