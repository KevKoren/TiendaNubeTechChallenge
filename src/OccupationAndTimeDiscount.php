<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class OccupationAndTimeDiscount extends Discount
{
    // Se podría hacer configurable.
    public const PERCENTAGE = 10.0;
    public const DESCRIPTION = '10% off as we are almost complete and one day away from the show!';
    public const ATLEAST_OCCUPATION_TRESHOLD_PERCENTAGE = 80.0;
    public const DAYS_BEFORE = 1;

    public function doesApply(Ticket $ticket): bool
    {
        // Supongo que la condición de día es la menos probable en cumplirse
        // por lo que se verifica primero para ser más performante.
        return $this->daysBeforeCondition($ticket) and $this->occupationCondition($ticket);
    }

    private function occupationCondition($ticket): bool
    {
        $showOccupation = $ticket->getShow()->getOccupation();

        $occupationCondition = $showOccupation > self::ATLEAST_OCCUPATION_TRESHOLD_PERCENTAGE;

        return $occupationCondition;
    }

    private function daysBeforeCondition(Ticket $ticket): bool
    {
        $showDate = $ticket->getShow()->getDateTime();

        $currentDateTime = new \DateTime();

        $difference = $currentDateTime->diff($currentDateTime);

        //TODO Revisar estas funciones
        $daysBeforeCondition = $difference->d == 1;

        return $daysBeforeCondition;
    }

    protected function getPercentage(): float
    {
        return self::PERCENTAGE;
    }
}