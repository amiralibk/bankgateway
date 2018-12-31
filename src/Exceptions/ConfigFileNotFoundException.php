<?php

namespace Roocketir\BankGateway\Exceptions;

class ConfigFileNotFoundException extends GatewayException {
	protected $code=-105;
	protected $message='فایل تنظیمات یافت نشد.';
}
