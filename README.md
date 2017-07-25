# homoglyph-download

[![Build Status](https://travis-ci.org/mcfedr/homoglyph-download.svg?branch=master)](https://travis-ci.org/mcfedr/homoglyph-download)

A tool to download a list of homoglyphs from [http://homoglyphs.net]() and
export them as a PHP array.

This is used in the `HomoglyphNamesFixer` in [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer/), 
pending a merged [pull requet](https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/2940).

## Usage

```bash
./bin/console download
```

The default list is [http://homoglyphs.net/?update=update&lang=en&exc7=1&exc8=1&exc13=1&exc14=1]()

This includes symbols:
- Latin homoglyphs
- IPA extensions
- Greek and Coptic
- Cyrillic
- Cyrillic Supplement
- Letter­like Symbols
- Latin Numbers
- Fullwidth Latin

You can override the url with the option `--url`
