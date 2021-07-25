# Database Documentation

Para documentar la base de datos utilizamos DBML que utiliza una sintaxis simple para definir la estructura de nuestra base de datos.

Con la finalidad de facilitar la comprensión y documentación de cada módulo del sistema, se generara un archivo.dbml para cada branch, el mismo que deberá reflejar el esquema real de la base de datos implementada.

Para conocer más sobre la sintaxis y el uso de la herramienta referirse a los siguientes enlaces.

-   [DBML](https://www.dbml.org/docs/) Database Markup Language Documentation
-   [dbdocs](https://dbdocs.io/docs)


## installation

//Installamos dbdocs utility
npm install -g dbdocs

//Nos logeamos usando github
dbdocs login

//Publicamos nuestro diagrama
dbdocs builds core.dbml

//Protegemos nuestro diagrama con password
dbdocs password --project core

//Password: coreman