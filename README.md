# PlantPro
 Plant pro website using Laravel and Vue.js.
 
# Installation
 
 In order to install and run this website, you need to have the following installed:
 * PHP with composer
 * Node.js with NPM
 * MySQL
 * Laravel
 * Some sort of web server (you can use the default Laravel web server for testing purposes)
 
 
  I recommend running a virtual machine with Homestead and vagrant so you don't have to install all of this stuff on your regular machine. Laravel's tutorial on setting up Homestead can be found [here](https://laravel.com/docs/7.x/homestead). In order to set up everything, I recommend visiting [the installation section of the Laravel website](https://laravel.com/docs/7.x/installation).

  # Setup

  Once you have completed the installation, open MySQL on the machine you'll run PlantPro on. Create a new database titled PlantPro, and then navigate to the PlantPro folder and type `php artisan migrate`. This will run all of the Laravel migrations, which create the tables necessary for PlantPro to run. You should be served the website now. 
