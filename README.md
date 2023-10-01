<center style='font-size:25px'>
    <b>IP MANAGEMENT SOLUTION</b>
</center>

### **🔭Scope:**
<p>
IP management solution could be storing IP information (ex: 202.92.249.111 is the ‘BFBC2` server ) and updating existing IP records. IP management solution tracks every IP stored and updated data history.
</p>



## **Install application using docker:**
Make sure to have following dependencies installed <br>
	    - Docker (https://docs.docker.com/get-docker/) <br><br>



<b>Create docker external network to future connected</b>

```bash
docker network create --subnet=10.10.10.0/24 --gateway=10.10.10.1 ad-common-network
```
<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-ip-managment.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp src/.env.example src/.env
 docker-compose build
 docker-compose up -d
```

<br><b>Enter docker container </b>
```bash
 docker exec -it ad_ip_management bash
```

<br><b>Run following command in docker container </b>
```bash
 composer install
 php artisan migrate
 exit
```

<br><b>Check application info below</b>


### **Manual installation:**
Make sure to have following dependencies installed <br>
	- PHP >- 7.4 <br>
 	- MYSQL <br>
  	- composer 2<br>

<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-ip-managment.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp src/.env.example src/.env
```
<br><b>Modify .env to connect database following information</b>
```env
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=ad_ip_management
DB_USERNAME=root
DB_PASSWORD=secret
```
<br><b>Run following command to run application</b>
```env
composer install
php artisan migrate
php artisan serve --port  4001
```
### **🌱 Application info:**
```env
App_URL: http://localhost:4001/
```

### **🌱 Database info when you use docker installation**
```env
Host: localhost
Port:33067
Username: root
Password: secret

```
