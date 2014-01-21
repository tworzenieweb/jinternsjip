<header class="banner navbar navbar-default navbar-static-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo home_url(); ?>/"><span class="organge">j</span>Internship.<span class="orange">com</span></a>
        </div>


        <nav class="navbar-collapse" role="navigation"> 

            <?php
            if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav navbar-right'));
            endif;
            ?>

        </nav>
    </div>
    <div class="menu navbar-default">
        <div class="container">
            
            <div class="navbar visible-xs">
                
                <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            
                <a href="http://ji.dev/apply-now/" class="apply-now visible-xs">Apply Now</a>
                
            </div>
            
            <nav class="collapse navbar-collapse" role="navigation"> 

                <?php
                if (has_nav_menu('secondary_navigation')) :
                    wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'nav navbar-nav'));
                endif;
                ?>

            </nav>
        </div>
    </div>
</header>
