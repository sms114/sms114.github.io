---
layout: single
title:  "[chapter09] chapter09. [Summary] 초고속 서버 셋팅  "
categories: [ chapter09]
tag: [ aws, 인스턴스, LAPM서버, phpMyAdmin설치  ]
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

### 세상에 공짜로 얻어지는 것은 없다.

#### 기본적으로, 좌절해본 사람만이 성공의 티켓을 가지고 있는 것.

chapter

## 9-2 AWS 에서 인스턴스 삭제 & 생성과 보안 그룹 설정

> 기타.

프리티어 aws 인스턴스 가격, 1대, 한달간 750시간 , 10대, 1대당 75시간, 10대 750시간 무료



>  인스턴수 유형별 사용 특징

1. __t2.medium__  30개 정도의 서버를 돌리고 있는데, 월 7만원 정도의 비용 발생 , 많게는 12만원.

2. __t2.large__ 한번에 많은 트래픽이 발생할 경우, t2.large 도 사용하기도 할 경우, 또는 많은 DB를 사용해야 할 경우는 이 유형 쓰기도 함.
   일반적으로는 이 유형은 사용 필요없음.

> 인스턴스 만들때 체크 사항

* 인바운드, 아웃바운드 규칙 편집  및 추가
  - 유형별 체크 후 추가 할 것 : 모든 트래픽 , SSH
  - 하드웨어적인 사항 강화하는 것

> 탄력적 IP 할당도 체크

* AWS에서 보유하고 있는 IP를 즉각적으로 할당 받기 



## 9-3. 쉘접속과 LAPM, phpMyAdmin 설치

> Amazon > 설명서> Amazon Linux 2023 > 사용자가이드 참조.

튜토리얼 : AL2 023에 LAMP 서버 설치 url 

< https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html > 

###### Tasks

