<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class Button
{
    public string $variant = 'primary';
    public string $size = 'md';
    public bool $icon = false;
    public string $href;
    public string $tag = 'button';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['href' => null]);
        $resolver->setDefaults(['variant' => 'primary']);
        $resolver->setAllowedValues('variant', ['primary', 'secondary', 'danger']);

        $resolver->setDefaults(['size' => 'md']);
        $resolver->setAllowedValues('size', ['sm', 'md', 'lg']);

        return $resolver->resolve($data) + $data;
    }

    public function mount(string $href): void
    {
        if (null !== $href) {
            $this->tag = 'a';
        } else {
            $this->tag = 'test';
        }
    }
}
