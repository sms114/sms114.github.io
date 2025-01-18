---
layout: single
title:  "[SSL] Amazon Linux 2023 SSL(Let’s encrypt) 적용"
categories: [ linux, ssl ]
tag: [ java ]
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

https://letsencrypt.org/ko/

**sudo su**

**dnf install openssl mod_ssl**

**sudo dnf install -y python3 augeas-libs pip**

**sudo python3 -m venv /opt/certbot/**

**ls /opt/certbot**

**sudo /opt/certbot/bin/pip install --upgrade pip**

**sudo /opt/certbot/bin/pip install certbot**

**sudo ln -s /opt/certbot/bin/certbot /usr/bin/certbot**

**sudo systemctl stop httpd**

sudo certbot certonly   - -  standalone**  ( - 작대기가 2개 임, 붙여져서 1개로 보임)

이메일입력, Y, N, 도메인입력

**sudo systemctl start httpd**

**sudo vi /etc/httpd/conf.d/ssl.conf**

<VirtualHost *:443> DocumentRoot "/var/www/html" ServerAlias [ttj2.tripbay.net](http://ttj2.tripbay.net/)

SSLEngine on SSLCertificateFile /etc/letsencrypt/live/ttj2.tripbay.net/cert.pem SSLCertificateKeyFile /etc/letsencrypt/live/ttj2.tripbay.net/privkey.pem SSLCertificateChainFile /etc/letsencrypt/live/ttj2.tripbay.net/chain.pem </VirtualHost>

**sudo systemctl restart httpd**

**sudo dnf install cronie-noanacron**

**sudo vi /etc/crontab**

```shell
30 1 * * 2 root /usr/bin/certbot renew --post-hook "systemctl reload httpd"
```

