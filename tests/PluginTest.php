<?php

namespace afSearch\Tests;

use afSearch\afSearch as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'afSearch' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['afSearch'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
