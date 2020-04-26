<?php

  /**
    This is the Filmmakers for Future theme.

    This file contains the theme class of the Filmmakers for Future theme.

    @package filmmakers4future\fm4ftheme
    @version 0.1a5
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
      Themes::preset("copyright_html",     null);
      Themes::preset("page_image",         static::getDefaultAttribute("PageImage", null));
      Themes::preset("page_info",          static::getDefaultAttribute("PageInfo", null));
      Themes::preset("page_type",          static::getDefaultAttribute("PageType",
                                                                       function ($result) {
                                                                         if (null === $result) {
                                                                           $result = "website";
                                                                         }
                                                                         return $result;
                                                                       }));
      Themes::preset("replace_heading",    static::getDefaultAttribute("ReplaceHeading",
                                                                       function ($result) {
                                                                         return istrue($result);
                                                                       }));
      Themes::preset("replace_section",    static::getDefaultAttribute("ReplaceSection",
                                                                       function ($result) {
                                                                         return istrue($result);
                                                                       }));
      Themes::preset("section_alignment",  static::getDefaultAttribute("SectionAlignment",
                                                                       function ($result) {
                                                                         // only allow supported values
                                                                         switch (strtolower($result)) {
                                                                           case "alternate":
                                                                           case "center":
                                                                           case "left":
                                                                           case "right":
                                                                             break;
                                                                           default:
                                                                             $result = null;
                                                                         }
                                                                         return $result;
                                                                       }));
      Themes::preset("section_background", static::getDefaultAttribute("SectionBackground",
                                                                       function ($result) {
                                                                         // only allow supported values
                                                                         switch (strtolower($result)) {
                                                                           case "alternate":
                                                                           case "dark":
                                                                           case "primary":
                                                                             break;
                                                                           default:
                                                                             $result = null;
                                                                         }
                                                                         return $result;
                                                                       }));

      // static theme configuration
      Themes::preset(FAVICON,    null);
      Themes::preset(MENU,       null);
      Themes::preset(SITENAME,   "Filmmakers for Future");
      Themes::preset(SITESLOGAN, null);
      Themes::preset(TIMEFORMAT, "d F Y");

      // recommended theme configuration
      Themes::preset(AUTHOR,      static::getDefaultAttribute(AUTHOR,
                                                              function ($result) {
                                                                // try to retrieve the first author
                                                                if (null === $result) {
                                                                  foreach (value(Main::class, CONTENT) as $content_item) {
                                                                    $author = value($content_item, AUTHOR);
                                                                    if (null !== $author) {
                                                                      $result = $author;
                                                                      break;
                                                                    }
                                                                  }
                                                                }
                                                                return $result;
                                                              }));
      Themes::preset(CANONICAL,   static::getDefaultCanonical());
      Themes::preset(CHARSET,     static::getDefaultCharset());
      Themes::preset(CONTENT,     static::getDefaultAttribute(CONTENT, null));
      Themes::preset(COPYRIGHT,   static::getDefaultCopyright());
      Themes::preset(DATE,        static::getDefaultAttribute(DATE,
                                                              function ($result) {
                                                                // alternative retrieve file modification date of the
                                                                // first content object
                                                                if (null === $result) {
                                                                  $content = preparecontent(value(Main::class, CONTENT),
                                                                                            null, [FilePlugin::FILE]);
                                                                  if (null !== $content) {
                                                                    if (is_file(value($content[0], FilePlugin::FILE))) {
                                                                      $result = filemtime(value($content[0],
                                                                                                FilePlugin::FILE));
                                                                    }
                                                                  }
                                                                } else {
                                                                  if (0 !== strcasecmp($result, "none")) {
                                                                    // convert retrieved secret to a date
                                                                    $result = strtotime($result);
                                                                  } else {
                                                                    $result = null;
                                                                  }
                                                                }
                                                                if (null !== $result) {
                                                                  $result = date(value(Themes::class, TIMEFORMAT), $result);
                                                                }
                                                                return $result;
                                                              }));
      Themes::preset(DESCRIPTION, static::getDefaultAttribute(DESCRIPTION, null));
      Themes::preset(KEYWORDS,    static::getDefaultAttribute(KEYWORDS,
                                                              function ($result) {
                                                                if (null === $result) {
                                                                  // retrieve all words from the titles and pagenames
                                                                  $words = [];
                                                                  foreach (value(Main::class, CONTENT) as $content_item) {
                                                                    $pagename = value($content_item, PAGENAME);
                                                                    if (null !== $pagename) {
                                                                      $words = array_merge($words, explode(SP, $pagename));
                                                                    }
                                                                    $title = value($content_item, TITLE);
                                                                    if (null !== $title) {
                                                                      $words = array_merge($words, explode(SP, $title));
                                                                    }
                                                                  }
                                                                  // filter all words that do not fit the scheme
                                                                  for ($index = count($words)-1; $index >= 0; $index--) {
                                                                    if (1 !== preg_match("~^[0-9A-Za-z\-]+$~", $words[$index])) {
                                                                      unset($words[$index]);
                                                                    }
                                                                  }
                                                                  $result = implode(DP.SP, $words);
                                                                }
                                                                return $result;
                                                              }));
      Themes::preset(LANGUAGE,    static::getDefaultLanguage());
      Themes::preset(PAGENAME,    static::getDefaultPagename());
      Themes::preset(TITLE,       static::getDefaultAttribute(TITLE,
                                                              function ($result) {
                                                                if (null === $result) {
                                                                  $result = value(Themes::class, SITENAME);
                                                                  // optionally add the siteslogan if it is set
                                                                  $siteslogan = value(Themes::class, SITESLOGAN);
                                                                  if (null !== $siteslogan) {
                                                                    $result = $result.SP."-".SP.$siteslogan;
                                                                  }
                                                                  // optionally add the pagename if it is set
                                                                  $pagename = value(Themes::class, PAGENAME);
                                                                  if (null !== $pagename) {
                                                                    $result = $pagename.SP."|".SP.$result;
                                                                  } else {
                                                                    // handle errors and pages
                                                                    if ((ErrorHandler::class === Handlers::getActive()) ||
                                                                        (PageHandler::class === Handlers::getActive())) {
                                                                      // get the first entry of the content entries
                                                                      if (0 < count(value(Main::class, CONTENT))) {
                                                                        $title = value(Main::class, CONTENT)[0]->isset(TITLE);
                                                                        if (null !== $title) {
                                                                          $result = $title.SP."|".SP.$result;
                                                                        }
                                                                      }
                                                                    }
                                                                  }
                                                                }
                                                                return $result;
                                                              }));
    }

    protected static function getDefaultAttribute($attribute, $filter = null) {
      $result = null;

      $metadata = value(Main::class, METADATA);
      if ($metadata instanceof Content) {
        switch (Handlers::getActive()) {
          case CategoryHandler::class:
            callcontent(strtolower(value($metadata, CATEGORY)), false, true,
                        function ($content) use ($attribute, &$result) {
                          if ((null === $result) && (null !== value($content, $attribute))) {
                            $result = value($content, $attribute);
                          }
                          return null;
                        });
            break;

          case FM4FHandler::class:
          case PageHandler::class:
            $content = preparecontent(value(Main::class, CONTENT), null, [CATEGORY]);
            if (null !== $content) {
              $category = static::getFirstCategory(value($content[0], CATEGORY));
              if (null !== $category) {
                callcontent(strtolower($category), false, true,
                            function ($content) use ($attribute, &$result) {
                              if ((null === $result) && (null !== value($content, $attribute))) {
                                $result = value($content, $attribute);
                              }
                              return null;
                            });
              }
            } else {
              if (null !== value(value(Main::class, CONTENT)[0], $attribute)) {
                $result = value(value(Main::class, CONTENT)[0], $attribute);
              }
            }
            break;
        }
      }

      // let the caller decide what happens with the result
      if (is_callable($filter)) {
        $result = $filter($result);
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
            callcontent(strtolower(value($metadata, CATEGORY)), false, true,
                        function ($content) use (&$result) {
                          if (null === $result) {
                            $result = value($content, PAGENAME);
                          }
                          return null;
                        });
            if (null === $result) {
              $result = t("Kategorie", FM4FTheme::class).COL.SP.strtoupper(value($metadata, CATEGORY));
            }
            break;

          case FM4FHandler::class:
          case PageHandler::class:
            $content = preparecontent(value(Main::class, CONTENT), null, [CATEGORY]);
            if (null !== $content) {
              $category = static::getFirstCategory(value($content[0], CATEGORY));
              if (null !== $category) {
                callcontent(strtolower($category), false, true,
                            function ($content) use (&$result) {
                              if (null === $result) {
                                $result = value($content, PAGENAME);
                              }
                              return null;
                            });
                if (null === $result) {
                  $result = t("Kategorie", FM4FTheme::class).COL.SP.strtoupper($category);
                }
              }
            } else {
              $result = value(value(Main::class, CONTENT)[0], PAGENAME);
            }
            break;

          case SearchHandler::class:
            $result = t("Suche", FM4FTheme::class).COL.SP.strtr(value($metadata, SearchHandler::SEARCH), DOT, SP);
            break;
        }
      }

      return $result;
    }

    protected static function getFirstCategory($category) {
      $result = null;

      $category = explode(SP, $category);
      foreach ($category as $category_item) {
        // make sure that only valid characters are contained
        if (1 === preg_match("~^[0-9A-Za-z\_\-]+$~", $category_item)) {
          $result = $category_item;

          break;
        }
      }

      return $result;
    }

    protected static function handlePageSections() {
      // only check if we show a single page or the index
      if ((FM4FHandler::class === Handlers::getActive()) ||
          (PageHandler::class === Handlers::getActive())) {
        // extract the potential folder name
        $filename = basename(value(value(Main::class, CONTENT)[0], FilePlugin::FILE), FilePlugin::EXTENSION);

        // retrieve the sections
        $content = callcontent($filename, true, false,
                               function ($content) {
                                 // ignore files where "section" is not set to true
                                 if (istrue(value($content, "section"))) {
                                   return $content;
                                 } else {
                                   return null;
                                 }
                               });

        // if there is something left
        if (null !== $content) {
          // make sure that we set an array
          if ($content instanceof Content) {
            $content = [$content];
          }

          // set the sections as the new content
          Main::set(CONTENT, $content);
        }
      }
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

        // read page sections if they are available
        static::handlePageSections();

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
