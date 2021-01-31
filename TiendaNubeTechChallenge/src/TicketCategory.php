<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class TicketCategory
{
    private string $name;
    private float $price;

    public function __construct(string $name, float $price)
    {
        // I have not included validations
        $this->name = $name;
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }
}