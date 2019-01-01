 by this  package we are able to connect to all Iranian bank with one unique API.

( This Package is now compatible with 5.\* versions of Laravel** )

Please inform us once you've encountered [bug](https://github.com/Hesammousavi/bankgateway/issues) or [issue](https://github.com/Hesammousavi/bankgateway/issues)  .

Available Banks:
 1. MELLAT
 2. SADAD (MELLI)
 3. SAMAN
 4. PARSIAN
 5. PASARGAD
 6. ZARINPAL
 8. ASAN PARDAKHT
 9. PAY.IR (to use : new \Payir())
----------


**Installation Version 3.4**:

Run below statements on your terminal :

#### Requirements:
- `php >= 7.0`
  
Step 1:

Run the Composer update comand

        $ composer require hesammoousavi/bankgateway:3.*

Step 2:  

    php artisan vendor:publish --provider=Roocketir\BankGateway\GatewayServiceProvider

Step 3: 

    php artisan migrate


Configuration file is placed in config/gateway.php , open it and enter your banks credential:

You can make connection to bank by several way (Facade , Service container):

    try {
       
       $bankgateway = \BanckGateway::make(new \Mellat());

       // $bankgateway->setCallback(url('/path/to/callback/route')); You can also change the callback
       $bankgateway
            // you can change currency in confit/bankgateway.php to `IRR` (RIAL) or `IRT` (Toman) 
            // of cource it's (IRR) RIAL by default
            ->setPrice(new Amount(10000))
            ->ready();

       $refId =  $bankgateway->refId(); // شماره ارجاع بانک
       $transID = $bankgateway->transactionId(); // شماره تراکنش

      // در اینجا
      //  شماره تراکنش  بانک را با توجه به نوع ساختار دیتابیس تان 
      //  در جداول مورد نیاز و بسته به نیاز سیستم تان
      // ذخیره کنید .
      
       return $bankgateway->redirect();
       
    } catch (\Exception $e) {
       
       	echo $e->getMessage();
    }

you can call the gateway by these ways :
 1. BankGateway::make(new Mellat());
 1. BankGateway::mellat()
 2. app('bankgateway')->make(new Mellat());
 3. app('bankgateway')->mellat();

Instead of MELLAT you can enter other banks Name as we introduced above .

In `price` method you can enter the price in `Amount Object`.
you can change IRR (RIAL) and IRT (TOMAN) from `config\bankgateway.php`  in `currency`

    $banckgateway->setPrice(new Amount(10000))

and in your callback :

    try { 
       
       $bankgateway = \BankGateway::verify();
       $trackingCode = $bankgateway->trackingCode();
       $refId = $bankgateway->refId();
       $cardNumber = $bankgateway->cardNumber();
       
        // تراکنش با موفقیت سمت بانک تایید گردید
        // در این مرحله عملیات خرید کاربر را تکمیل میکنیم
    
    } catch (\Roocketir\BankGateway\Exceptions\RetryException $e) {
    
        // تراکنش قبلا سمت بانک تاییده شده است و
        // کاربر احتمالا صفحه را مجددا رفرش کرده است
        // لذا تنها فاکتور خرید قبل را مجدد به کاربر نمایش میدهیم
        
        echo $e->getMessage() . "<br>";
        
    } catch (\Exception $e) {
       
        // نمایش خطای بانک
        echo $e->getMessage();
    }  

If you are intrested to developing this package you can help us by these ways :

 1. Improving documents.
 2. Reporting issue or bugs.
 3. Collaboration in writing codes and other banks modules.

This package is extended from PoolPort  but we've changed some functionality and improved it .
