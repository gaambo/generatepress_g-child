<?php

namespace UnderscoreG\Blocks;

require_once __DIR__ . '/abstract-acf-block.php';

function getCustomBlocks()
{
    return [
        // CustomBlock::getFullName() => CustomBlock::class,
    ];
}

function initBlocks()
{
    foreach (getCustomBlocks() as $blockName => $blockClass) {
        $blockClass::init();
    }
}
add_action('init', __NAMESPACE__ . '\initBlocks', 0);

function getRenderedTemplate($templateName, $context, $echo = false)
{
    ob_start();
    foreach ((array) $templateName as $template) {
        if (get_template_part('template-parts/blocks/' . $template, null, $context)) {
            break;
        }
    }

    if ($echo) {
        return ob_get_flush();
    }
    return ob_get_clean();
}
