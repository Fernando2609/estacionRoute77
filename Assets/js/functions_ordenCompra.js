$(document).ready(function(){
   
  $("#idProducto").keyup(function(e){
    e.preventDefault();

    
    var producto=$(this).val();
    if (producto!='') {
       let request = window.XMLHttpRequest
         ? new XMLHttpRequest()
         : new ActiveXObject("Microsoft.XMLHTTP");
       let ajaxUrl = base_url + "/OrdenCompra/getProducto/" + producto;
       request.open("GET", ajaxUrl, true);
       request.send();
       request.onreadystatechange = function () {
         if (request.readyState == 4 && request.status == 200) {
           let objData = JSON.parse(request.responseText);
           //console.log(objData);
           if (objData.status) {
             document.querySelector("#nombre").innerHTML = objData.data.NOMBRE;
             document.querySelector("#txtCategoria").innerHTML =
               objData.data.CATEGORÍA;
              $("#txtCantidad").removeAttr("disabled");
               $("#txtPrecio").removeAttr("disabled");
               document.querySelector("#add_product_Compra").classList.remove("notBlock");
           } else {
              document.querySelector("#nombre").innerHTML ='-';
              document.querySelector("#txtCategoria").innerHTML =
              '-';
              $("#txtCantidad").attr("disabled", "disabled");
              $("#txtPrecio").attr("disabled", "disabled");
              document
                .querySelector("#add_product_Compra")
                .classList.add("notBlock");
           }
         }
       }; 
    }else{
       document.querySelector("#nombre").innerHTML = "-";
       document.querySelector("#txtCategoria").innerHTML = "-";
       $("#txtCantidad").attr("disabled", "disabled");
       $("#txtPrecio").attr("disabled", "disabled");
       document.querySelector("#add_product_Compra").classList.add("notBlock");
    }
   
   
  })

  let precio;
  let cantidad;
  let precioTotal;
  //Calcular cantidad del producto antes de agregar
  $("#txtCantidad").keyup(function(e){
    e.preventDefault();
     cantidad = $(this).val();
    precioTotal = precio * cantidad;
    if (isNaN(precioTotal)) {
        document.querySelector("#txtPrecioTotal").innerHTML = "0.00";
    }else{

      document.querySelector("#txtPrecioTotal").innerHTML = precioTotal;
    }
    if($(this).val()<1 || isNaN($(this).val())){
      document.querySelector("#add_product_Compra").classList.add("notBlock");

    }else{
    document.querySelector("#add_product_Compra").classList.remove("notBlock");

    }
     
    
    //$("#txtPrecioTotal").html(precioTotal);
  })
   $("#txtPrecio").keyup(function (e) {
      precio = $(this).val();
      precioTotal=precio*cantidad
     if (isNaN(precioTotal)) {
       document.querySelector("#txtPrecioTotal").innerHTML = "0.00";
     } else {
       document.querySelector("#txtPrecioTotal").innerHTML = precioTotal;
     }
     if($(this).val()<1 || isNaN($(this).val())){
      document.querySelector("#add_product_Compra").classList.add("notBlock");

    }else{
    document.querySelector("#add_product_Compra").classList.remove("notBlock");

    }
   });
  $("#add_product_Compra").click(function (e) {
    e.preventDefault;
    if ($("#txtCantidad").val()>0) {

      let COD_PRODUCTO = $("#idProducto").val();
       let cantidad = $("#txtCantidad").val();
        let precio = $("#txtPrecio").val();
         let precioTotal = $("#txtPrecioTotal").html();


      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/OrdenCompra/detalleCompra";
       let formData = new FormData();
       formData.append("idProducto", COD_PRODUCTO);
       formData.append("txtCantidad", cantidad);
       formData.append("txtPrecio", precio);
       formData.append("txtPrecioTotal", precioTotal);

      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          
          if (objData.status) {
            

            document.querySelector("#tablaCompra").innerHTML =objData.htmlCompras;
            //document.querySelector("#detalle_venta").innerHTML=objData.data.detalle;
            document.querySelector("#detalle_totales").innerHTML=objData.htmlTotales;


             document.querySelector("#idProducto").value = "";
             document.querySelector("#nombre").innerHTML = "-";
             document.querySelector("#txtCategoria").innerHTML = "-";
             document.querySelector("#txtPrecioTotal").innerHTML = "-";
             document.querySelector("#txtCantidad").value = "0";
             document.querySelector("#txtPrecio").value = "0";
             $("#txtCantidad").attr("disabled", "disabled");
             $("#txtPrecio").attr("disabled", "disabled");
             document
               .querySelector("#add_product_Compra")
               .classList.add("notBlock");
             Swal.fire({
               toast: true,
               iconColor: "white",
               customClass: {
                 popup: "colored-toast",
               },
               position: "top-right",
               icon: "success",
               title: objData.msg,
               showConfirmButton: false,
               timer: 1500,
               timerProgressBar: true,
             });
             viewProcesar();

           /*  document.querySelector("#nombre").innerHTML = objData.data.NOMBRE;
            document.querySelector("#txtCategoria").innerHTML =
              objData.data.CATEGORÍA;
            $("#txtCantidad").removeAttr("disabled");
            $("#txtPrecio").removeAttr("disabled");
            document
              .querySelector("#add_product_Compra")
              .classList.remove("notBlock"); */
          } else {
            console.log('error');
            /* document.querySelector("#nombre").innerHTML = "-";
            document.querySelector("#txtCategoria").innerHTML = "-";
            $("#txtCantidad").attr("disabled", "disabled");
            $("#txtPrecio").attr("disabled", "disabled");
            document
              .querySelector("#add_product_Compra")
              .classList.add("notBlock"); */
          }
        }
      }; 
    }

    
  });


  $("#btn_anular_compra").click(function(e){
    e.preventDefault();
    var rows=$('#tablaCompra tr').length;
    if (rows>0) {
       let request = window.XMLHttpRequest
         ? new XMLHttpRequest()
         : new ActiveXObject("Microsoft.XMLHTTP");
       let ajaxUrl = base_url + "/OrdenCompra/anularCompra";
       let formData = new FormData();
       //formData.append("idProducto", id);

       request.open("POST", ajaxUrl, true);
       request.send();
       request.onreadystatechange = function () {
         if (request.readyState == 4 && request.status == 200) {
           let objData = JSON.parse(request.responseText);
           console.log(objData);
           if (objData.status) {
             location.reload();
           }
           viewProcesar();
         }
       };
    }
  });

 $("#btn_facturar_compra").click(function (e) {
   e.preventDefault;
   var rows = $("#tablaCompra tr").length;
   if (rows > 0) {
     let factura = $("#txtFactura").val();
     let proveedor = $("#listProveedor").val();
      let elementsValid = document.getElementsByClassName("valid");
      for (let i = 0; i < elementsValid.length; i++) {
        if (elementsValid[i].classList.contains("is-invalid")) {
          swal.fire(
            "Atención",
            "Por favor verifique los campos en rojo.",
            "error"
          );
          return false;
        }
      }
     /* let precio = $("#txtPrecio").val();
    let precioTotal = $("#txtPrecioTotal").html(); */

     let request = window.XMLHttpRequest
       ? new XMLHttpRequest()
       : new ActiveXObject("Microsoft.XMLHTTP");
     let ajaxUrl = base_url + "/OrdenCompra/procesarCompra";
     let formData = new FormData();
     formData.append("txtFactura", factura);
     formData.append("idProveedor", proveedor);

     request.open("POST", ajaxUrl, true);
     request.send(formData);
     request.onreadystatechange = function () {
       if (request.readyState == 4 && request.status == 200) {
         let objData = JSON.parse(request.responseText);

         if (objData.status) {
           window.location = base_url + "/Compras/";
         } else {
           swal.fire(
             "Atención",
             objData.msg,
             "error"
           );
           /* document.querySelector("#nombre").innerHTML = "-";
            document.querySelector("#txtCategoria").innerHTML = "-";
            $("#txtCantidad").attr("disabled", "disabled");
            $("#txtPrecio").attr("disabled", "disabled");
            document
              .querySelector("#add_product_Compra")
              .classList.add("notBlock"); */
         }
       }
     };
   }
 });
  

});

