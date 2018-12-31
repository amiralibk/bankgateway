<?php

namespace Roocketir\BankGateway\Exceptions;
/**
 * This exception when throws, user try to submit a payment request who submitted before
 */
class PriceNotEqualException extends GatewayException
{
	protected $code=-101;
	protected $message = 'مبلغ تراکنش انجام شده با مبلغ ذخیره شده در دیتابیس یکسان نیست.';
}
