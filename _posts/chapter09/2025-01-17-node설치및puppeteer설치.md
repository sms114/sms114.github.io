---
layout: single
title:  "[Summary] node & puppeteer & mysql 설치 가이드 "
categories: [ puppeteer ]
tag: [ puppeteer, mysql ]
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

## 



### Node.js 설치 

1. Node.js 소스 설치
   ```bash
   sudo yum install -y nodejs
   ```

2. Node.js 버전 확인
   ```bash
   node -v
   ```

### Puppeteer 설치

1. NPM (Node Package Manager)를 이용해 Puppeteer 설치

   ```bash
   cd /var/www/html
   npm install puppeteer
   
   ----------------------------------------------------------
   npm list puppeteer // puppeteer 의 버전을 확인 하는 방법 1
   npx puppeteer --version  // puppeteer 의 버전을 확인 하는 방법 2
   
   ```

   > 프로젝트 폴더로 이동 후 설치해야 함.

2. 라이브러리 설치
   ```bash
   sudo yum update -y
   
   sudo yum install -y pango.x86_64 libXcomposite.x86_64 libXcursor.x86_64 libXdamage.x86_64 libXext.x86_64 libXi.x86_64 libXtst.x86_64 cups-libs.x86_64 libXScrnSaver.x86_64 libXrandr.x86_64 alsa-lib.x86_64 atk.x86_64 gtk3.x86_64
   
   sudo yum install -y libdrm
   
   sudo yum install -y mesa-libgbm
   ```

   > npm 프로그램을 프로젝트 폴더로 이동해서 설치해야 함.



### Mysql 설치

1. NPM(Node Package manager)를 이용해 Mysql 설치

```bash
cd /var/www/html
npm install mysql
```

> npm 프로그램을 프로젝트 폴더로 이동해서 설치해야 함.