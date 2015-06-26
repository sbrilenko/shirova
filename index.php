<?
	
	/** добавляем папки в include_path */
	session_start();
	
	/** добавляем папки в include_path */
	$path = array('lib');
	if (phpversion()<5.3){
		define('__DIR__',dirname(__FILE__));
	}
    $path = get_include_path().PATH_SEPARATOR.__DIR__.'/'.implode(PATH_SEPARATOR.__DIR__.'/',$path);
    set_include_path($path);
	
	require_once 'class.page.php';
    require_once 'class.controller.php';
    require_once 'class.invis.db.php';
    $page = Page :: getInstance();
	$page -> setDoctype(Page :: $XHTML);
	$page -> addMetric("metrics/yandex.inc","metrics/google.inc");
    $controller = new controller();
	
	$db=db :: getInstance();
	$db2=db :: getInstance();
    $controller -> getView();

	if (is_file($controller -> view)){
		require_once 'views/_header.phtml';
		require_once($controller -> view);
		require_once 'views/_footer.phtml';
	} else {
		header("HTTP/1.1 404 Not Found");
		require_once 'views/_header.phtml';
		require_once "views/404.phtml";
		require_once 'views/_footer.phtml';
	}
?>