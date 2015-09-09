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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function printPage() {
        Structure::getInstance()->includeHeader($this->title);
        echo $this->getContent();
        Structure::getInstance()->includeFooter();
    }

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
}