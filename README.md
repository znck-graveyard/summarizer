# Summarizer [![](https://img.shields.io/packagist/v/znck/summarizer.svg)](https://packagist.org/packages/znck/summarizer) [![](https://img.shields.io/packagist/dt/znck/summarizer.svg)](https://packagist.org/packages/znck/summarizer)  [![](https://img.shields.io/packagist/l/znck/summarizer.svg)](http://znck.mit-license.org) [![](https://www.codacy.com/project/badge/005c3669e57442a198f3a4ffe5e5c9e2)](https://www.codacy.com/app/znck/summarizer) [![Build Status](https://travis-ci.org/znck/summarizer.svg)](https://travis-ci.org/znck/summarizer)
Automated summarizer (PHP wrapper for open text summary)

### Install
```
composer require znck/summarizer
```

Installing native dependencies.
- Linux:  
  ```
  sudo apt-get install libots0
  ```
- OS X:     
  ```
  brew install libxml2 glib popt
  ```

### Usage
```php
$summarizer = new \Znck\Summarizer\Summarizer;
$output = $summarizer->summarize('http://www.au.af.mil/au/awc/awcgate/usmchist/war.txt');
```
