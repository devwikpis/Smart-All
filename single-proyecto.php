<?php
get_header();

$proyect = get_post();
get_template_part('template-parts/target/target-proyect', null, ['proyect' => $proyect, 'index' => 1, 'tag_title' => 'h1', 'tag_sub_title' => 'h2']);

get_footer();
