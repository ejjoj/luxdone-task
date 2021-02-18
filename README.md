# Bartosz Szymański
## Luxdone task

## Install

- [Install Symfony](https://symfony.com/doc/current/setup.html) with Composer [(see requirements details)](https://symfony.com/doc/current/setup.html).
- Download .zip of project.
- Run ```composer install``` in folder in which you unzipped the project.
- Run ```symfony server:start -d``` in project folder.
- Paste in browser/API testing software (i.e. Postman) the URL of: [https://127.0.0.1:8000/usd/2020-02-17/2021-02-17/](https://127.0.0.1:8000/usd/2020-02-17/2021-02-17/) to test it out.
- After running ```composer install``` tests should be runnable in IDE like PHP Storm.
- General schema of URL is **GET /{currency}/{startDate}/{endDate}/**

## Specs
API accepts:
- currencies like: **USD, EUR, CHF, GBP**
- date format like: **YYYY-MM-DD** - NBP accepted type of format.
- Test covers basic functionalities like mathematical corectness, response from server etc. 
