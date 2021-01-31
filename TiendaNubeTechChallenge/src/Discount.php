<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


abstract class Discount
{
    abstract public function doesApply(Ticket $ticket): bool;
    abstract protected function getPercentage(): float;

    public function getApplicableDiscountPercentage(Ticket $ticket): float
    {
        if ($this->doesApply($ticket)) {
            return $this->getPercentage();
        } else {
            return 0.0;
        }
    }
}