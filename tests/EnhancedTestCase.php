<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge\Tests;

use PHPUnit\Framework\TestCase;
use TiendaNubeTechChallenge\Show;
use TiendaNubeTechChallenge\Ticket;
use TiendaNubeTechChallenge\TicketCategory;

/*
 * Testing code is also code, I am not totally convinced of the name I chose for this class as I ended up adding some test data creation logic.
 */
class EnhancedTestCase extends TestCase
{
    /*
     * For protected and private functions testing purpose.
     * @Source: https://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit
     */
    protected static function getMethod($className, $name): object
    {
        $class = new \ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /*
     * For protected and private properties testing purpose.
     * @Source: https://www.php.net/manual/es/reflectionproperty.setaccessible.php
     */
    protected static function getProperty($className, $name): object
    {
        $class = new \ReflectionClass($className);
        $attribute = $class->getProperty($name);
        $attribute->setAccessible(true);
        return $attribute;
    }

    /*
     * For testing purpose, I assume that every show has 10 tickets for each different category.
     *
     * Many tests depend on the quantity of tickets this method creates, this is not ideal.
     */
    protected function createTestTickets(int $startingId, Show $show): array
    {
        $diamondTickets = $this->createTestTicketsForCategory($startingId, new TicketCategory('Diamond', 100.00), $show);
        $goldTickets = $this->createTestTicketsForCategory($startingId + 10, new TicketCategory('Gold', 80.00), $show);
        $silverTickets = $this->createTestTicketsForCategory($startingId + 20, new TicketCategory('Silver', 70.00), $show);
        $bronzeTickets = $this->createTestTicketsForCategory($startingId + 30, new TicketCategory('Bronze', 50.00), $show);


        // Gotta be careful with array_merge and associative arrays with integer indexes
        // as array_merge would reorder the resulting array starting at index 0 when integer indexes are given.
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

    protected function createRandomTicket(Show $show): Ticket
    {
        $id = rand(1, 100);
        $seat = rand(1,100);

        $categories = [['Diamond', 100], ['Gold', 80.0], ['Silver', 70.0], ['Bronze', 50.0]];

        $category = rand(0,3);

        $ticketCategory = new TicketCategory($categories[$category][0], $categories[$category][1]);

        $ticket = new Ticket($id, $seat, $ticketCategory, $show);

        return $ticket;
    }
}