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


final class OccupationAndTimeDiscountTest extends EnhancedTestCase
{

    private OccupationAndTimeDiscount $occupationAndTimeDiscount;

    protected function setUp(): void
    {
        $this->occupationAndTimeDiscount = new OccupationAndTimeDiscount();
    }

    /**
     * @dataProvider daysBeforeConditionDataProvider
     */
    public function testDaysBeforeCondition(Ticket $ticket, bool $expected, string $errDescription): void
    {
        $daysBeforeConditionMethod = Self::getMethod('TiendaNubeTechChallenge\OccupationAndTimeDiscount', 'daysBeforeCondition');

        $this->assertEquals($expected, $daysBeforeConditionMethod->invokeArgs($this->occupationAndTimeDiscount, [$ticket]), $errDescription);
    }


    public function daysBeforeConditionDataProvider()
    {
        $today = new \DateTime();

        $yesterday = new \DateTime();
        $yesterday->sub(new \DateInterval('P1D'));

        $tomorrow = new \DateTime();
        $tomorrow->add(new \DateInterval('P1D'));

        $previousYearYesterdayDay = new \DateTime();
        $previousYearYesterdayDay->sub(new \DateInterval('P1Y'))->sub(new \DateInterval('P1D'));

        $showToday = new Show($today);
        $showYesterday = new Show($yesterday);
        $showTomorrow = new Show($tomorrow);
        $showOneYearBeforeYesterday = new Show($previousYearYesterdayDay);

        $ticketToday = $this->createRandomTicket($showToday);
        $ticketYesterday = $this->createRandomTicket($showYesterday);
        $ticketTomorrow = $this->createRandomTicket($showTomorrow);
        $ticketOneYearBeforeYesterday = $this->createRandomTicket($showOneYearBeforeYesterday);


        return [
          [$ticketToday, False, 'Today'],
          [$ticketYesterday, True, 'Yesterday'],
          [$ticketTomorrow, False, 'Tomorrow'],
          [$ticketOneYearBeforeYesterday, False, 'OneYearBeforeYesterday']
        ];
    }

}