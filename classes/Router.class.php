<?php

namespace AOTP;

class Router
{
    private static $indexSite = 'Index';
    private static $installSite = 'Install';

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
            Common::redirect(Uri::getAOTPModuleUri(self::$indexSite));
        }
    }

    public function routeFromArray(array $array) {
        if (isset($array[Uri::PARAM_MODULE]) && isset($array[Uri::PARAM_SITE])) {
            $this->route($array[Uri::PARAM_MODULE], $array[Uri::PARAM_SITE]);
        } else {
            throw new RoutingException("Module or site is not set");
        }
    }

    public function route($module, $site) {
        if (!Config::getInstance()->isUserConfigured() && ($module != MODULE_AOTP || $site != self::$installSite)) {
            Common::redirect(Uri::getAOTPModuleUri(self::$installSite));
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