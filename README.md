# Filmmakers for Future theme
The Filmmakers for Future theme is a multi-page theme for [Urlaube](https://github.com/urlaube/urlaube).

## Installation
Place the folder containing the theme into your themes directory located at `./user/themes/`.

Finally, add the following line to your configuration file located at `./user/config/config.php` to select the theme:
```
Main::set(THEMENAME, FM4FTheme::class);
```

## Configuration
To configure the theme you can change the corresponding settings in your configuration file located at `./user/config/config.php`.

### Author name
You can overwrite the auto-generated author header:
```
Themes::set(AUTHOR, $static::getDefaultAuthor());
```

### Canonical URL
You can overwrite the auto-generated canonical URL header:
```
Themes::set(CANONICAL, static::getDefaultCanonical());
```

### Charset
You can overwrite the auto-generated charset header:
```
Themes::set(CHARSET, static::getDefaultCharset());
```

### Description
You can add HTML content to the header:
```
Themes::set(CONTENT, null);
```

### Copyright text
You can set the following values to change the copyright text in the footer area. You can either choose auto-escaped text by setting `COPYRIGHT` or you can choose HTML by setting `"copyright_html"`:
```
Themes::set(COPYRIGHT, static::getDefaultCopyright());
```
```
Themes::set("copyright_html", null);
```

### Description
You can overwrite the auto-generated description header:
```
Themes::set(DESCRIPTION, static::getDefaultDescription());
```

### Favicon URL
You can set the URL of the favicon:
```
Themes::set(FAVICON, null);
```

### Keywords
You can overwrite the auto-generated keywords header:
```
Themes::set(KEYWORDS, static::getDefaultKeywords());
```

### Language
You can overwrite the auto-generated language header:
```
Themes::set(LANGUAGE, static::getDefaultLanguage());
```

### Menu
You can set the content of the site's menu:
```
Themes::set(MENU, null);
```

The menu content has to be set as an array containing associative arrays for each element:
```
Themes::set(MENU, [[TITLE => "Linktext",   URI => "https://example.com/"],
                   [TITLE => "Linktext 2", URI => "https://example.net/"]]);
```

The menu also support submenus by assigning an array containing associative to the `MENU` field of a menu element:
```
Themes::set(MENU, [[TITLE => "Linktext",
                    URI   => "https://example.com/"],
                   [TITLE => "Linktext 2",
                    URI   => "#",
                    MENU  => [[TITLE => "Linktext 2.A",
                               URI   => "https://example.net/"]]]]);
```

### Pagename
You can overwrite the auto-generated page name that is used as an H1 headline:
```
Themes::set(PAGENAME, static::getDefaultPagename());
```

### Sitename
You can overwrite the preset site name that is used a text logo and in the auto-generated title header:
```
Themes::set(SITENAME, "Filmmakers for Future");
```

### Siteslogan
You can overwrite the preset site slogan that is used in the auto-generated title header:
```
Themes::set(SITESLOGAN, null);
```

### Timeformat
You can set the time format used to display the DATE value of the content:
```
Themes::set(TIMEFORMAT, "d F Y");
```

The value specified here has to be supported by PHP's [date()](http://php.net/manual/en/function.date.php) function.

### Title
You can overwrite the auto-generated title header:
```
Themes::set(TITLE, static::getDefaultTitle());
```

## Usage

### Special Category Handling

The theme implements a special handling for categories. If a category `example` is used in content files and there exists a corresponding content file called `./user/content/example.md`, then the `PAGENAME`, `DESCRIPTION` and `DATE` fields are used to set the corresponding header values. Furthermore, the content of that content file is used in the header as well.

### Special Page Handling

The implements a special handling for pages. If a content file `./user/content/example.md` does not set the `CATEGORY` field, then the `PAGENAME`, `DESCRIPTION` and `DATE` fields are used to set the corresponding header values. Furthermore, the content of that content file is used in the header as well. For such a page the corresponding content folder `./user/content/example/` is searched for `*.md` files. If these are found and set the `SECTION` field to `true` then their content is used as individual sections of the page. The sections will be sorted by filename.
