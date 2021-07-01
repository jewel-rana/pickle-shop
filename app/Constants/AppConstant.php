<?php


namespace App\Constants;


class AppConstant
{
    const PRODUCT_AVAILABLE = 'available';
    const PRODUCT_UNAVAILABLE = 'unavailable';
    const DELIVERY_PENDING = 'pending';
    const DELIVERY_PROCESSING = 'processing';
    const DELIVERY_COLLECTED = 'collected';
    const ORDER_PENDING = 'pending';
    const ORDER_PROCESSING = 'processing';
    const DELIVERY_COMPLETE = 'delivered';
    const ORDER_COMPLETE = 'complete';
    const DELIVERY_FAILED = 'failed';
    const MIN_STOCK_AMOUNT = 5;
    const NOT_PRE_ORDER = 0;
    const PRE_ORDER = 1;
}
