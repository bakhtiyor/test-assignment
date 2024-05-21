<?php

namespace App\DBInterface;

interface DBInterface
{
    public function __construct(string $servername, string $username, string $password, string $database);
    public function execute(string $sql, ?array $params): array;
    public function close(): void;
}