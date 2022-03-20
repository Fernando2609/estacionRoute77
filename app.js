// ! CONSTANTES
const express = require("express");
const mysql = require("mysql");
const bodyParser = require("body-parser");
const jwt= require('jsonwebtoken');

const key="ClaveRoute77";
// ! PUERTO
const PORT = process.env.PORT || 3050;

const app = express();
// ! BODY PASER
app.use(bodyParser.json());

//! CONEXION AL MYSQL
var connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "db_route77",
});


// !------------HUGO PAZ----------------!
//TODO:LOGIN

app.post("/login", (req, res) => {
  const sql = `CALL LOGIN('${req.body.usuario}',"${req.body.contraseña}","V",null)`;
  const customerobj = {
    PV_USUARIO: req.body.usuario,
    PV_CONTRASEÑA: req.body.contraseña
  };
  connection.query(sql, customerobj, (error,results) => {
    if (error) throw error;
    if (results[0][0]["@CONTADOR"] > 0) {
     
      const payload = {
        check: true,
      };
      jwt.sign({ payload }, "Secretkey",/*{expiresIn:'10s'},*/ (err, token) => {
        res.json({
          mensaje:"LOGIN INICIADO",
          token: token
        });
      });
    } else {
      res.send("LOGIN INCORRECTO");
    }
  });
});

// !------------FERNANDO ORTIZ----------------!
//TODO: API OrdenCompra
//? View OrdenCompra
app.get("/OrdenCompra", verifyToken, (req, res) => {

  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = "CALL CRUD_ORDEN_COMPRA(null,null,null,null,null,'V',null);";
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//? Read OrdenCompra
app.get("/OrdenCompra/:id",verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{ 
     if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
        const sql = `CALL CRUD_ORDEN_COMPRA(null,null,null,null,null,'R',${id});`;
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
      }
  });
});

//? INSERT PROVEEDOR
app.post("/agregarOrdenCompra", verifyToken, (req, res) => {

  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = `CALL CRUD_ORDEN_COMPRA('${req.body.Proveedor}', '${req.body.Producto}','${req.body.Precio}', '${req.body.cantidad}','${req.body.ISV}','I',null)`;
      const customerobj = {
        PI_COD_PROVEEDOR: req.body.Proveedor,
        PI_COD_PRODUCTO: req.body.Producto,
        PD_PRECIO: req.body.Precio,
        PI_CANT_COMPRA: req.body.cantidad,
        PD_ISV: req.body.ISV,
      };
      connection.query(sql, customerobj, (error, results) => {
        if (error) throw error;
        res.send("Orden Agregada");
      });
    }
  });
});

//? UPDATE OrdenCompra
app.put("/updateOrdenCompra/:id",verifyToken, (req, res) => {
  const { id } = req.params;
  const { Proveedor } = req.body;
  const { Producto } = req.body;
  const { Precio } = req.body;
  const { cantidad } = req.body;
  const { ISV } = req.body;
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_ORDEN_COMPRA('${Proveedor}', '${Producto}','${Precio}', '${cantidad}','${ISV}','U',${id})`;
       connection.query(sql, (error) => {
         if (error) throw error;
         res.send("Orden Actualizada");
       });
     }
   });
});

//? DELETE OrdenCompra
app.delete("/deleteOrdenCompra/:id",verifyToken, (req, res) => {
  const { id } = req.params;
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_ORDEN_COMPRA(null,null,null,null,null,'D',${id})`;
       connection.query(sql, (error) => {
         if (error) throw error;
         res.send("Orden eliminada");
       });
     }
   });
});
//TODO: TERMINA API ORDEN COMPRA


//TODO: API Proveedores
//? View Proveedores
app.get("/Proveedores",verifyToken, (req, res) => {
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql =
         "CALL CRUD_PROVEEDOR(null,null,null,null,null,null,null,null,null,null,null,'V',null);";
       connection.query(sql, (error, results) => {
         if (error) throw error;
         if (results.length > 0) {
           res.json(results);
         } else {
           res.send("Sin resultados");
         }
       });
     }
   });
});

