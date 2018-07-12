Ticket System Net Tech International
========================

**Desarrollador Iván Mendoza**

**Pasos para la Instalación de la Aplicación:**

  * Tener instalado Composer y un servidor compatible con PHP.

  * Instalar Git en la Pc para hacer un clone del Repositorio o descargar el Proyecto desde GitHub. Luego Alojarlo en la carpeta en donde se visualizan las paginas web de su servidor local.

  * Ir a la TERMINAL en Linux o CMD de Windows e ir a donde esta el Proyecto.

  * Ejecutar los sigte. comandos antes de ejecutar la App:
  
    * **composer install**
    * **php bin/console doctrine:database:create**
    * **php bin/console doctrine:schema:update --force**
  
  * Ya puede iniciar el proyecto en la ruta: localhost(o nombre del servidor)/TicketSystem/web/.
  
  **Nota:** Al momento de entrar a la Applicación la primera vez, este crea un Usuario para que puedan acceder al login:
  
    * Username: i.mendoza
    * Password: 1234
 
 Ya puede utilizar la App Ticket System.

La documentación de la Aplicación esta en la carpeta Documentation dentro del proyecto.