<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain\Criteria;

use MyLibrary\Shared\Domain\Criteria\Order;
use MyLibrary\Shared\Domain\Criteria\OrderBy;
use MyLibrary\Shared\Domain\Criteria\OrderType;

final class OrderMother
{
    public static function create(?OrderBy $orderBy = null, ?OrderType $orderType = null): Order
    {
        return new Order($orderBy ?? OrderByMother::create(), $orderType ?? OrderType::random());
    }

    public static function none(): Order
    {
        return Order::none();
    }
}
