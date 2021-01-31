<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class Show
{
    public const TICKETS_SELL_RESTRICTION_BEFORE_SHOWTIME_IN_HOURS = 2;

    private \DateTime $dateTime;
    private array $tickets = array();

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function addTicket(Ticket $ticket): void
    {
        $this->tickets[$ticket->getId()] = $ticket;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function getOccupationPercentage(): float
    {
        $capacity = 0;
        $occupation = 0;

        foreach($this->tickets as $ticket) {
            $capacity++;
            if ($ticket->isAvailable()) {
                $occupation++;
            }
        }

        $occupationPercentage = 100 * $occupation / $capacity;

        return $occupationPercentage;
    }

    public function canSellTickets(): bool
    {
        $currentDateTime = new \DateTime();

        $difference = $currentDateTime->diff($this->getDateTime());

        //TODO Revisar estas funciones
        $hoursBeforeCondition = ($difference->invert == 1 and $difference->h >2);

        return $hoursBeforeCondition;
    }
}