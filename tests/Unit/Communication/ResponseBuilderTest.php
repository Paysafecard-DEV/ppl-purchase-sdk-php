<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Communication;

use DateTime;
use Paysafe\PayLater\Communication\ResponseBuilder;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Model\Amount;
use Paysafe\PayLater\Model\ConsumerVerification;
use Paysafe\PayLater\Model\Contract;
use Paysafe\PayLater\Model\Currency;
use Paysafe\PayLater\Model\Document;
use Paysafe\PayLater\Model\DocumentType;
use Paysafe\PayLater\Model\MerchantReference;
use Paysafe\PayLater\Model\OperationResult;
use Paysafe\PayLater\Model\OperationStatus;
use Paysafe\PayLater\Model\Payment;
use Paysafe\PayLater\Model\PaymentMethod;
use Paysafe\PayLater\Model\PaymentOption;
use Paysafe\PayLater\Model\ProductType;
use Paysafe\PayLater\Model\PurchaseInformation;
use Paysafe\PayLater\Model\PurchaseOperationResponse;
use Paysafe\PayLater\Model\PurchaseState;
use PHPUnit\Framework\TestCase;

use function filter_var;
use function json_decode;

use const FILTER_SANITIZE_URL;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
// phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

class ResponseBuilderTest extends TestCase
{
    /**
     * @throws BuilderException
     */
    public function testResponseBuilder(): void
    {
        $json = <<<JSON
{
    "result": {
        "operationId": null,
        "status": "OK",
        "statusCode": "0.0.0",
        "statusMessage": "Operation performed sucessfully",
        "processingStart": "2020-07-01T10:51:30.635+02:00",
        "processingEnd": "2020-07-01T10:51:31.072+02:00"
    },
    "purchase": {
        "purchaseId": "CID-66y62kmi9hq99dio88r9",
        "state": "INITIALIZED",
        "currency": "EUR",
        "authorizedAmount": null,
        "capturedAmount": null,
        "remainingCaptureAmount": null,
        "refundedAmount": null,
        "remainingRefundableAmount": null,
        "purchaseAmount": {
            "amount": 50000,
            "currency": "EUR"
        },
        "consumer": null,
        "consumerVerification": {
            "initializeUrl": null,
            "verifyUrl": null,
            "consumerDataAvailable": false,
            "consumerScanVerified": false
        },
        "merchantReference": {
            "orderId": null,
            "customerId": null,
            "invoiceId": null
        },
        "paymentInformation": null,
        "paymentOptions": [
            {
                "optionId": null,
                "consumerCountry": null,
                "currency": "EUR",
                "productType": "INVOICE",
                "supportedPaymentMethods": [
                    "BANK_TRANSFER"
                ],
                "totalAmount": {
                    "amount": 50000,
                    "currency": "EUR"
                },
                "purchaseAmount": {
                    "amount": 50000,
                    "currency": "EUR"
                },
                "interestRate": null,
                "effectiveInterestRate": null,
                "numberOfPayments": 1.0,
                "payments": [
                    {
                        "dueDate": "2020-07-15",
                        "paymentAmount": {
                            "amount": 50000,
                            "currency": "EUR"
                        }
                    }
                ],
                "contracts": [
                    {
                        "name": "test contract",
                        "type": "PDF",
                        "id": "test12345",
                        "url": "https://test-payment.payolution.com/"
                    }
                ]
            },
            {
                "optionId": null,
                "consumerCountry": null,
                "currency": "EUR",
                "productType": "INSTALLMENT",
                "supportedPaymentMethods": [
                    "BANK_TRANSFER",
                    "DIRECT_DEBIT"
                ],
                "totalAmount": {
                    "amount": 50000,
                    "currency": "EUR"
                },
                "purchaseAmount": {
                    "amount": 50000,
                    "currency": "EUR"
                },
                "interestRate": 0.0,
                "effectiveInterestRate": 0.0,
                "numberOfPayments": 2.0,
                "payments": [
                    {
                        "dueDate": "2020-08-05",
                        "paymentAmount": {
                            "amount": 16667,
                            "currency": "EUR"
                        }
                    },
                    {
                        "dueDate": "2020-09-05",
                        "paymentAmount": {
                            "amount": 16667,
                            "currency": "EUR"
                        }
                    }
                ],
                "contracts": [
                    {
                        "name": "test contract",
                        "type": "PDF",
                        "id": "test12345",
                        "url": "https://test-payment.payolution.com/"
                    }
                ]
            }
        ],
        "captures": [],
        "refunds": [],
        "documents": [
            {
                "name": "dataPrivacyDeclaration",
                "url": "https://test-payment.payolution.com/payolution-payment/infoport/dataprivacydeclaration?lang=de&mId=RGVtbyBjb21wYW55"
            },
            {
                "name": "termsAndConditions",
                "url": "https://test-payment.payolution.com/payolution-payment/infoport/termsandconditions?lang=de&channelId=instore-test-installment"
            }
        ],
        "metaData": {
            "flowType": "DACH",
            "jumioIdCheckRequired": "false"
        }
    }
}
JSON;
        $data = json_decode($json, true);
        /** @var PurchaseOperationResponse $response */
        $response = ResponseBuilder::build(PurchaseOperationResponse::class, $data);

        /** @var OperationResult $operationResult */
        $operationResult = $response->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);
        self::assertNull($operationResult->getOperationId());

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        self::assertSame('0.0.0', $operationResult->getStatusCode());
        self::assertSame('Operation performed sucessfully', $operationResult->getStatusMessage());
        self::assertInstanceOf(DateTime::class, $operationResult->getProcessingStart());
        self::assertInstanceOf(DateTime::class, $operationResult->getProcessingEnd());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);
        self::assertSame('CID-66y62kmi9hq99dio88r9', $purchaseInformation->getPurchaseId());

        /** @var PurchaseState $purchaseState */
        $purchaseState = $purchaseInformation->getState();
        self::assertInstanceOf(PurchaseState::class, $purchaseState);
        self::assertSame(PurchaseState::INITIALIZED, $purchaseState->getValue());

        /** @var Currency $currency */
        $currency = $purchaseInformation->getCurrency();
        self::assertInstanceOf(Currency::class, $currency);
        self::assertSame(Currency::EUR, $currency->getValue());

        self::assertNull($purchaseInformation->getAuthorizedAmount());
        self::assertNull($purchaseInformation->getCapturedAmount());
        self::assertNull($purchaseInformation->getRemainingCaptureAmount());
        self::assertNull($purchaseInformation->getRefundedAmount());
        self::assertNull($purchaseInformation->getRemainingRefundableAmount());

        /** @var Amount $purchaseAmount */
        $purchaseAmount = $purchaseInformation->getPurchaseAmount();
        self::assertInstanceOf(Amount::class, $purchaseAmount);
        self::assertSame(50000, $purchaseAmount->getAmount());
        self::assertSame(Currency::EUR, $purchaseAmount->getCurrency()->getValue());
        self::assertNull($purchaseInformation->getConsumer());

        /** @var ConsumerVerification $consumerVerification */
        $consumerVerification = $purchaseInformation->getConsumerVerification();
        self::assertInstanceOf(ConsumerVerification::class, $consumerVerification);
        self::assertNull($consumerVerification->getInitializeUrl());
        self::assertNull($consumerVerification->getVerifyUrl());
        self::assertFalse($consumerVerification->getConsumerDataAvailable());

        /** @var MerchantReference $merchantReference */
        $merchantReference = $purchaseInformation->getMerchantReference();
        self::assertInstanceOf(MerchantReference::class, $merchantReference);
        self::assertNull($merchantReference->getOrderId());
        self::assertNull($merchantReference->getCustomerId());
        self::assertNull($merchantReference->getInvoiceId());

        self::assertNull($purchaseInformation->getPaymentInformation());

        /** @var array<PaymentOption> $paymentOptions */
        $paymentOptions = $purchaseInformation->getPaymentOptions();
        self::assertIsArray($paymentOptions);
        self::assertCount(2, $paymentOptions);

        /** @var PaymentOption $paymentOption */
        foreach ($paymentOptions as $paymentOption) {
            self::assertInstanceOf(PaymentOption::class, $paymentOption);
            self::assertNull($paymentOption->getOptionId());
            self::assertNull($paymentOption->getConsumerCountry());

            /** @var Currency $paymentOptionCurrency */
            $paymentOptionCurrency = $paymentOption->getCurrency();
            self::assertInstanceOf(Currency::class, $paymentOptionCurrency);
            self::assertSame(Currency::EUR, $paymentOptionCurrency->getValue());

            /** @var Amount $paymentOptionTotalAmount */
            $paymentOptionTotalAmount = $paymentOption->getTotalAmount();
            self::assertInstanceOf(Amount::class, $paymentOptionTotalAmount);
            self::assertSame(Currency::EUR, $paymentOptionTotalAmount->getCurrency()->getValue());

            /** @var Amount $paymentOptionPurchaseAmount */
            $paymentOptionPurchaseAmount = $paymentOption->getPurchaseAmount();
            self::assertInstanceOf(Amount::class, $paymentOptionPurchaseAmount);
            self::assertSame(Currency::EUR, $paymentOptionPurchaseAmount->getCurrency()->getValue());

            /** @var Contract[] $contracts */
            $contracts = $paymentOption->getContracts();
            self::assertIsArray($contracts);
            self::assertCount(1, $contracts);
            foreach ($contracts as $contract) {
                self::assertInstanceOf(Contract::class, $contract);
                self::assertSame('test contract', $contract->getName());
                self::assertSame('test12345', $contract->getId());
                self::assertSame('https://test-payment.payolution.com/', $contract->getUrl());

                /** @var DocumentType $documentType */
                $documentType = $contract->getType();
                self::assertInstanceOf(DocumentType::class, $documentType);
                self::assertSame(DocumentType::PDF, $documentType->getValue());
            }
        }

        // Check 1st payment option
        $paymentOption1 = $paymentOptions[0];

        /** @var ProductType $productType */
        $productType = $paymentOption1->getProductType();
        self::assertInstanceOf(ProductType::class, $productType);
        self::assertSame(ProductType::INVOICE, $productType->getValue());

        /** @var array<PaymentMethod> $supportedPaymentMethods */
        $supportedPaymentMethods = $paymentOption1->getSupportedPaymentMethods();
        self::assertIsArray($supportedPaymentMethods);
        self::assertCount(1, $supportedPaymentMethods);
        self::assertInstanceOf(PaymentMethod::class, $supportedPaymentMethods[0]);
        self::assertSame(PaymentMethod::BANK_TRANSFER, $supportedPaymentMethods[0]->getValue());
        self::assertNull($paymentOption1->getInterestRate());
        self::assertNull($paymentOption1->getEffectiveInterestRate());
        self::assertSame(1.0, $paymentOption1->getNumberOfPayments());

        /** @var array<Payment> $payments */
        $payments = $paymentOption1->getPayments();
        self::assertIsArray($payments);
        self::assertCount(1, $payments);
        self::assertInstanceOf(Payment::class, $payments[0]);
        self::assertInstanceOf(DateTime::class, $payments[0]->getDueDate());

        /** @var Amount $paymentAmount */
        $paymentAmount = $payments[0]->getPaymentAmount();
        self::assertInstanceOf(Amount::class, $paymentAmount);
        self::assertSame(50000, $paymentAmount->getAmount());
        self::assertSame(Currency::EUR, $paymentAmount->getCurrency()->getValue());

        // Check 2nd payment option
        $paymentOption2 = $paymentOptions[1];

        /** @var ProductType $productType */
        $productType = $paymentOption2->getProductType();
        self::assertInstanceOf(ProductType::class, $productType);
        self::assertSame(ProductType::INSTALLMENT, $productType->getValue());

        /** @var array<PaymentMethod> $supportedPaymentMethods */
        $supportedPaymentMethods = $paymentOption2->getSupportedPaymentMethods();
        self::assertIsArray($supportedPaymentMethods);
        self::assertCount(2, $supportedPaymentMethods);
        self::assertInstanceOf(PaymentMethod::class, $supportedPaymentMethods[0]);
        self::assertSame(PaymentMethod::BANK_TRANSFER, $supportedPaymentMethods[0]->getValue());
        self::assertInstanceOf(PaymentMethod::class, $supportedPaymentMethods[1]);
        self::assertSame(PaymentMethod::DIRECT_DEBIT, $supportedPaymentMethods[1]->getValue());
        self::assertSame(0.0, $paymentOption2->getInterestRate());
        self::assertSame(0.0, $paymentOption2->getEffectiveInterestRate());
        self::assertSame(2.0, $paymentOption2->getNumberOfPayments());

        /** @var array<Payment> $payments */
        $payments = $paymentOption2->getPayments();
        self::assertIsArray($payments);
        self::assertCount(2, $payments);
        foreach ($payments as $payment) {
            self::assertInstanceOf(Payment::class, $payment);
            self::assertInstanceOf(DateTime::class, $payment->getDueDate());

            /** @var Amount $paymentAmount */
            $paymentAmount = $payment->getPaymentAmount();
            self::assertInstanceOf(Amount::class, $paymentAmount);
            self::assertSame(16667, $paymentAmount->getAmount());
            self::assertSame(Currency::EUR, $paymentAmount->getCurrency()->getValue());
        }

        self::assertNull($purchaseInformation->getCaptures());
        self::assertNull($purchaseInformation->getRefunds());

        /** @var array<Document> $documents */
        $documents = $purchaseInformation->getDocuments();
        self::assertIsArray($documents);
        self::assertCount(2, $documents);
        foreach ($documents as $document) {
            self::assertInstanceOf(Document::class, $document);
            self::assertNotEmpty($document->getName());
            self::assertNotEmpty($document->getUrl());

            $url = filter_var($document->getUrl(), FILTER_SANITIZE_URL);
            self::assertSame($url, $document->getUrl());
        }

        /** @var array<string> $metaData */
        $metaData = $purchaseInformation->getMetaData();
        self::assertIsArray($metaData);
        self::assertCount(2, $metaData);
    }

    /**
     * @throws BuilderException
     */
    public function testEmptyObjectResponseBuilder(): void
    {
        $data = json_decode(
            '{"purchase": {"purchaseId": "CID-66y62kmi9hq99dio88r9","merchantReference": {}}}',
            true
        );
        /** @var PurchaseOperationResponse $response */
        $response = ResponseBuilder::build(PurchaseOperationResponse::class, $data);

        self::assertNull($response->getResult());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);
        self::assertSame('CID-66y62kmi9hq99dio88r9', $purchaseInformation->getPurchaseId());
        self::assertNull($purchaseInformation->getMerchantReference());
    }
}