//? Read ProveedOres
app.get("/Proveedores/:id",verifyToken, (req, res) => {
  const { id } = req.params;
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_PROVEEDOR(null,null,null,null,null,null,null,null,null,null,null,'R',${id});`;
       connection.query(sql, (error, results) => {
         if (error) throw error;
         if (results.length > 0) {
           res.json(results);
         } else {
           res.send("Sin resultados");
         }
       });
     }
   });
});

//? INSERT PROVEEDOR
app.post("/agregarProveedores",verifyToken, (req, res) => {

   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_PROVEEDOR('${req.body.nombres}', '${req.body.apellidos}','${req.body.email}', '${req.body.status}','${req.body.rol}',
                                  '${req.body.telefono}','${req.body.empresa}','${req.body.rtn}','${req.body.ubicacion}', '${req.body.creadopor}',null,
                                  'I',null)`;
       //('Carla','Gomez','cGomez@gmail.com',1,1,9898131,'La colonia',98909809,'La flor','I',null);

       const customerobj = {
         nombres: req.body.nombres,
         apellidos: req.body.apellidos,
         email: req.body.email,
         status: req.body.status,
         rol: req.body.rol,
         telefono: req.body.telefono,
         nom_empresa: req.body.empresa,
         rtn: req.body.rtn,
         ubicacion: req.body.ubicacion,
         creadopor: req.body.creadopor,
       };
       connection.query(sql, customerobj, (error) => {
         if (error) throw error;
         res.send("Proveedor agregado");
       });
     }
   });
});

//? UPDATE PROVEEDOR
app.put("/updateProveedores/:id",verifyToken, (req, res) => {
  const { id } = req.params;
  const { nombres } = req.body.nombres;
  const { apellidos } = req.body.apellidos;
  const { email } = req.body.email;
  const { status } = req.body.status;
  const { rol } = req.body.rol;
  const { telefono } = req.body.telefono;
  const { empresa } = req.body.empresa;
  const { rtn } = req.body.rtn;
  const { ubicacion } = req.body.ubicacion;
  const { modificadopor } = req.body.modificadopor;
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_PROVEEDOR('${req.body.nombres}', '${req.body.apellidos}','${req.body.email}', '${req.body.status}','${req.body.rol}',
  '${req.body.telefono}','${req.body.empresa}','${req.body.rtn}','${req.body.ubicacion}',null,'${req.body.modificadopor}',
  'U',${id})`;
       connection.query(sql, (error) => {
         if (error) throw error;
         res.send("Proveedor Actualizado");
       });
     }
   });
});

//? DELETE Proveedor
app.delete("/deleteProveedores/:id",verifyToken, (req, res) => {
  const { id } = req.params;
   jwt.verify(req.token, "Secretkey", (error, authData) => {
     if (error) {
       res.send("ACCESO RESTRINGIDO");
     } else {
       const sql = `CALL CRUD_PROVEEDOR(null,null,null,null,null,null,null,null,null,null,null,'D',${id})`;
       connection.query(sql, (error) => {
         if (error) throw error;
         res.send("Proveedor eliminado");
       });
     }
   });
});
//TODO: TERMINA API PROOVERDORES

//TODO: API INVENTARIO
//? View Inventario
app.get("/Inventario", (req, res) => {
  const sql =
    "CALL INVENTARIO('V',null);";
  connection.query(sql, (error, results) => {
    if (error) throw error;
    if (results.length > 0) {
      res.json(results);
    } else {
      res.send("Sin resultados");
    }
  });
});

//? Read Inventario
app.get("/Inventario/:id", (req, res) => {
  const { id } = req.params;
  const sql = `CALL INVENTARIO('R',${id});`;
  connection.query(sql, (error, results) => {
    if (error) throw error;
    if (results.length > 0) {
      res.json(results);
    } else {
      res.send("Sin resultados");
    }
  });
});
//TODO: TERMINA API Inventario




// !------------ LEONELA PINEDA ----------------!
//TODO: API SUCURSAL
//? View SUCURSAL
app.get("/Sucursal", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = "CALL CRUD_SUCURSAL(null, null,'V',null)";
      connection.query(sql, (error, results) => {
      if (error) throw error;
      if (results.length > 0) {
       res.json(results);
      } else {
      res.send("Sin resultados");
     } 
    });
    }
  })
});

//? Read SUCURSAL
app.get("/Sucursal/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
     if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_SUCURSAL(null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        }else{
         res.send("Sin resultados");
        }
      });
    }
  }); 
});

//? Insert SUCURSAL
app.post("/agregarSucursal", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_SUCURSAL('${req.body.nombre}','${req.body.descripcion}','I',null)`;
      const customerobj = {
        nombre: req.body.nombre,
        descripcion: req.body.descripcion,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Sucursal Creada");
      });
    }
  });  
});

