<?php
defined ( 'APPLICATION_PATH' ) || define ( 'APPLICATION_PATH', realpath ( dirname ( __FILE__ ) . '/../application' ) );
defined ( 'LIBRARY_PATH' ) || define ( 'LIBRARY_PATH', realpath ( dirname ( __FILE__ ) . '/../library' ) );
defined ( 'PUBLIC_PATH' ) || define ( 'PUBLIC_PATH', realpath ( dirname ( __FILE__ ) ) );
defined ( 'ZEND_PATH' ) || define ( 'ZEND_PATH', 'C:/Program Files (x86)/Zend/Zend Studio for Eclipse - 6.1.2/plugins/org.zend.php.framework.resource_6.1.2.v20090318-1524/resources/ZendFramework_1.8/library' );
defined ( 'GRAPHVIZ_PATH' ) || define ( 'GRAPHVIZ_PATH', 'C:\Program Files (x86)\Graphviz2.26.3\bin\dot.exe' );
defined ( 'GRAPHVIZ_CACHEPATH' ) || define ( 'GRAPHVIZ_CACHEPATH', PUBLIC_PATH.'\cache\GraphViz' );
defined ( 'GRAPHVIZ_WWWCACHEPATH' ) || define ( 'GRAPHVIZ_WWWCACHEPATH', '/cache/GraphViz' );
defined ( 'APPLICATION_ENV' ) || define ( 'APPLICATION_ENV', (getenv ( 'APPLICATION_ENV' ) ? getenv ( 'APPLICATION_ENV' ) : 'production') );


// On modifie l'include path de PHP
set_time_limit(120);
set_include_path ( implode ( PATH_SEPARATOR, array (realpath ( ZEND_PATH ), get_include_path (), realpath(APPLICATION_PATH.'/modules') ) ) );
ini_set('magic_quotes_gpc', 0); 

// On a besoin de Zend Application pour lancer notre application
require_once 'Zend/Application.php';
// On lance la session
require_once 'Zend/Session.php';
Zend_Session::start ();

// On crée l'application, on lance le bootstrap et on lance l'application !
$application = new Zend_Application ( APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini' );
$application->bootstrap ()->run ();