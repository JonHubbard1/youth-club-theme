<?php
/**
 * Search form template
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field-<?php echo uniqid(); ?>" class="screen-reader-text">
        <?php echo esc_html_x('Search for:', 'label', 'youth-club-theme'); ?>
    </label>
    <div class="search-form-wrapper" style="display: flex; gap: 0.5rem;">
        <input 
            type="search" 
            id="search-field-<?php echo uniqid(); ?>" 
            class="search-field eyc-form-control" 
            placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'youth-club-theme'); ?>" 
            value="<?php echo get_search_query(); ?>" 
            name="s" 
            style="flex: 1;"
        />
        <button type="submit" class="search-submit btn btn-primary">
            <span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'youth-club-theme'); ?></span>
            <span aria-hidden="true">🔍</span>
        </button>
    </div>
</form>