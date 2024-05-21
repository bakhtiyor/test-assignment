<?php
require 'vendor/autoload.php';
use App\AssetRepository;
use App\DB;

//@todo move to .env file
$serverName = 'localhost';
$username = 'root';
$password = 'linux1';
$databaseName = 'test-task';

$db = new DB($serverName, $username, $password, $databaseName);
//$db = new \App\MySQLiDB($serverName, $username, $password, $databaseName);
$assetRepository = new AssetRepository($db); // DI

echo "Testing" . PHP_EOL;
$assetsWithActiveVulnerabilitiesDiscovered3MonthAgo = $assetRepository->getAssetsWithActiveVulnerabilitiesDiscovered3MonthAgo();
foreach ($assetsWithActiveVulnerabilitiesDiscovered3MonthAgo as $asset) {
    echo "Asset: {$asset['asset']}, Vulnerability: {$asset['vulnerability']}, Discovered at: {$asset['discovered_at']}\n";
}

