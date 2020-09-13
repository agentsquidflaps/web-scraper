# Getting started

## Install
    
    composer install agentsquidflaps/web-scraper

## Requirements

* PHP 7.2 or greater
* ext-json
* ext-simplexml
* symfony/dom-crawler 4 or greater
* symfony/css-selector 4 or greater

### Documentation

Please see below for basic usage or you can go to [https://agentsquidflaps.github.io/web-scraper/#/](https://agentsquidflaps.github.io/web-scraper/#/) for more information.

## Usage

Basic usage...
    
    (new WebScraper())->setSitemaps([
        'https://www.yoursite.com/sitemap.xml'
    ])->getData()
    
...this will simply output the HTML for all pages in your sitemap in a JSON format.
    
You can also target specific elements on a page...

    (new WebScraper())->setSitemaps([
        'https://www.yoursite.com/sitemap.xml'
    ])
    ->setElements([
        '.btn',
        'table'
    ])
    ->getData()

...and instead of returning the whole page, it'll return elements in a page that match the criteria of the elements provided.

### Save file

You can also save the data to a file. To do so just...

    (new WebScraper())->setSitemaps([
        'https://www.yoursite.com/sitemap.xml'
    ])
    ->setFileLocation('somewhere.json')
    ->saveData()
    
### Formats

You can also output the data in different formats. Supported formats are currently JSON, Array and CSV.

    (new WebScraper())->setSitemaps([
            'https://www.yoursite.com/sitemap.xml'
        ])
    ->setFileLocation('somewhere.csv')
    ->setFormat(WebScraper::FORMAT_CSV)
    ->saveData()
    
### Disabling verify peer

You don't have to verify peer when grabbing URLs to scrape (although, highly recommended).
This can be useful if the URLs provided in the sitemap have sketchy or non-existent SSLs.

    (new WebScraper())->setSitemaps([
            'http://www.yoursite.com/sitemap.xml'
        ])
    ->setFileLocation('somewhere.csv')
    ->setFormat(WebScraper::FORMAT_CSV)
    ->setVerifyPeerEnabled(false)
    ->saveData()
