# Scrape Image With Command in Laravel

**Scrape Image**, Image scraping is a subset of the web scraping technology. While web scraping deals with all forms of web data extraction, image scraping only focuses on the media side – images, videos, audio, and so on..


## How to use

``` bash
git clone git@github.com:(your_github)/Scrape-Laravel.git
cd Scrape-Laravel
composer install
```

The script above aims to clone and install the dependencies needed on the project, after everything goes well and there are no errors, you can make a configuration (.env) on your project in the following way?

```sh
copy .env.example to .env
```
- Then set the configuration according to your wishes.

For global configuration there may require the Generate APP_KEY script:

```sh
php artisan key:generate 
php artisan event:generate
php artisan storage:link
```
