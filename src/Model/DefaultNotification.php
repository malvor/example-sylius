<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Notification\ClickAction;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\CustomerInterface;

abstract class DefaultNotification
{
    /** @var int */
    protected $id;

    /** @var AdminUserInterface */
    protected $recipient;

    /** @var CustomerInterface|null */
    protected $sender;

    /** @var bool */
    protected $unread;

    /** @var string */
    protected $type;

    /** @var array */
    protected $parameters;

    /** @var ClickAction */
    protected $clickAction;

    /** @var \DateTimeImmutable */
    protected $createdAt;

    /** @var \DateTimeImmutable */
    protected $readAt;

    /** @var null|string */
    protected $message = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return AdminUserInterface
     */
    public function getRecipient(): AdminUserInterface
    {
        return $this->recipient;
    }

    /**
     * @return null|CustomerInterface
     */
    public function getSender(): ?CustomerInterface
    {
        return $this->sender;
    }

    /**
     * @return bool
     */
    public function isUnread(): bool
    {
        return $this->unread;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getReadAt(): \DateTimeImmutable
    {
        return $this->readAt;
    }

    public function getParameter($parameter, $maxLength = 200): string
    {
        if (false === isset($this->parameters[$parameter])) {
            return '';
        }
        return strtok(wordwrap((string)$this->parameters[$parameter], $maxLength, "...\n"), "\n");
    }

    public function getClickAction(): ?ClickAction
    {
        return $this->clickAction;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function message(): string
    {
        if (null === $this->message) {
            return '';
        }
        return $this->message;
    }
}
