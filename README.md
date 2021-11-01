## Jumia Task

### For install , Setup and instructions please read the following 

### Service Specification
**The service should be able to provide:** <br/>
• Create a single page application that uses the database provided (SQLite 3) to list and
categorize country phone numbers.
Phone numbers should be categorized by country, state (valid or not valid), country code and
number.
The page should render a list of all phone numbers available in the DB. It should be possible to
filter by country and state. Pagination is an extra.<br/>


## Installation & Setup
### first install and Run back-end
 1. clone the repo `git clone git@github.com:AliBedaer/jumia-task.git`
 2. install composer of project `composer install`
 3. copy the `.env` file `cp .env.example .env` this will copy the example to the `.env`
 4. run the application using `php -S localhost:8001 -t public` you cane change `8001` to any you want
 5. now go to your postman and type `http://localhost:80001/filter`

##### 6. please Make sure to change the database path in the `.env` to be full path like this `/media/user/project/database/sample.db`

 7. have implemented a few unit testing cases all are based on fixed data on the database
to run the unit test this cases covers  `./vendor/bin/phpunit` 
    
## Coding
to know more about the coding structure it just simple I use the `Service Repository Pattern` it's a pattern that 
separate Logic And database from each other
- `controller only responsible for Input Out Put`
- `Service Layer for the logic`
- `and repository pattern for the database and queries or any data `

## Code And Directory Structure

 1. `app\abstracts` folder responsible for any contracts like `interfaces` or `abstract classes`
 2. `app\DTOs` is for DTOs(Data Transfer Object) instead of passing variables to functions parameters DTO is much better for passing the data inside your code
 3. `app\Enums` is for static or lookups data 
 4. `app\Http\Controller` for the input output all is exists in the  `CountriesFilterController.php`
 5. `app\Service` here is all the logic inside `FilterService.php` class   
 5. `app\Repositories` is the data layer and handling queries all inside `FilterCountryRepository.php` class
 6. `app\Resources` the for response mapping layer lumen is not like laravel shipped with the resource layer, so it must be created 

### preview here is a [postman document](https://documenter.getpostman.com/view/2026321/UVByKWTq) published with test example please Make Sure to review

## Tools

Versions: `PHP 7.4` `Lumen 7.0` `Vue-js 2.6.14`

