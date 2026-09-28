# Autenticación

## Descripción

Se inicia el desarrollo del módulo de autenticación del sistema.

El acceso al sistema se realizará mediante las credenciales del empleado.

## Credenciales

El usuario ingresará:

- Número de nómina.
- Contraseña.

## Flujo

```text
Usuario
   ↓
Login
   ↓
Número de nómina + contraseña
   ↓
API Laravel
   ↓
Validación de credenciales
   ↓
Validación de estado
   ↓
Acceso al sistema
```

## Backend

Se utilizará un controlador independiente para la autenticación:

```text
app/Http/Controllers/Api/AuthController.php
```

Endpoint previsto:

```http
POST /api/login
```

## Seguridad

Las contraseñas serán comparadas utilizando el sistema de hashing de Laravel.

Los usuarios inactivos no podrán iniciar sesión.

## Estado

### Inicial

Se encuentra iniciado el módulo de autenticación.

### Pendiente

- Endpoint de login.
- Vista Login.
- Validación de credenciales.
- Persistencia de sesión.
- Protección de rutas.
- Logout.
- Redirección al sistema después del login.
