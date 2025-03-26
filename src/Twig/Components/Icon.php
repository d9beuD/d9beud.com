<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Icon
{
    public string $name;
    public string $size = 'md';
    public string $family = 'duotone';
    public string $style = 'regular';
    public bool $fixedWidth = false;
}
