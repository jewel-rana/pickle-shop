<?php


namespace Tests;


class MyTestCase extends TestCase
{
    protected function getHeader(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'json'
        ];
    }
}
