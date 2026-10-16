# Organizador de tareas escolares

Este es mi proyecto del curso de Algoritmos de la Universidad Mariano Gálvez. Es una página web para que una maestra y sus alumnos lleven el control de las tareas del curso. La hice con CodeIgniter 4 y MariaDB.

Hecho por: 

Cualquiera puede registrarse y le llega un correo con un enlace para activar su cuenta. Con la cuenta activa puede entrar, pedir que la página lo recuerde, recuperar su contraseña si la olvida, cambiar sus datos y su foto, y crear, buscar, editar y borrar tareas.

Los administradores además pueden ver, crear, editar y borrar usuarios.

Todo se puede ver en español o en inglés con los botones de arriba.


Sigue el patrón MVC de CodeIgniter. Las pantallas están en `app/Views`, los controladores en `app/Controllers` y los modelos en `app/Models`. Las tablas de la base de datos se crean con las migraciones que están en `app/Database/Migrations`.

# Como correrlo

Sigue el patrón MVC de CodeIgniter, con las vistas hechas en Blade. Las pantallas están en `app/Views` (son archivos `.blade.php`), los controladores en `app/Controllers`, los modelos en `app/Models` y la lógica de las tareas en `app/Services`. Las tablas de la base de datos se crean con las migraciones de `app/Database/Migrations`.

Dicho por capas: la presentación son las vistas de Blade y el CSS, la lógica son los controladores, los filtros y el servicio de tareas, y los datos son los modelos y la base de datos MariaDB.

```bash
git clone https://github.com/Hajolop/organizador-tareas.git
cd organizador-tareas
composer install
cp env .env
```

Después crea la base de datos y su usuario. Cambia `TU_CONTRASEÑA` por la que quieras:



Luego abre el archivo `.env` y deja estas líneas activas, sin el `#` del principio, con tus datos:

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

Por último crea las tablas y enciende el servidor:

```bash
php spark migrate
php spark serve
```

La página queda en http://localhost:8080

## Los correos

Para probar sin un servidor de correo de verdad uso un buzón de prueba que muestra los correos en la terminal:

```bash
sudo apt install python3-aiosmtpd
python3 -m aiosmtpd -n -l 127.0.0.1:1025
```

Si se usa en un servidor real, solo hay que cambiar las líneas `email.*` del `.env` por los datos del correo de verdad.



Registra una cuenta, actívala con el enlace que llega al correo y después hazla administradora desde MariaDB:

```sql
UPDATE users SET administrator = 1 WHERE email = 'tu-correo@ejemplo.com';
```

Los usuarios que crea un administrador desde la sección de usuarios ya quedan activos y no reciben correo de activación.


Las contraseñas se guardan cifradas, los formularios tienen protección CSRF y el archivo `.env`, que tiene las contraseñas, no se sube a GitHub. Los enlaces de activación y de recuperación usan códigos al azar que solo sirven una vez.


En una máquina virtual de VirtualBox con Lubuntu 24.04.



Para no crear cuentas a mano, hay dos usuarios ya activos, parecidos a los del diseño del documento:


- `admin@example.com`: David, administrador.
- `migue@example.com`: Miguel, usuario normal.

La contraseña de los dos es `Demo12345`. Son solo para pruebas.
