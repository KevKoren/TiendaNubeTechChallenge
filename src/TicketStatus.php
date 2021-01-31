<?php declare(strict_types=1);


namespace TiendaNubeTechChallenge;


abstract class TicketStatus
{
    public const AVAILABLE = 0;
    public const RESERVED = 1;
    public const SOLD = 2;
    public const EXPIRED = 3;
}