<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Communication;

use DateTime;
use Paysafe\PayLater\Communication\RequestBuilder;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Model\Account;
use Paysafe\PayLater\Model\Ach;
use Paysafe\PayLater\Model\AchAccountType;
use Paysafe\PayLater\Model\Address;
use Paysafe\PayLater\Model\Amount;
use Paysafe\PayLater\Model\AuthorizePurchaseRequest;
use Paysafe\PayLater\Model\Bacs;
use Paysafe\PayLater\Model\CapturePurchaseRequest;
use Paysafe\PayLater\Model\Company;
use Paysafe\PayLater\Model\Consumer;
use Paysafe\PayLater\Model\Country;
use Paysafe\PayLater\Model\Currency;
use Paysafe\PayLater\Model\DeliveryAddress;
use Paysafe\PayLater\Model\DeliveryInformation;
use Paysafe\PayLater\Model\DeliveryType;
use Paysafe\PayLater\Model\Eft;
use Paysafe\PayLater\Model\InitializePurchaseRequest;
use Paysafe\PayLater\Model\Language;
use Paysafe\PayLater\Model\LogisticsProvider;
use Paysafe\PayLater\Model\MerchantReference;
use Paysafe\PayLater\Model\MethodType;
use Paysafe\PayLater\Model\Occupation;
use Paysafe\PayLater\Model\Person;
use Paysafe\PayLater\Model\RefundPurchaseRequest;
use Paysafe\PayLater\Model\RefundReason;
use Paysafe\PayLater\Model\Sepa;
use PHPUnit\Framework\TestCase;

use function json_encode;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
// phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

class RequestBuilderTest extends TestCase
{
    /**
     * @throws BuilderException
     */
    public function testNullRequestBuilder(): void
    {
        self::assertEquals('{}', RequestBuilder::toJson(null));

        $resultArray = RequestBuilder::toArray(null);
        self::assertIsArray($resultArray);
        self::assertCount(0, $resultArray);
    }

    /**
     * @dataProvider captureRequestProvider
     * @throws BuilderException
     */
    public function testCapturePurchaseRequest(string $expected, CapturePurchaseRequest $request): void
    {
        self::assertEquals($expected, RequestBuilder::toJson($request));
        self::assertEquals($expected, json_encode(RequestBuilder::toArray($request)));
    }

    /**
     * @return array<string, array>
     */
    public function captureRequestProvider(): array
    {
        return [
            'Minimal CapturePurchaseRequest' => [
                '{"fulfillmentAmount":{"amount":5000,"currency":"EUR"}}',
                new CapturePurchaseRequest(new Amount(5000, new Currency(Currency::EUR))),
            ],
            'Full CapturePurchaseRequest' => [
                '{"purchaseId":"purchaseId12345","orderId":"orderId12345","fulfillmentAmount":{"amount":5000,"currency":"EUR"},"closePurchase":true,"deliveryInformation":{"expectedShippingDate":"2000-12-28T12:34:56+00:00","logisticsProvider":"DHL","trackingNumber":"trackingNumber12345"}}',
                new CapturePurchaseRequest(
                    new Amount(
                        5000,
                        new Currency(Currency::EUR)
                    ),
                    'purchaseId12345',
                    'orderId12345',
                    true,
                    new DeliveryInformation(
                        new DateTime('2000-12-28 12:34:56'),
                        new LogisticsProvider(LogisticsProvider::DHL),
                        'trackingNumber12345'
                    )
                ),
            ],
            'Full CapturePurchaseRequest Using Setters' => [
                '{"purchaseId":"purchaseId12345","orderId":"orderId12345","fulfillmentAmount":{"amount":5000,"currency":"EUR"},"closePurchase":true,"deliveryInformation":{"expectedShippingDate":"2000-12-28T12:34:56+00:00","logisticsProvider":"DHL","trackingNumber":"trackingNumber12345"}}',
                (new CapturePurchaseRequest(new Amount(5000, new Currency(Currency::EUR))))
                    ->setPurchaseId('purchaseId12345')
                    ->setOrderId('orderId12345')
                    ->setClosePurchase(true)
                    ->setDeliveryInformation(
                        new DeliveryInformation(
                            new DateTime('2000-12-28 12:34:56'),
                            new LogisticsProvider(LogisticsProvider::DHL),
                            'trackingNumber12345'
                        )
                    ),
            ],
        ];
    }

    /**
     * @dataProvider purchaseAuthorizationRequestProvider
     * @throws BuilderException
     */
    public function testAuthorizePurchaseRequest(string $expected, AuthorizePurchaseRequest $request): void
    {
        self::assertEquals($expected, RequestBuilder::toJson($request));
        self::assertEquals($expected, json_encode(RequestBuilder::toArray($request)));
    }

