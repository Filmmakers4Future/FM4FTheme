<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
<!DOCTYPE html>
<html lang="<?= html(value(Themes::class, LANGUAGE)) ?>">
  <head>
    <meta charset="<?= html(value(Themes::class, CHARSET)) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?= html(value(Themes::class, KEYWORDS)) ?>">
<?php
  if (null !== value(Themes::class, DESCRIPTION)) {
?>
    <meta name="description" content="<?= html(value(Themes::class, DESCRIPTION)) ?>">
    <meta property="og:description" content="<?= html(value(Themes::class, DESCRIPTION)) ?>">
<?php
  }
  if (null !== value(Themes::class, AUTHOR)) {
?>
    <meta name="author" content="<?= html(value(Themes::class, AUTHOR)) ?>">
<?php
  }
  if (null !== value(Themes::class, "page_image")) {
?>
    <meta property="og:image" content="<?= html(value(Themes::class, "page_image")) ?>">
<?php
  }
?>
    <meta property="og:type" content="<?= html(value(Themes::class, "page_type")) ?>">
    <meta property="og:title" content="<?= html(value(Themes::class, TITLE)) ?>">
<?php
  if (null !== value(Themes::class, CANONICAL)) {
?>
    <meta property="og:url" content="<?= html(absoluteurl(value(Themes::class, CANONICAL))) ?>">
    <link rel="canonical" href="<?= html(value(Themes::class, CANONICAL)) ?>">
<?php
  }
  $next = nextpage();
  if (null !== $next) {
?>
    <link rel="next" href="<?= html($next) ?>">
<?php
  }
  $prev = prevpage();
  if (null !== $prev) {
?>
    <link rel="prev" href="<?= html($prev) ?>">
<?php
  }
  $feeduri = feeduri();
  if (null !== $feeduri) {
?>
    <link rel="alternate" type="application/rss+xml" href="<?= html($feeduri) ?>" />
<?php
  }
  if (null !== value(Themes::class, FAVICON)) {
?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= html(value(Themes::class, FAVICON)) ?>">
<?php
  }
?>

    <title><?= html(value(Themes::class, TITLE)) ?></title>

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="/user/uploads/img/app_icon.png">

    <!-- Fork Awesome Icons -->
    <link href="<?= html(path2uri(__DIR__."/vendor/fork-awesome/css/fork-awesome.min.css")) ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= html(path2uri(__DIR__."/css/custom.css")) ?>" rel="stylesheet">

    <!-- Plugin CSS -->
    <link href="<?= html(path2uri(__DIR__."/vendor/magnific-popup/magnific-popup.css")) ?>" rel="stylesheet">
    <link href="<?= html(path2uri(__DIR__."/vendor/jquery-tagthis/jquery-tag-this.css")) ?>" rel="stylesheet">

    <!-- Theme CSS - Includes Bootstrap -->
    <link href="<?= html(path2uri(__DIR__."/css/creative.css")) ?>" rel="stylesheet">
  </head>


  <body id="page-top">
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="/#page-top"><?= html(value(Themes::class, SITENAME)) ?></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto my-2 my-lg-0">
<?php
  // iterate through the menu entries to generate the link bar
  $menu = value(Themes::class, MENU);
  if (is_array($menu)) {
    foreach ($menu as $menu_item) {
      if (is_array($menu_item)) {
        if (isset($menu_item[TITLE]) && isset($menu_item[URI])) {
          if (isset($menu_item[MENU]) && is_array($menu_item[MENU])) {
?>
            <li class="dropdown nav-item">
              <a href="<?= html($menu_item[URI]) ?>" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?= html($menu_item[TITLE]) ?></a>
              <div class="dropdown-menu dropdown-menu-left animate slideIn" aria-labelledby="navbarDropdown">
<?php
            foreach ($menu_item[MENU] as $submenu_item) {
              if (isset($submenu_item[TITLE]) && isset($submenu_item[URI])) {
                // handle local scrolling links
                $local = false;
                if (null !== value(Main::class, URI)) {
                  $url = parse_url($submenu_item[URI]);
                  if ((false !== $url) &&
                      !isset($url["scheme"]) && !isset($url["host"]) && !isset($url["port"]) && !isset($url["user"]) &&
                      !isset($url["pass"]) && isset($url["path"]) && isset($url["fragment"]) &&
                      (0 === strcmp(value(Main::class, URI), $url["path"]))) {
                    $local             = true;
                    $submenu_item[URI] = "#".$url["fragment"];
                  }
                }
?>
                <a class="dropdown-item<?= ($local) ? " js-scroll-trigger" : "" ?>" href="<?= html($submenu_item[URI]) ?>"><?= html($submenu_item[TITLE]) ?></a>
<?php
              }
            }
?>
              </div>
            </li>
<?php
          } else {
            // handle local scrolling links
            $local = false;
            if (null !== value(Main::class, URI)) {
              $url = parse_url($menu_item[URI]);
              if ((false !== $url) &&
                  !isset($url["scheme"]) && !isset($url["host"]) && !isset($url["port"]) && !isset($url["user"]) &&
                  !isset($url["pass"]) && isset($url["path"]) && isset($url["fragment"]) &&
                  (0 === strcmp(value(Main::class, URI), $url["path"]))) {
                $local          = true;
                $menu_item[URI] = "#".$url["fragment"];
              }
            }
?>
            <li class="nav-item"><a class="nav-link<?= ($local) ? " js-scroll-trigger" : "" ?>" href="<?= html($menu_item[URI]) ?>"><?= html($menu_item[TITLE]) ?></a></li>
<?php
          }
        }
      }
    }
  }
?>
          </ul>
        </div>
      </div>
    </nav>

