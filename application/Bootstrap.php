<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	public function run() {
		// Cela permet d'avoir la configuration disponible de partout dans notre application
		Zend_Registry::set ( 'config', new Zend_Config ( $this->getOptions () ) );
		Zend_Registry::set ( 'Notices', array() );
		parent::run ();
	}
	
	protected function _initAutoload() {
		// On enregistre les modules (les parties de notre application), souvenez-vous : Backend et Frontend
		$loader = new Zend_Application_Module_Autoloader ( array ('namespace' => '', 'basePath' => APPLICATION_PATH));
		$loader->addResourceType('form', 'forms', 'Form');
		$loader->addResourceType('model', 'models', 'Model');
		return $loader;
	}
	
	protected function _initSession() {
		// On initialise la session
		$session = new Zend_Session_Namespace ( 'ICRG', true );
		Zend_Registry::set('session', $session);
		return $session;
	}
	
	protected function _initTranslate()
	{
		// On récupère la session du site.
		$session = Zend_Registry::get('session');
		
		// On définit la langue par défaut sur le site.
		$locale = new Zend_Locale('fr');
		// On enregistre cette langue dans notre registre.
		Zend_Registry::set('Zend_Locale', $locale);
		// Si la langue existe en session, on récupère la session, sinon on prend la valeur par défaut.
		$langLocale = isset($session->lang) ? $session->lang : $locale;
		// On lance l'objet de traduction en lui passant les fichiers de langues
		$translate = new Zend_Translate('array',APPLICATION_PATH.'/languages/fr_FR.php','fr');
		//$translate->addTranslation(APPLICATION_PATH.'/languages/en_US.php','en');
		// On lui passe la langue courante du site
		$translate->setLocale($langLocale);
		// Important pour utiliser le helper.
		Zend_Registry::set('Zend_Translate', $translate);

	}
	
	protected function _initView() {
		// Initialisation de la vue et des helpers de vue
		$view = new Zend_View ( );
		$view->doctype ( 'XHTML1_STRICT' );
		// On ajoute le dossier des helpers
		$view->addHelperPath ( APPLICATION_PATH . '/views/helpers' );
		// On charge l'helper qui va se charger de la vue
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'ViewRenderer' );
		$viewRenderer->setView ( $view );
		
		return $view;
	}

}