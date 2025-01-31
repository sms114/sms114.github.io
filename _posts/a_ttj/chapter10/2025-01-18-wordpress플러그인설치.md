---
layout: single
title:  "[wordpress]워드프레스 플러그인 설치"
categories: [wordpress]
tag: [ wordpress, plugin ]
author_profile: false
typora-root-url: ../
toc: true
toc_sticky: true
toc_label: "목차"
toc_icon: "fas fa-utensils" 
remove_sidebar: true
##sidebar:
##   nav: "counts"
search: true 우
---



## 워드프레스 플러그인 설치

### 1. Wordpress 플러그인 설치 > SSH SFTP Updater Support

* __download__ 해서 해당 파일을 압축 풀고, fillzilla 를 통해 Move 한다.
* 이 파일을 플로그인에서 다운 받지 말고, 아래 화면처럼 직접 download 버튼을 눌러, 받은 파일을 압축 받아서, fillzilla 로 
  /var/www/html/wp-content/plugin 에 붙여 넣는다.
  
  
  
  > **아래 sftp 플러그인 폴더명 : ssh-sftp-updater-support.1.0.0**
  >
  > 

![image-20250118162618358](/../images/2025-01-18-wordpress플러그인설치/image-20250118162618358.png)

![image-20250118162801269](/../images/2025-01-18-wordpress플러그인설치/image-20250118162801269.png)





### 2. plugin 폴더에 해당 플러그인 옮겨 놓고, 다시 한번 아래 linux 권한 설정을 처리 한다.(선택1)

#### 2-1 요약 - 파일권한설정

## **(요약)**

```bash
sudo chown -R ec2-user:apache /var/www
sudo usermod -a -G apache ec2-user
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
sudo chown ec2-user:apache /var/www/html/.htaccess

```

## **(참고 reference )**

#### 파일 권한 설정 ( <https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html>)

1. 사용자(이 경우는 `ec2-user`)를 `apache` 그룹에 추가합니다.

   ```
   [ec2-user ~]$ sudo usermod -a -G apache ec2-user
   ```

2. 로그아웃하고 다시 로그인한 다음, 새 그룹을 선택하고 멤버십을 확인합니다.

   1. 로그아웃합니다(**exit** 명령을 사용하거나 터미널 창 닫기).

      ```
      [ec2-user ~]$ exit
      ```

   2. `apache` 그룹의 멤버십을 확인하려면 인스턴스에 다시 연결한 후 다음 명령을 실행합니다.

      ```
      [ec2-user ~]$ groups
      ec2-user adm wheel apache systemd-journal
      ```

3. `/var/www` 및 그 콘텐츠의 그룹 소유권을 `apache` 그룹으로 변경합니다.

   ```
   [ec2-user ~]$ sudo chown -R ec2-user:apache /var/www
   ```

4. 그룹 쓰기 권한을 추가하여 나중에 하위 디렉터리에 대한 그룹 ID를 설정하려면 `/var/www`와 그 하위 디렉터리의 디렉터리 권한을 변경합니다.

   ```
   [ec2-user ~]$ sudo chmod 2775 /var/www && find /var/www -type d -exec sudo chmod 2775 {} \;
   ```

5. 그룹 쓰기 권한을 추가하려면 `/var/www` 및 그 하위 디렉터리의 파일 권한을 반복하여 변경합니다.

   ```
   [ec2-user ~]$ find /var/www -type f -exec sudo chmod 0664 {} \;
   ```



#### 2-2 .htacess  modify

**아래 .htaccess 로 파일 교체**


```bash
# BEGIN WordPress
# "BEGIN WordPress"와 "END WordPress" 사이의 지시문(줄)은 
# 동적으로 생성되며 워드프레스 필터를 통해서만 수정해야합니다. 
# 이 표시 사이의 지시문을 변경하면 덮어쓰게 됩니다.
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

```

