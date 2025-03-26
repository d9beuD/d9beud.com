<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Icon
{
    public string $name;
    public string $size;
    public string $family = 'duotone';
    public string $style = 'regular';
}
