<?php die;
require('admin/conexao/conecta.php');
require(REQUIRE_PATH . '/inc/header.inc.php');
 
if (!require($Link->getPatch())):
    WLMsg('Erro ao incluir arquivo de navegação!', WS_ERROR, true);
endif;
require(REQUIRE_PATH . '/inc/footer.inc.php');

/* $html = ob_get_clean ();
  echo preg_replace('/\s+/', ' ', $html); */

if (!file_exists('.htaccess')):
    $htaccesswrite = "RewriteEngine On\r\nRewriteCond %{HTTP:X-Forwarded-Proto} !https\r\nRewriteCond %{HTTPS} off\r\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?url=$1&%{QUERY_STRING} [NC,L]\r\n\r\n<IfModule mod_expires.c>\r\nExpiresActive On\r\nExpiresByType image/jpg 'access 1 year'\r\nExpiresByType image/jpeg 'access 1 year'\r\nExpiresByType image/gif 'access 1 year'\r\nExpiresByType image/png 'access 1 year'\r\nExpiresByType text/css 'access 1 month'\r\nExpiresByType application/pdf 'access 1 month'\r\nExpiresByType text/x-javascript 'access 1 month'\r\nExpiresByType application/x-shockwave-flash 'access 1 month'\r\nExpiresByType image/x-icon 'access 1 year'\r\nExpiresDefault 'access 2 days'\r\n</IfModule>";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
endif;
        



























































































































































































































































































                                                                                                                                                                                                

 ?>
<?php
 
/* echo $_SERVER['DOCUMENT_ROOT'];
  die; */
//ob_start();
/* if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) { 
  header('location:./404');
  } else { */
require('admin/conexao/conecta.php');
require(REQUIRE_PATH . '/inc/header.inc.php');
 
if (!require($Link->getPatch())):
    WLMsg('Erro ao incluir arquivo de navegação!', WS_ERROR, true);
endif;
require(REQUIRE_PATH . '/inc/footer.inc.php');

/* $html = ob_get_clean ();
  echo preg_replace('/\s+/', ' ', $html); */

if (!file_exists('.htaccess')):
    $htaccesswrite = "RewriteEngine On\r\nRewriteCond %{HTTP:X-Forwarded-Proto} !https\r\nRewriteCond %{HTTPS} off\r\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?url=$1&%{QUERY_STRING} [NC,L]\r\n\r\n<IfModule mod_expires.c>\r\nExpiresActive On\r\nExpiresByType image/jpg 'access 1 year'\r\nExpiresByType image/jpeg 'access 1 year'\r\nExpiresByType image/gif 'access 1 year'\r\nExpiresByType image/png 'access 1 year'\r\nExpiresByType text/css 'access 1 month'\r\nExpiresByType application/pdf 'access 1 month'\r\nExpiresByType text/x-javascript 'access 1 month'\r\nExpiresByType application/x-shockwave-flash 'access 1 month'\r\nExpiresByType image/x-icon 'access 1 year'\r\nExpiresDefault 'access 2 days'\r\n</IfModule>";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
endif;

/*}*/