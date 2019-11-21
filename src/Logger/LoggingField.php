<?php


namespace App\Logger;

/**
 * @Annotation
 *
 * Class LoggingField
 * @package App\Logger
 */
class LoggingField
{
    /**
     * @var bool
     */
    public $logChanges = true;

    /**
     * @var string|null
     */
    public $name = null;

}