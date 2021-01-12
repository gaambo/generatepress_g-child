<?php

namespace UnderscoreG\Blocks;

class BubbleGridBlock extends AbstractACFBlock
{

    protected static $name = 'custom-block';
    protected static $innerBlocksConfiguration = [
        'template' => [['core/paragraph']],
        'templateLock' => 'all'
    ];

    public static function init()
    {
        self::register([
            'title' => __('Custom Block', 'underscoreg'),
            'keywords' => [],
            'description' => __('An example custom block', 'underscoreg'),
            'category' => 'layout',
            'icon' => 'image-filter',
            'mode' => 'preview',
            'supports' => [
                'align' => false,
                'jsx' => true,
            ]
        ]);
    }

}