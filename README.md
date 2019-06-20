# intern2021_Summer_SegawaKouhei

# check_apiの結果
[check_result.txt](/check_result.txt)

# 実行環境
```
PHP7.3.5 +  10.3.14-MariaDB - mariadb.org binary distribution
> php -m
[PHP Modules]
bcmath
calendar
Core
ctype
curl
date
dom
fileinfo
filter
hash
iconv
imagick
intl
json
libxml
mbstring
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
Phar
readline
Reflection
session
SimpleXML
SPL
standard
tokenizer
wddx
xml
xmlreader
xmlwriter
zip
zlib

[Zend Modules]

```

# 実行方法
```
git clone https://github.com/f81/intern2021_Summer_SegawaKouhei
cd intern2021_Summer_SegawaKouhei
wget https://getcomposer.org/download/1.8.6/composer.phar
chmod +x composer.phar
php ./composer.phar install
cp .env.example .env
```

- .envに以下の例を参考にデータベース項目を変更
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=f81
DB_USERNAME=f81
DB_PASSWORD=f81
```

```
php artisan key:generate
php artisan migrate
php artisan serve
.\check_api.exe http://127.0.0.1:8000
```
