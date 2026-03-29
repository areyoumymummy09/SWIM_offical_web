<?php
$wrapper_classes  = 'site-header at-top';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= (true === get_theme_mod('display_title_and_tagline', true)) ? ' has-title-and-tagline' : '';
$wrapper_classes .= is_front_page() ? ' front-page' : '';
?>

<header id="header-main" class="<?php echo esc_attr($wrapper_classes); ?>" role="banner" data-sticky-container>
    <?php if (has_nav_menu('primary')) : ?>
        <div class="nav-menu nav-menu-mobile" id="nav-menu-off-canvas" data-position="right" data-transition="overlay" data-off-canvas>
            <div class="nav-menu-mobile-wrapper">
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'main',
                    'menu_class'     => 'vertical menu accordion-menu',
                    'container'      => 'false',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true">%3$s</ul>'
                ]); ?>
                <?php if (is_user_logged_in()) : ?>
                    <?php if (has_nav_menu('logged_in_menu')) : ?>
                        <div class="nav-logged-in-menu">
                            <p class="user-welcome"><?php esc_html_e('Welcome, ', 'swim');
                                                    echo wp_get_current_user()->display_name; ?></p>
                            <?php wp_nav_menu([
                                'theme_location' => 'logged_in_menu',
                                'menu_id'        => 'logged-in-menu',
                                'menu_class'     => 'logged-in-menu',
                                'container'      => 'false',
                            ]); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (has_nav_menu('logged_out_menu')) : ?>
                        <?php wp_nav_menu([
                            'theme_location' => 'logged_out_menu',
                            'menu_id'        => 'logged-out-menu',
                            'menu_class'     => 'logged-out-menu',
                            'container'      => 'false',
                        ]); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="off-canvas-content" data-off-canvas-content>
        <div class="header-bar">
            <div class="header-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<h1>' . get_bloginfo('name') . '</h1>';
                }
                ?>
            </div>
            <div class="header-nav-container">
                <button class="menu-icon" type="button" data-open="nav-menu-off-canvas"></button>
                <?php if (has_nav_menu('primary')) : ?>
                    <div class="nav-menu nav-menu-desktop">
                        <?php wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu_id'        => 'main',
                            'menu_class'     => 'menu dropdown',
                            'container'      => 'false',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>'
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="nav-menu header-extra">
                <?php if (is_user_logged_in()) : ?>
                    <?php if (has_nav_menu('logged_in_menu')) : ?>
                        <div class="nav-logged-in-menu">
                            <p class="user-welcome"><?php esc_html_e('Welcome, ', 'swim');
                                                    echo wp_get_current_user()->display_name; ?></p>
                            <?php wp_nav_menu([
                                'theme_location' => 'logged_in_menu',
                                'menu_id'        => 'logged-in-menu',
                                'menu_class'     => 'logged-in-menu',
                                'container'      => 'false',
                            ]); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (has_nav_menu('logged_out_menu')) : ?>
                        <?php wp_nav_menu([
                            'theme_location' => 'logged_out_menu',
                            'menu_id'        => 'logged-out-menu',
                            'menu_class'     => 'logged-out-menu',
                            'container'      => 'false',
                        ]); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (has_nav_menu('secondary')) : ?>
                    <?php wp_nav_menu([
                        'theme_location' => 'secondary',
                        'menu_id'        => 'secondary-menu',
                        'menu_class'     => 'secondary-menu',
                        'container'      => 'false',
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
</header>