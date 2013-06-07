E-z Payroller
=============

Specification
-------------

A small command-line utility to help a fictional company determine the dates they need to pay salaries to their sales department. This company is handling their sales payroll in the following way:

* Sales staff gets a regular monthly fixed base salary and a monthly bonus.
* The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday (weekend) in which case they are paid on the Friday before.
* On the 15th of every month bonuses are paid for the previous month, unless that day is weekend. In that case, they are paid the first Wednesday after the 15th.
* The output of the utility should be a CSV file, containing the payment dates for this year. The CSV file should contain a column for the month name, a column that contains the salary payment date for that month, and a column that contains the bonus payment date.

User story
----------

    Feature: Tool to display payment dates
        In order to manage salaries
        As a member of office staff
        I want to know what dates staff should be paid upon

        Scenario: Running the tool from the CLI
            Given the tool is run for 2014
             Then the dates for 2014 should be displayed

Installation
------------

First, install vendors using Composer:

    ./composer.phar install

Running the tool
----------------

You can run the tool by passing in a year:

    bin/ezpayroller.php 2013

On Windows systems, you may need to invoke it with:

    php bin/ezpayroller.php 2013

You can see a help file using:

    bin/ezpayroller.php --help

Running tests and analysis
--------------------------

Run "ant" to run all tests, static analysis et cetera. This project is based on [Sebastian Bergmann's Jenkins-PHP template](http://jenkins-php.org/index.html).

Continuous Integration
----------------------

This project is [continuously integrated using Travis CI](https://travis-ci.org/gavD/ez-payroller/).

Coding standards
----------------

The coding standard for this project is [PSR2](http://www.php-fig.org/).
The PMD rules applied are in the build directory and are as [defined by Sebastian Bergmann](http://jenkins-php.org/).

Libraries used
--------------

* [Carbon](https://github.com/briannesbitt/Carbon) has been used for date handling. This library abstracts away the slightly sketchy PHP date implementation. This library has a good reputation and is well written with an extensive battery of tests so I've been confident enough to rely upon it rather than reinvent the wheel.
