# Installation
This is a simple todo application that allows you create, view and delete tasks.

Follow this process below to install this todo application
* Clone project to your system
* Create database - **todo**
* Create a file **.env** in your base folder
* Run **composer update** on your terminal
* Copy the contents in the **.env.example** file to the **.env** file
* Edit **.env** file with your database settings
* Generate application key by running the command **php artisan key:generate**
* Run database migration with command - **php artisan migrate**
* Run application in you terminal using - **php artisan serve**
