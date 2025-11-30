<?php

namespace App\Libraries\Wablas;

use App\Libraries\Wablas\Exceptions\FailedToSendNotification;
use JsonSerializable;

class WablasMessage implements JsonSerializable
{
    protected $payload = [];
    protected $token;

    public static function create(string $content = '') : self
    {
        return new self($content);
    }

    public function __construct(string $content = '')
    {
        $this->content($content);
    }

    public function content(string $content) : self
    {
        $this->payload['message'] = $content;

        return $this;
    }

    /**
     * @throws FailedToSendNotification
     */
    public function to($phoneNumber) : self
    {
        if (app()->isLocal() && config('app.debug')) {
            $this->payload['phone'] = config('wablas.debug_number');

            return $this;
        }

        if (blank($phoneNumber)) {
            throw FailedToSendNotification::destinationIsEmpty();
        }

        if (is_array($phoneNumber)) {
            $phoneNumber = implode(',', $phoneNumber);
        }

        $this->payload['phone'] = $phoneNumber;

        return $this;
    }

    /**
     * @throws FailedToSendNotification
     */
    public function token($token) : self
    {
        if (blank($token) && empty($this->token)) {
            throw FailedToSendNotification::tokenIsEmpty();
        }

        if (blank($token)) {
            $this->payload['token'] = $this->token;
        } else {
            $this->payload['token'] = $token;
        }

        return $this;
    }

    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }

    public function toArray() : array
    {
        return $this->payload;
    }
}
