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

final class OccupationAndTimeDiscountTest extends EnhancedTestCase
{

    private Show $show1;
    private ShoppingCart $shoppingCart;
    private array $tickets = array();
    private OccupationAndTimeDiscount $occupationAndTimeDiscount;

    protected function setUp(): void
    {
        $this->show1 = new Show(new \DateTime('2021-01-27 20:00:00'));
        $ticketsShow1 = $this->createTestTickets(1, $this->show1);

        $this->tickets = $ticketsShow1;

        $this->occupationAndTimeDiscount = new OccupationAndTimeDiscount();

        $availableDiscounts = array($this->occupationAndTimeDiscount);

        $this->shoppingCart = new ShoppingCart($availableDiscounts);
    }

    public function testOccupationAndTimeDiscountDoesApply(): void
    {

    }

    public function testOccupationAndTimeDiscountDoesNotApplyBecauseOfOccupation(): void
    {

    }
}