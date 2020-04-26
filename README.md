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
Themes::set(AUTHOR, static::getDefaultAttribute(AUTHOR));
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

### Content
You can add HTML content to the header:
```
Themes::set(CONTENT, static::getDefaultAttribute(CONTENT));
```

### Date
You can overwrite the auto-generated date information:
```
Themes::set(DATE, static::getDefaultAttribute(DATE));
```

Set this value to `none` if you want to hide the date information in the header.

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
Themes::set(DESCRIPTION, static::getDefaultAttribute(DESCRIPTION));
```

### Favicon URL
You can set the URL of the favicon:
```
Themes::set(FAVICON, null);
```

### Keywords
You can overwrite the auto-generated keywords header:
```
Themes::set(KEYWORDS, static::getDefaultAttribute(KEYWORDS));
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

### Pageimage
You can set the following value to define the `og:image` meta header:
```
Themes::set("page_image", static::getDefaultAttribute("PageImage"));
```

### Pageinfo
You can set the following value to define the descriptive sentence in the heading section:
```
Themes::set("page_info", static::getDefaultAttribute("PageInfo"));
```

### Pagename
You can overwrite the auto-generated page name that is used as an H1 headline:
```
Themes::set(PAGENAME, static::getDefaultAttribute(PAGENAME));
```

### Pagetype
You can set the following value to define the `og:type` meta header:
```
Themes::set("page_image", static::getDefaultAttribute("PageType"));
```

### Replace Heading
You can set the following value to define that the default heading shall be completely replaced with the content:
```
Themes::set("replace_heading", static::getDefaultAttribute("ReplaceHeading"));
```

### Replace Section
You can set the following value to define that the section block shall be completely replaced with the content:
```
Themes::set("replace_section", static::getDefaultAttribute("ReplaceSection"));
```

### Section Alignment
You can set the following value to define the alignment of sections:
```
Themes::set("section_alignment", static::getDefaultAttribute("SectionAlignment"));
```

Valid values are:
* `alternate`
* `center`
* `left`
* `right`

### Section Background
You can set the following value to define the background color of sections:
```
Themes::set("section_background", static::getDefaultAttribute("SectionBackground"));
```

Valid values are:
* `alternate`
* `dark`
* `primary`

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
Themes::set(TITLE, static::getDefaultAttribute(TITLE));
```

## Usage

### Special Category Handling

The theme implements a special handling for categories. If a category `example` is used in content files and there exists a corresponding content file called `./user/content/example.md`, then the fields in the corresponding content file overwrite the theme configurations.

### Special Page Handling

The theme implements a special handling for pages. If a content file `./user/content/example.md` does not set the `CATEGORY` field, then the fields in the content file overwrite the theme configurations. Furthermore, the content of that content file is used in the heading section. For such a page the corresponding content folder `./user/content/example/` is searched for `*.md` files. If these are found and set the `SECTION` field to `true` then their content is used as individual sections of the rendered page. The sections will be sorted by filename.
