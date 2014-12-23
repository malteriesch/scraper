Scraper
============
A simple Console Application to scrape data from a listing on a web page, potentially traversing to the detail pages to get values

Installation
-------------------

* note that this is tested on Linux only.
* make sure that you have composer installed.
* make sure that file_get_contents has the url wrapper enabled

Go to a folder to which you have write permissions and run

```shell
git clone https://github.com/malteriesch/scraper.git
cd scraper
composer install
```


Running
-------------------
The simplest way to run it is (the csv file will be written to out.csv in the same folder:
```shell
php scrape.php extract http://www.unite-students.com/liverpool 
php scrape.php extract http://www.unite-students.com/manchester  --out=manchester.csv
cat out.csv
cat manchester.csv
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

It is possible to use the scraper outside an application environment, see tests/Unit/HtmlScraperTest.php for an example

Assumptions
-------------------
* Both a file path and a http url can be used, but the assumption is that the url has only one level, i.e. 'http://foo.com/listing' is ok, but 'http://foo.com/some-deeper-path/listing' is not at present

Technologies Used
-------------------
* Symfony Crawler to parse web pages using css selectors
* ZfConsole for the Console Application framework (depends on Zend Framework 2)
* vfsStream to mock file systems
* TDD: Unit and Functional tests 

The main test coverage is pretty much through the happy path, and the functional test (in tests/Functional) does a lot of the heavy lifting. 
The unit tests have been pragmatic, as to be specific enough to catch obvious errors, but they can be boosted up with more boundary conditions. 
Additionally, the unit tests also quite often have a general smoke test to test general happy-path functionality, especially the HtmlScraper class which is the main entry point to the API. 
Again when more refactoring is happening, these tests can be boosted.
