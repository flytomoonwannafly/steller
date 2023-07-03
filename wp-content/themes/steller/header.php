<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Basic -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Site Icons -->

    <?php wp_head(); ?>
</head>
<body>

<!-- Page navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top affix" data-spy="affix" data-offset-top="0">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="assets/imgs/logo.svg" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            $args = array(
                'container'=> false,
                'theme_location'=>'primary',
                'depth'         => 1,
                'items_wrap'=>'<ul class="navbar-nav ml-auto align-items-center %2$s">%3$s</ul>',
                'menu_class'=>'navbar-nav mr-auto',
//                'add_li_class'  => 'nav-item',
//                'add_a_class'  => 'nav-link',
            );
            wp_nav_menu($args);

            ?>
<!--            <ul class="navbar-nav ml-auto align-items-center">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link active" href="#home">Home</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#about">About</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#service">Service</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#portfolio">Portfolio</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#testmonial">Testmonial</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#blog">Blog</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#contact">Contact</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="- btn btn-primary rounded ml-4" href="components.html">Copmonents</a>-->
<!--                </li>-->
<!--            </ul>-->
        </div>
    </div>
</nav>