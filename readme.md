composer install

testy
vendor/bin/phpunit -c tests/phpunit.xml


endpoint /get
parametry:
    date: 2018-08-21
    n:7

endpoint /insert
parametry:
    name:Excavator 012
    weekday:Sun
    hours:9:00-11:00