<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


class Ticket
{
    private int $seat;
    private TicketCategory $category;
    private int $status;
    private Show $show;
    private int $id;

    /*
     * Aside from initializing the ticket, it adds itself to the show object.
     */
    public function __construct(int $id, int $seat, TicketCategory $category, Show $show)
    {
        $this->id = $id;
        $this->seat = $seat;
        $this->category = $category;
        $this->status = TicketStatus::AVAILABLE;
        $this->show = $show;
        // Debatable having this kind of side effects.
        $this->show->addTicket($this);
    }

    public function getPrice(): float
    {
        return $this->category->getPrice();
    }

    public function getShow(): Show
    {
        return $this->show;
    }

    public function getSeat(): int
    {
        return $this->seat;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isAvailable(): bool
    {
        return $this->status == TicketStatus::AVAILABLE;
    }

    public function isSold(): bool
    {
        return $this->status == TicketStatus::SOLD;
    }

    public function reserve(): void
    {
        // Race condition potential.
        if ($this->canBeSold()) {
            $this->status = TicketStatus::RESERVED;
        } else {
            // Podría implementarse excepciones más específicas.
            throw new \DomainException("El ticket no se puede reservar!");
        }
    }

    private function canBeSold(): bool
    {
        $isAvailable = $this->isAvailable();

        $showCanSellTickets = $this->show->canSellTickets();

        return $isAvailable and $showCanSellTickets;
    }
}