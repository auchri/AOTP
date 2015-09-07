<?php

namespace AOTP;

/**
 * Class to generate and display alert messages
 *
 * @package AOTP
 */
class Alert
{
    private $type;
    private $message;

    const TYPE_ERROR = "error";
    const TYPE_SUCCESS = "success";
    const TYPE_WARNING = "warning";
    const TYPE_NOTICE = "notice";

    private static $text = array(
        self::TYPE_ERROR   => 'Error: ',
        self::TYPE_SUCCESS => 'Success: ',
        self::TYPE_WARNING => 'Warning: ',
        self::TYPE_NOTICE  => 'Notice: '
    );

    /**
     * @param $type    string The type of the alert (TYPE_ERROR, TYPE_SUCCESS, TYPE_WARNING or TYPE_NOTICE)
     * @param $message string The message of the alert
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type, $message) {
        $message = trim($message);
        if (!array_key_exists($type, self::$text)) {
            throw new \InvalidArgumentException('$type should be one of TYPE_ERROR, TYPE_SUCCESS, TYPE_WARNING or TYPE_NOTICE, was ' . $type);
        } else if (empty($message)) {
            throw new \InvalidArgumentException('Message must not be empty');
        }

        $this->type    = $type;
        $this->message = $message;

        return $this;
    }

    /**
     * Displays the alert box
     */
    public function show() {
        echo $this->getHtml();
    }

    /**
     * Returns the html code of the alert box
     *
     * @return string
     */
    public function getHtml() {
        return '<div class="alert-box ' . $this->type . '"><span>' . self::$text[$this->type] . '</span>' . $this->message . '</div>';
    }
}