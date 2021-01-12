<?php

namespace UnderscoreG\Setup;

function setupTheme()
{
    // remove copyright generatepress text
    remove_action('generate_footer', 'generate_construct_footer');
}
add_filter('after_setup_theme', __NAMESPACE__ . '\setupTheme');

add_filter('nav_menu_css_class', function ($classes, $item) {
    // removes `current-menu-item` class from item if it's an anchor link to the current page
    $currentItemIndex = array_search('current-menu-item', $classes);
    if (!$currentItemIndex) {
        return $classes;
    }

    if (strpos($item->url, '#')) {
        unset($classes[$currentItemIndex]);
        $classes = array_values($classes); // fix keys
    }

    return $classes;
}, 10, 3);
