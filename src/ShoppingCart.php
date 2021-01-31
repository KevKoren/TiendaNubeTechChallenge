<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class ShoppingCart
{
    private array $tickets = array();
    private array $availableDiscounts = array();

    public function __construct(array $availableDiscounts)
    {
        $this->availableDiscounts = $availableDiscounts;
    }

    public function addTicket(Ticket $ticket): void
    {
        try {
            $ticket->reserve();
            $this->tickets[$ticket->getId()] = $ticket;
            // Exceptions should be made more specific.
        } catch (\DomainException $ex) {
            throw $ex;
        }
    }

    public function getTickets(): array
    {
        // If I am not mistaken, in this case a copy of the array containing
        // pointers to the different tickets objects is returned.
        return $this->tickets;
    }

    public function getTicketsSeatShowTimeAndPrice(): array
    {
        $mappedTicketsInformation = array();

        foreach ($this->tickets as $ticket) {
            $mappedTicket = array(
                'seat' => $ticket->getSeat(),
                'price' => $ticket->getPrice(),
                'showtime' => $ticket->getShow()->getDateTime()
            );

            $mappedTicketsInformation[] = $mappedTicket;
        }

        return $mappedTicketsInformation;
    }

    public function getTotalCostApplyingDiscounts(): float
    {
        $totalCostApplyingDiscounts = 0;

        foreach ($this->tickets as $ticket) {
            $totalCostApplyingDiscounts += $this->getTicketPriceApplyingDiscounts($ticket);
        }

        return $totalCostApplyingDiscounts;
    }

    public function getApplicableDiscounts(): array
    {
        $applicableDiscounts = array();

        foreach ($this->tickets as $ticket) {
            $applicableDiscountsToTicket = $this->getApplicableDiscountsToTicket($ticket);
            $applicableDiscounts = array_merge($applicableDiscounts, $applicableDiscountsToTicket);
        }

        return $applicableDiscounts;
    }

    private function getTicketPriceApplyingDiscounts(Ticket $ticket): float
    {
        $ticketPrice = $ticket->getPrice();

        $totalApplicableDiscountPercentage = 0.0;

        foreach ($this->availableDiscounts as $availableDiscount) {
            $applicablePercentege = $availableDiscount->getApplicableDiscountPercentage($ticket);
            $totalApplicableDiscountPercentage += $applicablePercentege;
        }

        $discountedTicketPrice = $ticketPrice * (100 - $totalApplicableDiscountPercentage) / 100;

        // When dealing with money I am not sure about what is the correct way to handle it with code.
        return $discountedTicketPrice;
    }

    private function getApplicableDiscountsToTicket(Ticket $ticket): array
    {
        $applicableDiscounts = array();

        foreach ($this->availableDiscounts as $availableDiscount) {
            if ($availableDiscount->doesApply($ticket)) {
                $applicableDiscounts[] = $availableDiscount;
            }
        }

        return $applicableDiscounts;
    }
}