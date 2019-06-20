# intern2021_Summer_SegawaKouhei
# intern2021_Summer_SegawaKouhei

# check_apiの結果
```$shell
PS C:\SE\intern\2019_fringe_intern_scala\check_tool> .\check_api.exe http://127.0.0.1:8000
==== 正常パターンチェック ===

==== GET /posts リクエストチェック ===
レスポンスの詳細 :  {"result":"OK","posts":[{"id":"612A5977-286B-4A72-BC71-37630DF85338","user_id":"11111111-1111-1111-1111-111111111111","text":"have a good night!","comment_count":1,"parent_post_id":"64F87060-894F-4C18-B9DD-C82B4F2FB4A1","posted_at":"2019-06-20 14:15:31"},{"id":"64F87060-894F-4C18-B9DD-C82B4F2FB4A1","user_id":"11111111-1111-1111-1111-111111111111","text":"have a good night!","comment_count":1,"parent_post_id":null,"posted_at":"2019-06-20 14:15:30"}]}
成功

==== GET /posts/:post_id/comments リクエストチェック ===
レスポンスの詳細 :  {"result":"OK","comments":[]}
成功

==== POST /posts/create リクエストチェック ===
レスポンスの詳細 :  {"result":"OK"}
成功

==== POST /posts/:post_id/comments/create リクエストチェック ===
レスポンスの詳細 :  {"result":"OK"}
成功

==== 非正常パターンのチェック ===

==== POST /posts/create テキストの長さが0 ===
レスポンスの詳細 :  {"result":"NG","message":"text\u306f1\u6587\u5b57\u4ee5\u4e0a100\u6587\u5b57\u4ee5\u4e0b\u306b\u3057\u3066\u304f\u3060\u3055\u3044"}
成功

==== POST /posts/create テキストの長さが101 ===
レスポンスの詳細 :  {"result":"NG","message":"text\u306f1\u6587\u5b57\u4ee5\u4e0a100\u6587\u5b57\u4ee5\u4e0b\u306b\u3057\u3066\u304f\u3060\u3055\u3044"}
成功

==== POST /posts/create 存在しないuser_idを指定 ===
レスポンスの詳細 :  {"result":"NG","message":"\u30e6\u30fc\u30b6\u304c\u898b\u3064\u304b\u308a\u307e\u305b\u3093"}
成功

==== POST /posts/:post_id/comments/create テキストの長さが0 ===
レスポンスの詳細 :  {"result":"NG","message":"\u5b58\u5728\u3057\u306a\u3044post_id\u3067\u3059"}
成功

==== POST /posts/:post_id/comments/create テキストの長さが101 ===
レスポンスの詳細 :  {"result":"NG","message":"\u5b58\u5728\u3057\u306a\u3044post_id\u3067\u3059"}
成功

==== POST /posts/:post_id/comments/create 存在しないuser_idを指定 ===
レスポンスの詳細 :  {"result":"NG","message":"\u5b58\u5728\u3057\u306a\u3044user_id\u3067\u3059"}
成功

==== POST /posts/:post_id/comments/create 存在しないpost_idを指定 ===
レスポンスの詳細 :  {"result":"NG","message":"\u5b58\u5728\u3057\u306a\u3044post_id\u3067\u3059"}
成功

チェックをパスした数: 11/11
全てのチェックに成功しました.
PS C:\SE\intern\2019_fringe_intern_scala\check_tool>
```

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
php artisan migrate
php artisan serve
.\check_api.exe http://127.0.0.1:8000
```
