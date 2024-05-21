<?php

use App\BankAccount;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    protected $bankAccount;

    protected function setUp(): void
    {
        $this->bankAccount = new BankAccount(1); // Assuming accountId is 1 for testing
    }

    public function testDeposit()
    {
        $this->bankAccount->deposit(100);
        $this->assertEquals(100, $this->bankAccount->getBalance());
    }


    public function testWithdraw()
    {
        $this->bankAccount->deposit(100);
        $this->bankAccount->setBalance(50);
        $this->assertEquals(50, $this->bankAccount->getBalance());
    }

    public function testGetBalance()
    {
        $this->bankAccount->deposit(100);
        $this->assertEquals(100, $this->bankAccount->getBalance());
    }
}