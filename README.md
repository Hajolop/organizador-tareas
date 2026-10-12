# Sistema organizador de tareas escolares

Aplicación web hecha con **CodeIgniter 4** (PHP 8.3) y **MariaDB** para organizar las tareas de un curso. Proyecto del curso de Algoritmos, Universidad Mariano Gálvez de Guatemala.

Alejandro Josue Lopez Pozuelos 0910-26-6822

## Funcionalidades

- Registro con correo de activación, inicio y cierre de sesión, "remember me" y recuperación de contraseña por correo.
- Perfil: editar datos (pidiendo la contraseña), cambiar contraseña, subir y eliminar foto.
- Módulo de usuarios solo para administradores: listar, crear, ver, editar y eliminar.
- Tareas: crear, ver, buscar, editar y eliminar, con paginación.
- Interfaz en español e inglés.

## Arquitectura

Aplicación monolítica de tres capas con el patrón MVC:

- **Presentación:** vistas en `app/Views`.
- **Lógica de negocio:** controladores y filtros en `app/Controllers` y `app/Filters`.
- **Datos:** modelos y migraciones en `app/Models` y `app/Database`.

## Requisitos

- PHP 8.1 o superior con las extensiones intl, mbstring, mysql, curl, xml y zip
- Composer
- MariaDB o MySQL

## Instalación

```bash
git clone https://github.com/USUARIO/organizador-tareas.git
cd organizador-tareas
composer install
cp env .env
```

Crea la base de datos y un usuario (cambia la contraseña):

```sql
CREATE DATABASE organizador_tareas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tareas_user'@'localhost' IDENTIFIED BY 'TU_CONTRASEÑA';
GRANT ALL PRIVILEGES ON organizador_tareas.* TO 'tareas_user'@'localhost';
FLUSH PRIVILEGES;
```

Edita `.env` con los datos de la base de datos y del correo:

```
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = organizador_tareas
database.default.username = tareas_user
database.default.password = TU_CONTRASEÑA
database.default.DBDriver = MySQLi
database.default.port = 3306

email.fromEmail = no-reply@organizador.local
email.fromName = 'Organizador de tareas'
email.protocol = smtp
email.SMTPHost = 127.0.0.1
email.SMTPPort = 1025
email.SMTPCrypto =
email.mailType = text
email.wordWrap = false
```

Crea las tablas y enciende el servidor:

```bash
php spark migrate
php spark serve
```

La aplicación queda en http://localhost:8080

## Correos en desarrollo

Para ver los correos sin un servidor real, se usa un buzón local de pruebas que imprime cada mensaje en la terminal:

```bash
sudo apt install python3-aiosmtpd
python3 -m aiosmtpd -n -l 127.0.0.1:1025
```

En producción se cambian las líneas `email.*` del `.env` por los datos de un servidor SMTP real.

## Primer administrador

Regístrate desde la aplicación, activa la cuenta con el enlace del correo y conviértete en administrador:

```sql
UPDATE users SET administrator = 1 WHERE email = 'tu-correo@ejemplo.com';
```

## Seguridad

- Contraseñas cifradas con `password_hash`.
- Validación de datos en el servidor y texto escapado en las vistas.
- Enlaces de activación y recuperación con códigos aleatorios de un solo uso.
- Páginas protegidas por filtros de sesión y de rol.
- El archivo `.env` no se sube al repositorio.

## Entorno de desarrollo

Máquina virtual en VirtualBox con Lubuntu 24.04 LTS.
