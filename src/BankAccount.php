<?php

namespace App;

use mysqli;

/**
 * PHP7
 * Tasks:
 * 1. write the logic for depositing and withdrawing money
 * 2. write a total of 3 test cases for either unit and integration tests
 */

class BankAccount {

    private $accountId;
    private $db;

    public function __construct($accountId) {
        $this->accountId = $accountId;
        $this->db = new mysqli('localhost', 'root', 'linux1', 'test-task');
    }

    public function deposit($amount) {
        $query = $this->db->query('select amount from balance where account_id = ' . $this->accountId);
        $result = $query->fetch_assoc();
        if (!isset($result['amount'])) {
            $stmt = $this->db->prepare('insert into balance (account_id, amount) values (?, ?)');
            $stmt->bind_param('ii', $this->accountId, $amount);
            $stmt->execute();
        } else {
            $this->db->query('update balance set amount = ' .$amount. ' where account_id = ' . $this->accountId);
        }
    }

    public function withdraw($amount) {
        $query = $this->db->query('select amount from balance where account_id = ' . $this->accountId);
        $result = $query->fetch_assoc();
        if (!isset($result['amount'])) {
            throw new \Exception('No account found for account id ' . $this->accountId);
        } elseif ($amount <= $result['amount']) {
            $this->db->query('update balance set amount=amount-'.$amount.' where account_id = '.$this->accountId);
        } else {
            throw new \Exception('No sufficient balance to withdraw');
        }
    }

    public function getBalance() {
        $query = $this->db->query('select amount from balance where account_id = ' . $this->accountId);
        return $query->fetch_column(0);
    }

    public function setBalance($amount) {
        $this->db->query("UPDATE balance SET amount = " . $amount . " where account_id = " . $this->accountId);
    }
}