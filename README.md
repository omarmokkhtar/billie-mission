## About 

Microservice should receive the time on Earth in UTC as an input and return two values:
the Mars Sol Date (MSD) and the Martian Coordinated Time (MTC).

## Installation

- composer install 
- php artisan serve.
- GET `/mars-data?utcDateTime`

## Improvements

- Get iso time from user not utc time
- Make a cron job to auto fetch the time every one minute
- Get more data like `Mission Sol` `Mission Time (Landing LMST)` `Local True Solar Time`

## Clarifications

- Developed the required equations to get the MSD & MTC as referenced in https://www.giss.nasa.gov/tools/mars24/help/algorithm.html
- Implemented a service layer to be able to develop the microservice logic in it
- In the service layer there is a method called `marsData` which the initiation point of the service in which it calls the `prepareData` method and path
  the return value to the `marsSolDate` method and with the return value we would be able to get the second output which is `coordinatedMarsTime`
- Implemented a request layer to validate the input data
- Github project link https://github.com/omarmokkhtar/billie-mission

