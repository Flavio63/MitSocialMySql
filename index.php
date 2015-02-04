<?php
/**
 * Description of index
 *
 * @author flaviovilla
 */
final class Index {
    const DEFAULT_PAGE = 'home';
    const PAGE_DIR = 'page/';
    const LAYOUT_DIR = 'layout/';


    /**
     * System config.
     */
    public function init() {
        // error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
        error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler(array($this, 'handleException'));
        spl_autoload_register(array($this, 'loadClass'));
        // session
        session_start();
    }

    /**
     * Run the application!
     */
    public function run() {
        $this->runPage($this->getPage());
    }

    /**
     * Class loader.
     */
    public function loadClass($name) {
        $classes = array(
            'Config' => 'config/Config.php',
            'Error' => 'model//Error.php',
            //'Flash' => '../flash/Flash.php',
            'NotFoundException' => 'utils/NotFoundException.php',
            'connManager' => 'dao/connManager.php',
            'daoSearchCriteria' => 'dao/daoSearchCriteria.php',
            'ClientSocials' => 'model/ClientSocials.php',
            'ModelValidator' => 'model/ModelValidator.php',
            'ModelMapper' => 'model/ModelMapper.php',
            'Utils' => 'utils/Utils.php',
        );
        if (!array_key_exists($name, $classes)) {
            die('Class "' . $name . '" not found.');
        }
        require_once $classes[$name];
    }
    /**
     * Exception handler.
     */
    public function handleException(Exception $ex) {
        $extra = array('message' => $ex->getMessage());
        if ($ex instanceof NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            $this->runPage('404', $extra);
        } else {
            // TODO log exception
            header('HTTP/1.1 500 Internal Server Error');
            $this->runPage('500', $extra);
        }
    }
    
    private function getPage() {
        $page = self::DEFAULT_PAGE;
        //print_r($_GET);
        if (array_key_exists('page', $_GET)) {
            $page = $_GET['page'];
        }
        return $this->checkPage($page);
    }

    private function checkPage($page) {
        if (!preg_match('/^[a-z0-9-]+$/i', $page)) {
            // TODO log attempt, redirect attacker, ...
            echo("sono in checkpage !preg_match<br>");
            throw new NotFoundException('Unsafe page "' . $page . '" requested');
        }
        if (!$this->hasScript($page) && !$this->hasTemplate($page)) {
            // TODO log attempt, redirect attacker, ...
            echo("sono in checkpage hasScript and hasTemplate<br>");
            throw new NotFoundException('Page "' . $page . '" not found');
        }
        return $page;
    }
    
    private function runPage($page, array $extra = array()) {
        $run = false;
        if ($this->hasScript($page)) {
            $run = true;
            require $this->getScript($page);
        }
        if ($this->hasTemplate($page)) {
            $run = true;
            // data for main template
            $template = $this->getTemplate($page);
            // main template (layout)
            require self::LAYOUT_DIR . 'index.phtml';
        }
        if (!$run) {
            die('Page "' . $page . '" has neither script nor template!');
        }
    }

    private function getScript($page) {
        return self::PAGE_DIR . $page . '.php';
    }

    private function getTemplate($page) {
        return self::PAGE_DIR . $page . '.phtml';
    }


    private function hasScript($page) {
        return file_exists($this->getScript($page));
    }

    private function hasTemplate($page) {
        return file_exists($this->getTemplate($page));
    }


}
$index = new Index();
$index->init();
// run application!
$index->run();
?>