//? UPDATE SUCURSAL
app.put("/updateSucursal/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
  const { nombre } = req.body;
  const { descripcion } = req.body;
     if (error) {
      res.send("ACCESO RESTRINGIDO");
     }else{
       const sql = `CALL CRUD_SUCURSAL('${nombre}','${descripcion}','U',${id})`;
       connection.query(sql, (error) => {
       if (error) throw error;
        res.send("Sucursal Actualizado");
      });
    }  
  });   
});

//? DELETE SUCURSAL
app.delete("/deleteSucursal/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_SUCURSAL(null,null,'D',${id})`;
      connection.query(sql, (error) => {
      if (error) throw error;
      res.send("Sucursal Eliminada");
     });
    }
  });
});
//TODO: API SUCURSAL

//TODO: API CLIENTE
//? View CLIENTE
app.get("/Cliente", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
    const sql = `CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'V',null)`;
    connection.query(sql, (error, results) => {
      if (error) throw error;
      if (results.length > 0) {
        res.json(results);
      } else {
        res.send("Sin resultados");
      }
    });
    }
  });
});

//? Read CLIENTE
app.get("/Cliente/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }  
  });
});
//INSERT CLIENTE 
app.post("/agregarCliente", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_CLIENTE('${req.body.nombres}', '${req.body.apellidos}','${req.body.email}', 
                                    '${req.body.contraseña}', '${req.body.rol}', '${req.body.status}',
                                    '${req.body.telefono}', '${req.body.creadopor}', '${req.body.modificadopor}',
                                    'I',null)`;
      const customerobj={
        nombres: req.body.nombres,
        apellidos: req.body.apellidos,
        email: req.body.email,
        contraseña: req.body.contraseña,
        rol: req.body.rol,
        status: req.body.status,
        telefono: req.body.telefono,
        creadopor: req.body.creadopor,
        modificadopor: req.body.modificadopor
      }
      connection.query(sql,customerobj,error=>{
        if(error) throw error;
        res.send('Cliente Creado');
      });
    }  
  });
});


//? UPDATE CLIENTE
app.put("/updateCliente/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  const { nombres } = req.body;
  const { apellidos } = req.body;
  const { email } = req.body;
  const { contraseña } = req.body;
  const { rol } = req.body;
  const { status } = req.body;
  const { telefono } = req.body;
  const { creado_por } = req.body;
  const { modificado_por } = req.body;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_CLIENTE('${nombres}','${apellidos}','${email}', '${contraseña}','${rol}',
                                    '${status}', '${telefono}','${creado_por}', '${modificado_por}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Cliente Actualizado");
      });
    }
  });
});

//? DELETE CLIENTE
app.delete("/deleteCliente/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'D',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Cliente Eliminado");
      });
    }
  });
});

//TODO: TERMINA API CLIENTE

//TODO: API USUARIO
//? View USUARIO
app.get("/Usuario", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,'V',null)`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }  
  });
});

//? Read Usuario
app.get("/Usuario/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }  
  });
});

