<?php

define('ROOT', __DIR__ . '/');
define('SRC_PATH', ROOT . 'src/');

// Could have added an autoloader, I decided to spent more time on tests.

require_once(SRC_PATH . 'Show.php');
require_once(SRC_PATH . 'Discount.php');
require_once(SRC_PATH . 'DayOfWeekDiscount.php');
require_once(SRC_PATH . 'OccupationAndTimeDiscount.php');
require_once(SRC_PATH . 'ShoppingCart.php');
require_once(SRC_PATH . 'Ticket.php');
require_once(SRC_PATH . 'TicketCategory.php');
require_once(SRC_PATH . 'TicketStatus.php');