    /**
     * @return array<string, array>
     */
    public function purchaseAuthorizationRequestProvider(): array
    {
        return [
            'Minimal AuthorizePurchaseRequest' => [
                '{"purchaseId":"PurchaseAuthorization12345","method":"URL"}',
                new AuthorizePurchaseRequest('PurchaseAuthorization12345', new MethodType(MethodType::URL)),
            ],
            'Full AuthorizePurchaseRequest' => [
                '{"purchaseId":"PurchaseAuthorization12345","phone":"003112345678","method":"SMS","successUrl":"https:\/\/example.com\/successUrl","callbackUrl":"https:\/\/example.com\/callbackUrl"}',
                new AuthorizePurchaseRequest(
                    'PurchaseAuthorization12345',
                    new MethodType(MethodType::SMS),
                    '003112345678',
                    'https://example.com/successUrl',
                    'https://example.com/callbackUrl'
                ),
            ],
            'Full AuthorizePurchaseRequest With Setters' => [
                '{"purchaseId":"PurchaseAuthorization12345","phone":"003112345678","method":"SMS","successUrl":"https:\/\/example.com\/successUrl","callbackUrl":"https:\/\/example.com\/callbackUrl"}',
                (new AuthorizePurchaseRequest('PurchaseAuthorization12345', new MethodType(MethodType::SMS)))
                    ->setPhone('003112345678')
                    ->setSuccessUrl('https://example.com/successUrl')
                    ->setCallbackUrl('https://example.com/callbackUrl'),
            ],
        ];
    }

    /**
     * @dataProvider purchaseInitializationRequestProvider
     * @throws BuilderException
     */
    public function testInitializePurchaseRequest(string $expected, InitializePurchaseRequest $request): void
    {
        self::assertSame($expected, RequestBuilder::toJson($request));
        self::assertEquals($expected, json_encode(RequestBuilder::toArray($request)));
    }

