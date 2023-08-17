<?php

class Account {
    
    private $accountID;
    private $accountBalance;
    private static $count = 0; 
    
    public function __construct($accountID, $initialBalance) {
        $this->accountID = $accountID;
        $this->accountBalance = $initialBalance;
        self::$count++;  
    }

    public function showInformation() {
        echo "Account ID: " . $this->accountID . "<br>";
        echo "Account Balance: " . $this->accountBalance . "<br>";
    }

    public function deposit($amount) {
        if($amount > 0) {
            $this->accountBalance += $amount;
            echo "Deposited: " . $amount . "<br>";
        } else {
            echo "Invalid deposit amount.<br>";
        }
    }

    public function withdraw($amount) {
        if($amount > 0 && $this->accountBalance >= $amount) {
            $this->accountBalance -= $amount;
            echo "Withdrawn: " . $amount . "<br>";
        } else {
            echo "Invalid withdrawal amount or insufficient funds.<br>";
        }
    }

    public function showAccountInfo() {
        echo "Account ID: " . $this->accountID . "<br>";
        echo "Account Balance: " . $this->accountBalance . "<br>";
    }

    public function transferMoney($targetAccount, $amount) {
        if($amount > 0 && $this->accountBalance >= $amount) {
            $this->withdraw($amount);          
            $targetAccount->deposit($amount);  
            echo "Transferred " . $amount . " to Account ID: " . $targetAccount->getAccountID() . "\n";
        } else {
            echo "Invalid transfer amount or insufficient funds.<br>";
        }
    }
    
    public function getAccountID() {
        return $this->accountID;
    }

    public static function showTotalAccounts() {
        echo "Total Accounts Created: " . self::$count . "<br>";
    }
}

$acc1 = new Account(101, 52000);
$acc2 = new Account(102, 30200);

$acc1->deposit(2000);
$acc1->withdraw(1000);
$acc1->transferMoney($acc2, 20300);

$acc1->showAccountInfo();
$acc2->showAccountInfo();

Account::showTotalAccounts();

?>
