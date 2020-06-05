<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
    <!-- Footer -->
    <footer class="bg-light py-5">
      <div class="container">
<?php
  // output COPYRIGHT_HTML if it is set or COPYRIGHT otherwise
  if (null !== value(Themes::class, "copyright_html")) {
    print(value(Themes::class, "copyright_html").NL);
  } else {
?>
        <p><?= html(value(Themes::class, COPYRIGHT)).NL ?></p>
<?php
  }
?>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= html(path2uri(__DIR__."/vendor/jquery/jquery.min.js")) ?>"></script>
    <script src="<?= html(path2uri(__DIR__."/vendor/bootstrap/js/bootstrap.bundle.min.js")) ?>"></script>

    <!-- Plugin JavaScript -->
    <script src="<?= html(path2uri(__DIR__."/vendor/jquery-easing/jquery.easing.min.js")) ?>"></script>
    <script src="<?= html(path2uri(__DIR__."/vendor/magnific-popup/jquery.magnific-popup.min.js")) ?>"></script>
    <script src="<?= html(path2uri(__DIR__."/vendor/jquery-tagthis/jquery.tagthis.js")) ?>"></script>

    <!-- Custom scripts for this template -->
    <script src="<?= html(path2uri(__DIR__."/js/creative.js")) ?>"></script>
  </body>
</html>