- [1단계: 서버 준비 LAMP](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html#prepare-lamp-server-2023)
- [2단계: LAMP 서버 테스트](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html#test-lamp-server-2023)
- [3단계: 데이터베이스 서버 보안 설정](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html#secure-mariadb-lamp-server-2023)
- [4단계: (선택 사항) 설치 phpMyAdmin](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html#install-phpmyadmin-lamp-server-2023)

### LAMP서버 준비하기

1. 인스턴스에 연결합니다. 자세한 내용은 [AL2023 인스턴스에 연결](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/connecting-to-instances.html) 단원을 참조하십시오.

2. 모든 소프트웨어 패키지가 최신 상태로 업데이트되어 있는지 확인하기 위해, 인스턴스에서 퀵 소프트웨어 업데이트를 실행합니다. 이 과정은 몇 분 정도 시간이 소요될 수 있지만, 최신 보안 업데이트와 버그 수정이 있는지 확인하는 것이 중요합니다.

   `-y` 옵션을 사용하면 확인 여부를 묻지 않고 업데이트를 설치합니다. 설치 전에 업데이트 정보를 확인하려면 이 옵션을 생략합니다.

   ```
   [ec2-user ~]$ sudo dnf upgrade -y
   ```

3. AL2023용 최신 버전의 Apache 웹 서버 및 PHP 패키지를 설치합니다.

   ```
   [ec2-user ~]$ sudo dnf install -y httpd wget php-fpm php-mysqli php-json php php-devel
   ```

4. 소프트웨어 패키지 MariaDB를 설치합니다. **dnf install** 명령을 사용하여 여러 소프트웨어 패키지와 모든 관련 종속 프로그램을 동시에 설치합니다.

   ```
   [ec2-user ~]$ sudo dnf install mariadb105-server
   ```

   다음 명령을 사용하여 이러한 패키지의 현재 버전을 볼 수 있습니다.

   ```
   [ec2-user ~]$ sudo dnf info package_name
   ```

   예제:

   ```
   [root@ip-172-31-25-170 ec2-user]# dnf info mariadb105
   Last metadata expiration check: 0:00:16 ago on Tue Feb 14 21:35:13 2023.
   Installed Packages
   Name         : mariadb105
   Epoch        : 3
   Version      : 10.5.16
   Release      : 1.amzn2023.0.6
   Architecture : x86_64
   Size         : 18 M
   Source       : mariadb105-10.5.16-1.amzn2023.0.6.src.rpm
   Repository   : @System
   From repo    : amazonlinux
   Summary      : A very fast and robust SQL database server
   URL          : http://mariadb.org
   License      : GPLv2 and LGPLv2
   Description  : MariaDB is a community developed fork from MySQL - a multi-user, multi-threaded
                : SQL database server. It is a client/server implementation consisting of
                : a server daemon (mariadbd) and many different client programs and libraries.
                : The base package contains the standard MariaDB/MySQL client programs and
                : utilities.
   ```

5. Apache 웹 서버를 시작합니다.

   ```
   [ec2-user ~]$ sudo systemctl start httpd
   ```

6. **systemctl** 명령을 사용하여 Apache 웹 서버가 매번 시스템이 부팅할 때마다 시작되도록 합니다.

   ```
   [ec2-user ~]$ sudo systemctl enable httpd
   ```

   다음 명령을 실행하여 **httpd**가 실행되고 있는지 확인할 수 있습니다.

   ```
   [ec2-user ~]$ sudo systemctl is-enabled httpd
   ```

7. 인스턴스에 대한 인바운드 HTTP (포트 80) 연결을 허용하는 보안 규칙을 아직 추가하지 않았다면 추가하세요. 기본적으로 **시작 마법사는 다음과 같습니다.`N`**시작 중에 인스턴스에 대한 보안 그룹이 생성되었습니다. 보안 그룹 규칙을 추가하지 않은 경우 이 그룹에는 SSH 연결을 허용하는 단일 규칙만 포함됩니다.

   1. 에서 Amazon EC2 콘솔을 엽니다 https://console.aws.amazon.com/ec2/.

   2. 탐색 창에서 **인스턴스(Instances)**를 선택하고 인스턴스를 선택합니다.

   3. **보안** 탭에서 인바운드 규칙을 확인합니다. 다음과 같은 규칙이 표시되어야 합니다.

      ```
      Port range   Protocol     Source
      22           tcp          0.0.0.0/0
      ```

      

      ###### 주의

      를 `0.0.0.0/0` 사용하면 모든 IPv4 주소가 를 사용하여 인스턴스에 액세스할 수 SSH 있습니다. 테스트 환경에서 잠시 사용하는 것은 괜찮지만 프로덕션 환경에서는 안전하지 않습니다. 프로덕션에서는 특정 IP 주소나 주소 범위만 인스턴스에 액세스하도록 허용하세요.

   4. HTTP(포트 80) 연결을 허용하는 인바운드 규칙이 없는 경우 지금 규칙을 추가해야 합니다. 보안 그룹에 대한 링크를 선택합니다. [Linux 인스턴스의 인바운드 트래픽 권한 부여의](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/authorizing-access-to-an-instance.html) 절차를 사용하여 다음 값이 포함된 새 인바운드 보안 규칙을 추가합니다.

      - **다음을 입력합니다.** HTTP
      - **프로토콜**: TCP
      - **포트 범위**: 80
      - **소스**: 사용자 지정

8. 웹 서버를 테스트합니다. 웹 브라우저에서 인스턴스의 퍼블릭 DNS 주소 (또는 퍼블릭 IP 주소) 를 입력합니다. `/var/www/html`에 콘텐츠가 없으면 "**It works!**"라는 메시지를 보여 주는 Apache 테스트 페이지가 표시됩니다.

   **Amazon EC2 콘솔을 사용하여 인스턴스를 DNS 공개할 수 있습니다 (\**Public IPv4 DNS\** 열을 확인하고, 이 열이 숨겨져 있으면 \**Preferences\** (톱니바퀴 모양 아이콘) 을 선택하고 Public으로 전환하십시오). IPv4 DNS**

   인스턴스의 보안 그룹에 포트 80에서의 HTTP 트래픽을 허용하는 규칙이 포함되어 있는지 확인하십시오. 자세한 내용은 [보안 그룹에 규칙 추가를](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/working-with-security-groups.html#adding-security-group-rule) 참조하십시오.

   

   ###### 중요

   Amazon Linux를 사용하지 않는 경우, 이러한 연결을 허용하도록 인스턴스에서 방화벽을 구성해야 할 수도 있습니다. 방화벽 구성 방법에 대한 자세한 내용은 사용자의 특정 배포에 대한 문서를 참조하세요.

Apache **httpd**는 Apache document root라는 디렉터리에 보관된 파일을 처리합니다. Amazon Linux Apache 문서 루트는 `/var/www/html`이며, 기본적으로 루트에서 소유합니다.

`ec2-user` 계정에서 이 디렉터리의 파일을 조작할 수 있게 하려면 디렉터리의 소유권과 권한을 변경해야 합니다. 이 작업을 수행하는 방법에는 여러 가지가 있습니다. 본 자습서에서는 `ec2-user`를 `apache` 그룹에 추가하여 `apache` 그룹에 `/var/www` 디렉터리의 소유권을 부여하고 쓰기 권한을 할당합니다.

### 파일 권한 설정

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



### 2단계: LAMP 서버 테스트



서버가 설치되어 실행 중이고 파일 권한이 올바르게 설정되어 있다면 해당 `ec2-user` 계정으로 인터넷에서 사용할 수 있는 `/var/www/html` 디렉터리에 PHP 파일을 만들 수 있을 것입니다.

###### LAMP서버를 테스트하려면

1. Apache 문서 루트에 PHP 파일을 생성합니다.

   ```
   [ec2-user ~]$ echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
   ```

   이 명령을 실행하는 동안 "Permission denied" 오류가 발생하면, 로그아웃하고 다시 로그인한 다음, [파일 권한 설정](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/ec2-lamp-amazon-linux-2023.html#setting-file-permissions-2023)에서 구성한 적절한 그룹 권한을 선택합니다.

2. 웹 URL 브라우저에 방금 만든 파일을 입력합니다. 이 URL 주소는 인스턴스의 퍼블릭 DNS 주소 뒤에 슬래시와 파일 이름이 붙습니다. 예:

   ```
   http://my.public.dns.amazonaws.com/phpinfo.php
   ```

   PHP정보 페이지가 표시되어야 합니다.

   ![LAMP서버 테스트 결과 PHP 정보 페이지가 표시됩니다.](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/images/php-8.1.7-2022.png)

   

   이 페이지가 보이지 않을 경우 이전 단계에서 `/var/www/html/phpinfo.php` 파일이 제대로 생성되었는지 확인하세요. 또한 다음 명령을 사용하여 필수 패키지가 모두 설치되었는지도 확인할 수 있습니다.

   ```
   [ec2-user ~]$ sudo dnf list installed httpd mariadb-server php-mysqlnd
   ```

   출력에서 필요한 패키지가 하나라도 나열되지 않으면, **sudo yum install `package`** 명령을 사용하여 패키지를 설치합니다.

3. `phpinfo.php` 파일을 삭제합니다. 이 파일은 유용한 정보를 포함하고 있지만 보안상 이유로 인터넷에 공개되어서는 안 됩니다.

   ```
   [ec2-user ~]$ rm /var/www/html/phpinfo.php
   ```

이제 모든 기능을 갖춘 LAMP 웹 서버가 생겼을 것입니다. Apache 문서 루트 위치에 콘텐츠를 추가하면 인스턴스의 공개 DNS 주소에서 해당 콘텐츠를 볼 수 있어야 합니다. `/var/www/html`

### 3단계: 데이터베이스 서버 보안 설정

MariaDB 서버의 기본 설치는 테스트 및 개발 기능에 유용한 여러 기능을 포함하고 있지만, 이 기능들은 프로덕션 서버에서는 비활성화되거나 제거되어야 합니다. **mysql_secure_installation** 명령을 통해 루트 암호를 설정하고 설치 패키지에서 보안성이 낮은 기능을 제거하는 과정을 수행할 수 있습니다. MariaDB 서버를 사용할 계획이 없더라도 이 절차를 수행하는 것이 좋습니다.

###### MariaDB 서버의 보안을 유지하려면

1. MariaDB 서버를 시작합니다.

   ```
   [ec2-user ~]$ sudo systemctl start mariadb
   ```

2. **mysql_secure_installation**를 실행합니다.

   ```
   [ec2-user ~]$ sudo mysql_secure_installation
   ```

   1. 암호를 입력하라는 메시지가 표시되면 루트 계정의 암호를 입력합니다.

      1. 현재 루트 암호를 입력합니다. 기본적으로 root 계정에는 암호가 없습니다. Enter를 누릅니다.

      2. 암호를 설정하려면 `Y`를 누른 후 안전한 암호를 두 번 입력합니다. 보안 암호 생성에 대한 자세한 내용은 을 참조하십시오 https://identitysafe.norton.com/password-generator/. 이 암호를 안전한 장소에 보관하시기 바랍니다.

         MariaDB에 대한 루트 암호를 설정하는 것은 데이터베이스를 보호하는 가장 기초적인 방법일 뿐입니다. 데이터베이스 기반 애플리케이션을 빌드하거나 설치할 때, 일반적으로 그 애플리케이션의 데이터베이스 서비스 사용자를 만들고 데이터베이스 관리 이외의 어떤 목적으로도 루트 계정을 사용하지 못하게 합니다.

   2. `Y`를 눌러서 익명 사용자 계정을 제거합니다.

   3. `Y`를 입력하여 원격 루트 로그인을 비활성화합니다.

   4. `Y`를 눌러서 테스트 데이터베이스를 제거합니다.

   5. `Y`를 눌러서 권한 테이블을 다시 로드하고 변경사항을 저장합니다.

3. (선택 사항) 지금 바로 사용할 계획이 아니라면 MariaDB 서버를 중지합니다. 필요할 때 다시 시작할 수 있습니다.

   ```
   [ec2-user ~]$ sudo systemctl stop mariadb
   ```

4. (선택 사항) 부팅 시 MariaDB 서버가 시작되도록 하려면 다음 명령을 입력합니다.

   ```
   [ec2-user ~]$ sudo systemctl enable mariadb
   ```

### 4단계: (선택 사항) 설치 phpMyAdmin

[phpMyAdmin](https://www.phpmyadmin.net/)EC2인스턴스의 내 SQL 데이터베이스를 보고 편집하는 데 사용할 수 있는 웹 기반 데이터베이스 관리 도구입니다. Amazon Linux 인스턴스에서 `phpMyAdmin`을 설치 및 구성하려면 다음 단계를 따르세요.



###### 중요

TLSApache에서 SSL /를 활성화하지 않는 한 LAMP 서버에 액세스하는 `phpMyAdmin` 데 사용하지 않는 것이 좋습니다. 그렇지 않으면 데이터베이스 관리자 암호와 기타 데이터가 인터넷을 통해 안전하지 않게 전송됩니다. 개발자의 보안 권장 사항은 설치 [보안을 phpMyAdmin ](https://docs.phpmyadmin.net/en/latest/setup.html#securing-your-phpmyadmin-installation) 참조하십시오. EC2인스턴스의 웹 서버 보안에 대한 일반 정보는 을 참조하십시오[자습서: AL2023에서 SSL/TLS 구성](https://docs.aws.amazon.com/ko_kr/linux/al2023/ug/SSL-on-amazon-linux-2023.html).

###### 설치하려면 phpMyAdmin

1. 필요한 종속 항목을 설치합니다.

   ```
   [ec2-user ~]$ sudo dnf install php-mbstring php-xml -y
   ```

2. Apache를 다시 시작합니다.

   ```
   [ec2-user ~]$ sudo systemctl restart httpd
   ```

3. `php-fpm`을 다시 시작합니다.

   ```
   [ec2-user ~]$ sudo systemctl restart php-fpm
   ```

4. Apache 문서 루트(`/var/www/html`)로 이동합니다.

   ```
   [ec2-user ~]$ cd /var/www/html
   ```

5. https://www.phpmyadmin.net/downloads 에서 최신 phpMyAdmin 릴리스의 소스 패키지를 선택합니다. 인스턴스로 파일을 직접 다운로드하려면 다음 예제와 같이 링크를 복사한 후 **wget** 명령에 붙여 넣습니다.

   ```
   [ec2-user html]$ wget https://www.phpmyadmin.net/downloads/phpMyAdmin-latest-all-languages.tar.gz
   ```

6. `phpMyAdmin` 폴더를 생성하고 다음 명령을 사용하여 해당 폴더로 패키지의 압축을 풉니다.

   ```
   [ec2-user html]$ mkdir phpMyAdmin && tar -xvzf phpMyAdmin-latest-all-languages.tar.gz -C phpMyAdmin --strip-components 1
   ```

7. 삭제 `phpMyAdmin-latest-all-languages.tar.gz` 타르볼.

   ```
   [ec2-user html]$ rm phpMyAdmin-latest-all-languages.tar.gz
   ```

8. (선택 사항) 내 SQL 서버가 실행되고 있지 않으면 지금 시작하세요.

   ```
   [ec2-user ~]$ sudo systemctl start mariadb
   ```

9. 웹 브라우저에 phpMyAdmin 설치 URL 내용을 입력합니다. URL이는 인스턴스의 퍼블릭 DNS 주소 (또는 퍼블릭 IP 주소) 이고 그 뒤에 슬래시와 설치 디렉터리 이름이 붙습니다. 예:

   ```
   http://my.public.dns.amazonaws.com/phpMyAdmin
   ```

   phpMyAdmin 로그인 페이지가 표시되어야 합니다.