    /**
     * @return array<string, array>
     */
    public function purchaseInitializationRequestProvider(): array
    {
        return [
            'Minimal InitializePurchaseRequest' => [
                '{"purchaseAmount":{"amount":50000,"currency":"EUR"}}',
                new InitializePurchaseRequest(new Amount(50000, new Currency(Currency::EUR))),
            ],
            'Full InitializePurchaseRequest' => [
                '{"purchaseAmount":{"amount":50000,"currency":"EUR"},"consumer":{"person":{"salutation":"Dhr","firstName":"Test Person FirstName","lastName":"Test Person LastName","birthdate":"2000-12-28T12:34:56+00:00","socialId":"SOCIAL12345","occupation":{"name":"Test Occupation","yearlyGrossSalary":"123456","employersName":"Test EmployersName","employersAddress":{"street":"Test Employers Streetname","houseNumber":"123A","additionalInfo":"Additional Employers address information","zipCode":"1234AB","city":"Test Employers City","countryCode":"NL","state":"Test Employers State"}}},"company":{"firstName":"Test FirstName","lastName":"Test LastName","companyName":"Test CompanyName"},"bankAccount":{"holder":"Test Person Holder","country":"NL","sepa":{"iban":"GB33BUKB20201555555555","bic":"BUKBGB22"},"eft":{"accountNumber":"TEST12345678","transitNumber":"transit12345","institutionId":"Inst123"},"ach":{"accountNumber":"ach_account_number","accountType":"CHECKING","routingNumber":"1234567890"},"bacs":{"accountNumber":"987654321","sortCode":"ABC"}},"billingAddress":{"street":"Test Billing Streetname","houseNumber":"123A","additionalInfo":"Additional Billing address information","zipCode":"1234AB","city":"Test Billing City","countryCode":"NL","state":"Test Billing State"},"deliveryAddress":{"firstName":"Test Delivery Address FirstName","lastName":"Test Delivery Address LastName","companyName":"Test Delivery Address CompanyName","address":{"street":"Test Delivery Streetname","houseNumber":"123A","additionalInfo":"Additional Delivery address information","zipCode":"1234AB","city":"Test Delivery City","countryCode":"NL","state":"Test Delivery State"}},"deliveryType":"SHOP_PICKUP","language":"EN","phone":"003112345678","email":"test@example.com"},"merchantReference":{"orderId":"order_12345","customerId":"customer_id_123","invoiceId":"invoice_12345"},"additionalInformation":"test additional information"}',
                new InitializePurchaseRequest(
                    new Amount(
                        50000,
                        new Currency(Currency::EUR)
                    ),
                    $this->getConsumer(),
                    new MerchantReference(
                        'order_12345',
                        'customer_id_123',
                        'invoice_12345'
                    ),
                    'test additional information'
                ),
            ],
            'Full InitializePurchaseRequest Using Setters' => [
                '{"purchaseAmount":{"amount":50000,"currency":"EUR"},"consumer":{"person":{"salutation":"Dhr","firstName":"Test Person FirstName","lastName":"Test Person LastName","birthdate":"2000-12-28T12:34:56+00:00","socialId":"SOCIAL12345","occupation":{"name":"Test Occupation","yearlyGrossSalary":"123456","employersName":"Test EmployersName","employersAddress":{"street":"Test Employers Streetname","houseNumber":"123A","additionalInfo":"Additional Employers address information","zipCode":"1234AB","city":"Test Employers City","countryCode":"NL","state":"Test Employers State"}}},"company":{"firstName":"Test FirstName","lastName":"Test LastName","companyName":"Test CompanyName"},"bankAccount":{"holder":"Test Person Holder","country":"NL","sepa":{"iban":"GB33BUKB20201555555555","bic":"BUKBGB22"},"eft":{"accountNumber":"TEST12345678","transitNumber":"transit12345","institutionId":"Inst123"},"ach":{"accountNumber":"ach_account_number","accountType":"CHECKING","routingNumber":"1234567890"},"bacs":{"accountNumber":"987654321","sortCode":"ABC"}},"billingAddress":{"street":"Test Billing Streetname","houseNumber":"123A","additionalInfo":"Additional Billing address information","zipCode":"1234AB","city":"Test Billing City","countryCode":"NL","state":"Test Billing State"},"deliveryAddress":{"firstName":"Test Delivery Address FirstName","lastName":"Test Delivery Address LastName","companyName":"Test Delivery Address CompanyName","address":{"street":"Test Delivery Streetname","houseNumber":"123A","additionalInfo":"Additional Delivery address information","zipCode":"1234AB","city":"Test Delivery City","countryCode":"NL","state":"Test Delivery State"}},"deliveryType":"SHOP_PICKUP","language":"EN","phone":"003112345678","email":"test@example.com"},"merchantReference":{"orderId":"order_12345","customerId":"customer_id_123","invoiceId":"invoice_12345"},"additionalInformation":"test additional information"}',
                (new InitializePurchaseRequest(new Amount(50000, new Currency(Currency::EUR))))
                    ->setConsumer($this->getConsumer())
                    ->setAdditionalInformation('test additional information')
                    ->setMerchantReference((new MerchantReference())
                        ->setCustomerId('customer_id_123')
                        ->setInvoiceId('invoice_12345')
                        ->setOrderId('order_12345')),
            ],
            'Empty request object' => [
                '{"purchaseAmount":{"amount":50000,"currency":"EUR"},"consumer":{"person":{"salutation":"Dhr","firstName":"Test Person FirstName","lastName":"Test Person LastName","birthdate":"2000-12-28T12:34:56+00:00","socialId":"SOCIAL12345","occupation":{"name":"Test Occupation","yearlyGrossSalary":"123456","employersName":"Test EmployersName","employersAddress":{"street":"Test Employers Streetname","houseNumber":"123A","additionalInfo":"Additional Employers address information","zipCode":"1234AB","city":"Test Employers City","countryCode":"NL","state":"Test Employers State"}}},"company":{"firstName":"Test FirstName","lastName":"Test LastName","companyName":"Test CompanyName"},"bankAccount":{"holder":"Test Person Holder","country":"NL","sepa":{"iban":"GB33BUKB20201555555555","bic":"BUKBGB22"},"eft":{"accountNumber":"TEST12345678","transitNumber":"transit12345","institutionId":"Inst123"},"ach":{"accountNumber":"ach_account_number","accountType":"CHECKING","routingNumber":"1234567890"},"bacs":{"accountNumber":"987654321","sortCode":"ABC"}},"billingAddress":{"street":"Test Billing Streetname","houseNumber":"123A","additionalInfo":"Additional Billing address information","zipCode":"1234AB","city":"Test Billing City","countryCode":"NL","state":"Test Billing State"},"deliveryAddress":{"firstName":"Test Delivery Address FirstName","lastName":"Test Delivery Address LastName","companyName":"Test Delivery Address CompanyName","address":{"street":"Test Delivery Streetname","houseNumber":"123A","additionalInfo":"Additional Delivery address information","zipCode":"1234AB","city":"Test Delivery City","countryCode":"NL","state":"Test Delivery State"}},"deliveryType":"SHOP_PICKUP","language":"EN","phone":"003112345678","email":"test@example.com"},"merchantReference":{},"additionalInformation":"test additional information"}',
                new InitializePurchaseRequest(
                    new Amount(
                        50000,
                        new Currency(Currency::EUR)
                    ),
                    $this->getConsumer(),
                    new MerchantReference(),
                    'test additional information'
                ),
            ],
        ];
    }