//? INSERT USUARIO
app.post("/agregarUsuario", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_USUARIO('${req.body.nombres}', '${req.body.apellidos}','${req.body.email}','${req.body.contraseña}', '${req.body.rol}', '${req.body.status}','${req.body.telefono}',  '${req.body.sucursal}',  '${req.body.genero}','${req.body.dni}', '${req.body.creado_por}', '${req.body.modificado_por}','I',null)`;
      const customerobj = {
        nombres: req.body.nombres,
        apellidos: req.body.apellidos,
        email: req.body.email,
        contraseña: req.body.contraseña,
        rol: req.body.rol,
        status: req.body.status,
        telefono: req.body.telefono,
        sucursal: req.body.sucursal,
        genero: req.body.genero,
        dni: req.body.dni,
        creado_por: req.body.creado_por,
        modificado_por: req.body.modificado_por,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Usuario Creado");
      });
    }  
  });
});

//? UPDATE USUARIO
app.put("/updateUsuario/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  const { nombres } = req.body;
  const { apellidos } = req.body;
  const { email } = req.body;
  const { contraseña } = req.body;
  const { rol } = req.body;
  const { status } = req.body;
  const { telefono } = req.body;
  const { sucursal } = req.body;
  const { genero } = req.body;
  const { dni } = req.body;
  const { creado_por } = req.body;
  const { modificado_por } = req.body;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_USUARIO('${nombres}','${apellidos}','${email}','${contraseña}','${rol}','${status}','${telefono}','${sucursal}','${genero}','${dni}','${creado_por}','${modificado_por}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Usuario Actualizado");
      });
    }  
  });
});

//? DELETE USUARIO
app.delete("/deleteUsuario/:id", verifyToken,(req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
    const sql = `CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,'D',${id})`;
    connection.query(sql, (error) => {
      if (error) throw error;
      res.send("Usuario Eliminado");
      });
    }  
  });
});
//TODO:TERMINA API USUARIO

//TODO: API GENERO
//? VIEW
app.get("/Genero", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = "CALL CRUD_GENERO(null,'V',null)";
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  });
});
//? READ
app.get("/Genero/:id", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const { id } = req.params;
      const sql = `CALL CRUD_GENERO(null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  });
});

//? INSERT GENERO
app.post("/agregarGenero", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_GENERO('${req.body.descripcion}','I',null)`;
      const customerobj = {
        descripcion: req.body.descripcion,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Genero Creado");
      });
    }
  });
});

//?  UPDATE GENERO
app.put("/updateGenero/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  const { descripcion } = req.body;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_GENERO('${descripcion}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Genero Actualizado");
      });
    }
  });
});
//? DELETE GENERO
app.delete("/deleteGenero/:id", verifyToken, (req, res) => {
  const { id } = req.params;
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql = `CALL CRUD_GENERO(null,'D',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Genero Eliminado");
      });
    }
  });
});
//TODO: Termina API GENERO
// !------------ GABRIELA MARADIAGA ----------------!
//TODO: API EMPRESA
//? VIEW
app.get("/Empresa",verifyToken, (req, res) => {

  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = "CALL CRUD_EMPRESA(null,null,null,null,null,'V',null)";
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//? READ
app.get("/Empresa/:id",verifyToken, (req, res) => {

  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_EMPRESA(null,null,null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

// ? INSERT
app.post("/agregarEmpresa",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = `CALL CRUD_EMPRESA('${req.body.nombre_empresa}','${req.body.direccion}','${req.body.razon_social}','${req.body.email}','${req.body.gerente_general}','I',null)`;
      const customerobj = {
        nombre_empresa: req.body.nombre_empresa,
        direccion: req.body.direccion,
        razon_social: req.body.razon_social,
        email: req.body.email,
        gerente_general: req.body.gerente_general,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Empresa Creada");
      });
    }
  })
});

//?  UPDATE
app.put("/updateEmpresa/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const { nombre_empresa } = req.body;
      const { direccion } = req.body;
      const { razon_social } = req.body;
      const { email } = req.body;
      const { gerente_general } = req.body;
      const sql = `CALL CRUD_EMPRESA('${nombre_empresa}','${direccion}','${razon_social}','${email}','${gerente_general}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Empresa Actualizada");
      });
    }
  })
});

//API EMPRESA
//DELETE
/* app.delete("/deleteEmpresa/:id",verifyToken, (req, res) => {
   jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
   const { id } = req.params;
   const sql = `CALL CRUD_EMPRESA(null,null,null,null,null,'D',${id})`;
   connection.query(sql, (error) => {
     if (error) throw error;
     res.send("Empresa Eliminada");
   });
  }
})
}); */
//TODO: TERMINA API EMPRESA

//TODO: API REDES SOCIALES
//?  VIEW
app.get("/REDES_SOCIALES",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = "CALL CRUD_REDES_SOCIALES(null,null,null,'V',null)";

      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

// ? READ
app.get("/REDES_SOCIALES/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_REDES_SOCIALES(null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//? INSERT
app.post("/agregarREDES_SOCIALES",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = `CALL CRUD_REDES_SOCIALES('${req.body.COD_empresa}','${req.body.descripcion}','${req.body.enlace}','I',null)`;
      const customerobj = {
        COD_empresa: req.body.COD_empresa,
        descripcion: req.body.descripcion,
        enlace: req.body.enlace,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Redes Sociales Creada");
      });
    }
  })
});

//? UPDATE
app.put("/updateREDES_SOCIALES/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const { COD_empresa } = req.body;
      const { descripcion } = req.body;
      const { enlace } = req.body;
      const sql = `CALL CRUD_REDES_SOCIALES('${COD_empresa}','${descripcion}','${enlace}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Redes Sociales Actualizada");
      });
    }
  })
});

