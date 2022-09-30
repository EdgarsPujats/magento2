<?php

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    type: ComponentRegistrar::MODULE,
    componentName: 'ModuleTest_FirstModule',
    path: __DIR__
);
