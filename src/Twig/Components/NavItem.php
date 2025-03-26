<?php

namespace App\Twig\Components;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavItem
{
    public ?string $href = null;
    public ?string $name = null;
    public ?string $checkPath = null;
    public array $navLinkClasses = ['nav-link'];

    public function __construct(
        protected UrlGeneratorInterface $urlGenerator,
        protected RequestStack $requestStack,
    ) {
    }

    public function mount(?string $name = null, ?string $checkPath = null): void
    {
        $this->name = $name;
        $this->checkPath = $checkPath;

        if ($name !== null && !empty($name)) {
            $this->href = $this->urlGenerator->generate($name);
        }

        if ($checkPath !== null && $this->isActive($checkPath)) {
            $this->navLinkClasses[] = 'active';
        }
    }

    public function isActive(?string $checkPath = null): bool
    {
        $check = $checkPath ?? $this->checkPath;

        if ($check) {
            return str_starts_with($this->requestStack->getCurrentRequest()->get('_route'), $checkPath);
        }

        return false;
    }
}