//? DELETE
app.delete("/deleteREDES_SOCIALES/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_REDES_SOCIALES(null,null,null,'D',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Redes Sociales Eliminada");
      });
    }
  })
});
//TODO: TERMINA API REDES SOCIALES

//TODO: API TELEFONO EMPRESA
//? VIEW
app.get("/TELEFONO_EMPRESA",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = "CALL CRUD_TELEFONO_EMPRESA(null,null,'V',null)";

      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//? READ
app.get("/TELEFONO_EMPRESA/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_TELEFONO_EMPRESA(null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//?INSERT
app.post("/agregarTELEFONO_EMPRESA",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = `CALL CRUD_TELEFONO_EMPRESA('${req.body.COD_empresa}','${req.body.telefono}','I',null)`;
      const customerobj = {
        COD_empresa: req.body.COD_empresa,
        telefono: req.body.telefono,
      };
      connection.query(sql, customerobj, (error) => {
        if (error) throw error;
        res.send("Telefono Empresa Creada");
      });
    }
  })
});

//? UPDATE
app.put("/updateTELEFONO_EMPRESA/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const { COD_empresa } = req.body;
      const { telefono } = req.body;
      const sql = `CALL CRUD_TELEFONO_EMPRESA('${COD_empresa}','${telefono}','U',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Telefono Empresa Actualizada");
      });
    }
  })
});

//? DELETE
app.delete("/deleteTELEFONO_EMPRESA/:id",verifyToken, (req, res) => {
  jwt.verify(req.token, 'Secretkey', (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_TELEFONO_EMPRESA(null,null,'D',${id})`;
      connection.query(sql, (error) => {
        if (error) throw error;
        res.send("Telefono Empresa Eliminada");
      });
    }
  })
});
//TODO TERMINA API TELEFONO EMPRESA

// !------------KEVIN ZUNIGA----------------!
//TODO: API PRODUCTOS
// ? VIEW

