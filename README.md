# A PHP sitemap generator and crawler
##

[![Build Status](https://travis-ci.org/danielemoraschi/sitemap-common.png?branch=master)](https://travis-ci.org/danielemoraschi/sitemap-common)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/danielemoraschi/sitemap-common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/danielemoraschi/sitemap-common/)

This package provides all of the components to crawl a website and build and write sitemaps file.

Example of console application using the library: [dmoraschi/sitemap-app](https://github.com/danielemoraschi/sitemap-app)


## Installation

Run the following command and provide the latest stable version (e.g v1.0.0):

```bash
composer require dmoraschi/sitemap-common
```

or add the following to your `composer.json` file :

```json
"dmoraschi/sitemap-common": "1.0.*"
``````

`SiteMapGenerator`
-----
**Basic usage**

``` php
$generator = new SiteMapGenerator(
    new FileWriter($outputFileName),
    new XmlTemplate()
);
```

Add a URL:
``` php
$generator->addUrl($url, $frequency, $priority);
```

Add a single `SiteMapUrl` object or array:
``` php
$siteMapUrl = new SiteMapUrl(
    new Url($url), $frequency, $priority
);

$generator->addSiteMapUrl($siteMapUrl);

$generator->addSiteMapUrls([
    $siteMapUrl, $siteMapUrl2
]);
```

Set the URLs of the sitemap via `SiteMapUrlCollection`:
``` php
$siteMapUrl = new SiteMapUrl(
    new Url($url), $frequency, $priority
);

$collection = new SiteMapUrlCollection([
    $siteMapUrl, $siteMapUrl2
]);

$generator->setCollection($collection);
```

Generate the sitemap:
``` php
$generator->execute();
```

`Crawler`
-----
**Basic usage**

``` php
$crawler = new Crawler(
    new Url($baseUrl),
    new RegexBasedLinkParser(),
    new HttpClient()
);
```

You can tell the `Crawler` **not to visit** certain url's by adding policies. Below the default policies provided by the library:
```php
$crawler->setPolicies([
    'host' => new SameHostPolicy($baseUrl),
    'url'  => new UniqueUrlPolicy(),
    'ext'  => new ValidExtensionPolicy(),
]);
// or
$crawler->setPolicy('host', new SameHostPolicy($baseUrl));
```
`SameHostPolicy`, `UniqueUrlPolicy`, `ValidExtensionPolicy` are provided with the library, you can define your own policies by implementing the interface `Policy`.

Calling the function `crawl` the object will start from the base url in the contructor and crawl all the web pages with the specified depth passed as a argument.
The function will return with the array of all unique visited `Url`'s:
```php
$urls = $crawler->crawl($deep);
```

You can also instruct the `Crawler` to collect custom data while visiting the web pages by adding `Collector`'s to the main object:
```php
$crawler->setCollectors([
    'images' => new ImageCollector()
]);
// or
$crawler->setCollector('images', new ImageCollector());
```
And then retrive the collected data:
```php
$crawler->crawl($deep);

$imageCollector = $crawler->getCollector('images');
$data = $imageCollector->getCollectedData();
```
`ImageCollector` is provided by the library, you can define your own collector by implementing the interface `Collector`.