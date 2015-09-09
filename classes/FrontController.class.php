<?php

namespace AOTP;

/**
 * The class which controls the html
 *
 * @package AOTP
 */
class FrontController extends Singleton
{
    private $title;
    private $content;

    private $menuEntries = array();

    protected function __construct() {
        $this->menuEntries = array(
            'Projects' => Uri::getAOTPModuleUri('Projects')
        );
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function printPage() {
        echo $this->getHeaderHtml();
        echo $this->getContent();
        echo $this->getFooterHtml();
    }

    /**
     * Returns the title of the site
     *
     * @return mixed
     */
    public function getTitle() {
        if (is_string($this->title)) {
            $title = array($this->title);
        }

        $title[] = 'AOTP';
        $title   = implode(' | ', $title);

        return $title;
    }

    /**
     * Returns the content of the site
     *
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set the content and the title from a site
     *
     * @param Site $site
     */
    public function setFromSite(Site $site) {
        $site->prepare();
        ob_start();
        $output = $site->getOutput();

        $output .= ob_get_contents();
        ob_end_clean();

        $this->setTitle($site->getTitle());
        $this->setContent($output);
    }

    /**
     * Returns the html of the menu items
     *
     * @return string
     */
    private function getMenuItemHtml() {
        $html = '';

        foreach ($this->menuEntries as $title => $url) {
            $html .= '<li><a href="' . $url . '">' . $title . '</a></li>';
        }

        return $html;
    }

    /**
     * Returns the html of the header
     *
     * @return string
     */
    private function getHeaderHtml() {
        $placeholderReplacements = array(
            '[[TITLE]]'      => $this->getTitle(),
            '[[URI_ROOT]]'   => URI_ROOT,
            '[[URI_CSS]]'    => URI_CSS,
            '[[MENU_ITEMS]]' => $this->getMenuItemHtml()
        );
        $placeholder             = array_keys($placeholderReplacements);
        $replacement             = array_values($placeholderReplacements);

        $headerHtml = file_get_contents(DIR_STRUCTURE . 'header.php');

        return str_replace($placeholder, $replacement, $headerHtml);
    }

    /**
     * Returns the html of the footer
     *
     * @return string
     */
    private function getFooterHtml() {
        $placeholderReplacements = array(
            '[[URI_ROOT]]' => URI_ROOT,
            '[[YEAR]]'     => date('o')
        );
        $placeholder             = array_keys($placeholderReplacements);
        $replacement             = array_values($placeholderReplacements);

        $headerHtml = file_get_contents(DIR_STRUCTURE . 'footer.php');

        return str_replace($placeholder, $replacement, $headerHtml);
    }
}