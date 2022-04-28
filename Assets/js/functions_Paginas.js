let tablePaginas;
let rowTable;
document.addEventListener("DOMContentLoaded", function () {
  tablePaginas = $("#tablePaginas").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: " " + base_url + "/Paginas/getPaginas",
      dataSrc: "",
      /* success: function(data, textStatus, jqXHR)
            {
                console.log(data); //*** returns correct json data
    } */
    },

    columns: [
      { data: "COD_POST" },
      { data: "TITULO" },
      { data: "fecha" },
      { data: "options" },
    ],
    columnDefs: [
      { className: "textcenter", targets: [2] },
      { className: "textcenter", targets: [3] },

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
          columns: [0, 1, 2],
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
          columns: [0, 1, 2],
          modifier: {},
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fas fa-file-pdf'></i> PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger mr-1 mb-2",
        filename: "PEDIDOS",
        download: "open",
        orientation: "landscape",
        pageSize: "letter",
        title: "Reporte de Pedidos",
        customize: function (doc) {
          doc.content[1].margin = [0, 40, 120, 20];
          doc.content[0].margin = [0, 20, 0, 0];
          doc.content[0].alignment = "center";
          doc.content[1].alignment = "left";
          //orientacion vertical
          //doc.content[1].table.widths = [ '5%', '25%', '20%', '40%', '20%', '20%', '11%']
          //orientacion Horizontal
          doc.content[1].table.widths = [
            "5%",
            "25%",
            "45%",
            "15%",
            "20%",
            "15%",
          ];
          doc.content[1].table.body[0].forEach(function (h) {
            h.alignment = "left";
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

          /* let cols2 = [];
                                  cols2[0] = {fontSize: 13,text:  , alignment: 'center', margin:[0,0,0,0] };
                                  
                                  let objfooter = {};
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
                        "Página " + currentPage.toString() + " de " + pageCount,
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
          columns: [0, 1, 2],
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
          columns: [0, 1, 2],
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
          columns: [0, 1, 2],
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
});

tinymce.init({
  selector: "#txtContenido",
  language: "es_419",
  width: "100%",
  
  skin: localStorage.getItem("dark") === "true" ? "oxide-dark" : "oxide",
  content_css: localStorage.getItem("dark") === "true" ? "dark" : "default",
  height: 600,
  statubar: true,

  plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "save table advtable contextmenu directionality emoticons template paste textcolor",
  ],
  toolbar:
    "insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

 if (document.querySelector("#formPagina")) {
   let formPagina = document.querySelector("#formPagina");
   formPagina.onsubmit = function (e) {
     e.preventDefault();
     tinyMCE.triggerSave();
     let strTitulo = document.querySelector("#txtTitulo").value;
     let strContenido = document.querySelector("#txtContenido").value;
     let intStatus = document.querySelector("#listStatus").value;
     console.log(strContenido+' '+strTitulo+' '+intStatus);
     if (strTitulo == "" || strContenido == "" || intStatus == "") {
       swal.fire("Atención", "Todos los campos son obligatorios.", "error");
       return false;
      }
      
      divLoading.style.display = "flex";
      
     let request = window.XMLHttpRequest
       ? new XMLHttpRequest()
       : new ActiveXObject("Microsoft.XMLHTTP");
     let ajaxUrl = base_url + "/Paginas/setPagina";
     let formData = new FormData(formPagina);
     request.open("POST", ajaxUrl, true);
     request.send(formData);
     request.onreadystatechange = function () {
       if (request.readyState == 4 && request.status == 200) {
         
         let objData = JSON.parse(request.responseText);
         if (objData.status) {
           swal.fire({
             title: "",
             text: objData.msg,
             icon: "success",
             /* showCancelButton: true,
             confirmButtonText: "Si, eliminar!",
             cancelButtonText: "No, cancelar!", */
             closeOnConfirm: false,
             //closeOnCancel: true,
           }).then((result) => {
        if (result.isConfirmed) {
           location.reload();
        }

    });

         } else {
           swal.fire("Error", objData.msg, "error");
         } 
         
       }
       divLoading.style.display = "none";
       return false;
     };
   };
 }


    if (document.querySelector("#foto")) {
      let foto = document.querySelector("#foto");
      foto.onchange = function (e) {
        let uploadFoto = document.querySelector("#foto").value;
        let fileimg = document.querySelector("#foto").files;
        let nav = window.URL || window.webkitURL;
        let contactAlert = document.querySelector("#form_alert");
        if (uploadFoto != "") {
          let type = fileimg[0].type;
          let name = fileimg[0].name;
          if (
            type != "image/jpeg" &&
            type != "image/jpg" &&
            type != "image/png"
          ) {
            contactAlert.innerHTML =
              '<p class="errorArchivo">El archivo no es válido.</p>';
            if (document.querySelector("#img")) {
              document.querySelector("#img").remove();
            }
            document.querySelector(".delPhoto").classList.add("notBlock");
            foto.value = "";
            return false;
          } else {
            contactAlert.innerHTML = "";
            if (document.querySelector("#img")) {
              document.querySelector("#img").remove();
            }
            document.querySelector(".delPhoto").classList.remove("notBlock");
            let objeto_url = nav.createObjectURL(this.files[0]);
            document.querySelector(".prevPhoto div").innerHTML =
              "<img id='img' src=" + objeto_url + ">";
          }
        } else {
          alert("No selecciono foto");
          if (document.querySelector("#img")) {
            document.querySelector("#img").remove();
          }
        }
      };
    }

if (document.querySelector(".delPhoto")) {
  let delPhoto = document.querySelector(".delPhoto");
  delPhoto.onclick = function (e) {
    if (document.querySelector("#foto_remove")) {
      document.querySelector("#foto_remove").value = 1;
    }
    removePhoto();
  };
}
function fntDelInfo(idPagina) {
  swal
    .fire({
      title: "Eliminar Página",
      text: "¿Realmente quiere eliminar el Página?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "No, cancelar!",
      closeOnConfirm: false,
      closeOnCancel: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/paginas/delPagina";
        let strData = "idPagina=" + idPagina;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        request.send(strData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal.fire("Eliminar!", objData.msg, "success");
              tablePaginas.api().ajax.reload();
            } else {
              swal.fire("Atención!", objData.msg, "error");
            }
          }
        };
      }
    });
}
function removePhoto() {
  document.querySelector("#foto").value = "";
  document.querySelector(".delPhoto").classList.add("notBlock");
  if (document.querySelector("#img")) {
    document.querySelector("#img").remove();
  }
}