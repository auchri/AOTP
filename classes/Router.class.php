<?php

namespace AOTP;

class Router
{
    const PARAM_MODULE = 'module';
    const PARAM_SITE = 'site';

    private static $indexSite = array(self::PARAM_MODULE => 'aotp', self::PARAM_SITE => 'Index');
    private static $installSite = array(self::PARAM_MODULE => 'aotp', self::PARAM_SITE => 'Install');

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
        } catch (\InvalidArgumentException $e) {
            Common::redirect(URI_ROOT . 'index.php?' . http_build_query(self::$indexSite));
        }
    }

    public function routeFromArray(array $array) {
        if (isset($array[self::PARAM_MODULE]) && isset($array[self::PARAM_SITE])) {
            $this->route($array[self::PARAM_MODULE], $array[self::PARAM_SITE]);
        } else {
            throw new \InvalidArgumentException("Module or site is not set");
        }
    }

    public function route($module, $site) {
        $test = Config::getInstance()->isUserConfigured();
        if (!Config::getInstance()->isUserConfigured() && ($module != self::$installSite[self::PARAM_MODULE] || $site != self::$installSite[self::PARAM_SITE])) {
            Common::redirect(URI_ROOT . 'index.php?' . http_build_query(self::$installSite));
        }

        $className = NS_SITES . $module . '\\' . $site;
        $site      = new $className();

        if (!($site instanceof Site)) {
            throw new \UnexpectedValueException('Class ' . $className . ' should ba an instance of AOTP\Site');
        } else {
            ob_start();
            $output = $site->getOutput();

            $output .= ob_get_contents();
            ob_end_clean();

            FrontController::getInstance()->setTitle($site->getTitle());
            FrontController::getInstance()->setContent($output);
        }
    }
}