    /**
     * @dataProvider refundRequestProvider
     * @throws BuilderException
     */
    public function testRefundPurchaseRequest(string $expected, RefundPurchaseRequest $request): void
    {
        self::assertSame($expected, RequestBuilder::toJson($request));
        self::assertEquals($expected, json_encode(RequestBuilder::toArray($request)));
    }

    /**
     * @return array<string, array>
     */
    public function refundRequestProvider(): array
    {
        return [
            'Minimal RefundPurchaseRequest' => [
                '{"purchaseId":"refund12345","refundAmount":{"amount":50000,"currency":"EUR"}}',
                new RefundPurchaseRequest('refund12345', new Amount(50000, new Currency(Currency::EUR))),
            ],
            'Full RefundPurchaseRequest' => [
                '{"purchaseId":"refund12345","refundAmount":{"amount":50000,"currency":"EUR"},"reason":"CUSTOMER_REFUND"}',
                new RefundPurchaseRequest(
                    'refund12345',
                    new Amount(50000, new Currency(Currency::EUR)),
                    new RefundReason(RefundReason::CUSTOMER_REFUND)
                ),
            ],
            'Full RefundPurchaseRequest With Setters' => [
                '{"purchaseId":"refund12345","refundAmount":{"amount":50000,"currency":"EUR"},"reason":"CUSTOMER_REFUND"}',
                (new RefundPurchaseRequest('refund12345', new Amount(50000, new Currency(Currency::EUR))))
                    ->setReason(new RefundReason(RefundReason::CUSTOMER_REFUND)),
            ],
        ];
    }

    /**
     * @return Consumer
     */
    private function getConsumer(): Consumer
    {
        $consumer = new Consumer();
        $consumer
            ->setDeliveryType(new DeliveryType(DeliveryType::SHOP_PICKUP))
            ->setEmail('test@example.com')
            ->setLanguage(new Language(Language::EN))
            ->setPhone('003112345678');

        $consumer->setBankAccount(
            (new Account())
                ->setAch((new Ach())
                     ->setAccountNumber('ach_account_number')
                     ->setAccountType(new AchAccountType(AchAccountType::CHECKING))
                     ->setRoutingNumber('1234567890'))
                ->setBacs((new Bacs())
                      ->setAccountNumber('987654321')
                      ->setSortCode('ABC'))
                ->setCountry(new Country('NL'))
                ->setEft((new Eft())
                     ->setAccountNumber('TEST12345678')
                     ->setInstitutionId('Inst123')
                     ->setTransitNumber('transit12345'))
                ->setHolder('Test Person Holder')
                ->setSepa((new Sepa())
                      ->setBic('BUKBGB22')
                      ->setIban('GB33BUKB20201555555555'))
        );

        $consumer->setBillingAddress(
            (new Address())
                ->setAdditionalInfo('Additional Billing address information')
                ->setCity('Test Billing City')
                ->setCountryCode(new Country('NL'))
                ->setHouseNumber('123A')
                ->setState('Test Billing State')
                ->setStreet('Test Billing Streetname')
                ->setZipCode('1234AB')
        );

        $consumer->setCompany(
            (new Company())
                ->setCompanyName('Test CompanyName')
                ->setFirstName('Test FirstName')
                ->setLastName('Test LastName')
        );

        $consumer->setDeliveryAddress(
            (new DeliveryAddress())
                ->setAddress((new Address())
                     ->setAdditionalInfo('Additional Delivery address information')
                     ->setCity('Test Delivery City')
                     ->setCountryCode(new Country('NL'))
                     ->setHouseNumber('123A')
                     ->setState('Test Delivery State')
                     ->setStreet('Test Delivery Streetname')
                     ->setZipCode('1234AB'))
                ->setCompanyName('Test Delivery Address CompanyName')
                ->setFirstName('Test Delivery Address FirstName')
                ->setLastName('Test Delivery Address LastName')
        );

        $consumer->setPerson(
            (new Person())
                ->setBirthdate(new DateTime('2000-12-28 12:34:56'))
                ->setFirstName('Test Person FirstName')
                ->setLastName('Test Person LastName')
                ->setOccupation((new Occupation())
                    ->setEmployersAddress((new Address())
                          ->setAdditionalInfo('Additional Employers address information')
                          ->setCity('Test Employers City')
                          ->setCountryCode(new Country('NL'))
                          ->setHouseNumber('123A')
                          ->setState('Test Employers State')
                          ->setStreet('Test Employers Streetname')
                          ->setZipCode('1234AB'))
                    ->setEmployersName('Test EmployersName')
                    ->setName('Test Occupation')
                    ->setYearlyGrossSalary('123456'))
                ->setSalutation('Dhr')
                ->setSocialId('SOCIAL12345')
        );

        return $consumer;
    }
}
