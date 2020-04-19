<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
    <!-- Header Section -->
    <section class="header-section bg-primary">
      <div class="container">
<?php
  if (null !== value(Themes::class, PAGENAME)) {
?>
        <h2 class="text-center text-white mt-0"><?= html(value(Themes::class, PAGENAME)) ?></h2>
<?php
  }
  if (null !== value(Themes::class, DESCRIPTION)) {
?>
        <h5 class="text-white mt-0 text-center"><?= html(value(Themes::class, DESCRIPTION)) ?></h5>
<?php
  }
  if (null !== value(Themes::class, DATE)) {
?>
        <h6 class="text-white-50 mt-0 text-center">(Last update: <?= html(value(Themes::class, DATE)) ?>)</h6>
<?php
  }
?>
      </div>
    </section>

<?php
  // iterate through the content entries
  $dark_or_primary = null;
  $index           = 0;
  foreach (value(Main::class, CONTENT) as $content_item) {
    $index++;

    $content = value($content_item, CONTENT).NL;
    $title   = value($content_item, TITLE);

    // get the category string and covert it into an array
    $category = null;
    $catvalue = value($content_item, CATEGORY);
    if (is_string($catvalue)) {
      $catvalue = explode(SP, $catvalue);
      foreach ($catvalue as $catvalue_item) {
        // make sure that only valid characters are contained
        if (1 === preg_match("~^[0-9A-Za-z\_\-]+$~", $catvalue_item)) {
          if (null === $category) {
            $category = [];
          }

          // add category as lowercase string
          $category[] = strtolower($catvalue_item);
        }
      }

      if (null !== $category) {
        // remove duplicates
        $category = array_unique($category);

        // sort the categories
        sort($category);
      }
    }

    // get the date and make sure that only parsable dates are displayed
    $date = null;
    $time = value($content_item, DATE);
    if (is_string($time)) {
      $time = strtotime($time);
      if (false !== $time) {
        $date = date(value(Themes::class, TIMEFORMAT), $time);
        $time = getdate($time);
      }
    }

    // link the headline only when it's not an error or a single page single page
    $uri = null;
    if ((ErrorHandler::class !== Handlers::getActive()) &&
        (PageHandler::class !== Handlers::getActive())) {
      $uri = value($content_item, URI);
    }
?>
    <!-- <?= html($title) ?> Section -->
    <section class="page-section <?= (0 === ($index % 2)) ? "bg-primary" : "bg-dark" ?> text-left">
      <div class="container">
        <h3 class="text-white-75">
<?php
    if (null !== $uri) {
?>
          <a href="<?= html($uri) ?>">
<?php
    }
?>
            <?= html($title.NL) ?>
<?php
    if (null !== $uri) {
?>
          </a>
<?php
    }
?>
        </h3>
<?php
    if ((null !== $category) || (null !== $date)) {
?>
        <p class="text-white-50">
<?php
      $metadata = new Content();

      if (null !== $date) {
        $metadata->set(ArchiveHandler::DAY,   $time["mday"]);
        $metadata->set(ArchiveHandler::MONTH, $time["mon"]);
        $metadata->set(ArchiveHandler::YEAR,  $time["year"]);

        $link = ArchiveHandler::getUri($metadata);
?>
          <a href="<?= html($link) ?>"><?= html($date) ?></a>
<?php
      }
      if (null !== $category) {
        $in_or_and = "in";
        foreach ($category as $category_item) {
          $metadata->set(CATEGORY, $category_item);

          $link = CategoryHandler::getUri($metadata);
?>
          <?= html($in_or_and) ?> <a href="<?= html($link) ?>"><?= html(strtoupper($category_item)) ?></a>
<?php

          // set for additional iterations
          $in_or_and = "and";
        }
      }
?>
        </p>
<?php
    }
?>
<?= $content ?>
      </div>
    </section>

<?php
  }

  // check if pagination is needed
  if (1 < value(Main::class, PAGECOUNT)) {
    $first = firstpage();
    $last  = lastpage();
    $next  = nextpage();
    $prev  = prevpage();
?>
    <!-- Pagination -->
    <section class="page-pagination <?= (0 === (($index+1) % 2)) ? "bg-primary" : "bg-dark" ?> text-center">
      <ul class="pagination pagination justify-content-center">
        <li class="page-item<?= (null === $first) ? " disabled" : "" ?>">
          <a class="page-link" href="<?= html($first) ?>" aria-label="First">
            <span aria-hidden="true">|&laquo;</span>
            <span class="sr-only">First</span>
          </a>
        </li>
        <li class="page-item<?= (null === $prev) ? " disabled" : "" ?>">
          <a class="page-link" href="<?= html($prev) ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item disabled"><a class="page-link" href="<?= html(curpage()) ?>"><?= html(value(Main::class, PAGE)) ?></a></li>
        <li class="page-item<?= (null === $next) ? " disabled" : "" ?>">
          <a class="page-link" href="<?= html($next) ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        <li class="page-item<?= (null === $last) ? " disabled" : "" ?>">
          <a class="page-link" href="<?= html($last) ?>" aria-label="Last">
            <span aria-hidden="true">&raquo;|</span>
            <span class="sr-only">Last</span>
          </a>
        </li>
      </ul>
    </section>
<?php
  }
?>

