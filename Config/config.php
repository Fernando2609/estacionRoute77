<?php
    //Fernando 

    //require_once("Models/CategoriasModel.php"); 
    //Fernadno 23/10/2021

    //Definición de constantes
    //define('BASEURL', 'http://localhost:/route77/');
/*
   const BASE_URL="https://estacionroute77.com";
   

	//const BASE_URL="http://localhost/route77";

	//Para envío de correo
	const ENVIRONMENT = 0; // Local: 0, Produccón: 1;
    //Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	//const DB_NAME = "db_route";
    const DB_NAME = "u251006101_db_route";
	const DB_USER = "u251006101_Fernando";
	const DB_PASSWORD = "routeEstacion76+1";
	const DB_CHARSET = "utf8";
*/
	//const BASE_URL="http://localhost/route77";
   
    //Definición de constantes
    //define('BASEURL', 'http://localhost:8080/route77/');
    const BASE_URL="http://localhost:8080/estacionRoute77/";

    //Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	//const DB_NAME = "db_route";
    const DB_NAME = "db_route77";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";

    //Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";
    
    //Simbolo de moneda
	const SMONEY = "L";
	const CURRENCY = "LPS";

    //Zona horaria
	date_default_timezone_set('America/Tegucigalpa');
    
//SANDBOX
	//Cuenta Prueba: sb-lrh2t8250598@personal.example.com;
	//contraseña Prueba:route77
	const URLPAYPAL= "https://api-m.sandbox.paypal.com";
	const IDCLIENTE="AW-GazKFas6VozK_zb29ZqBhrkbW6XZQ5_NnOuTQljqniRrlSRM-Q89rMIq2Iq20EEzzvY8WDTL0M79C";
	const SECRET="EF8AzlNNx_MTenCKea4d9NY2H2M8nupC9XoU3NAIxRuTwsZS86-JpgpZN71rM1O_AixNrMY-TmbnahwK";
	//LIVE
	/* const URLPAYPAL= "https://api-m.paypal.com";
	const IDCLIENTE="AebH60XEhltFQq9Wz-1MT50V3UQ3my1nQnlZ-VZmlRsY039aehjSAAjo233dtS49bBtWf2ulHfdKkcM9";
	const SECRET="EMcfARjqBsEbmiOyhEd6OfeTNC32jzMNZ3oinVbQcDJcugTC3mRZE6UlmMbTBzt4KwbSKCpyqBM9d8wE"; */
	
	//Datos envio de correo
	const NOMBRE_REMITENTE = "Route 77";
	const EMAIL_REMITENTE = "estacionroutehn@gmail.com";
	const NOMBRE_EMPESA = "Route 77";
	const WEB_EMPRESA = "http://localhost:8080/route77";
//DATOS EMPRESA
	const DIRECCION = "Col. Los Laureles";
	const TELEMPRESA= "+504 9643-2601";
	const EMAIL_EMPRESA = "estacionroutehn@gmail.com";
	const EMAIL_PEDIDOS = "estacionroutehn@gmail.com";

	const CAT_SLIDER = "10,5,1,6";
	const CAT_BANNER = "10,5,1";

	//Datos para Encriptar / Desencriptar
	const KEY = 'route77';
	const METHODENCRIPT = "AES-128-ECB";

	const COSTOENVIO=10;

	const emailGerente="josefortizsantos@gmail.com";
?>