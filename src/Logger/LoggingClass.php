<?php


namespace App\Logger;

/**
 * Class LoggingClass
 * @package App\Logger
 *
 * @Annotation
 */
class LoggingClass
{
    public $name;

    public $events = ['create'];

    public $messageUpdate = 'Update: an item of {{entityName}} ({{pk}}) has been changed. Changes: {{changes}}.';

    public $messageCreate = 'Create: an item of {{entityName}} ({{pk}}), {{fields}} has been created';
}