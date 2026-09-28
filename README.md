# 📦 Sistema de Gestión de Almacén

Sistema web para la administración y control de productos almacenados, desarrollado con **Laravel 12**, **Vue 3**, **Vite** y **Tailwind CSS**.

El proyecto permite administrar productos, empleados, usuarios, roles y permisos mediante una interfaz web moderna y responsive.

---

## 📋 Tabla de contenidos

- [Descripción](#-descripción)
- [Características](#-características)
- [Tecnologías](#-tecnologías)
- [Versiones](#-versiones)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración de la base de datos](#-configuración-de-la-base-de-datos)
- [Migraciones y Seeders](#-migraciones-y-seeders)
- [Ejecución del proyecto](#-ejecución-del-proyecto)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [Módulos](#-módulos)
- [CRUD de usuarios](#-crud-de-usuarios)
- [Roles y permisos](#-roles-y-permisos)
- [API](#-api)
- [Variables de entorno](#-variables-de-entorno)
- [Comandos útiles](#-comandos-útiles)
- [Producción](#-producción)
- [Seguridad](#-seguridad)
- [Autor](#-autor)

---

# 📌 Descripción

El **Sistema de Gestión de Almacén** es una aplicación web administrativa diseñada para facilitar el control de productos dentro de un almacén.

El sistema permite gestionar la información de productos, controlar usuarios y empleados, administrar roles y permisos y proporcionar diferentes niveles de acceso dependiendo del perfil del usuario.

La aplicación utiliza Laravel como backend y API, mientras que Vue 3 se utiliza para construir la interfaz de usuario.

---

# ✨ Características

## 👥 Usuarios y empleados

- Listado de empleados.
- Búsqueda de usuarios.
- Alta de empleados.
- Edición de empleados.
- Eliminación de empleados.
- Asignación de roles.
- Estado del usuario.
- Número de empleado.
- Contraseñas protegidas mediante hashing.

## 🔐 Roles y permisos

- Asignación de permisos a roles.
- Relación entre usuarios y roles.

## 📦 Productos

- Alta de productos.
- Consulta de productos.
- Edición de productos.
- Eliminación de productos.
- Búsqueda de productos.
- Control de cantidades.

## 📊 Dashboard

El sistema cuenta con un panel administrativo para visualizar información general del almacén.

## 🎨 Interfaz

- Diseño responsive.
- Sidebar de navegación.
- Navbar administrativo.
- Modales.
- Tablas.
- Formularios.
- Buscadores.
- Estados visuales.
- Componentes reutilizables.

---

# 🛠 Tecnologías

## Backend

- PHP
- Laravel
- Laravel Tinker
- Composer
- PHPUnit

## Frontend

- Vue 3
- Vite
- Vue Router
- Axios
- Tailwind CSS

## Base de datos

- MySQL / MariaDB

## Control de versiones

- Git
- GitHub

---

# 📌 Versiones

Las versiones principales utilizadas en el proyecto son:

| Tecnología     | Versión                                  |
| -------------- | ---------------------------------------- |
| PHP            | `^8.2`                                   |
| Laravel        | `^12.0`                                  |
| Laravel Tinker | `^2.10.1`                                |
| PHPUnit        | `^11.5.50`                               |
| FakerPHP       | `^1.23`                                  |
| Laravel Pint   | `^1.24`                                  |
| Node.js        | `20.x LTS o superior`                    |
| Vue            | `3.x`                                    |
| Vite           | `5.x / versión definida en package.json` |
| Tailwind CSS   | `4.x`                                    |
| Vue Router     | `4.x`                                    |
| Axios          | `versión definida en package.json`       |
| Composer       | `2.x`                                    |
| NPM            | `10.x o superior`                        |

> Las versiones exactas de las dependencias frontend deben consultarse en `package.json` y `package-lock.json`.

---

# 💻 Requisitos

Antes de instalar el proyecto se requiere tener instalado:

- PHP 8.2 o superior.
- Composer 2.x.
- Node.js.
- NPM.
- MySQL o MariaDB.
- Git.
- Navegador web moderno.

## Verificar PHP

```bash
php -v
```

## Verificar Composer

```bash
composer -V
```

## Verificar Node.js

```bash
node -v
```

## Verificar NPM

```bash
npm -v
```

## Verificar Git

```bash
git --version
```

---

# 🚀 Instalación

## 1. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
```

Entrar al proyecto:

```bash
cd proyecto-inventario-YNE
```

---

# 2. Instalar dependencias de PHP

```bash
composer install
```

Esto instalará las dependencias definidas en:

```text
composer.json
```

---

# 3. Crear archivo `.env`

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Windows CMD:

```cmd
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

---

# 4. Generar la clave de Laravel

```bash
php artisan key:generate
```

Esto generará automáticamente:

```env
APP_KEY=
```

en el archivo `.env`.

---

# 5. Configurar la base de datos

Abrir:

```text
.env
```

Configurar los datos de conexión:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventario
DB_USERNAME=root
DB_PASSWORD=
```

Los valores deben modificarse según la configuración local.

---

# 6. Crear la base de datos

Desde MySQL:

```sql
CREATE DATABASE inventario

```

---

# 7. Ejecutar migraciones

```bash
php artisan migrate
```

---

# 8. Ejecutar Seeders

Para cargar los datos iniciales:

```bash
php artisan db:seed
```

También se puede ejecutar todo desde cero:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ `migrate:fresh` elimina todas las tablas existentes y vuelve a crearlas.

---

# 9. Instalar dependencias frontend

```bash
npm install
```

---

# 10. Ejecutar el proyecto

### Terminal 1

```bash
php artisan serve
```

### Terminal 2

```bash
npm run dev
```

Abrir:

```text
http://localhost:8000
```

---

# ⚡ Ejecución rápida

El proyecto contiene scripts definidos en `composer.json`.

Después de instalar las dependencias puede utilizarse:

```bash
composer run dev
```

Este comando ejecuta los procesos principales del proyecto:

```text
Laravel Server
Queue
Laravel Pail
Vite
```

---

# 🗂 Estructura del proyecto

```text
proyecto-inventario-YNE/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           ├── UsuarioController.php
│   │           ├── RolController.php
│   │           ├── PermisoController.php
│   │           └── ProductoController.php
│   │
│   └── Models/
│       ├── Usuario.php
│       ├── Rol.php
│       ├── Permiso.php
│       └── Producto.php
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── components/
│   │   ├── layouts/
│   │   ├── pages/
│   │   ├── router/
│   │   ├── App.vue
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   └── views/
│       └── app.blade.php
│
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
│
├── public/
│
├── storage/
│
├── tests/
│
├── .env.example
├── composer.json
├── package.json
├── package-lock.json
├── vite.config.js
└── README.md
```

---

# 🧩 Arquitectura

El proyecto utiliza una arquitectura donde Laravel funciona como backend y Vue como frontend.

```text
┌─────────────────────────────┐
│          Usuario            │
└──────────────┬──────────────┘
               │
               ▼
┌─────────────────────────────┐
│        Vue 3 + Vite         │
│                             │
│ Dashboard                   │
│ Usuarios                    │
│ Productos                   │
│ Roles y permisos            │
└──────────────┬──────────────┘
               │
             Axios
               │
               ▼
┌─────────────────────────────┐
│       Laravel 12 API        │
│                             │
│ Controllers                 │
│ Models                      │
│ Validaciones                │
│ Autenticación               │
│ Autorización                │
└──────────────┬──────────────┘
               │
               ▼
┌─────────────────────────────┐
│       MySQL / MariaDB       │
│                             │
│ usuarios                    │
│ roles                       │
│ permisos                    │
│ rol_permiso                 │
│ productos                   │
└─────────────────────────────┘
```

---

# 👥 Módulo de usuarios

El módulo permite administrar los empleados registrados en el sistema.

## Información administrada

- Nombre.
- Apellido.
- Número de empleado.
- Usuario.
- Contraseña.
- Rol.
- Estado.

## Operaciones

```text
Crear
Consultar
Editar
Eliminar
```

---

# 🔐 Módulo de roles y permisos

El sistema utiliza una relación:

```text
Usuario
   │
   ▼
Rol
   │
   ▼
Permisos
```

Ejemplo:

```text
Usuario: Brenda Ruiz
        │
        ▼
Rol: Administrador
        │
        ├── usuarios.ver
        ├── usuarios.crear
        ├── usuarios.editar
        ├── usuarios.eliminar
        ├── productos.ver
        ├── productos.crear
        ├── productos.editar
        └── productos.eliminar
```

---

# 🔑 Permisos

Los permisos están organizados por módulo.

## Usuarios

```text
usuarios.ver
usuarios.crear
usuarios.editar
usuarios.eliminar
```

## Productos

```text
productos.ver
productos.crear
productos.editar
productos.eliminar
```

---

# 📦 Módulo de productos

El módulo de productos representa la parte principal del sistema de almacenamiento.

Permite:

- Registrar productos.
- Consultar productos.
- Actualizar productos.
- Eliminar productos.
- Buscar productos.
- Consultar existencias.
- Controlar stock mínimo.
- Identificar ubicación dentro del almacén.

---

# 🔄 CRUD

El sistema implementa operaciones CRUD.

CRUD significa:

```text
C - Create  → Crear
R - Read    → Consultar
U - Update  → Actualizar
D - Delete  → Eliminar
```

Ejemplo para usuarios:

```text
POST    /api/usuarios
GET     /api/usuarios
PUT     /api/usuarios/{id}
DELETE  /api/usuarios/{id}
```

Ejemplo para productos:

```text
POST    /api/productos
GET     /api/productos
PUT     /api/productos/{id}
DELETE  /api/productos/{id}
```

---

# 🌐 API

Las rutas de API se encuentran en:

```text
routes/api.php
```

Ejemplo:

```php
Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::post('/usuarios', [UsuarioController::class, 'store']);
```

---

# 👤 API de usuarios

## Obtener usuarios

```http
GET /api/usuarios
```

## Crear usuario

```http
POST /api/usuarios
```

Ejemplo:

```json
{
    "nombre": "Carlos",
    "apellido": "López",
    "no_empleado": "12345",
    "password": "123456",
    "id_rol": 2
}
```

---

# 🚫 Archivos que NO deben subirse a Git

El `.gitignore` debe evitar subir:

```text
/vendor
/node_modules
.env
/storage/*.key
```

También deben evitarse archivos generados temporalmente.

---

# 🧹 Limpiar cachés

Si Laravel presenta problemas después de modificar configuración:

```bash
php artisan optimize:clear
```

También pueden ejecutarse individualmente:

```bash
php artisan config:clear
```

```bash
php artisan cache:clear
```

```bash
php artisan route:clear
```

```bash
php artisan view:clear
```

---

# 🔄 Actualizar autoload de Composer

Si se agregan nuevas clases o modelos:

```bash
composer dump-autoload
```

---

# 🏗 Compilar frontend para producción

Para generar los archivos optimizados:

```bash
npm run build
```

Esto genera los archivos compilados para producción.

---

# 🛠 Comandos principales

## Laravel

```bash
php artisan serve
```

```bash
php artisan migrate
```

```bash
php artisan migrate:fresh --seed
```

```bash
php artisan db:seed
```

```bash
php artisan optimize:clear
```

```bash
php artisan route:list
```

```bash
php artisan make:model Producto -m
```

```bash
php artisan make:controller Api/ProductoController
```

---

## Composer

```bash
composer install
```

```bash
composer update
```

```bash
composer dump-autoload
```

```bash
composer run dev
```

---

## NPM

```bash
npm install
```

```bash
npm run dev
```

```bash
npm run build
```

---

# 🔎 Verificar rutas Laravel

Para revisar las rutas registradas:

```bash
php artisan route:list
```

Se deben poder identificar las rutas de:

```text
/api/usuarios
/api/roles
/api/permisos
/api/productos
```

---

# 📋 Checklist de instalación

Antes de ejecutar el proyecto:

- [ ] PHP 8.2+ instalado.
- [ ] Composer instalado.
- [ ] Node.js instalado.
- [ ] NPM instalado.
- [ ] MySQL/MariaDB instalado.
- [ ] Repositorio clonado.
- [ ] `composer install` ejecutado.
- [ ] `.env` creado.
- [ ] Base de datos configurada.
- [ ] `php artisan key:generate` ejecutado.
- [ ] Migraciones ejecutadas.
- [ ] Seeders ejecutados.
- [ ] `npm install` ejecutado.
- [ ] `php artisan serve` ejecutado.
- [ ] `npm run dev` ejecutado.

---

# 👩‍💻 Autor

**Brenda Ruiz**

Proyecto desarrollado como sistema de gestión y almacenamiento de productos para demostrar implementación de:

- Desarrollo Backend.
- Desarrollo Frontend.
- API REST.
- Laravel.
- Vue 3.
- Bases de datos relacionales.
- CRUD.
- Autenticación.
- Autorización.
- Roles.
- Permisos.
- Git.
- Diseño de interfaces administrativas.

---
