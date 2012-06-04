ErudaPHP
========

ErudaPHP, mini PHP framework


#CLASSES
* Eruda Core
* Eruda CF
* Eruda Router
* Eruda Header <ABSTRACT>
    * HTML
    * JSON *TO-DO*
    * XML *TO-DO*
* Eruda View <ABSTRACT> *TO-DO*
    * ...
* Eruda Model <ABSTRACT> *TO-DO*
    * ...
* Eruda Form *TO-DO*
* Eruda Field *TO-DO*
* Eruda Validator <ABSTRACT> *TO-DO*
    * Int *TO-DO*
    * Numeric *TO-DO*
    * Alphanumeric *TO-DO*
    * String *TO-DO*
    * Mail *TO-DO*
    * URL *TO-DO*
    * ...
* ...

##Eruda Core
Nucleo de la aplicación.

**funciones principales:**
* `__construct()`
* `setRouter(Eruda_Router router)` : Setea el enrutador inicial de la aplicación.
* `setBase(string base)` : Setea la uri base, por defecto vacia
* `setUri(string uri)` : Setea la uri actual, por defecto `$_SERVER['REQUEST_URI']`
* `setMethod(string method)` : Setea el metodo de la petición actual, por defecto `$_SERVER['REQUEST_METHOD']`
* `addFolder(string folder, string dir)` : Añade una directorio de archivos. *Ej:`addFolder('css','/public/css/')`*
* `parseUri()` : Setea el CF a partir del enrutador, base, uri y metodo guardado
* ...
