<?php
require_once __DIR__.'/App/bootstrap.php';
global $container;
$twig = $container->get("twig.environment");

// page
if(get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif(isset($_GET["paged"]) && $_GET['paged']) {
    $paged = $_GET['paged'];
} else {
    $paged = 2;
}

// search
if(isset($_POST["term"]) && $_POST['term']) {
    $term = $_POST['term'];
}

// post type
$postType = $_POST['post_type'];
if($postType != 'case_studies' && $postType != 'post') {
    echo "invalid post type";
    exit;
}

// args
$args = [
    'post_type'      => $postType,
    'posts_per_page' => get_option('posts_per_page'),
    'paged'          => $paged
];
if(isset($_POST['tag']) && $_POST['tag']) {
    $args['tag'] = $tag;
}
if(isset($term) && $term) {
    $args['s'] = $term;
}

// template
if($postType == 'case_studies') {
    $template = "panels/case-studies-teaser.html.twig";
} else {
    $template = "panels/blog-teaser.html.twig";
}

// output
query_posts($args);
if (have_posts()) {
    while (have_posts()){
        the_post();
        echo $twig->render($template);
        echo PHP_EOL;
    }
}