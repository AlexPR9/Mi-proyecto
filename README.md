# Proyecto API REST con PHP y Frontend en HTML, CSS y JavaScript

Este proyecto consiste en una API REST desarrollada en PHP puro para la gestión de productos y categorías, con un frontend en HTML, CSS y JavaScript utilizando Bootstrap.

##  Instrucciones de Instalación

### 1. Clonar el Repositorio
```bash
https://github.com/AlexPR9/Mi-proyecto.git
```

### 2. Mover el Proyecto a la Carpeta de XAMPP
Coloca la carpeta `mi-proyecto` en la siguiente ruta:
```bash
D:\PROGRAMAS\Programacion\xampp\htdocs\mi-proyecto
```

### 3. Configurar Base de Datos

- Abrir **phpMyAdmin** en tu navegador:
```
http://localhost/phpmyadmin/
```
- Crear la base de datos `examen`.
- Importar el archivo SQL ubicado en:
```
/mi-proyecto/database/mi_proyecto.sql
```

### 4. Configuración de la Base de Datos

- Edita el archivo `config/database.php` si necesitas cambiar credenciales.

```php
<?php
$host = 'localhost';
$db_name = 'examen';
$username = 'root';
$password = '';
?>
```

##  Ejecución del Proyecto

### 1. Iniciar el Servidor XAMPP
- Abrir XAMPP y activar los servicios **Apache** y **MySQL**.

### 2. Probar API desde Postman

#### Listar Categorías
```
GET http://localhost/mi-proyecto/public/index.php/categorias
```

#### Obtener Categoría por ID
```
GET http://localhost/mi-proyecto/public/index.php/categorias?id=1
```

#### Listar Productos
```
GET http://localhost/mi-proyecto/public/index.php/productos
```

#### Obtener Producto por ID
```
GET http://localhost/mi-proyecto/public/index.php/productos?id=1
```

#### Crear Producto
```
POST http://localhost/mi-proyecto/public/index.php/productos
Body (raw, JSON):
{
    "nombre": "Nuevo Producto",
    "descripcion": "Descripción del producto",
    "precio": 50.00,
    "categoria_id": 1,
    "stock": 20
}
```

#### Actualizar Producto
```
PUT http://localhost/mi-proyecto/public/index.php/productos?id=1
Body (raw, JSON):
{
    "nombre": "Producto Actualizado",
    "descripcion": "Descripción actualizada",
    "precio": 55.00,
    "categoria_id": 2,
    "stock": 15
}
```

#### Eliminar Producto
```
DELETE http://localhost/mi-proyecto/public/index.php/productos?id=1
```

---

##  Frontend (Interfaz Gráfica)

El proyecto incluye una interfaz gráfica desarrollada con **HTML, CSS y JavaScript**, además de **Bootstrap 5** para los estilos. 

###  Estructura del Proyecto:

```
mi-proyecto/
├── api/
│   ├── categorias.php
│   └── productos.php
├── config/
│   └── database.php
├── database/
│   └── mi_proyecto.sql
├── public/
│   ├── crud.html      
│   ├── css/
│   │   └── styles.css  
│   ├── js/
│   │   └── app.js      
│   └── index.php
└── routes/
    └── routes.php
```

###  Uso del Frontend

1. Abre tu navegador y accede a:
```
http://localhost/mi-proyecto/public/crud.html
```
2. Desde la interfaz, puedes:
   - Obtener, agregar y eliminar categorías.
   - Obtener, agregar y eliminar productos.
   - Interactuar con la API REST de forma visual.

---

##  Tecnologías Utilizadas

- PHP (Backend)
- MySQL (Base de datos)
- HTML, CSS, JavaScript (Frontend)
- Bootstrap 5 (Estilos)

---

##  Autor

**AlexPR9** - Proyecto para gestión de productos y categorías.
