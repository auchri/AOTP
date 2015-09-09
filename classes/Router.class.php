<?php

namespace AOTP;

class Router
{
    const PARAM_MODULE = 'module';
    const PARAM_SITE = 'site';

    private static $indexSite = array(self::PARAM_MODULE => 'AOTP', self::PARAM_SITE => 'Index');
    private static $installSite = array(self::PARAM_MODULE => 'AOTP', self::PARAM_SITE => 'Install');

    public function routeFromActualUri() {
        $this->routeFromUri($_SERVER['REQUEST_URI']);
    }

    public function routeFromUri($uri) {
        $parameters = array();
        $parsedUrl  = parse_url($uri);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $parameters);
        }

        try {
            $this->routeFromArray($parameters);
        } catch (RoutingException $e) {
            Common::redirect(URI_ROOT . 'index.php?' . http_build_query(self::$indexSite));
        }
    }

    public function routeFromArray(array $array) {
        if (isset($array[self::PARAM_MODULE]) && isset($array[self::PARAM_SITE])) {
            $this->route($array[self::PARAM_MODULE], $array[self::PARAM_SITE]);
        } else {
            throw new RoutingException("Module or site is not set");
        }
    }

    public function route($module, $site) {
        if (!Config::getInstance()->isUserConfigured() && ($module != self::$installSite[self::PARAM_MODULE] || $site != self::$installSite[self::PARAM_SITE])) {
            Common::redirect(URI_ROOT . 'index.php?' . http_build_query(self::$installSite));
        }

        $className = NS_SITES . $module . '\\' . $site;
        $classPath = getClassPathFromName($className);

        if (!doesClassExist($classPath)) {
            throw new \InvalidArgumentException('The class "' . $className . '" does not exist!');
        }

        $site = new $className();

        if (!($site instanceof Site)) {
            throw new \UnexpectedValueException('Class ' . $className . ' should ba an instance of AOTP\Site');
        }

        FrontController::getInstance()->setFromSite($site);
    }
}

class RoutingException extends \Exception
{

}