---
layout: single
title:  "[virtualhost] VirtualHost 샘플 및 빠른 폴더 권한"
categories: [wordpress]
tag: [ server, linux, virtualhost, wordpress ]
author_profile: false
typora-root-url: ../
toc: true
toc_sticky: true
toc_label: "목차"
toc_icon: "fas fa-utensils" 
remove_sidebar: true
##sidebar:
##   nav: "counts"
search: true 
---

## 1. wordpress 다운로드

```bash
wget https://ko.wordpress.org/latest-ko_KR.tar.gz
```

```bash
tar -xzf latest-ko_KR.tar.gz
```

## 2. VirtualHost 샘플 

```shell
<VirtualHost *:80>
DocumentRoot /var/www/html
ServerName a.tripbay.net 
ServerAlias a.tripbay.net
<Directory "/var/www/html">
        Options FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
</Directory>
#RewriteEngine On
#RewriteCond %{HTTPS} off
#RewriteRule ^(.)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>
```

## 3. /var/www/ 및 이하 모든 디렉토리에 읽기, 쓰기, 실행 빠른 권한 설정

### 3-1. 2775(특수권한, 소유자권한, 그룹권한, 다른사용자권한)

```shell
sudo chmod 2775 /var/www && find /var/www -type d -print0 | sudo xargs -0 chmod 2775
```

### 3-2. 0664(특수권한, 소유자권한, 그룹권한, 다른사용자권한)

```shell
find /var/www -type f -print0 | sudo xargs -0 chmod 0664
```

