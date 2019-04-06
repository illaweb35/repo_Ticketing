# Louvre ticket office

## Project 4 Ticket Shop at the Louvre Museum



### Context of the project

The Louvre Museum has commissioned you for an ambitious project:

 To create a new system for booking and managing tickets online to reduce long queues and take advantage of the growing use of smartphones.


#### Production


- MVC
- Symfony
- Bootstrap
- Sqlite
- Html/ Twig
- CSS
- jQuery
- Twig
- SwifMailer
- Stripe

#### Site Architecture

- Home
    - Booking of tickets
        - Date choice
        - email order
        - number ticket
        - reduce choice
    - Enter ticket information
        - lastName
        - firstName
        - birthday
        - country
    - Checking order
        - show the summary of the order
    - Pay with card
        - email order
        - number card
        - date valid
        - CVC
        - zip Code


#### How use the project

You have the choice between downloading the zip, or cloning the deposit.

Once you have searched for the repository, open the folder with your code editor and launch a terminal in the folder, then enter the following statements:

```
   : $ composer install
   : $ composer update
```
The database used by default is Sqlite.

For installation  enter in terminal :
```
: $ ./bin/console doctrine:database:create
: $ ./bin/console doctrine:migrations:migrate
```


If you want to use another database please refer to the symfony documentation.

The configuration parameters are in the .env file

- Dev Environment or Prod
- Database connection information
- email information




Et Voilà !! your project is functionnal