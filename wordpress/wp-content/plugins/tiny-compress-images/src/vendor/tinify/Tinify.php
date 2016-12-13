<?php

namespace Tinify;

const VERSION = "1.3.0";

class Tinify {
    const AUTHENTICATED = true;
    const ANONYMOUS = false;

    private static $key = NULL;
    private static $appIdentifier = NULL;
    private static $compressionCount = NULL;

    private static $client = NULL;

    public static function setKey($key) {
        self::$key = $key;
        self::$client = NULL;
    }

    public static function getKey() {
        return self::$key;
    }

    public static function createKey($email, $options) {
        $body = array_merge(array("email" => $email), $options);
        $response = self::getClient(self::ANONYMOUS)->request("post", "/keys", $body);
        self::setKey($response->body->key);
    }

    public static function setAppIdentifier($appIdentifier) {
        self::$appIdentifier = $appIdentifier;
        self::$client = NULL;
    }

    public static function getCompressionCount() {
        return self::$compressionCount;
    }

    public static function setCompressionCount($compressionCount) {
        self::$compressionCount = $compressionCount;
    }

    public static function getClient($mode = self::AUTHENTICATED) {
        if ($mode == self::AUTHENTICATED && !self::$key) {
            throw new AccountException("Provide an API key with Tinify\setKey(...)");
        }

        if (!self::$client) {
            self::$client = new Client(self::$key, self::$appIdentifier);
        }

        return self::$client;
    }

    public static function setClient($client) {
        self::$client = $client;
    }
}

function setKey($key) {
    return Tinify::setKey($key);
}

function getKey() {
    return Tinify::getKey();
}

function createKey($email, $options) {
    return Tinify::createKey($email, $options);
}

function setAppIdentifier($appIdentifier) {
    return Tinify::setAppIdentifier($appIdentifier);
}

function getCompressionCount() {
    return Tinify::getCompressionCount();
}

function compressionCount() {
    return Tinify::getCompressionCount();
}

function fromFile($path) {
    return Source::fromFile($path);
}

function fromBuffer($string) {
    return Source::fromBuffer($string);
}

function fromUrl($string) {
    return Source::fromUrl($string);
}

function validate() {
    try {
        Tinify::getClient()->request("post", "/shrink");
    } catch (AccountException $err) {
        if ($err->status == 429) return true;
        throw $err;
    } catch (ClientException $err) {
        return true;
    }
}
