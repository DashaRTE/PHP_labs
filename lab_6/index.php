<?php
require_once 'account.php';

try {
    $account1 = new BankAccount(150);
    $savingsAccount = new SavingsAccount(600);

    echo "Поповнення рахунку на 300 USD";
    echo " ";
    $account1->deposit(300);
    echo "Баланс: " . $account1->getBalance() . " " . $account1->getCurrency() . "\n";

    echo "Спроба зняття 500 USD\n";
    $account1->withdraw(500);
    echo "Баланс: " . $account1->getBalance() . " " . $account1->getCurrency() . "\n";

} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}

try {
    echo "Застосування відсотків до накопичувального рахунку\n";
    $savingsAccount->applyInterest();
    echo "Баланс після застосування відсотків: " . $savingsAccount->getBalance() . " " . $savingsAccount->getCurrency() . "\n";

    echo "Спроба зняття -100 USD\n";
    $savingsAccount->withdraw(-100);
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}
?>
