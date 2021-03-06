# IBMid demo [![Build Status](https://travis-ci.org/nyrobert/ibmid-demo.svg?branch=master)](https://travis-ci.org/nyrobert/ibmid-demo)

## Requirements

* PHP >= 5.6

## Installation

1. Download PHP dependencies via Composer:

  ```shell
  composer install
  ```
2. Register your application with the IBM Identity Service

3. Set required environment variables:

  * `IBMID_ENDPOINT_BASE_URL`
  * `IBMID_CLIENT_ID`
  * `IBMID_CLIENT_SECRET`

## Testing

Run Codeception from the command line:

 ```shell
  php vendor/bin/codecept run
  ```

## License

This project is licensed under the terms of the [MIT License (MIT)](LICENSE).
