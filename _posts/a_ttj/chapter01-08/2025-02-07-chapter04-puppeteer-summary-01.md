---
layout: single
title:  "[ puppeteer] puppeteer 마스터하기"
categories: [ puppeteer]
tag: [ puppeteer ]
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



# puppeteer 및 nodejs 설치 및 기본



## 1. Node.js 설치

```bash
sudo yum install -y nodejs
```

## 2. Node.js 버전 확인

```bash
node -v
npm -v  // npm(Node Package Manager)은 nodejs 설치를 관리해 주는 프로그램
```

## 3. Puppeteer 설치(기본)

```bash
sudo ls npm install puppeteer
```

> puppeteer 설치 후 설치 확인 하는 방법
>
> ```bash
> npm list puppeteer
> ```
>
> 결과
>
> ```bash
> [ec2-user@ip-172-31-42-115 html]$ npm list puppeteer
> html@ /var/www/html
> └── puppeteer@24.2.0
> ```
>
> 



