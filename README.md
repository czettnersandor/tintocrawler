# Tintocrawler

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/czettnersandor/tintocrawler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/czettnersandor/tintocrawler/?branch=master)

Crawl weather station data for own purposes. My problem with the original website is it takes ages to load on mobile network and renders poorly on mobile devices: usually no graphs, just current reading visible and it's not reponsive. I host this crawler on a Respberry PI at home and collect the data to there when away. It's using sqlite for database engine.

To set up locally, copy config.php.sample to config.php and edit your login credentials.

To get the data and refresh the chart, simply run or add this to the cron:

```
php crawler.php
```

To view the results, start a simple web server:

```
php -S localhost:8000 -t public
```

But it can be lightdm as well, PHP is not needed, everything is static content.
