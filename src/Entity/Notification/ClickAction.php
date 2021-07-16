<?php

declare(strict_types=1);

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class ClickAction
{
    /**
     * @var string
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @var array
     * @ORM\Column(name="parameters", type="array", nullable=true)
     */
    private $parameters;

    public function __construct(string $route, array $parameters)
    {
        $this->route = $route;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function isClickable(): bool
    {
        return empty($this->route) === false;
    }
}