>`.htaccess` 파일은 **Apache 웹 서버**에서 URL 재작성(Rewrite) 규칙을 설정하는 코드다. 주로 **워드프레스(WordPress)나 Laravel 같은 프레임워크에서 사용**되며, **SEO-friendly한 URL을 생성하거나 보안 설정을 강화**할 때 사용된다.

```apache
<IfModule mod_rewrite.c>
```

`mod_rewrite` 모듈이 활성화되어 있는지 확인하는 조건문.

`mod_rewrite.c`가 **설치되어 있고 사용할 수 있을 때만** 내부 코드를 실행함.

```apache
RewriteEngine On
```

**URL Rewrite 기능을 활성화**하는 명령어.

`mod_rewrite`가 동작하도록 허용하는 설정.

```
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
```

- `.*` → **모든 요청(URL 포함)**에 대해 적용됨.

- `-` → **URL 변경 없음 (rewrite 없이 원래 URL 그대로 사용)**

- ```
  [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
  ```

  - `HTTP_AUTHORIZATION` 헤더 값을 유지하도록 환경 변수(Environment Variable)를 설정하는 역할.
  - API 인증을 사용할 때, 특히 `Authorization` 헤더를 프록시 서버(Nginx, Apache)에서 유지하는 데 필요함.

```
RewriteBase /
```

- **Rewrite 규칙의 기준(base) 디렉토리**를 설정.
- `/`는 **사이트 루트 디렉토리에서 URL 재작성**이 수행된다는 의미.

```
RewriteRule ^index\.php$ - [L]
```

- `^index\.php$` → `index.php` 파일로 직접 접근하는 경우
- `-` → URL 변경 없이 그대로 둠 (Rewrite 안 함)
- `[L]` → 이 규칙이 **적용되면 다른 규칙들은 더 이상 실행되지 않음**

```
RewriteCond %{REQUEST_FILENAME} !-f
```

- `REQUEST_FILENAME` → 현재 요청된 파일
- `!-f` → 요청된 파일이 존재하지 **않는 경우**에만 다음 RewriteRule 실행

```
RewriteCond %{REQUEST_FILENAME} !-d
```

- `REQUEST_FILENAME` → 현재 요청된 폴더(디렉토리)
- `!-d` → 요청된 경로가 **디렉토리가 아닌 경우**에만 다음 RewriteRule 실행

```
RewriteRule . /index.php [L]
```

- `.` → **모든 요청을 의미**
- `/index.php` → 모든 요청을 `index.php`로 리디렉트 (즉, `index.php`가 요청을 처리하도록 함)
- `[L]` → 이 규칙이 적용되면 더 이상 다른 규칙 실행 안 함





### 3. 다른 플러그인, 예를 들어 rankmath ( Rank Math SEO ) 를 설치한다.

#### 3-1. 플러그인 검색에서 'rankmath'  

* 기설정한 SSH2 게정 정보를 입력하면 된다.
* 아래 Rank Math SEO 가 조금 쉽게 되어 있어 SEO 도구로서 유용한 플러그인이 될 것이다.

![image-20250118181714808](/../images/2025-01-18-wordpress플러그인설치/image-20250118181714808.png)

![image-20250118181810241](/../images/2025-01-18-wordpress플러그인설치/image-20250118181810241.png)



![image-20250118182359224](/../images/2025-01-18-wordpress플러그인설치/image-20250118182359224.png)

설치하면 된다. 나중에 사용해도 된다. 당장은 필요없다.



![image-20250118182912069](/../images/2025-01-18-wordpress플러그인설치/image-20250118182912069.png)

>  **RankMath 와 겹치는 부분도 있지만, 젯팩도 속도나 보안에 관한 내용이 있어서 같이 사용하면 효율을 높일 수 있을 것이다.**



## 서버 하나에 워드프레스 다수 운영하기



