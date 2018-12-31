<?php

namespace Roocketir\BankGateway;

use Mockery\Exception;
use Roocketir\BankGateway\Contracts\Port;
use Roocketir\BankGateway\Parsian\Parsian;
use Roocketir\BankGateway\Paypal\Paypal;
use Roocketir\BankGateway\Sadad\Sadad;
use Roocketir\BankGateway\Mellat\Mellat;
use Roocketir\BankGateway\Pasargad\Pasargad;
use Roocketir\BankGateway\Saman\Saman;
use Roocketir\BankGateway\Asanpardakht\Asanpardakht;
use Roocketir\BankGateway\Zarinpal\Zarinpal;
use Roocketir\BankGateway\Payir\Payir;
use Roocketir\BankGateway\Exceptions\RetryException;
use Roocketir\BankGateway\Exceptions\PortNotFoundException;
use Roocketir\BankGateway\Exceptions\InvalidRequestException;
use Roocketir\BankGateway\Exceptions\NotFoundTransactionException;
use Illuminate\Support\Facades\DB;

class BankGatewayResolver
{
	protected $request;

	/**
	 * @var Config
	 */
	public $config;

	/**
	 * Gateway constructor.
	 * @param null $config
	 * @param null $port
	 */
	public function __construct($config = null, $port = null)
	{
		$this->config = app('config');
		$this->request = app('request');

		if ($this->config->has('bankgateway.timezone'))
			date_default_timezone_set($this->config->get('bankgateway.timezone'));

		if (!is_null($port)) $this->make($port);
	}

    /**
     * Call methods of current driver
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws PortNotFoundException
     */
	public function __call($name, $arguments)
	{
        $port = ucfirst(strtolower($name));
        $class = __NAMESPACE__.'\\'.$port.'\\'.$port;

        if(! class_exists($class)) throw new PortNotFoundException;

        return call_user_func_array([$this, 'make'], [new $class($arguments)]);
    }

	/**
	 * Gets query builder from you transactions table
	 * @return mixed
	 */
	public function getTable()
	{
		return DB::table($this->config->get('bankgateway.table'));
	}

	/**
	 * Callback
	 *
	 * @return PortAbstract
     *
	 * @throws InvalidRequestException
	 * @throws NotFoundTransactionException
	 * @throws PortNotFoundException
	 * @throws RetryException
	 */
	public function verify() : PortAbstract
	{
		if (!$this->request->has('transaction_id') && !$this->request->has('iN'))
			throw new InvalidRequestException;
		if ($this->request->has('transaction_id')) {
			$id = $this->request->get('transaction_id');
		} else {
			$id = $this->request->get('iN');
		}

		$transaction = $this->getTable()->whereId($id)->first();

		if (!$transaction)
			throw new NotFoundTransactionException;

		if (in_array($transaction->status, [Enum::TRANSACTION_SUCCEED, Enum::TRANSACTION_FAILED]))
			throw new RetryException;

        $port = $this->{$transaction->port}();

		return $port->verify($transaction);
	}


    /**
     * Create new object from port class
     *
     * @param PortAbstract $port
     * @return PortAbstract
     */
	public function make(PortAbstract $port) : PortAbstract
	{
		$port->setConfig($this->config);
		$port->boot();

		return $port;
	}
}
