<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge\Tests;

use PHPUnit\Framework\TestCase;
use TiendaNubeTechChallenge\Show;
use TiendaNubeTechChallenge\Ticket;
use TiendaNubeTechChallenge\TicketCategory;

class EnhancedTestCase extends TestCase
{
    /*
     * For protected and private functions testing purpose.
     * @Source: https://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit
     */
    protected static function getMethod($name): string
    {
        $class = new ReflectionClass('MyClass');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }


    /*
     * For testing purposes
     */
    protected function createTestTicket(int $id, int $ticketSeat, Show $show, TicketCategory $ticketCategory)
    {
        return new Ticket($id, $ticketSeat, $ticketCategory, $show);
    }

    /*
     * For testing purpose, I assume that every show has 10 tickets for each different category.
     */
    protected function createTestTickets(int $startingId, Show $show): array
    {
        $diamondTickets = $this->createTestTicketsForCategory($startingId, new TicketCategory('Diamond', 100.00), $show);
        $goldTickets = $this->createTestTicketsForCategory($startingId + 10, new TicketCategory('Gold', 80.00), $show);
        $silverTickets = $this->createTestTicketsForCategory($startingId + 20, new TicketCategory('Silver', 70.00), $show);
        $bronzeTickets = $this->createTestTicketsForCategory($startingId + 30, new TicketCategory('Bronze', 50.00), $show);


        // TODO Gotta be careful with array_merge and associative arrays with integer indexes
        // as array_merge reorders the resulting array starting from 0.
        $tickets = $diamondTickets + $goldTickets + $silverTickets + $bronzeTickets;
        return $tickets;
    }

    protected function createTestTicketsForCategory(int $startingId, TicketCategory $category, Show $show): array
    {
        $tickets = array();

        $currentId = $startingId;

        $lastId = $currentId + 9;

        for (; $currentId <= $lastId; $currentId++) {
            $ticketSeat = $currentId % 40 == 0 ? 40 : $currentId % 40;
            $ticket = new Ticket($currentId, $ticketSeat, $category, $show);
            $tickets[$ticket->getId()] = $ticket;
        }

        return $tickets;
    }
}