app.get("/Productos", verifyToken, (req, res) => {
    jwt.verify(req.token,'Secretkey',(error,authData)=>{
      if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
  
    const sql = "CALL CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,'V',null)";
  
    connection.query(sql, (error, results) => {
      if (error) throw error;
      if (results.length > 0) {
        res.json(results);
      } else {
        res.send("Sin resultados");
      }
    });
  }
  })
  });
  
  
  // ? READ
  app.get("/Productos/:id",verifyToken, (req, res) => {
    jwt.verify(req.token,'Secretkey',(error,authData)=>{
      if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
    const { id } = req.params;
    const sql = `CALL CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,'R',${id})`;
    connection.query(sql, (error, results) => {
      if (error) throw error;
      if (results.length > 0) {
        res.json(results);
      } else {
        res.send("Sin resultados");
      }
    });
  }
  })
  });
  //? Insert Producto
  app.post("/agregarProducto",verifyToken, (req, res) => {
    jwt.verify(req.token,'Secretkey',(error,authData)=>{
      if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
      
    const sql = `CALL CRUD_PRODUCTOS(${req.body.categoria},'${req.body.barra}','${req.body.Nombre}','${req.body.Descripcion}',${req.body.Precio},'${req.body.Creado_Por}',${req.body.Modificado_Por},${req.body.Status},'I',null)`;
    const customerobj = {
      Cod_Categoria: req.body.categoria,
      Cod_Barra: req.body.barra,
      Nombre: req.body.Nombre,
      Descripcion: req.body.Descripcion,
      Precio: req.body.Precio,
      Creado_Por: req.body.Creado_Por,
      Modificado_Por: req.body.Modificado_Por,
      Cod_Status: req.body.Status,
    };
    connection.query(sql, customerobj, (error) => {
      if (error) throw error;
      res.send("Producto Creado");
    });
  }
  })
  });
  
  
  //? Update Producto
  app.put("/updateProducto/:id",verifyToken, (req, res) => {
    jwt.verify(req.token,'Secretkey',(error,authData)=>{
      if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
    const { id } = req.params;
    const { categoria } = req.body;
    const { barra } = req.body;
    const { Nombre } = req.body;
    const { Descripcion } = req.body;
    const { Precio } = req.body;
    const { Creado_por } = req.body;
    const { Modificado_Por } = req.body;
    const { Status } = req.body;
  
    const sql = `CALL CRUD_PRODUCTOS(${categoria},'${barra}','${Nombre}','${Descripcion}',${Precio},${Creado_por},${Modificado_Por},${Status},'U',${id})`;
    connection.query(sql, (error) => {
      if (error) throw error;
      res.send("Producto Actualizado");
    });
  }
  })
  });
  
  //? DELETE Producto
  app.delete("/deleteProducto/:id",verifyToken, (req, res) => {
    jwt.verify(req.token,'Secretkey',(error,authData)=>{
      if (error) {
        res.send("ACCESO RESTRINGIDO");
      }else{
  
    const { id } = req.params;
    const sql = `CALL CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,'D',${id})`;
    connection.query(sql, (error) => {
      if (error) throw error;
      res.send("Producto Eliminado");
    });
  }
  })
  });
  //TODO: Termina API PRODUCTOS
// !------------VICTOR GARCIA----------------!

//TODO: API TABLA PEDIDO 

//? VIEW
app.get("/Pedido", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const sql ="CALL CRUD_PEDIDO(null,null,null,null,null,null,null,null,null,'V',null)";
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  })
});

//? READ
app.get("/Pedido/:id",  verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
      const { id } = req.params;
      const sql = `CALL CRUD_PEDIDO(null,null,null,null,null,null,null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
      if (error) throw error;
      if (results.length > 0) {
       res.json(results);
      } else {
        res.send("Sin resultados");
      }
    });
  }
  })
});

//? INSERT
app.post("/agregarPedido",  verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
    const sql = `CALL CRUD_PEDIDO(${req.body.cod_persona},${req.body.cod_producto},${req.body.cantidad},
                                ${req.body.costoenvio},${req.body.cod_tipo_pago},'${req.body.direccion_envio}',
                                ${req.body.cod_estado},${req.body.creado_por},${req.body.modificado_por},'I',null)`;
    const customerobj = {
      cod_persona: req.body.cod_persona,
      cod_producto: req.body.cod_producto,
      cantidad: req.body.cantidad,
      costoenvio: req.body.costoenvio,
      cod_tipo_pago: req.body.cod_tipo_pago,
      direccion_envio: req.body.direccion_envio,
      cod_estado: req.body.cod_estado,
      creado_por: req.body.creado_por,
      modificado_por: req.body.modificado_por,
    };
    connection.query(sql, customerobj, (error) => {
      if (error) throw error;
       res.send("Pedido Insertado");
  });
  }
})
});

//? UPDATE
app.put("/updatePedido/:id",  verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
  const { id } = req.params;
  const { cod_persona } = req.body;
  const { cod_producto } = req.body;
  const { cantidad } = req.body;
  const { costoenvio } = req.body;
  const { cod_tipo_pago } = req.body;
  const { direccion_envio } = req.body;
  const { cod_estado } = req.body;
  const { creado_por } = req.body;
  const { modificado_por } = req.body;

  const sql = `CALL CRUD_PEDIDO(${cod_persona},${cod_producto},${cantidad},${costoenvio},${cod_tipo_pago},'${direccion_envio}',${cod_estado},${creado_por},${modificado_por},'U',${id})`;

  connection.query(sql, (error) => {
    if (error) throw error;
    res.send("Pedido Actualizado");
  });
}
})
});

//? DELETE
app.delete("/deletePedido/:id", verifyToken,  (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
  const { id } = req.params;
  const sql = `CALL CRUD_PEDIDO(null,null,null,null,null,null,2,null,null,'E',${id})`;
  connection.query(sql, (error) => {
    if (error) throw error;
    res.send("Pedido Completado");
  
  });
}
})
});

//TODO: TERMINA API PEDIDO

// !------------HUGO PAZ----------------!

app.get("/Categoria", verifyToken, (req, res) => {
  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = "CALL CRUD_CATEGORIA(1,null,null,null,null,null,'V',null)";
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  });
});

//? READ
app.get("/Categoria/:id", verifyToken, (req, res) => {
  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_CATEGORIA(1,null,null,null,null,null,'R',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Sin resultados");
        }
      });
    }
  });
});

//? INSERT
app.post("/agregarCategoria", verifyToken, (req, res) => {
  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const sql = `CALL CRUD_CATEGORIA(1,'${req.body.descripcion}','${req.body.nombre}','${req.body.portada}',${req.body.creado_por},null,'I',null);`;
      const customerobj = {
        descripcion: req.body.descripcion,
        nombre: req.body.nombre,
        Portada: req.body.portada,
        creado_por: req.body.creado_por,
      };

      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Categoría Agregada");
        }
      });
    }
  });
});

//? UPDATE
app.put("/updateCategoria/:id", verifyToken, (req, res) => {
  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const { descripcion } = req.body.descripcion;
      const { nombre } = req.body.nombre;
      const { portada } = req.body.portada;
      const { modificado_por } = req.body.modificado_por;
      const sql = `CALL CRUD_CATEGORIA(1,'${req.body.descripcion}','${req.body.nombre}','${req.body.portada}',null,'${req.body.modificado_por}','U',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Categoría Actualizada");
        }
      });
    }
  });
});

