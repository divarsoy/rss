# RSS
This is the `divarsoy/rss` repository. This project utilises `Laravel v5.8`.

## Setup Local Environment

### Initial Checks
Free ports: Please ensure that you're not running MySQL or any HTTP(s) server on your host machine. For example, if you already have MySQL or Apache running on your host machine you'll need to stop those services so the ports become available.

### Step 1: Prerequisites

- Install the [git tool](https://docs.github.com/en/free-pro-team@latest/github/getting-started-with-github/set-up-git) on your machine, if you don't have it already.
- Install [composer](https://getcomposer.org/).
- Clone this **divarsoyrss** repository on your machine, click [here](https://docs.github.com/en/free-pro-team@latest/github/creating-cloning-and-archiving-repositories/cloning-a-repository) for instructions.
- Install **[Docker for Desktop](https://www.docker.com/products/docker-desktop)** tool, for your OS.

:rocket: Great, we're almost there!

### Step 2: Provision environment
- Open command prompt / shell to the location where you cloned the repository `divarsoyrss`
- Type `docker-compose up` and it will start provisioning the environment
    - If this is the first time you're doing this it may take a while to download all required images from the internet and build these images on your machine.
    - Later runs will always be quicker.
- Add the host name `divarsoyrss.loc` to your hosts file. Read about [how to edit the file here](https://www.howtogeek.com/howto/27350/beginner-geek-how-to-edit-your-hosts-file/).
    - Add the line `127.0.0.1 divarsoyrss.loc` in the hosts file.
- Go to `https://divarsoyrss.loc/` in your browser and you should see the server responding but you might experience some SSL warnings and issues (see next - Step 3)

### Step 3: Import Certificate Authority (CA)
##### This needs to be done once only (when you initially clone/setup the project).
- In order to avoid any certificate warnings in the browser and to have a fully trusted certificate (validated by your local CA) please do the following:
  - Open new terminal window
  - Copy the CA file from container (while the containers are running from previous step) by issuing following command.
    - `docker cp divarsoy-rss:/ssl/divarsoyrssCA.pem ~/Desktop`
    - This will copy divarsoyrssCA.pem file from the container to your Desktop or you may use a different location in the command.
  - Then run the following command to import the divarsoyrssCA.pem as a trusted CA.
    - Adjust `~/Desktop/divarsoyrssCA.pem` in the following command if you saved the certificate file else where.
    - For mac `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ~/Desktop/divarsoyrssCA.pem`
    - For other platforms please follow [this guide](https://support.kerioconnect.gfi.com/hc/en-us/articles/360015200119)
- Once the certificate is imported visit `https://divarsoyrss.loc/` in your browser and you should get a green bar (with no certificate issues or warnings)

### Step 4: Environment Setup
In the terminal run the following commands
- CD into project repository folder
- Install composer dependencies run `docker exec -it divarsoy-rss composer install`
- To create .env file `docker exec -it divarsoy-rss php -r "file_exists('.env') || copy('.env.example', '.env');"`
- To generate app key `docker exec -it divarsoy-rss php artisan key:generate --ansi`
- To run migrations `docker exec -it divarsoy-rss php artisan migrate --seed`

Later on (during development) you can access artisan by running following command:
`docker exec -it divarsoy-rss php artisan`

### Step 5: Setup xDebug
- Open the IDE of your choice (PHPStorm preferred)
- Go to `PHP Storm Preferences > Languages & Frameworks > PHP > Servers` and configure as below:
![image](https://i.imgur.com/hV6niHp.png)
- Go to `Run > Edit Configurations` and configure as below:
![image](https://i.imgur.com/Dp5fBmp.png)
- Install browser debug helper extension
    - [Chrome extension](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc?hl=en)
    - [Firefox extension](https://addons.mozilla.org/en-GB/firefox/addon/xdebug-helper-for-firefox/)
- Configure extension's IDE key - it should say `PHPSTORM` as below
![image](https://i.imgur.com/N2ZkGiS.png/)
- Enable debug mode in browser (extension) and in PHP Storm listen for incoming connections
    - `Run > Start Listening for PHP Connections`
- Set a break point and visit the endpoint of interest and it should stop on the break point.  

## Connecting to MySQL Database
### Using Desktop Clients
The database can be connected to from host machine using any MySQL client installed e.g. MySQL Workbench, Sequel Pro etc. The settings for the MySQL client are:
Host: `localhost`
Port: `3306`
User: `docker`
Pass: `p3PA6343aBHZDjXv76du`
 
## Mail Catcher
Email sent by the PHP server/application are trapped in MailHog and the emails can be viewed at: http://localhost:8025/

## Useful Commands

Bring the environment up:
> `docker-compose up`

Destroy the environment:
> `docker-compose down`

Start environment (silent) without log tails:
> `docker-compose start`

Stop (but not destroy environment):
> `docker-compose stop`

SSH into the container(s):
> **For Webserver:** `docker exec -it divarsoy-rss /bin/sh`

> **For MySQL:** `docker exec -it divarsoy-rss-mysql /bin/sh`

Rebuild of environment (enforce rebuild image):
> `docker-compose up --build --force-recreate`

### Got questions?
Please speak to a member of the team for further help or assistance.