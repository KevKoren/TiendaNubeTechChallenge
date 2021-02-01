<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge\Tests;

use TiendaNubeTechChallenge\DayOfWeekDiscount;
use TiendaNubeTechChallenge\OccupationAndTimeDiscount;
use TiendaNubeTechChallenge\ShoppingCart;
use TiendaNubeTechChallenge\Show;
use TiendaNubeTechChallenge\Ticket;
use TiendaNubeTechChallenge\TicketCategory;
use TiendaNubeTechChallenge\TicketStatus;

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

    /**
     * @dataProvider occupationPercentageConditionDataProvider
     */
    public function testOccupationPercentage(Ticket $ticket, bool $expected, string $errDescription): void
    {
        $occupationConditionMethod = Self::getMethod('TiendaNubeTechChallenge\OccupationAndTimeDiscount', 'occupationCondition');

        $this->assertEquals($expected, $occupationConditionMethod->invokeArgs($this->occupationAndTimeDiscount, [$ticket]), $errDescription);
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

    public function occupationPercentageConditionDataProvider()
    {

        $show0 = new Show(new \DateTime());
        $show50 = new Show(new \DateTime());
        $show80 = new Show(new \DateTime());
        $show90 = new Show(new \DateTime());
        $show100 = new Show(new \DateTime());

        $this->createTestTickets(1, $show0);
        $this->createTestTickets(41, $show50);
        $this->createTestTickets(81, $show80);
        $this->createTestTickets(121, $show90);
        $this->createTestTickets(161, $show100);

        $this->setSomePercentOfTicketToSoldStatus($show50, 50);
        $this->setSomePercentOfTicketToSoldStatus($show80, 80);
        $this->setSomePercentOfTicketToSoldStatus($show90, 90);
        $this->setSomePercentOfTicketToSoldStatus($show100, 100);

        $ticket0 = $show0->getTickets()[1];
        $ticket50 = $show50->getTickets()[41];
        $ticket80 = $show80->getTickets()[81];
        $ticket90 = $show90->getTickets()[121];
        $ticket100 = $show100->getTickets()[161];

        return [
            [$ticket0, False, '$ticket0Occupation'],
            [$ticket50, False, '$ticket50Occupation'],
            [$ticket80, False, '$ticket80Occupation'],
            [$ticket90, True, '$ticket90Occupation'],
            [$ticket100, True, '$ticket100Occupation']
        ];
    }

    private function setSomePercentOfTicketToSoldStatus(Show $show, float $percent): void
    {
        $tickets = $show->getTickets();
        $count = count($tickets);

        $countOfTicketsToSetToSoldStatus = floor($percent * $count / 100);

        $ticketsToSetToSoldStatus = array_slice($tickets, 0, $countOfTicketsToSetToSoldStatus);

        foreach($ticketsToSetToSoldStatus as $id => $ticket) {
            $this->getProperty('TiendaNubeTechChallenge\Ticket', 'status')->setValue($ticket, TicketStatus::SOLD);
        }
    }

}