<?php
/*
Template Name: Home page
*/

get_header();
?>

<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post(); ?>
        <div id="container-main" class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col l12 m12 s12">
                            <?php
                            if(!is_front_page()) {
                                the_title("<h1>", "</h1>");
                            }
                            breadcrumb();
                            the_content();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

<?php get_footer(); ?>
