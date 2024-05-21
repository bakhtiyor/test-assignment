<?php

namespace App;

use App\DBInterface\DBInterface;
use PDO;
use PDOException;
//@todo I just copy pasted the code from DB.php. Need to write mysqli implementation for the DBInterface
class MySQLiDB implements DBInterface
{

    public function __construct(string $servername, string $username, string $password, string $database)
    {
        try {
            $this->conn = mysqli_connect("mysql:host=$servername;dbname=$database", $username, $password);
            // Set PDO to throw exceptions
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function execute(string $sql, ?array $params): array
    {
        try {
            $stmt = $this->conn->prepare($sql);
            if ($params === null) {
                $stmt->execute();
            } else {
                $stmt->execute($params);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing prepared statement: " . $e->getMessage());
        }
    }

    public function close(): void
    {
        $this->conn = null;
    }
}