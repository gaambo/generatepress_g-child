<?php
$classes = [];
if (isset($args['block']['className'])) {
    $classes[] = $args['block']['className'];
}
?>
<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <InnerBlocks <?php echo $args['innerBlocksConfiguration']; ?> />
</div>