<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge\Tests;

use TiendaNubeTechChallenge\DayOfWeekDiscount;
use TiendaNubeTechChallenge\OccupationAndTimeDiscount;
use TiendaNubeTechChallenge\ShoppingCart;
use TiendaNubeTechChallenge\Show;
use TiendaNubeTechChallenge\Ticket;
use TiendaNubeTechChallenge\TicketCategory;

require_once( __DIR__ . '/../config.php');

require_once( __DIR__ . '/EnhancedTestCase.php');

require_once(SRC_PATH . 'Show.php');
require_once(SRC_PATH . 'Discount.php');
require_once(SRC_PATH . 'DayOfWeekDiscount.php');
require_once(SRC_PATH . 'OccupationAndTimeDiscount.php');
require_once(SRC_PATH . 'ShoppingCart.php');
require_once(SRC_PATH . 'Ticket.php');
require_once(SRC_PATH . 'TicketCategory.php');
require_once(SRC_PATH . 'TicketStatus.php');

final class DayOfWeekDiscountTest extends EnhancedTestCase
{
    private Show $showSunday;
    private Show $showMonday;
    private Show $showTuesday;
    private Show $showWednesday;
    private Show $showThursday;
    private Show $showFriday;
    private Show $showSaturday;

    private array $tickets = array();
    private DayOfWeekDiscount $dayOfWeekDiscount;

    protected function setUp(): void
    {
        $this->showSunday = new Show(new \DateTime('2021-01-10 20:00:00'));
        $this->showMonday = new Show(new \DateTime('2021-01-11 20:00:00'));
        $this->showTuesday = new Show(new \DateTime('2021-01-12 20:00:00'));
        $this->showWednesday = new Show(new \DateTime('2021-01-13 20:00:00'));
        $this->showThursday = new Show(new \DateTime('2021-01-14 20:00:00'));
        $this->showFriday = new Show(new \DateTime('2021-01-15 20:00:00'));
        $this->showSaturday = new Show(new \DateTime('2021-01-16 20:00:00'));

//        $ticketsShow1 = $this->createTestTickets(1, $this->show1);
//        $this->show1->setTickets($ticketsShow1);

//        $this->tickets = $ticketsShow1;

        $this->dayOfWeekDiscount = new DayOfWeekDiscount();
    }

    public function testDayOfWeekDiscountDoesApply(): void
    {
        $show1 = new Show(new \DateTime('2021-01-12 20:00:00'));
        $show2 = new Show(new \DateTime('2021-01-13 20:00:00'));


//
//        $this->assertTrue($this->dayOfWeekDiscount->doesApply($show1));
//        $this->assertTrue($this->dayOfWeekDiscount->doesApply($show2));
    }

    public function testDayOfWeekDiscountDoesNotApply(): void
    {

    }
}