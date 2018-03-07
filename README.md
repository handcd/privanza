# Privanza

Este es el proyecto de un CRM con control de Procesos para __Privanza__. El objetivo general es poder brindar un funcionamiento completo para el equipo interno y externo de la empresa.

El sistema cuenta con las siguientes acciones:

- Control de Vendedores
    + Cuentas únicas
    + Capacidad de añadir pedidos de c/u
    + Control de _sus_ clientes así como recordatorios de cumpleaños
- Control de Validadores
    + Administración general de los pedidos
    + Control de los Vendedores
    + Control de todos los Clientes en el sistema
- Control de Pedidos
    + Manejo de línea de producción
    + Recordatorios para eficientar proceso de funcionamiento de la línea de producción
    + Análisis de Ventas

## Instalación

Instalar Privanza requiere de instalar los requisitos del framework [Laravel](https://laravel.com) que son descritos en su propia documentación. Sin embargo se enlistan los pasos requeridos en el presente apartado.

### Requisitos Mínimos de Ejecución

- Sistema Operativo *Nix _(Ubuntu, CentOS, RedHat)_
- Memoria RAM de 512 MB
- Control total de S.O. (para instalación de paquetes y demás)
- 1 VCPU+ 
- Espacio de 1.8gb en Disco Duro (ejecución con 10 Vendedores, 5 Validadores y 2 Administradores)

### Dependencias Previas

Se requieren las siguientes dependencias para poder ejecutar el software:

- Git
- PHP 7+ (más las librerías habilitadas descritas en la documentación de Laravel)
- MySQL (_MariaDB funciona por igual_)
- Node
- NPM
- Apache 2
- Supervisor (para las queues de los emails)

_Opcional_

- Certificado SSL
- Servidor de E-Mail para notificaciones (p. ej. Mailgun)

### Deployment a Producción

- Clonar repositorio `https://github.com/handcd/privanza.git`
- Colocarse sobre la rama `master` que está definida para ser la adecuada para producción.
- Ajustar `.htaccess` en la carpeta `public` para cualquier error con las rutas (sobretodo si se cambia de secuencia de uso de HTTPS a HTTP o viceversa)
- Llenar la información del `.env` con los datos más relevantes:
    + Nombre de la aplicación
    + Conexión de Base de Datos
    + Conexión con el _Servidor de Correos_ (Mailgun)
    + Conexión con 

## Historial de Versiones

|Versión|Fecha de Lanzamiento|Comentarios|
|:---:|:----:|:-----:|
|1.0.0| _Estimado a Mediados de Marzo_|Lanzamiento Inicial de Producto|

## Datos de Equipo

Desarrollado por [HAND Creative Design][1] para el uso exclusivo de `International Sewing Company S.A. de C.V.`

## Contacto

Cualquier duda y/o aclaración del presente software deberá ser comunicada con el equipo de desarrollo de [HAND Creative Design][1] escribiendo en los siguientes medios:

- Teléfono: 
- Correo Electrónico: [proyectos@handcd.com](mailto:proyectos@handcd.com)

## Licencia

HAND Creative Design no se hace responsable del uso indebido del presente software así como las modificaciones posteriores al mismo que impliquen un uso desleal o inadecuado del mismo. Para revisar la licencia completa del presente proyecto puede consultarla [Haciendo click aquí](http://www.binpress.com/license/view/l/a90d498720f8764610c9737d6b287560).

> Programado con 🧡 por [HAND Creative Design][1] en Santa Fé, México

[1]: http://handcd.com