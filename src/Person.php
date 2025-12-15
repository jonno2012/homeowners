<?php

declare(strict_types=1);

namespace Jonat\Homeowners;

final readonly class Person implements \JsonSerializable
{
    public function __construct(
        public string $title,
        public ?string $first_name,
        public ?string $initial,
        public string $last_name,
    ) {}

    /**
     * @return array<string, string|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'first_name' => $this->first_name,
            'initial' => $this->initial,
            'last_name' => $this->last_name,
        ];
    }
}
