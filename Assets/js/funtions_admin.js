function controlTag(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9) return true;
    patron =/[0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n);
}

function controlTagPrecio(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9) return true;
    patron =/[0-9.\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n);
}

function controlTagLetraNumero(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9) return true;
    patron =/[a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n);
}

function controlTagNumeroEmpresa(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9) return true;
    patron =/[0-9+\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n);
}

function controlTagImagenes(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9) return true;
    patron =/[0-9,\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n);
}



function testEntero(intCant) {
  var intCantidad = new RegExp(/^([0-9])*$/);
  if (intCantidad.test(intCant)) {
    return true;
  } else {
    return false;
  }
}
function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü]+(\s[a-zA-ZÑñÁáÉéÍíÓóÚúÜü]+)*$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}
function testContraseña(txtString) {
  var stringText = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#$!%*.?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/);
  if (stringText.test(txtString)) {
    return true;
  } else {
    return false;
  }
}

function testImg(txtString) {
  var stringText = new RegExp(
    /^(?=.*\d)(?=.*[$@#$!%*.?&])$/
  );
  if (stringText.test(txtString)) {
    return true;
  } else {
    return false;
  }
}


function testEnteroDni(intCant) {
    var intCantidad = new RegExp(/^([0-9]{13})$/);
    if (intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}
function testEnteroRtn(intCant) {
    var intCantidad = new RegExp(/^([0-9]{14})$/);
    if (intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}
//FUncion de entero y longitud Telefono
function testEnteroTel(intCant) {
    var intCantidad = new RegExp(/^([0-9]{8})$/);
    if (intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}



function testPrecio(intCant) {

    var intCantidad = new RegExp(/^([0-9]{1,6})\.{0,1}(([0-9]{0,2}))$/);


    if (intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email) {
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }  
}

function fntValidImg() {
  let ValidImg = document.querySelectorAll(".ValidImg");
  ValidImg.forEach(function (ValidImg) {
    ValidImg.addEventListener("keyup", function () {
      let inputValue = this.value;
      if (!testImg(inputValue)) {
        this.classList.add("is-invalid");
        /*  this.classList.remove('is-valid'); */
      } else {
        this.classList.remove("is-invalid");
        /*       this.classList.add('is-valid'); */
      }
    });
  });
}
    
function fntValidContra(){
    let ValidContra = document.querySelectorAll(".ValidContra");
    ValidContra.forEach(function(ValidContra) {
        ValidContra.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testContraseña(inputValue)) {
              this.classList.add("is-invalid");
              /*  this.classList.remove('is-valid'); */
            } else {
              this.classList.remove("is-invalid");
              /*       this.classList.add('is-valid'); */
            }
        });
    });
}
function fntValidText(){
    let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function (){
            let inputValue = this.value;
            if(!testText(inputValue)){
                this.classList.add('is-invalid');
               /*  this.classList.remove('is-valid'); */
            }else{
                this.classList.remove('is-invalid');
          /*       this.classList.add('is-valid'); */
                
            }
        });
    });
}

function fntValidNumberDni(){
    let validNumberDni = document.querySelectorAll(".validNumberDni");
    validNumberDni.forEach(function(validNumberDni) {
        validNumberDni.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testEnteroDni(inputValue)){
                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            
            }
        });
    });
}

function fntValidNumberRtn(){
    let validNumberRtn = document.querySelectorAll(".validNumberRtn");
    validNumberRtn.forEach(function(validNumberRtn) {
        validNumberRtn.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testEnteroRtn(inputValue)){
                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            
            }
        });
    });
}

function fntValidNumberPrecio(){
    let validNumberPrecio = document.querySelectorAll(".validNumberPrecio");
    validNumberPrecio.forEach(function(validNumberPrecio) {
        validNumberPrecio.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testPrecio(inputValue)){
                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            
            }
        });
    });
}
//Funcion validacion telefono
function fntValidNumberTel(){
    let validNumberTel = document.querySelectorAll(".validNumberTel");
    validNumberTel.forEach(function(validNumberTel) {
        validNumberTel.addEventListener('keyup', function (){
            let inputValue = this.value;
            if (!testEnteroTel(inputValue)){
                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            
            }
        });
    });
}

function fntValidEmail(){
    let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function () {
            let inputValue = this.value;
            if (!fntEmailValidate(inputValue)){
                this.classList.add('is-invalid');
            }else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
}
function fntValidNumber() {
  let validNumber = document.querySelectorAll(".validNumber");
  validNumber.forEach(function (validNumber) {
    validNumber.addEventListener("keyup", function () {
      let inputValue = this.value;
      if (!testEntero(inputValue)) {
        this.classList.add("is-invalid");
      } else {
        this.classList.remove("is-invalid");
      }
    });
  });
}



//Llamado de las Funciones
window.addEventListener('load', function() {
    fntValidText();
    fntValidNumber();
    fntValidEmail();
    fntValidNumberDni();
    fntValidNumberTel();
    fntValidNumberPrecio();
    fntValidNumberRtn();
    fntViewProductos();
    fntValidContra();
    fntValidImg();
}, false);


function fntViewProductos() {
     let prevImg = document.querySelector("#notificacion");
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Dashboard/getProductos/";
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
     var cant=0;
      
      for (let i = 0; i < objData.length; i++) {
          const producto = objData[i];
          if (producto.STOCK<=producto.CANT_MINIMA) {
              
              console.log("hola");
            }
            //console.log(producto.CANT_MINIMA>producto.STOCK);
      }
    }
  };
}