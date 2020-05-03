sudo apt-get update -y && sudo apt-get upgrade -y; 

if [-d "/var/www/html/PlantPro"];
	then sudo rm -rf /var/www/html/PlantPro;
fi

git clone https://github.com/rudiejd/PlantPro.git /var/www/html;
chmod 777 /var/www/html/PlantPro;

echo 'PlantPro up to date! Enjoy!';


