<?php

namespace ModuleTest\FirstModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Example implements ObserverInterface
{

    public function execute(Observer $observer)
    {
//        echo 'event triggered';
    }
}
