<?php

namespace Roocketir\BankGateway;

use Illuminate\Support\Facades\Facade;

/**
 * @method static PortAbstract make(PortAbstract $port)
 * @method static PortAbstract verify()
 *
 * @see \Roocketir\BankGateway\BankGatewayResolver
 */
class BankGateway extends Facade
{
	/**
	 * The name of the binding in the IoC container.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'bankgateway';
	}
}
