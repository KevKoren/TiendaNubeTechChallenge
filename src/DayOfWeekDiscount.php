<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class DayOfWeekDiscount extends Discount
{
    // Se podría hacer configurable.
    const PERCENTAGE = 50.0;
    const DESCRIPTION = '50% off in Tuesdays and Wednesday!';
    const APPLICABLE_TO_SHOW_DAYS = array("Tuesday", "Wednesday");

    public function doesApply(Ticket $ticket): bool
    {
        $dayOfWeek = date('l', $ticket->getShow()->getDateTime()->getTimestamp());

        if (in_array($dayOfWeek, self::APPLICABLE_TO_SHOW_DAYS)) {
            return true;
        }

        return false;
    }

    protected function getPercentage(): float
    {
        return self::PERCENTAGE;
    }
}