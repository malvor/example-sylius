<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NotificationWidgetExtension extends AbstractExtension
{
    private const
        LIMIT = 5,
        FREQUENCY = 10;

    public function __construct()
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'websnacks_render_notifications_widget',
                [$this, 'renderWidget'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    public function renderWidget(Environment $environment): string
    {
        return $environment->render(
            'Admin/Notification/_notifications.html.twig',
            [
                'frequency' => self::FREQUENCY,
                'limit' => self::LIMIT
            ]
        );
    }
}
