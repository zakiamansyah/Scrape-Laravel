# Scrape Image With Command and Web Based in Laravel

**Scrape Image**, Image scraping is a subset of the web scraping technology. While web scraping deals with all forms of web data extraction, image scraping only focuses on the media side – images, videos, audio, and so on..


## How to use

In this case I assume you have the following requirements:

- [Chrome](https://www.google.com/intl/id/chrome/) Or [Firefox](https://www.mozilla.org/id/firefox/new/)
- [VSC] (https://code.visualstudio.com/download) 
- [Apache](https://httpd.apache.org/) Or [Nginx](http://nginx.org/en/download.html)
- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)


``` bash
git clone git@github.com:(your_github)/Scrape-Laravel.git
cd Scrape-Laravel
composer install
```

The script above aims to clone and install the dependencies needed on the project, after everything goes well and there are no errors, you can make a configuration (.env) on your project in the following way?

```sh
copy .env.example to .env
```

For global configuration there may require the Generate APP_KEY script:

```sh
php artisan key:generate 
php artisan storage:link
```

## How to run Scrape Image from web based

To use Scrape Image from Web Based must use the command:

``` bash
php artisan serve
```

Then :

- Open browser
- Put URL http://localhost:8000/crawler on your browser
- Just wait until the loading process is complete
- Then look in the folder storage/app there is a file name foto-face.txt

## How to run Scrape Image from CommandPrompt/Terminal

To use Scrape Image from CommandPrompt/Terminal must use the command: 

``` bash
php artisan scrape:image
```

Then :

- Just wait until the process is complete
- Then look in the folder storage/app there is a file name foto-face.txt

> **Happy Coding**. 😆
