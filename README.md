ErudaPHP
========

ErudaPHP, mini PHP framework


#CLASSES
* Eruda Core
* Eruda Router
* Eruda CF
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
    * Input *TO-DO*
    * Select *TO-DO*
    * CheckBox *TO-DO*
    * ...
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

##Eruda Router
Enrutador basico.

El enrutador recive una petición con una URI y Metodo concreto. 
Si la URI esta vacía, se devuelve el CF que coincida con el metodo actual o el por defecto en su ausencia.
En caso contrario, se recorren los sub-enrutadores en busca de la primera coincidencia y se le pasa la responsabilidad a este.
En caso de no encontrar ningún CF hasta este punto, se devuelve el CF de error para el metodo actual o el por defecto en su ausencia.

**Parametros:**
* `array(Eruda_CF) def` : Lista de CF para la dirección actual
* `array(Eruda_Router) exr` : Mapa de sub-enrutadores
* `array(Eruda_CF) err` : Lista de CF para la dirección actual en caso de error

**funciones principales:**
* `__construct(Eruda_CF|array(Eruda_CF) def = null, array(Eruda_Router) $ext = array(), Eruda_CF|array(Eruda_CF) err = null)`
* `addDef(Eruda_CF cf)` : Añade `cf` a la lista `def`
* `addDef(Eruda_Router router)` : Añade `router` a la lista `ext`
* `addErr(Eruda_CF cf)` : Añade `cf` a la lista `err`
* `run(string uri, string method, array &params)` : ejecuta el enrutador actual devolviendo el CF resultado y añade a `params` los matches de las expresiones de enrutado.

##Eruda CF
Controller&Function

**Parametros:**
* `string meth` : Metodo de la petición
* `string cont` : Controlador
* `string func` : Función
* `array data` : Parametros para la función

**funciones principales:**
* `__construct(string controller = null, string function = null, string method = 'DEFAULT')`


##Eruda Header
*Clase abstracta* - Cabecera de la respuesta

**Parametros:**
* `string type` : Tipo de la cabecera a devolver
* `array(string) avaliveTypes` : Tipos aceptados

**funciones principales:**
* `setType(string type)` : Setea el tipo de cabecera, ha de ser uno de los aceptados
* `printDOCTYPE()` : *Abstracta* - Imprime la cabecera tipo de documento
* `printHeader(array folders = array())` : *Abstracta* - Imprime el header del documento, como parametro tiene la lista de directorios de archivos

###Eruda Header HTML
Cabecera para respuestas HTML basica

**Parametros:**
* `string cType` : Versión de HTML a devolver
* `array(string) title` : Valores del titulo
* `string titleSep` : Separador de los valores del titulo
* `string base` : URL base
* `string target` : Target por defecto para los links, por defecto `_self`
* `array(string) keys` : Lista de Keywords
* `array(string) meta` : Etiquetas Meta
* `array(string) css` : Lista de archivos css locales a añadir
* `array(string) cssExt` : Lista de archivos css externos a añadir
* `string extraCss` *TO-ADD* : Codigo css a añadir inline
* `array(string) js` : Lista de archivos javascript locales a añadir
* `array(string) jsExt` : Lista de archivos javascript externos a añadir
* `string extraJs` *TO-ADD* : Codigo javascript a añadir inline

###Eruda Header JSON
Cabecera para respuestas JSON basica
*TO-DO*

###Eruda Header XML
Cabecera para respuestas XML basica
*TO-DO*


##Eruda View
*Clase abstracta* - Generador del cuerpo de la respuesta
Dos opciones de uso, generar directo sobre salida o retornar la salida a una variable
*TO-DO*

##Eruda Model
*Clase abstracta* - Modelo de datos a devolver, dependiente de la vista a mostrar
*TO-DO*

##Eruda Form
Validador de formularios.
Puede setear objetos de retorno a partir de los datos del formulario.
*TO-DO*

##Eruda Field
Campo de formulario.
*TO-DO*

##Eruda Validator
*Clase abstracta* - Validador de campos de formulario
*TO-DO*