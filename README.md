# README para el Proyecto de API REST

## Descripción
Este proyecto implementa una API REST para la gestión de pacientes en un sistema de salud. Permite operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre los datos de los pacientes, además de manejar la autenticación y actualización de tokens para usuarios.

## Tecnologías Utilizadas
- PHP
- MySQL
- Apache (con configuración `.htaccess` para reescritura de URL)

## Configuración del Entorno
### Base de Datos
- Servidor: `localhost`
- Usuario: `root`
- Contraseña: `123456`
- Base de datos: `apirest`
- Puerto: `3306`

### Configuración del Servidor
El archivo `.htaccess` maneja la reescritura de URL para acceder a los archivos PHP sin necesidad de especificar la extensión `.php`.

## Estructura de Directorios
- `clases/`: Contiene las clases PHP para manejo de conexiones, respuestas, autenticación, y operaciones específicas de pacientes y tokens.
- `cron/`: Scripts para tareas programadas como la actualización de tokens.
- `pacientes.php`: Endpoint para operaciones relacionadas con pacientes.
- `auth.php`: Endpoint para la autenticación de usuarios.

## Endpoints
### Pacientes
- **GET** `/pacientes.php`: Obtiene la lista de pacientes o un paciente específico.
- **POST** `/pacientes.php`: Crea un nuevo paciente.
- **PUT** `/pacientes.php`: Actualiza los datos de un paciente existente.
- **DELETE** `/pacientes.php`: Elimina un paciente.

### Autenticación
- **POST** `/auth.php`: Autentica a un usuario y devuelve un token.

## Seguridad
La API utiliza tokens para la autenticación y autorización de los usuarios. Los tokens deben ser incluidos en las cabeceras de las solicitudes para acceder a los endpoints protegidos.

## Tareas Programadas
El script `cron/actualizar_tokens.php` se utiliza para desactivar tokens antiguos y debe ser ejecutado periódicamente.
