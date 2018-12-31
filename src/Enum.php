<?php

namespace Roocketir\BankGateway;

class Enum
{
    const CURRENCY_IRT = 'IRT';
    const CURRENCY_IRR = 'IRR';

	/**
	 * Status code for status field in poolport_transactions table
	 */
	const TRANSACTION_INIT = 'INIT';
	const TRANSACTION_INIT_TEXT = 'تراکنش ایجاد شد.';

	/**
	 * Status code for status field in poolport_transactions table
	 */
	const TRANSACTION_SUCCEED = 'SUCCEED';
	const TRANSACTION_SUCCEED_TEXT = 'پرداخت با موفقیت انجام شد.';

	/**
	 * Status code for status field in poolport_transactions table
	 */
	const TRANSACTION_FAILED = 'FAILED';
	const TRANSACTION_FAILED_TEXT = 'عملیات پرداخت با خطا مواجه شد.';

}