function del_product_detalle(id) {

 

  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/OrdenCompra/delCompra";
   let formData = new FormData();
   formData.append("idProducto", id);
   

  request.open("POST", ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      console.log(objData);
      if (objData.status) {
        document.querySelector("#tablaCompra").innerHTML = objData.htmlCompras;
        //document.querySelector("#detalle_venta").innerHTML=objData.data.detalle;
        document.querySelector("#detalle_totales").innerHTML =
          objData.htmlTotales;
          Swal.fire({
            toast: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
            position: "top-right",
            icon: "warning",
            title: objData.msg,
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
          });
      } else {
        Swal.fire({
          toast: true,
          iconColor: "white",
          customClass: {
            popup: "colored-toast",
          },
          position: "top-right",
          icon: "error",
          title: "Error",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        });
      }
      viewProcesar();
    }
  };
}
function viewProcesar() {
  if ($("#tablaCompra tr" ).length>0) {
    document.querySelector("#btn_facturar_compra").classList.remove("notBlock");
  }else{
    document.querySelector("#btn_facturar_compra").classList.add("notBlock");
  }
};
//Cargar las clases desde el load
window.addEventListener('load', function() {
   viewProcesar();
   fntProveedores();
}, false);



function fntProveedores(){
  
      let ajaxUrl = base_url + "/OrdenCompra/getSelectProveedores";
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
              document.querySelector("#listProveedor").innerHTML =
                request.responseText;
              document.querySelector("#listProveedor").value = 1;
              $("#listProveedor").selectpicker("render");
          }
  }
 }