<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge\Tests;

use TiendaNubeTechChallenge\DayOfWeekDiscount;
use TiendaNubeTechChallenge\OccupationAndTimeDiscount;
use TiendaNubeTechChallenge\ShoppingCart;
use TiendaNubeTechChallenge\Show;
use TiendaNubeTechChallenge\Ticket;
use TiendaNubeTechChallenge\TicketCategory;

require_once(__DIR__ . '/../config.php');

require_once(__DIR__ . '/EnhancedTestCase.php');


final class ShoppingCartTest extends EnhancedTestCase
{

    private Show $show1;
    private Show $show2;
    private ShoppingCart $shoppingCart;
    private array $tickets = array();
    private DayOfWeekDiscount $dayOfWeekDiscount;
    private OccupationAndTimeDiscount $occupationAndTimeDiscount;

    /*
     * When I code this I wasn't aware of PHPUnit Data Providers.
     */
    protected function setUp(): void
    {
        // Will fail in 2030.
        $wednesdayInTheFuture = new \DateTime('2030-02-13 20:00:00');
        $ThursdayInTheFuture = new \DateTime('2030-02-14 20:00:00');

        $this->show1 = new Show($wednesdayInTheFuture);
        $ticketsShow1 = $this->createTestTickets(1, $this->show1);

        $this->show2 = new Show($ThursdayInTheFuture);
        $ticketsShow2 = $this->createTestTickets(41, $this->show2);

        $this->tickets = $ticketsShow1 + $ticketsShow2;

        $this->occupationAndTimeDiscount = new OccupationAndTimeDiscount();

        $this->dayOfWeekDiscount = new DayOfWeekDiscount();

        $availableDiscounts = array($this->occupationAndTimeDiscount, $this->dayOfWeekDiscount);

        $this->shoppingCart = new ShoppingCart($availableDiscounts);
    }

    public function testTicketsAreCorrectlyAdded(): void
    {
        $ticket1 = $this->show1->getTickets()[1];
        $ticket75 = $this->show2->getTickets()[75];

        $this->shoppingCart->addTicket($ticket1);
        $this->shoppingCart->addTicket($ticket75);

        $this->assertContains($ticket1, $this->shoppingCart->getTickets());
        $this->assertContains($ticket75, $this->shoppingCart->getTickets());
        $this->assertCount(2, $this->shoppingCart->getTickets());
    }

    public function testGetTotalCostApplyingDiscounts(): void
    {
        $ticket1 = $this->show1->getTickets()[1];
        $ticket75 = $this->show2->getTickets()[75];

        $this->shoppingCart->addTicket($ticket1);
        $this->shoppingCart->addTicket($ticket75);


        /*
         * Ticket1 is a diamond ticket sold at 100 but its corresponding show is held on a Wednesday
         * so a 50% discounts is applied. The ticket end up at a price of 50.
         * Ticket75 is a bronze ticket sold at 50.
         */

        $this->assertEquals(100.0, round($this->shoppingCart->getTotalCostApplyingDiscounts(), 2));
    }

    public function testGetApplicableDiscounts(): void
    {
        $ticket1 = $this->show1->getTickets()[1];
        $ticket75 = $this->show2->getTickets()[75];

        $this->shoppingCart->addTicket($ticket1);
        $this->shoppingCart->addTicket($ticket75);

        $this->assertEquals([$this->dayOfWeekDiscount], $this->shoppingCart->getApplicableDiscounts());
    }

    public function testGetTicketsSeatShowTimeAndPrice(): void
    {
        $ticket1 = $this->show1->getTickets()[1];
        $ticket75 = $this->show2->getTickets()[75];

        $this->shoppingCart->addTicket($ticket1);
        $this->shoppingCart->addTicket($ticket75);

        $expectedResult = [
            [
                'seat' => $ticket1->getSeat(),
                'showtime' => $ticket1->getShow()->getDateTime(),
                'price' => $ticket1->getPrice()
            ],
            [
                'seat' => $ticket75->getSeat(),
                'showtime' => $ticket75->getShow()->getDateTime(),
                'price' => $ticket75->getPrice()
            ]
        ];

        $this->assertEquals($expectedResult, $this->shoppingCart->getTicketsSeatShowTimeAndPrice());
    }
}