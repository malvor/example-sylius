<?php

declare(strict_types=1);

namespace App\Command\Notification\CreateNotification;

final class CreateNotificationCommand
{
    /** @var string */
    private $type;
    /** @var int|null */
    private $senderId;
    /** @var string */
    private $clickActionRoute;
    /** @var array */
    private $clickActionParameters;
    /** @var string */
    private $parameters;

    public function __construct(
        string $type,
        ?int $senderId,
        string $clickActionRoute,
        array $clickActionParameters,
        array $parameters
    ) {
        $this->type = $type;
        $this->senderId = $senderId;
        $this->clickActionRoute = $clickActionRoute;
        $this->clickActionParameters = $clickActionParameters;
        $this->parameters = $parameters;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getClickActionRoute()
    {
        return $this->clickActionRoute;
    }

    public function getClickActionParameters()
    {
        return $this->clickActionParameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

}
