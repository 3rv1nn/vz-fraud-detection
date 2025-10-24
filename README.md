## VZ Fraud Detection
For this coding assignment, I have created a web application that scans and shows fraudulent 
customers. Customers are considered fraudulent when:
- they don't have a Dutch phone number
- are younger than 18 years old
- have an identical IBAN as other customers
- have an identical IP address as other customers

I was able to implement most things expected from the assignment, however I was unfortunately not able to write tests using Pen, cache the latest scan and to dockerize the web application.
Furthermore, I was not consistent with the naming convention of my Eloquent models, I couldn't get a POST request working, and I have missed an error handler for parsing dates. Also, the responsiveness of this web application could have been better.

If I had more time, I would:
- try to improve the code quality
- cache the scan results
- work further on the responsiveness of the web application
- focus on having the web application dockerized

It was my first time working with PHP and Laravel, and it was quite interesting to work with these technologies.

## How To Run The Project Locally
1. Add this .env file to the codebase (make sure to save this file)
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:RUtdw4rS41FOCUFu/No1xqmMwUq6YFx63FOghFQJjBg=
APP_DEBUG=true
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3304
DB_DATABASE=vz_fraud_detection
DB_USERNAME=root
DB_PASSWORD=S1249239!

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```
2. Run the command ```composer install```
3. Run the command ```npm install```
4. Run the command ```docker compose up -d```
5. Run the command ```php artisan migrate```
6. Run the command ```composer run dev```
7. Open the web application at ```http://localhost:8000```

## Screenshots
<img width="1918" height="921" alt="image" src="https://github.com/user-attachments/assets/42a1a0eb-8445-400a-a2e7-98059f6b14b4" />
<img width="1917" height="862" alt="image" src="https://github.com/user-attachments/assets/77bda839-0776-4133-9253-1dbd4969192e" />
<img width="1910" height="821" alt="image" src="https://github.com/user-attachments/assets/faa78755-d032-437f-a83a-7fba960272b2" />