파일질라가 아닌, 쉘에서 압축 파일을 받아서, 서버에서 직접 풀어버리는 방법 
#### 튜토리얼: AL2 023에 WordPress 블로그 호스팅

<https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/hosting-wordpress-aml-2023.html>

#### 한국 워드프레스에서 wget 으로 받음.

![image-20250118191635035](/../images/2025-01-18-wordpress플러그인설치/image-20250118191635035.png)

```bash
$ wget https://ko.wordpress.org/latest-ko_KR.tar.gz
```

> zip 버전이 아닌, tar.gz 으로 받자.

##### 설치 패키지의 압축 및 아카이빙을 해제합니다. 설치 폴더는 `wordpress`라는 폴더로 압축 해제됩니다.

```bash
$ tar -xzf latest-ko_KR.tar.gz
```



![image-20250118192127762](/../images/2025-01-18-wordpress플러그인설치/image-20250118192127762.png)

풀고 나니, wordpress 폴더가 생겼다.

자 이제, /var/www 하위에 html 과 wordpress 두 개의 워드프레스 솔루션이 deploy 된 것이다.

자! 이렇게 두개의 워드프레스를 관리하려면, apache 서버에서 설정 셋팅을 해 줘야 한다.

```bash
$ /etc/httpd/conf.d 
```

에서 신규 conf 파일 생성 

```bash
$ cd /etc/httpd/conf.d
$ vi a.nurinet.biz.conf  // 반드시 .conf 확장자로 끝나야 함.
```



>* Apache는 기본적으로 /conf/httpd.conf 와 /conf.d/*.conf 를 사용하여 설정 파일을 관리하도록 설계되었다. 
>* 설정파일을 나눠 관리하면 표준을 따르면서도 유지 보수가 편리하다.
>* 따라서, 예를 들어, /conf.d/a.nurinet.biz.conf 로 만들어 특정 도메인의 설정을 관리하면 전역 설정과 충돌할 가능성을 줄일 수 있다.



##### 가상 호스트 정의 순서

1. Apache 는 가상 호스트 정의 순서에 따라 요청을 처리한다.
2. /conf.d 에서 먼저 로드된 가상 호스트가 기본 가상 호스트 역할을 할 수 있으므로, 기본 설정이 적용되길 원하는 도메인은 가장 먼저 정의하거나 ___ default_ __  로 설정해야 한다.

3. 가상 호스트별로 로그 파일 경로를 명시하여 로그가 섞이지 않도록 설정해야 한다.

4. HTTPS를 사용하는 경우, 각 도메인에 대한 SSL 설정(*:443)을 별도로 추가해야 한다.

   예) /conf.d/a.nurinet.biz-ssl.conf 를 만들어서 https 설정을 분리 관리한다.



#### 확장 예제

```bash
# /conf/httpd.conf
ServerRoot "/etc/httpd"
Listen 80

DocumentRoot "/var/www/default"
ServerName default.example.com

# Include additional configuration files
IncludeOptional conf.d/*.conf

<Directory "/var/www/default">
    AllowOverride None
    Require all granted
</Directory>
```

#### 새로운 도메인 추가

```bash
# /conf.d/makeurl.conf
<VirtualHost *:80>
    ServerName makeurl.com
    ServerAlias www.makeurl.com
    DocumentRoot /var/www/makeurl

    ErrorLog /var/log/httpd/makeurl_error.log
    CustomLog /var/log/httpd/makeurl_access.log combined
</VirtualHost>

```

#### HTTPS 설정(선택 사항)

```bash
# /conf.d/makeurl-ssl.conf
<VirtualHost *:443>
    ServerName makeurl.com
    DocumentRoot /var/www/makeurl

    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/makeurl.crt
    SSLCertificateKeyFile /etc/ssl/private/makeurl.key

    ErrorLog /var/log/httpd/makeurl_ssl_error.log
    CustomLog /var/log/httpd/makeurl_ssl_access.log combined
</VirtualHost>

```









