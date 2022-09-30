<?php

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    type: ComponentRegistrar::MODULE,
    componentName: 'ModuleTest_FirstLayout',
    path: __DIR__
);
