# OldCar API REST 
### Final project of Full Stack Development Bootcamp at CodeSpace(Malaga).

## About this project...
Back-end side of OldCar App, service created to respond all queries done by [Client-side](https://en.wikipedia.org/wiki/Client-side#:~:text=Client%2Dside%20refers%20to%20operations,relationship%20in%20a%20computer%20network.) (ReactJS in this case) to keep logical standards and efficiency. Manipulating the resources as GET, POST and DELETE verbs to handle data, which return a response in JSON Format for a straight forward Front-end understanding.
 
## Back End Stack...
<div align="center">

![Screenshot 2021-04-01 at 12 38 59](https://user-images.githubusercontent.com/43299285/113282471-3fc66780-92e7-11eb-9f30-a9ad1507b05d.png)

</div>

<h2 align="left">
  <img src="https://user-images.githubusercontent.com/43299285/113305032-e9672200-9302-11eb-93b2-99687686883d.png" width="50">
  How to build the pillars...
</h2>

[Composer](https://getcomposer.org/) as main application-level package manager in PHP, it's a mandatory use it to shape your project adding dendencies as needed. All available bundles may be found at [packagist.org](https://packagist.org/) from getting started to New contributions.

#### How to to use it [here ...](https://getcomposer.org/doc/01-basic-usage.md)

## Example API responses...
This following examples are based on user profile, where is retrieving user's data when has been logged in, updating details at user's profile and deleting user's profile. 

### :question: Request...
`GET - http://localhost:8000/user/data`
### :heavy_minus_sign: Response...
```
{
  id: 11,
  name: "Vintage Car",
  email: "vintage@gmail.com",
  address: "Chaussée de Ninove", 
  city: "Anderlecht", …
}
```
### :question: Request...
`POST - http://localhost:8000/user/update`
### :heavy_minus_sign: Response...
```
  {
    id: 11,
    name: "Vintage Car", 
    email: "vintage@gmail.com", 
    address: "Chausse de Ninove", 
    city: "Bruges", …
  }
```

### :question: Request...
`DELETE - http://localhost:8000/user/delete`
### :heavy_minus_sign: Response...
```
  {
    message: "Account deleted"
  }
```
## Security in Back-end...
#### :lock::lock: &nbsp; <b>API security is mission-critical to digital businesses as it is the most-frequent attack vector for enterprise web applications data breaches</b> &nbsp; :lock::lock: <br /> 

* Security access control has been set up in different paths to restrict any request to the API in users' areas are done by not registered. <br/>
* Type Declarations in entities and each controller route, avoiding any data not required is passed on through the DDBB.<br/> 
* [JWT Authentication Bundle](https://github.com/lexik/LexikJWTAuthenticationBundle) Token authentication system to represent the user in a secure manner, configured by you to modify different features as wanted. 

## Doctrine Query Language...
[DQL](https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/dql-doctrine-query-language.html) is a very powerful way to raise queries as an object model, switching relationships between entities combining different types of clauses getting results with Entity manager.

### See below...

<b>With functions </b>: In Published Controller a search will be done to find a specific image in five different columns (2 parameters).

<div align="center">

![Screenshot 2021-04-01 at 17 44 59](https://user-images.githubusercontent.com/43299285/113319709-05be8b00-9312-11eb-96f6-85d5c84a3887.png)

</div>

<b>Without functions </b>: In Cars Repository the query is mixing tables info (4 tables) using join multiple passing a variable dynamically based on URL info.

<div align="center">

![Screenshot 2021-04-01 at 17 50 31](https://user-images.githubusercontent.com/43299285/113320396-c3497e00-9312-11eb-909e-de8640df5bf6.png)

</div>

## Creating Templates...
[Twig](https://symfony.com/doc/current/templates.html) is a modern template engine for PHP, it has been used by creating emails in two scenarios. First, when a user not registered in OldCar has published a car, confirming all details has been uploaded, and second for users who want to contact via email with OldCar Support and seller in each advert.

#### Have a look at...
<div align="center">

![Screenshot 2021-04-01 at 18 20 47](https://user-images.githubusercontent.com/43299285/113324095-fe4db080-9316-11eb-9c96-a61587451cd1.png)

</div>

## Installing..
* **Note that you should have installed PHP ^7.2.5 and composer to proceed with steps below**
* Clone the project to your local directory
* `$git clone https://github.com/JoseMMorales/OldCarAPI.git`
* `$cd OldCarAPI`
* `$composer install`
* `$php -S localhost:8000 -t public/` ([PHP Local Server](https://www.php.net/manual/en/features.commandline.webserver.php))

## :exclamation::exclamation: Please note :exclamation::exclamation: 
Just to advise that credentials at .env file are just being created to build the App, so it should be changed for you to use the repo accordingly with yours.

* <b>ROW 25:</b> Change DDBB details:<br />
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

* <b>ROW 39:</b> Change email account if you want to use Swift_Message in Gmail account:<br />
MAILER_URL=gmail://username:password@localhost

## Author
Jose MMorales
