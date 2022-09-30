<?php

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    type: ComponentRegistrar::MODULE,
    componentName: 'ModuleTest_FirstPage',
    path: __DIR__
);