//? DELETE
app.delete("/deleteCategoria/:id", verifyToken, (req, res) => {
  jwt.verify(req.token, "Secretkey", (error, authData) => {
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    } else {
      const { id } = req.params;
      const sql = `CALL CRUD_CATEGORIA(1,null,null,null,null,null,'D',${id})`;
      connection.query(sql, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          res.json(results);
        } else {
          res.send("Categoría eliminada");
        }
      });
    }
  });
});
//TODO: TERMINA API CATEGORIA
// !------------REYNALDO GIRÓN----------------!
//TODO: API MODULO ROLES
//  ? View all
app.get("/Roles", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const sql = "CALL CRUD_ROLES(null, null, null,'V', null)";
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
    }  
  })      
});
// ?    Read
app.get("/Roles/:id", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const sql = `CALL CRUD_ROLES(null, null, null,'R',${id})`;
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
    }
  })      
});
//?  Insert
app.post("/agregarRol", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const sql = `CALL CRUD_ROLES('${req.body.nombreRol}','${req.body.descripcionRol}','${req.body.statusRol}','I',null)`;
        const customerobj = {
          nombreRol: req.body.nombreRol,
          descripcionRol: req.body.descripcionRol,
          statusRol: req.body.statusRol,
        };
        connection.query(sql, customerobj, (error) => {
          if (error) throw error;
          res.send("¡Rol agregado con exito!");
        });
    }
  })      
});
// ?  Update
app.put("/updateRol/:id", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const customerobj = {
          nombreRol: req.body.nombreRol,
          descripcionRol: req.body.descripcionRol,
          statusRol: req.body.statusRol,
        };
        const sql = `CALL CRUD_ROLES('${req.body.nombreRol}','${req.body.descripcionRol}','${req.body.statusRol}','U',${id})`;
        connection.query(sql, (error) => {
          if (error) throw error;
          res.send("Rol Actualizado");
        });
    }
  })      
});
// ? Delete
app.delete("/deleteRol/:id", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const sql = `CALL CRUD_ROLES(null, null, null,'D',${id})`;
        connection.query(sql, (error) => {
          if (error) throw error;
          res.send("Rol Eliminado");
        });
    }
  })      
});
///-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//TODO: API MODULO PERMISOS
//  ? Read
app.get("/Permisos/:id", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const sql = `CALL CRUD_PERMISOS(${id},null,null,null,null,null,"R",null)`;
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
    }
  })      
});
//? Insert
app.post("/agregarPermiso", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const sql = `CALL CRUD_PERMISOS(${req.body.cod_rol},${req.body.cod_modulo},${req.body.r},${req.body.w},${req.body.u},${req.body.d},'I',null)`;
        const customerobj = {
          cod_rol: req.body.cod_rol,
          cod_modulo: req.body.cod_modulo,
          r: req.body.r,
          w: req.body.w,
          u: req.body.u,
          d: req.body.d,
        };
        connection.query(sql, customerobj, (error) => {
          if (error) throw error;
          res.send("Permiso Creado");
        });
    }  
  })     
});
// ? Update
app.put("/updatePermiso/:id_rol/:id_mod", verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id_rol } = req.params;
        const { id_mod } = req.params;
        const { descripcion } = req.body;
        const customerobj = {
          r: req.body.r,
          w: req.body.w,
          u: req.body.u,
          d: req.body.d,
        };
        const sql = `CALL CRUD_PERMISOS(${id_rol},${id_mod},${req.body.r},${req.body.w},${req.body.u},${req.body.d},'U',null)`;
        connection.query(sql, (error) => {
          if (error) throw error;
          res.send("Permiso Actualizado");
        });
    }
  })      
});
// TODO: TERMINA API PERMISOS
///*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// TODO: API MODULO MODULOS
//  ? View
app.get("/Modulos",verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const sql = `CALL CRUD_MODULOS(null, null, null, null, "V", null)`;
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
    }
  })      
});
// ? Read
app.get("/modulos/:id_rol",verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id_rol } = req.params;
        const sql = `CALL CRUD_MODULOS(null, null, null,null, "R", ${id_rol})`;
        connection.query(sql, (error, results) => {
          if (error) throw error;
          if (results.length > 0) {
            res.json(results);
          } else {
            res.send("Sin resultados");
          }
        });
    }
  })      
});
//? Insert
app.post("/agregarModulo",verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const sql = `CALL CRUD_MODULOS('${req.body.nombre_mod}','${req.body.descripcion_mod}','${req.body.status_mod}',null,'I',null)`;
        const customerobj = {
          nombre_mod: req.body.nombre_mod,
          descripcion_mod: req.body.descripcion_mod,
          status_mod: req.body.status_mod,
        };
        connection.query(sql, customerobj, (error) => {
          if (error) throw error;
          res.send("Modulo Creado");
        });
    }
  })      
});
// ? Update
app.put("/updateModulo/:id",verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const { nombre_mod } = req.body;
        const { descripcion_mod } = req.body;
        const { status_mod } = req.body;
        const sql = `CALL CRUD_MODULOS('${req.body.nombre_mod}','${req.body.descripcion_mod}','${req.body.status_mod}',null,'U',${id})`;
        connection.query(sql, (error) => {
          if (error) throw error;
          res.send("Modulo Actualizado");
        });
    }
  })      
});
// ? Delete
app.delete("/deleteModulo/:id",verifyToken, (req, res) => {
  jwt.verify(req.token,'Secretkey',(error,authData)=>{
    if (error) {
      res.send("ACCESO RESTRINGIDO");
    }else{
        const { id } = req.params;
        const sql = `CALL CRUD_MODULOS(null, null, null, null, "D",${id})`;
        connection.query(sql, (error) => {
          if (error) throw error;
          res.send("Modulo Eliminado");
        });
    }
  })  
});
//TODO: TERMINA API MODULO

//Authorization: Bearer <token>
function verifyToken(req,res,next) {
  const bearerHeader = req.headers["authorization"];
  if (typeof bearerHeader !== 'undefined') {
      const bearerToken=bearerHeader.split(" ")[1];
      req.token=bearerToken;
      next();
  }else{
    res.send("ACCESO RESTRINGIDO");
  }
}


// ! PRUEBA DE CONEXIONES
connection.connect(function (err) {
  if (err) throw error;

  console.log("todo Correcto");
});

app.listen(PORT, () => {
  console.log(`Servidor Corriendo`);
});
