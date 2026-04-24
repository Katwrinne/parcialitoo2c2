UNIVERSIDAD GERARDO BARRIOS

INTEGRANTES:
Katerinne Alejandra Mendez Garcia
Yoselin Andrea Linares Hernández

USUARIOS:
doctor@farmacia.com   Contraseña: 1234
admin@farmacia.com    Contraseña: 123

# Farmacias La Buena - Sistema de Asistencia Médica

## Descripción del Proyecto

Sistema web desarrollado para la gestión de pacientes en Farmacias La Buena, una empresa farmacéutica de la zona oriental de El Salvador (San Miguel, La Unión, Morazán, Usulután). El sistema permite registrar, editar, eliminar y visualizar información médica de los pacientes.


### 1. ¿Cómo manejan la conexión a la BD y qué pasa si algunos de los datos son incorrectos? Justifiquen la manera de validación de la conexión.

La conexión la manejamos en un archivo `conexion.php` usando `new mysqli()`. Si los datos son incorrectos, la propiedad `connect_error` detecta el error y `die()` detiene el programa mostrando el mensaje. Esta validación es importante porque evita que el sistema siga funcionando con una conexión fallida. Pusimos la conexión en un archivo aparte para reutilizarlo en todas las páginas y facilitar futuros cambios.

### 2. ¿Cuál es la diferencia entre $_GET y $_POST en PHP? ¿Cuándo es más apropiado usar cada uno? Da un ejemplo real de tu proyecto.

La diferencia principal es que $_GET envía los datos visibles en la URL, mientras que $_POST los envía ocultos en el cuerpo de la petición. $_GET se usa para búsquedas, filtros o paginación porque permite guardar la URL en favoritos. $_POST se usa para información sensible como contraseñas o formularios largos porque es más seguro. En mi proyecto, uso $_GET para editar pacientes (`dashboard.php?editar=5`) y uso $_POST en el login y en el registro de pacientes para proteger los datos.

### 3. Tu app va a usarse en una empresa de la zona oriental. ¿Qué riesgos de seguridad identificas en una app web con BD que maneja datos de los usuarios? ¿Cómo los mitigarían?

1. Inyección SQL: Un atacante podría escribir código malicioso en los campos del formulario para robar o modificar la base de datos. Mitigación: Usar consultas preparadas (prepared statements) en lugar de concatenar variables directamente en las consultas SQL.

2. Contraseñas débiles: Actualmente usamos MD5 que es un algoritmo fácil de romper con tablas rainbow. Mitigación: Usar password_hash() con Bcrypt, que es mucho más seguro y lento de crackear.

3. Acceso no autorizado: Usuentes no autenticados podrían acceder al panel de administración si no protegemos las páginas. Mitigación: Verificar la sesión al inicio de cada página privada con if(!isset($_SESSION['usuario'])).

---

## 8. Diccionario de Datos

### Tabla 1: usuarios

| Columna | Tipo de dato | Límite | ¿Nulo? | Descripción |
|---------|-------------|--------|--------|-------------|
| id | INT | 11 | No | Identificador único del usuario |
| nombre_completo | VARCHAR | 100 | No | Nombre completo del usuario |
| email | VARCHAR | 100 | No | Correo electrónico (único) |
| password | VARCHAR | 255 | No | Contraseña encriptada |
| rol | ENUM | - | No | admin, medico o usuario |
| fecha_registro | TIMESTAMP | - | No | Fecha de registro |

### Tabla 2: pacientes

| Columna | Tipo de dato | Límite | ¿Nulo? | Descripción |
|---------|-------------|--------|--------|-------------|
| id | INT | 11 | No | Identificador único del paciente |
| nombre | VARCHAR | 100 | No | Nombre del paciente |
| apellido | VARCHAR | 100 | No | Apellido del paciente |
| edad | INT | 3 | No | Edad en años |
| telefono | VARCHAR | 15 | No | Teléfono principal |
| telefono_opcional | VARCHAR | 15 | Sí | Teléfono alternativo |
| direccion | VARCHAR | 200 | No | Dirección de residencia |
| enfermedad | VARCHAR | 100 | No | Diagnóstico médico |
| alergias | TEXT | - | Sí | Alergias a medicamentos |
| tipo_sangre | VARCHAR | 5 | No | Tipo de sangre |
| fecha_consulta | TIMESTAMP | - | No | Fecha de la consulta |
| doctor_asignado | VARCHAR | 100 | No | Doctor que atendió |

