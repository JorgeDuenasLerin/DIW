## Enunciado
En esta práctica trabajaremos con el API de twitter, jQuery, HTML y CSS


### Práctica 

Realizar un control para visualizar tweets de un tema en concreto (se usará la búsqueda).

Especificaciones:
 1. El control debe mostrar 20 tweets
 2. Al final debe haber un botón de cargar más, cargará 20 tweets más
 3. Debemos generar en el lado del servidor un 


### Práctica 2

Basandonos en el anterior desarrollo, haremos que nuestro cliente no necesite a nuestro server usando YQL y haremos que la carga de más tweets se haga en el evento de scroll.

Especificaciones:
 1. Uso de YQL
 2. Cuando se llegue al final del scroll se deben cargar 20 tweets más


## Materiales

 * [Plantilla base](http://www.justfreetemplates.com/web-templates/view/3378.html)
 * [Librería PHP](https://github.com/J7mbo/twitter-api-php)
 * [AJAX GET](https://api.jquery.com/jquery.get/)
 * [XPATH](http://www.liquid-technologies.com/xpath-tutorial.aspx)
 * [YQL](https://developer.yahoo.com/yql/guide/yql-select-xpath.html)


## Instrucciones

### Acceso API Twitter

Crea en tu cuenta de twitter una cuenta de desarrollador y genera una aplicación. Esta aplicación estará identificada por una API KEY, en el mundo de twitter lo han llamado: **consumer_key**, también deberás especificar la contraseña: **consumer_secret**.

Después tienes que identificarte tu a través del token de acceso **oauth_access_token** y **oauth_access_token_secret**

 ```
$settings = array(
    'oauth_access_token' => "****............***********",
    'oauth_access_token_secret' => "****............***********",
    'consumer_key' => "****............***********",
    'consumer_secret' => "****............***********"
);
 ```


### Uso

En la versión del API 1.1 de twitter existen distintos [puntos de interacción](https://dev.twitter.com/rest/public). De los distintos puntos vamos a usar para esta práctica el de [búsqueda](https://dev.twitter.com/rest/public/search)

 ```
$url = 'https://api.twitter.com/1.1/search/tweets.json';
 ```

Este punto de entrada al API espera un parámetro con la búsqueda aunque existen otros [parámetros](https://dev.twitter.com/rest/reference/get/search/tweets)

 ```
$getfield = "q=madrid&lang=es";

o 

$getfield = http_build_query(
		array(
		    'q' => $_GET['q'],
		    'lang' => 'es'
		)
	);
 ```

Este punto de entrada al API utiliza una petición GET

 ```
$requestMethod = 'GET';
 ```

Mira la documentación de la librería para realizar la llamada a Twitter y devuelve los resultados:

 ```
$data =  /* ??? */

header('Content-type: application/json');
echo $data;
 ```


### Ajax GET

Para realizar la petición AJAX utilizaremos jQuery, la función $.get

 ```
var url  = 'http://dirección de mi API'
var param = { name: "John", time: "2pm" };

$.get( url, param )
  .done(function( data ) {
  	//Función de exito
    //...
  }).fail(function( data ) {
  	//Función de error
    //...
  })always(function() {
    //Función de finalización
    //...
  });
 ```


### HTML

Dentro del HTML debemos generar un gif para cuando cargamos los tweets (típico ajax loader), utilizaremos el que viene con el tema. También necesitamos tener un sitio donde mostrar los posibles errores y el botón de cargar más para la primera versión (La segunda utilizará el evento de scroll)

 ```
...
<div id="preload_tweet">
  <img src="img/status.gif" />
</div>
<div id="error_tweet">
  <span>CODE:</span> <span>Error text</span>
</div>
<ul class="middlebar_nav">
  <li>
   <a class="mbar..."
...
</ul>
<div id="load_more">
  <a href="" id="show more"/>Show more...</a>
</div>
 ```


### Pseudocódigo

Funcionamiento
 * El loading se muestra por defecto.
 * El error se oculta por defecto.
 * En la carga principal de la página hacer una petición de 20 tweets
 * Cada vez que se pidan más tweets usar las funciones para recoger los 20 siguientes
   * [Documentación](https://dev.twitter.com/rest/public/timelines)
   * Iterating in a result set: count, until, since_id, max_id


El código de cada petición
 * Mostrar el cargando
 * Si ha ido bien .append tweets
 * Si ha ido mal rellenar el mensaje de error
 * En la finalización de la función (always) ocultar el cargando

### Investigación

Describe el significado del parámetro opcional callback y razona el texto de la documentación.

 ```
callback
optional

If supplied, the response will use the JSONP format with a callback of the given name. The usefulness of this parameter is somewhat diminished by the requirement of authentication for requests to this endpoint.

Example Values: processTweets
 ```

### Versión utilizando YQL

En la nueva versión del API de twitter es necesario estar autentificado, la versión 1.0 permitía acceso a algunas funciones sin autentificación como por ejemplo la búsqueda.

Si queremos realizar un control de este tipo sin código en el servidor podemos usar el servicio de Yahoo para acceder a los tweets, para ello debemos generar el código XPATH para obtener el contenido de los tweets y después hacer la petición a:

 ```
https://query.yahooapis.com/v1/public/yql?q=
 ```


#### Ejemplo de uso de YQL y XPATH
Imagina que queremos sacar el listado de paises de esta [web](https://www.countries-ofthe-world.com/all-countries.html)

Para realizar esto debemos conocer el XPATH para llegar a los valores, podemos usar la consola de [Yahoo](https://developer.yahoo.com/yql/console/) para probar.

Solución XPATH:
 ```
xpath='//ul[contains(@class,"colum")]/li[text()]'
 ```

Solución YQL:
 ```
select * from html where url="https://www.countries-ofthe-world.com/all-countries.html" and xpath='//ul[contains(@class,"colum")]/li[text()]'
 ```

En la consola YQL:
 ```
https://developer.yahoo.com/yql/console/#h=select+*+from+html+where+url%3D%22https%3A%2F%2Fwww.countries-ofthe-world.com%2Fall-countries.html%22+and+xpath%3D'%2F%2Ful%5Bcontains(%40class%2C%22colum%22)%5D%2Fli%5Btext()%5D'
 ```