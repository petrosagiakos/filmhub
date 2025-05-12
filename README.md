# FilmHub

A web browser application to manage your video content locally 

## How to Install
### Linux 
- clone this repository 
- go inside the repository
- run ```bash sudo docker-compose up -d```
- run ```bash sudo docker-compose start```

### Windows

- Install xampp
- go inside the htdocs repository
- clone this repository inside htdocs
- start the apache server and mysql in xampp control panel
- go to ```bash http://localhost/phpmyadmin``` in you browser
- create a new database called "movies"
- click the databse and select import
- import the .sql.zip file in the sql/init folder
- go to ```bash http://localhost/filmhub/php```
