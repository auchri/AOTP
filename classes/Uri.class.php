<?php

namespace AOTP;

/**
 * Class to add query parameters to the uri or redirect to a module
 *
 * @package AOTP
 */
class Uri
{
    const PARAM_MODULE = 'module';
    const PARAM_SITE = 'site';

    /**
     * Returns the uri of a site in the AOTP module
     *
     * @param string $site
     *
     * @return string
     */
    public static function getAOTPModuleUri($site) {
        return self::getModuleSiteUrl(MODULE_AOTP, $site);
    }

    /**
     * Returns the uri of a site in a module
     *
     * @param string $module
     * @param string $site
     *
     * @return string
     */
    public static function getModuleSiteUrl($module, $site) {
        return self::getQueriesUri(array(
            self::PARAM_MODULE => $module,
            self::PARAM_SITE   => $site
        ));
    }

    /**
     * Adds the give query parameter to the actual uri
     *
     * @param string $name
     * @param string $value
     */
    public static function redirectToQuery($name, $value) {
        self::redirectToQueries(self::getQueryUri($name, $value));
    }

    /**
     * Return the uri to redirect to query parameters
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    public static function getQueryUri($name, $value) {
        return self::getQueriesUri(array($name => $value));
    }

    /**
     * Redirects to a set of query parameters: [name => value, name2 => value2]
     *
     * @param array $array
     */
    public static function redirectToQueries(array $array) {
        Common::redirect(self::getQueriesUri($array));
    }

    /**
     * Returns the uri to redirect to a set of query parameters: [name => value, name2 => value2]
     *
     * @param array $array
     *
     * @return string
     */
    public static function getQueriesUri(array $array) {
        $parameters = array();
        $parsedUrl  = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $parameters);
        }

        $parameters = array_merge($parameters, $array);

        return URI_ROOT . 'index.php?' . http_build_query($parameters);
    }
}