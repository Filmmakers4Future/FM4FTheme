<?php

  /**
    This is the Filmmakers for Future theme.

    This file contains the theme class of the Filmmakers for Future theme.

    @package filmmakers4future\fm4ftheme
    @version 0.1a0
    @author  Yahe <hello@yahe.sh>
    @since   0.1a0
  */

  // ===== DO NOT EDIT HERE =====

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  class FM4FTheme extends BaseSingleton implements Theme {

    // HELPER FUNCTIONS

    protected static function configureTheme() {
      // individual theme configuration
      Themes::preset("copyright_html",  null);
      Themes::preset("header_name",     null);
      Themes::preset("header_sentence", null);

      // recommended theme configuration
      Themes::preset(AUTHOR,      static::getDefaultAuthor());
      Themes::preset(CANONICAL,   static::getDefaultCanonical());
      Themes::preset(CHARSET,     static::getDefaultCharset());
      Themes::preset(COPYRIGHT,   static::getDefaultCopyright());
      Themes::preset(DESCRIPTION, static::getDefaultDescription());
      Themes::preset(FAVICON,     null);
      Themes::preset(KEYWORDS,    static::getDefaultKeywords());
      Themes::preset(LANGUAGE,    static::getDefaultLanguage());
      Themes::preset(MENU,        null);
      Themes::preset(PAGENAME,    static::getDefaultPagename());
      Themes::preset(SITENAME,    t("Deine Webseite", static::class));
      Themes::preset(SITESLOGAN,  t("Dein Slogan", static::class));
      Themes::preset(TIMEFORMAT,  "d.m.Y");
      Themes::preset(TITLE,       static::getDefaultTitle());
    }

    protected static function getDefaultAuthor() {
      $result = null;

      // try to retrieve the first author
      foreach (value(Main::class, CONTENT) as $content_item) {
        if ($content_item->isset(AUTHOR)) {
          $result = value($content_item, AUTHOR);
          break;
        }
      }

      return $result;
    }

    protected static function getDefaultCanonical() {
      $result = null;

      // do not set a canonical URI on error
      if (ErrorHandler::class !== Handlers::getActive()) {
        $result = value(Main::class, URI);
      }

      return $result;
    }

    protected static function getDefaultCharset() {
      return strtolower(value(Main::class, CHARSET));
    }

    protected static function getDefaultCopyright() {
      return "Copyright &copy;".SP.value(Themes::class, SITENAME).SP.date("Y");
    }

    protected static function getDefaultDescription() {
      $result = null;

      // get the first entry of the content entries
      if (0 < count(value(Main::class, CONTENT))) {
        if (value(Main::class, CONTENT)[0]->isset(CONTENT)) {
          // remove all HTML tags and replace line breaks with spaces
          $result = substr(strtr(strip_tags(value(value(Main::class, CONTENT)[0], CONTENT)),
                                 ["\r\n" => SP, "\n" => SP, "\r" => SP]),
                           0, 300);
        }
      }

      return $result;
    }

    protected static function getDefaultKeywords() {
      $result = null;

      // retrieve all words from the titles
      $words = [];
      foreach (value(Main::class, CONTENT) as $content_item) {
        if ($content_item->isset(TITLE)) {
          $words = array_merge($words, explode(SP, value($content_item, TITLE)));
        }
      }

      // filter all words that do not fit the scheme
      for ($index = count($words)-1; $index >= 0; $index--) {
        if (1 !== preg_match("~^[0-9A-Za-z\-]+$~", $words[$index])) {
          unset($words[$index]);
        }
      }

      $result = implode(DP.SP, $words);

      return $result;
    }

    protected static function getDefaultLanguage() {
      $result = strtolower(value(Main::class, LANGUAGE));

      // only take the first part if the language is of the form "ab_xy"
      if (1 === preg_match("~^([a-z]+)\_[a-z]+$~", $result, $matches)) {
        if (2 === count($matches)) {
          $result = $matches[1];
        }
      }

      return $result;
    }

    protected static function getDefaultPagename() {
      $result = null;

      // convert the METADATA to a pagename
      $metadata = value(Main::class, METADATA);
      if ($metadata instanceof Content) {
        switch (Handlers::getActive()) {
          case ArchiveHandler::class:
            if ((null !== value($metadata, ArchiveHandler::DAY)) ||
                (null !== value($metadata, ArchiveHandler::MONTH)) ||
                (null !== value($metadata, ArchiveHandler::YEAR))) {
              $result = t("Archiv", FM4FTheme::class).COL.SP;

              $parts = [];
              if (null !== value($metadata, ArchiveHandler::DAY)) {
                $parts[] .= t("Tag", FM4FTheme::class).SP.value($metadata, ArchiveHandler::DAY);
              }
              if (null !== value($metadata, ArchiveHandler::MONTH)) {
                $parts[] .= t("Monat", FM4FTheme::class).SP.value($metadata, ArchiveHandler::MONTH);
              }
              if (null !== value($metadata, ArchiveHandler::YEAR)) {
                $parts[] .= t("Jahr", FM4FTheme::class).SP.value($metadata, ArchiveHandler::YEAR);
              }

              $result .= implode(DP.SP, $parts);
            }
            break;

          case AuthorHandler::class:
            $result = t("Autor", FM4FTheme::class).COL.SP.strtoupper(value($metadata, AUTHOR));
            break;

          case CategoryHandler::class:
            $result = t("Kategorie", FM4FTheme::class).COL.SP.strtoupper(value($metadata, CATEGORY));
            break;

          case SearchHandler::class:
            $result = t("Suche", FM4FTheme::class).COL.SP.strtr(value($metadata, SearchHandler::SEARCH), DOT, SP);
            break;
        }
      }

      return $result;
    }

    protected static function getDefaultTitle() {
      $result = value(Themes::class, SITENAME).SP."-".SP.value(Themes::class, SITESLOGAN);

      if (null !== value(Themes::class, PAGENAME)) {
        $result = value(Themes::class, PAGENAME).SP."|".SP.$result;
      } else {
        // handle errors and pages
        if ((ErrorHandler::class === Handlers::getActive()) ||
            (PageHandler::class === Handlers::getActive())) {
          // get the first entry of the content entries
          if (0 < count(value(Main::class, CONTENT))) {
            if (value(Main::class, CONTENT)[0]->isset(TITLE)) {
              $result = value(value(Main::class, CONTENT)[0], TITLE).SP."|".SP.$result;
            }
          }
        }
      }

      return $result;
    }

    // RUNTIME FUNCTIONS

    public static function theme() {
      $result = false;

      // we do not handle empty content
      $content = preparecontent(value(Main::class, CONTENT));
      if (null !== $content) {
        // make sure that we only handle arrays
        if ($content instanceof Content) {
          Main::set(CONTENT, [$content]);
        }

        // preset theme configuration
        static::configureTheme();

        // generate the head output
        Plugins::run(BEFORE_HEAD);
        require_once(__DIR__.DS."head.php");
        Plugins::run(AFTER_HEAD);

        // generate the body output
        Plugins::run(BEFORE_BODY);
        require_once(__DIR__.DS."body.php");
        Plugins::run(AFTER_BODY);

        // generate the footer output
        Plugins::run(BEFORE_FOOTER);
        require_once(__DIR__.DS."footer.php");
        Plugins::run(AFTER_FOOTER);

        // we handled this page
        $result = true;
      }

      return $result;
    }

  }

  // register theme
  Themes::register(FM4FTheme::class, "theme", FM4FTheme::class);

  // register translation
  Translate::register(__DIR__.DS."lang".DS, FM4FTheme::class);
