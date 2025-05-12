# FilmHub

A web browser application to manage your video content locally 

## How to Install
### Linux 
- clone this repository 
- go inside the repository
- run ```sudo docker-compose up -d```
- run ```sudo docker-compose start```
- go to ```http://127.0.0.1:8083``` in your browser

### Windows

- Install xampp
- go inside the htdocs folder
- clone this repository inside htdocs
- start the apache server and mysql in xampp control panel
- go to ```http://localhost/phpmyadmin``` in you browser
- create a new database called "movies"
- click the databse and select import
- import the init.sql file in the sql_init folder
- go to ```http://localhost/filmhub/php```
