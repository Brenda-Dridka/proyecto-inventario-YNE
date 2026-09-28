# CRUD de Usuarios

## Descripción

Se implementó el módulo de administración de usuarios/empleados del sistema de inventario.

El módulo permite administrar el personal registrado en el sistema.

## Funcionalidades

- Listar empleados.
- Buscar empleados.
- Crear empleados.
- Editar empleados.
- Cambiar contraseña.
- Asignar roles.
- Activar o desactivar usuarios desde edición.
- Consultar el detalle de un empleado.
- Eliminar definitivamente un empleado.
- Mostrar estado activo/inactivo.
- Validar información desde Laravel.
- Mostrar mensajes de éxito y error mediante Toast.

## Backend

Controlador:

```text
app/Http/Controllers/Api/UsuarioController.php
```

Modelo:

```text
app/Models/Usuario.php
```

## Endpoints

### Obtener usuarios

```http
GET /api/usuarios
```

Obtiene todos los usuarios registrados junto con su rol.

### Crear usuario

```http
POST /api/usuarios
```

Datos principales:

```json
{
    "nombre": "Brenda",
    "apellido": "Ruiz",
    "no_empleado": "00125",
    "password": "123456",
    "id_rol": 1
}
```

El usuario nuevo se registra como activo.

### Ver detalle

```http
GET /api/usuarios/{id}
```

Obtiene la información completa del empleado junto con su rol.

### Actualizar usuario

```http
PUT /api/usuarios/{id}
```

Permite modificar:

- Nombre.
- Apellido.
- Número de empleado.
- Rol.
- Contraseña.
- Estado.

### Eliminar usuario

```http
DELETE /api/usuarios/{id}
```

Elimina físicamente el registro de la base de datos.

## Frontend

Vista principal:

```text
resources/js/pages/Usuarios.vue
```

Componentes:

```text
resources/js/components/usuarios/
├── UsuarioModal.vue
├── UsuarioEditModal.vue
└── UsuarioDetailModal.vue
```

## Interfaz

El módulo cuenta con las siguientes acciones:

- 👁️ Ver detalle.
- ✏️ Editar.
- 🗑️ Eliminar.

La eliminación utiliza un diálogo de confirmación antes de ejecutar la petición.

## Validaciones

Laravel valida:

- Nombre obligatorio.
- Apellido obligatorio.
- Número de empleado obligatorio y único.
- Contraseña con mínimo de 6 caracteres.
- Rol existente.
- Estado válido.

Las contraseñas se almacenan utilizando `Hash::make()`.

## Eliminación

La eliminación es definitiva.

Al confirmar la eliminación:

```text
DELETE /api/usuarios/{id}
```

el registro es eliminado físicamente de la tabla `usuarios`.

## Estado

El campo:

```text
activo
```

permite identificar si un usuario está activo o inactivo.

Valores:

```text
1 = Activo
0 = Inactivo
```

## Siguiente módulo

El siguiente desarrollo corresponde al módulo de autenticación:

```text
feature/auth/login
```

El acceso utilizará:

```text
Número de nómina
Contraseña
```
