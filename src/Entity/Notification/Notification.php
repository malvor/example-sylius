<?php

declare(strict_types=1);

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\CustomerInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_notifications")
 */
class Notification implements NotificationInterface
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var AdminUserInterface
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\AdminUser", cascade={"all"})
     */
    protected $recipient;

    /**
     * @var CustomerInterface|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer")
     */
    protected $sender;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;

    /**
     * @var array
     * @ORM\Column(name="parameters", type="array")
     */
    protected $parameters;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    protected $createdAt;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="read_at", type="datetime_immutable", nullable=true)
     */
    protected $readAt;

    /**
     * @var ClickAction
     * @ORM\Embedded(class="ClickAction")
     */
    protected $clickAction;

    public function __construct(
        string $type,
        ClickAction $clickAction,
        array $parameters,
        AdminUserInterface $recipient,
        ?CustomerInterface $sender
    ) {
        $this->type = $type;
        $this->clickAction = $clickAction;
        $this->parameters = $parameters;
        $this->createdAt = new \DateTimeImmutable();
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

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
     * @param AdminUserInterface $recipient
     */
    public function setRecipient(AdminUserInterface $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getSender(): ?CustomerInterface
    {
        return $this->sender;
    }

    /**
     * @param CustomerInterface|null $sender
     */
    public function setSender(?CustomerInterface $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return bool
     */
    public function isUnread(): bool
    {
        return null === $this->readAt;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters ?? [];
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return ClickAction
     */
    public function getClickAction(): ClickAction
    {
        return $this->clickAction;
    }

    /**
     * @param ClickAction $clickAction
     */
    public function setClickAction(ClickAction $clickAction): void
    {
        $this->clickAction = $clickAction;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getReadAt(): \DateTimeImmutable
    {
        return $this->readAt;
    }

    public function seen(\DateTimeImmutable $readAt = null): void
    {
        if (null === $readAt) {
            $readAt = new \DateTimeImmutable();
        }
        $this->readAt = $readAt;
    }
}
