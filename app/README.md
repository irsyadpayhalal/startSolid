# TPA

## Setup

``` shell
touch .env && chmod 644 .env

echo "LOGIN_TYPE=standard
DB_HOST=mariadb
DB_USERNAME=tpa_user
DB_PASSWORD=tpa_user_password
DB_NAME=tpa
JWT_SECRET=" >> .env
```

To generate the JWT secret, run the following command:

``` shell
openssl rand -base64 48 | tr -dc 'A-Za-z0-9' | head -c 32
```

and paste the output as the value.

If you're on Windows, I don't know how tf to help you.

That's about it :D
