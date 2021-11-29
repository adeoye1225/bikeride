# Task Statement

Problem Statement
A bike hire scheme consists of a number of bike hire stations from which bikes can be rented.
A CSV report (no headers, no specified sort order) can be produced containing the history of bike movements over a specified period.
FILEPATH = "data.csv"

File Format:

*Station ID
Integer, representing the bike hire station. Valid values: 1-1,000.
*Bike ID
Integer, representing the bike itself. Valid values: 1-10,000.
*Arrival Datetime
Datetime in format YYYYMMDDThh:mm:ss. Representing the date/time the bike arrived at the station. It is empty if the bike was at this station at the start of the reporting period.
*Departure Datetime
Datetime in format YYYYMMDDThh:mm:ss. Representing the date/time the bike departed from the station. It is empty if the bike was at this station at the end of the reporting period.

Example Line 1:
Bike 102 was docked (arrived) at station 22 at 2020-03-04 13:04 and was rented out again (departed) at 2020-03-04 13:25:32:
22,102,20200304T13:04:00,20200304T13:25:32

Example Line 2:
Bike 34 was already at station 4 at the start of the reporting period, and was first rented out at 2020-03-01 05:15:08
4,34,,20200301T05:15:08

##Task
Please write a program that will read the CSV report from the current working directory, and print the average (mean) journey duration, across all bikes and all stations, for the reporting period, in format hh:mm:ss.

This project runs with Laravel version 8.65.

## Getting started

Assuming you've already installed on your machine: PHP (>= 7.3.0), [Laravel](https://laravel.com) and [Composer](https://getcomposer.org).

``` bash
# install dependencies
composer install

```

Rename .env.example file to .env.
This file contains a variable "DATA_FILE" that is pointing to data.csv
To change the file name or path edit this variable.

To run feature test:

``` bash
php artisan test
```
If there are no failures you are good to go.

NB: Test uses the .env.testing file for it is enviromental variables. 
Test csv file is data_test.csv. If file is edited, test might fail.

Then launch the server:

``` bash
php artisan serve
```
visit route "http://localhost/api/report/mean" ( for examplehttp://127.0.0.1:8000/api/report/mean) to have the mean duration displayed in the format hh:mm:ss.
