<?php

namespace AOTP;

class Structure extends Singleton
{
    public function includeHeader($title) {
        if (is_string($title)) {
            $title = array($title);
        }

        $title[] = 'AOTP';
        $title   = implode(' | ', $title);

        /** @noinspection PhpIncludeInspection */
        include DIR_STRUCTURE . 'header.php';
    }

    public function includeFooter() {
        /** @noinspection PhpIncludeInspection */
        include DIR_STRUCTURE . 'footer.php';
    }
}