<?php  
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'Libraries/phpmailer/Exception.php';
    require 'Libraries/phpmailer/PHPMailer.php';
    require 'Libraries/phpmailer/SMTP.php';
    
    function base_url(){
        return BASE_URL;
    }
    //Retorla la url de Assets
    function media()
    {
        return BASE_URL."/Assets";
    }
    function headerAdmin($data="")
    {
        $view_header = "Views/Template/header_admin.php";
        require_once ($view_header);
    }
    function footerAdmin($data="")
    {
        $view_footer = "Views/Template/footer_admin.php";
         require_once ($view_footer);
    }
    function headerTienda($data="")
    {
        $view_header = "Views/Template/header_tienda.php";
        require_once ($view_header);
    }
    function footerTienda($data="")
    {
        $view_footer = "Views/Template/footer_tienda.php";
         require_once ($view_footer);
    }



    //Muestra información formateada
	function dep($data)
    {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }
    function getModal(string $nameModal, $data)
    {
      $view_modal = "Views/Template/Modals/{$nameModal}.php";
      require_once $view_modal;
    }
    function getFile(string $url, $data)
    {
        ob_start();
        require_once("Views/{$url}.php");
        $file = ob_get_clean();
        return $file;        
    }
    //Envio de correos
    function sendEmail($data,$template)
    {
        
        if(ENVIRONMENT == 1){
            $asunto = $data['asunto'];
            $emailDestino = $data['email'];
            $empresa = NOMBRE_REMITENTE;
            $remitente = EMAIL_REMITENTE;
            $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";
            //ENVIO DE CORREO
            $de = "MIME-Version: 1.0\r\n";
            $de .= "Content-type: text/html; charset=UTF-8\r\n";
            $de .= "From: {$empresa} <{$remitente}>\r\n";
            $de .= "Bcc: $emailCopia\r\n";
            ob_start();
            require_once("Views/Template/Email/".$template.".php");
            $mensaje = ob_get_clean();
            $send = mail($emailDestino, $asunto, $mensaje, $de);
            return $send;
        }else{
           
           //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            ob_start();
            require_once("Views/Template/Email/".$template.".php");
            $mensaje = ob_get_clean();

            try {
                //Server settings
                $mail->SMTPDebug =  0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'Estacionroutehn@gmail.com';          //SMTP username
                $mail->Password   = 'Estacion.route123';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('Estacionroutehn@gmail.com', 'Servidor Local ROUTE 77');
                $mail->addAddress($data['email']);     //Add a recipient
                if(!empty($data['emailCopia'])){
                    $mail->addBCC($data['emailCopia']);
                }
                $mail->CharSet = 'UTF-8';
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $data['asunto'];
                $mail->Body    = $mensaje;
                
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            } 
        }
    }
    
    function sendMailLocal($data,$template){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        ob_start();
        require_once("Views/Template/Email/".$template.".php");
        
        $mensaje = ob_get_clean();

        try {
            //Server settings
            $mail->SMTPDebug = 1;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'estacionroutehn@gmail.com';                     //SMTP username
            $mail->Password   = 'Estacion.route123';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('estacionroutehn@gmail.com', 'Servidor Local');
            $mail->addAddress($data['email']);     //Add a recipient
            if(!empty($data['emailCopia'])){
                $mail->addBCC($data['emailCopia']);
            }

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $data['asunto'];
            $mail->Body    = $mensaje;
            
            $mail->send();
            return true;
            echo 'Mensaje enviado';
        } catch (Exception $e) {
            echo "Error en el envío del mensaje: {$mail->ErrorInfo}";
        }
    }
    function getInfoPage(int $idpagina){
        require_once("Libraries/Core/Mysql.php");
        $con = new Mysql();
        $sql = "SELECT * FROM TBL_POST WHERE COD_POST = $idpagina";
        $request = $con->select($sql);
        return $request;
    }

    function getPermisos(int $idmodulo){
        require_once ("Models/PermisosModel.php");
        $objPermisos = new PermisosModel();
        
        //$idrol = $_SESSION['userData']['Id_Rol'];
        if (!empty($_SESSION['userData'])) {
            # code...
            $idrol = $_SESSION['userData']['COD_ROL'];
            $arrPermisos = $objPermisos->permisosModulo($idrol);
            $permisos = '';
            $PermisosMod = '';
    
            if(count($arrPermisos) > 0){
                $permisos = $arrPermisos;
                $PermisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
            }
            $_SESSION['permisos'] = $permisos;
            $_SESSION['permisosMod'] = $PermisosMod;
        }
    }
    
    function sessionUser(int $idpersona){
        require_once ("Models/LoginModel.php");
        $objLogin = new LoginModel();
        $request = $objLogin->sessionLogin($idpersona);
        return $request;
    }   
    function datosEmpresa(){
        require_once ("Models/LoginModel.php");
        $objLogin = new LoginModel();
        $request = $objLogin->datosEmpresa();
        return $request;
    }   

    function uploadImage(array $data, string $name){
        $url_temp = $data['tmp_name'];
        $destino    = 'Assets/images/uploads/'.$name;        
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }
    function getPageRout(string $ruta){
        require_once("Libraries/Core/Mysql.php");
        $con = new Mysql();
        $sql = "SELECT * FROM TBL_POST WHERE RUTA = '$ruta' AND COD_STATUS != 0 ";
        $request = $con->select($sql);
        if(!empty($request)){
            $request['PORTADA'] = $request['PORTADA'] != "" ? media()."/images/uploads/".$request['PORTADA'] : "";
        }
        return $request;
    }
