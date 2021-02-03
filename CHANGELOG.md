# Changelog

## 0.1a7 (03.02.2021)
### Feature
* support pages in subfolders

## 0.1a6 (01.06.2020)
### Bugfixes
* properly generate title of pages

## 0.1a5 (26.04.2020)
### Feature
* added support for `PageImage` to set the `og:image` meta header
* added support for `PageInfo` to set the descriptive sentence in the heading section
* added support for `PageType` to set the `og:type` meta header
* added support for `ReplaceSection` so that a section content file can replace the whole section block
* `Author` can now be used to set the `author` meta header
* `Description` can now be used to set the `description` and `og:description` meta header
* `Title` can now be used to set the `title` and the `og:title` meta header

## 0.1a4 (24.04.2020)
### Bugfixes
* fixed auto-generation of `DATE` based on the file date
### Feature
* changed `AlternateAlignment` to `SectionAlignment` with values `alternate`, `center`, `left` and `right`
* `SectionAlignment` can now be overwritten by individual section content files as well
* added support for `SectionBackground` with values `alternate`, `dark` and `primary`
* added support for `ReplaceHeading` so that a page content file can replace the whole heading section block
* menu items linking to the current page with a fragment now use the `js-scroll-trigger` CSS class

## 0.1a3 (21.04.2020)
### Feature
* added support for pages with section
* added support for `ALTERNATEALIGNMENT` value

## 0.1a2 (21.04.2020)
### Feature
* added support for submenus

## 0.1a1 (19.04.2020)
### Feature
* allow to set the `PAGENAME`, `DESCRIPTION` and `DATE` value of a category page

## 0.1a0 (18.04.2020)
### Features
* initial version
