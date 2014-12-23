Scraper
============
A simple Console Application to scrape data from a listing on a web page, potentially traversing to the detail pages to get values

Installation
-------------------

* Note that this is tested on Linux only.
* make sure that you have composer installed.
* make sure that file_get_contents has the url wrapper enabled

1. Go to a folder to which you have write permissions and run

```shell
git clone https://github.com/malteriesch/scraper.git' 
cd scraper
composer install
```


Running
-------------------
The simplest way to run it is:
```shell
php scrape.php extract http://www.unite-students.com/liverpool 
```

You can specify various parameters, as in the following (which uses a test configuration, a file system url and a custom output file
```shell
php scrape.php extract tests/Assets/liverpool.html --config=tests/Assets/test-config.php --out=foo.csv

```

For help and command line parameters, you can run the following
```shell
php scrape.php help extract
php scrape.php help
php scrape.php extract

```

It is possible to use the scraper outside an applicatin environment, see tests/Unit/HtmlScraperTest.php for an example


Technologies Used
-------------------
* Symfony Crawler to parse web pages using css selectors
* ZfConsole for the Console Application framework (depends on Zend Framework 2)
* vfsStream to mock file systems
* TDD: Unit and Functional tests 
