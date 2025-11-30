<?php

namespace App\Libraries\Wablas\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class FailedToSendNotification extends Exception
{
    public static function tokenIsEmpty(): self
    {
        return new static("Wablas API token is empty");
    }

    public static function urlIsEmpty(): self
    {
        return new static("Wablas API Endpoint url is empty");
    }

    public static function destinationIsEmpty(): self
    {
        return new static("Wablas API WhatsApp Number is empty");
    }

    public static function couldNotCommunicateWithWablas(): self
    {
        return new static("Could not communicate with wablas API Server");
    }

    public static function wablasRespondedWithAnError(ClientException $exception): self
    {
        if (! $exception->hasResponse()) {
            return new static("Wablas responded with an error, but not response body found");
        }

        $statusCode = $exception->getResponse()->getStatusCode();

        $result = json_decode($exception->getResponse()->getBody(), false);
        $description = $result->description ?? 'no description given';

        return new static("Wablas responded with an error `{$statusCode} - {$description}`", 0, $exception);
    }
}
