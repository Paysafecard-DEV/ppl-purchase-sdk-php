# Paysafe Pay Later PHP SDK

The Paysafe Pay Later PHP SDK lets you communicate with the [Paysafe Pay Later platform](https://www.paysafe.com/products-overview/paysafe-pay-later-home/developer-center/) and provides the following features:

* Handles authentication in all requests towards the API 
* Wrapper around all API calls and responses to make building a request and interpreting responses as easy as possible
* Takes care of marshalling and unmarshalling request and responses
* Processes errors from the API and transforms them in specific exceptions
* Handles decrypting of incoming webhook messages

## Documentation

The project contains multiple unit and integration tests that shows how to use the SDK.

For more examples and detailed information on how to use the SDK, you can go to the [Paysafe Pay Later Developer Hub](https://www.paysafe.com/products-overview/paysafe-pay-later-home/developer-center/).

## Installation

The Paysafe Pay Later PHP SDK can be installed using composer:

```
composer require paysafe/paylater-sdk
```

The package requires the following dependencies, which will automatically be installed when using composer:

Dependency | Version 
--- | ---
guzzlehttp/guzzle | ^6.5
psr/log | ^1.1

### Requirements
The Paysafe Pay Later PHP SDK requires PHP version 7.2 or higher with the following extensions installed:

- json
- openssl

## Project structure

The project contains two components:

* `/src/` which contains all source code of the SDK
* `/tests/` which contains the unit and integration tests
