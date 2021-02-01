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

final class TicketTest extends EnhancedTestCase
{
    /**
     * @dataProvider canBeSoldDataProvider
     */
    public function testCanBeSold(Ticket $ticket, bool $expected, string $errDescription): void
    {

        $canBeSoldMethod = Self::getMethod('TiendaNubeTechChallenge\Ticket', 'canBeSold');

        $this->assertEquals($expected, $canBeSoldMethod->invokeArgs($ticket, []), $errDescription);
    }

    /**
     * @dataProvider reserveIsPossibleDataProvider
     */
    public function testReserveIsPosibble(Ticket $ticket, string $errDescription): void
    {
        $ticket->reserve();

        $ticketStatus =  $this->getProperty('TiendaNubeTechChallenge\Ticket', 'status')->getValue($ticket);

        $this->assertEquals(TicketStatus::RESERVED, $ticketStatus, $errDescription);
    }

    /**
     * @dataProvider reserveIsNotPosibbleThrowsExceptionDataProvider
     */
    public function testReserveIsNotPosibbleThrowsException(Ticket $ticket): void
    {
        $this->expectException(\DomainException::class);
        $ticket->reserve();
    }

    public function canBeSoldDataProvider(): array
    {
        $runningDateTime = new \DateTime();

        $tomorrowDateTime = new \DateTime();
        $tomorrowDateTime->add(new \DateInterval('P1D'));

        $oneYearAgoDateTime = new \DateTime();
        $oneYearAgoDateTime->sub(new \DateInterval('P1Y'));

        $oneYearLaterDateTime = new \DateTime();
        $oneYearLaterDateTime->add(new \DateInterval('P1Y'));

        $runningShow = new Show($runningDateTime);
        $tomorrowShow = new Show($tomorrowDateTime);
        $oneYearAgoShow = new Show($oneYearAgoDateTime);
        $oneYearLaterShow = new Show($oneYearLaterDateTime);

        $ticketRunningShow = $this->createRandomTicket($runningShow);
        $ticketTomorrowShow = $this->createRandomTicket($tomorrowShow);
        $ticketOneYearAgoShow = $this->createRandomTicket($oneYearAgoShow);
        $ticketOneYearLaterShow = $this->createRandomTicket($oneYearLaterShow);

        return [
            [$ticketRunningShow, False, 'Running show'],
            [$ticketTomorrowShow, True, 'Tomorrow Show'],
            [$ticketOneYearAgoShow, False, 'One year ago show'],
            [$ticketOneYearLaterShow, True, 'One year later show']
        ];
    }

    public function reserveIsPossibleDataProvider(): array
    {
        $tomorrowDateTime = new \DateTime();
        $tomorrowDateTime->add(new \DateInterval('P1D'));

        $oneYearLaterDateTime = new \DateTime();
        $oneYearLaterDateTime->add(new \DateInterval('P1Y'));

        $tomorrowShow = new Show($tomorrowDateTime);
        $oneYearLaterShow = new Show($oneYearLaterDateTime);

        $ticketTomorrowShow = $this->createRandomTicket($tomorrowShow);
        $ticketOneYearLaterShow = $this->createRandomTicket($oneYearLaterShow);

        return [
            [$ticketTomorrowShow, 'Tomorrow Show'],
            [$ticketOneYearLaterShow, 'One year later show']
        ];
    }

    public function reserveIsNotPosibbleThrowsExceptionDataProvider(): array
    {
        $runningDateTime = new \DateTime();

        $tomorrowDateTime = new \DateTime();
        $tomorrowDateTime->add(new \DateInterval('P1D'));

        $oneYearAgoDateTime = new \DateTime();
        $oneYearAgoDateTime->sub(new \DateInterval('P1Y'));

        $oneYearLaterDateTime = new \DateTime();
        $oneYearLaterDateTime->add(new \DateInterval('P1Y'));

        $runningShow = new Show($runningDateTime);
        $tomorrowShow = new Show($tomorrowDateTime);
        $oneYearAgoShow = new Show($oneYearAgoDateTime);
        $oneYearLaterShow = new Show($oneYearLaterDateTime);

        $ticketRunningShow = $this->createRandomTicket($runningShow);
        $ticketOneYearAgoShow = $this->createRandomTicket($oneYearAgoShow);

        $reservedTicketTomorrowShow = $this->createRandomTicket($tomorrowShow);
        $reservedTicketTomorrowShow->reserve();

        $reservedTicketOneYearLaterShow = $this->createRandomTicket($oneYearLaterShow);
        $reservedTicketOneYearLaterShow->reserve();

        return [
            [$ticketRunningShow],
            [$ticketOneYearAgoShow],
            [$reservedTicketTomorrowShow],
            [$reservedTicketOneYearLaterShow]
        ];
    }
}