# Exemple de creació d'una API REST amb SLIM 3

Per instal·lar el framework el millor es fer servir composer.

## Instal.lació

Una vegada instal·lat composer hem d'executar desde el directori on volem instal·lar l'aplicació la següent comanda. (Si feim servir xampp dins l'arrel).

    php composer.phar create-project slim/slim-skeleton [sa-meva-aplicacio]

[sa-meva-aplicacio] es el nom del directori que contindrà l'aplicació. 

El que farem serà utilitzant les classes fetes per la pràctica de llibres montar l'api REST fent servir Slim.

A la carpeta **screenshots** hi ha captures de pantalla de les operacions que es poden fer amb Llibres;


|DESCRIPCIO| RUTA | METODE | HEADER | KEY |
| --- | --- | --- | --- | --- |
|Llegir tots els llibres. (GET)| http://localhost/rest-api-amb-slim-felipxavier/public/llibre/ | GET | application/x-www-form-urlencoded | |
|Llegir un llibre a partir de la clau primària. (GET)| http://localhost/rest-api-amb-slim-felipxavier/public/llibre/{id_llib} | GET | application/x-www-form-urlencoded |id_llib |
|Llegir un llibre amb filtres i ordenació (GET)| | GET | application/x-www-form-urlencoded|  |
|Alta d’un llibre. (POST)| http://localhost/rest-api-amb-slim-felipxavier/public/llibre/ | POST | application/x-www-form-urlencoded | titol,numedicio,llocedicio, anyedicio, ... |
|Modificar un llibre (PUT)| http://localhost/rest-api-amb-slim-felipxavier/public/llibre/ | PUT | application/x-www-form-urlencoded | id_llib, titol,numedicio,llocedicio, anyedicio, ... |
|Borrar un llibre(DELETE)|http://localhost/rest-api-amb-slim-felipxavier/public/llibre/ | DELETE |application/x-www-form-urlencoded | id_llib |
|Llegir tots els autors d’un llibre. (GET)| http://localhost/rest-api-amb-slim-felipxavier/public/llibre/llibre-autors/{id_llib}| GET |application/x-www-form-urlencoded | id_llib |
|Alta d’un nou autor d’un llibre (POST) |http://localhost/rest-api-amb-slim-felipxavier/public/llibre/autors-llibre/| POST|application/x-www-form-urlencoded | id_llib, id_aut |
|Baixa d’un autor d’un determinat llibre (DELETE)|http://localhost/rest-api-amb-slim-felipxavier/public/llibre/autors-llibre/| DELETE| application/x-www-form-urlencoded| id_llib, id_aut|
