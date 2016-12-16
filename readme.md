# Leave Application System

Intended for leave application only. 
Manages the number of people on leave in a particular day.  

## Technologies Used

UI ==> Built using JavaScript ([Jeasyui framework](http://www.jeasyui.com/))  
Backend ==> [Laravel PHP Framework](https://laravel.com/)

### Installation 
#### Server Requirements
If you are not using **[Laravel Homestead]**(https://laravel.com/docs/5.3/homestead) , you will need to make sure your server meets the following requirements:  
	* PHP >= 5.6.4.  
	* OpenSSL PHP Extension.  
	* PDO PHP Extension.  
	* Mbstring PHP Extension.  
	* Tokenizer PHP Extension.  
	* XML PHP Extension.  
If you server meets the above requirements, then clone this app to your local directory.  
Using composer run `composer update` command to download the required packages.  
Create database and run the command `php artisan migrate` to set up the db.  
*Bingo!!!* You did it!! :punch:
