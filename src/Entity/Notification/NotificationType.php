<?php

declare(strict_types=1);

namespace App\Entity\Notification;

final class NotificationType
{
    /** @var string  */
    public $class;

    /** @var string  */
    public $name;

    /** @var null|string */
    public $translation;

    public function __construct(string $name, string $class, ?string $translation = null)
    {
        $this->name = $name;
        $this->class = $class;
        $this->translation = $translation;
    }
}
