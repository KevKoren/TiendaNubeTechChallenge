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

final class DayOfWeekDiscountTest extends EnhancedTestCase
{

    private DayOfWeekDiscount $dayOfWeekDiscount;

    protected function setUp(): void
    {
        $this->dayOfWeekDiscount = new DayOfWeekDiscount();
    }

    /**
     * @dataProvider dayOfWeekDiscountDoesApplyProvider
     */
    public function testDayOfWeekDiscountDoesApply($ticket, $expected, $errDescription): void
    {
        $this->assertEquals($expected, $this->dayOfWeekDiscount->doesApply($ticket), $errDescription);
    }

    public function dayOfWeekDiscountDoesApplyProvider()
    {
        $showSunday = new Show(new \DateTime('2021-01-10 20:00:00'));
        $showMonday = new Show(new \DateTime('2021-01-11 20:00:00'));
        $showTuesday = new Show(new \DateTime('2021-01-12 20:00:00'));
        $showWednesday = new Show(new \DateTime('2021-01-13 20:00:00'));
        $showThursday = new Show(new \DateTime('2021-01-14 20:00:00'));
        $showFriday = new Show(new \DateTime('2021-01-15 20:00:00'));
        $showSaturday = new Show(new \DateTime('2021-01-16 20:00:00'));

        $ticketSunday = $this->createRandomTicket($showSunday);
        $ticketMonday = $this->createRandomTicket($showMonday);
        $ticketTuesday = $this->createRandomTicket($showTuesday);
        $ticketWednesday = $this->createRandomTicket($showWednesday);
        $ticketThursday = $this->createRandomTicket($showThursday);
        $ticketFriday = $this->createRandomTicket($showFriday);
        $ticketSaturday = $this->createRandomTicket($showSaturday);

        return [
            [$ticketSunday, False, 'Sunday'],
            [$ticketMonday, False, 'Monday'],
            [$ticketTuesday, True, 'Tuesday'],
            [$ticketWednesday, True, 'Wednesday'],
            [$ticketThursday, False, 'Thursday'],
            [$ticketFriday, False, 'Friday'],
            [$ticketSaturday, False, 'Saturday']
        ];
    }
}