function deleteFile(string $name){  
    unlink('Assets/images/uploads/'.$name);
 }

    //Elimina exceso de espacios entre palabras
    function strClean($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        $string = str_ireplace('22\r\n','\r\n   ',$string);
        return $string;
        
    }
    function clear_cadena(string $cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }
    //Genera una contraseña de 10 caracteres
	function passGenerator($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }
    //Genera un token
    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }
    //Formato para valores monetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad,2,SPD,SPM);
        return $cantidad;
    }
    function img64(){
        return img64;
    }
    //funcion para obtner la fecha y hora actual y enviarla al mysql
    function NOW(){
        $date = date('Y-m-d H:i:s');
        return $date;
    }
   function getTokenPaypal(){
       $payLogin= curl_init(URLPAYPAL."/v1/oauth2/token");
       curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER,FALSE);
       curl_setopt($payLogin, CURLOPT_RETURNTRANSFER ,TRUE);
       curl_setopt($payLogin, CURLOPT_USERPWD , IDCLIENTE.":".SECRET);
       curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
       $result = curl_exec($payLogin);
       $err = curl_error($payLogin);
       curl_close($payLogin);
       if ($err){
           $request="CURL Error #:" .$err;
       }else{
           $objData=json_decode($result);
           $request=$objData->access_token;
       }
    
      /*  curl_close($payLogin);
        $json = json_decode($result); */
       return $request;
   }

   function CurlConnectionGet(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){ 
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{ 
            $arrHeader = array('Content-Type:'.$content_type);
        } 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }
    function CurlConnectionPost(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){ 
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{ 
            $arrHeader = array('Content-Type:'.$content_type);
        } 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    
    //https://stackoverflow.com/questions/3139879/how-do-i-get-currency-exchange-rates-via-an-api-such-as-google-finance
    //Funcion 100 request por hora

    /* function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = '9ef98fb066a17158d3a5';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
        if (($json = @file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}")) === false) {
            $error = error_get_last();
            return "NULL";
           
      } else {
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);

        
        $total = $val * $amount;
        return number_format($total, 2, '.', '');
      } */


      function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = '9ef98fb066a17158d3a5';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
        if (($json = @file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}")) === false) {
            $error = error_get_last();
            return "NULL";
           
      } else {
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);

        
        $total = $val * $amount;
        return number_format($total, 2, '.', '');
      }
        // change to the free URL if you're using the free version
        //$json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        
      }

        
      
      
    function getRates($amount){        
        $app_id ='f07be6cae81a423fab3dac9717a16aef';
        $file = "latest.json";  
        //header("Content-Type: application/json");
        $json = file_get_contents("http://openexchangerates.org/api/{$file}?app_id={$app_id}&base=USD&symbols=HNL");
        $obj = json_decode($json);
        $rate_container = array();
        
        if(isset($obj->{"rates"})){
            foreach($obj->{"rates"} as $key=>$rate){
                $rate_container[$key]=$rate;
            }
        }
        $valor=$rate_container['HNL'];
        $total = $amount/$valor ;
        return number_format($total, 2, '.', '');
    }   

   function Meses(){
     $meses = array("Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre");
    return $meses;
     }
    function getCatFooter(){
        require_once ("Models/CategoriasModel.php");
        $objCategoria = new CategoriasModel();
        $request = $objCategoria->getCategoriasFooter();
        return $request;
 }
 
 function viewPage(int $idpagina){
    require_once("Libraries/Core/Mysql.php");
    $con = new Mysql();
    $sql = "SELECT * FROM TBL_POST WHERE COD_POST = $idpagina ";
    $request = $con->select($sql);
    if( ($request['COD_STATUS'] == 2 AND isset($_SESSION['permisosMod']) AND $_SESSION['permisosMod']['u'] == true) OR $request['COD_STATUS'] == 1){
        return true;        
    }else{
        return false;
    }
 }
?>