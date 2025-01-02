---
layout: single
title:  "[puppeteer] puppeteer 기본 문법 - 1"
categories: puppeteer
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

# Puppeteer 기본 문법

Puppeteer는 Node.js 환경에서 사용되는 고수준의 헤드리스 브라우저 자동화 라이브러리입니다. Puppeteer의 기본적인 문법을 통해 브라우저를 제어하고 페이지와 상호작용하는 방법을 설명합니다.

------

## Puppeteer 기본 구조

```javascript
const puppeteer = require('puppeteer');

(async () => {
    // Puppeteer 브라우저 인스턴스 생성
    const browser = await puppeteer.launch({
        headless: true, // true: 브라우저 UI를 숨김, false: UI를 표시
        args: ['--no-sandbox', '--disable-setuid-sandbox'] // 추가 설정
    });

    // 새 페이지 열기
    const page = await browser.newPage();

    // 특정 URL로 이동
    await page.goto('https://example.com', { waitUntil: 'load' });

    // 페이지에서 텍스트 추출
    const pageTitle = await page.title();
    console.log('페이지 제목:', pageTitle);

    // 특정 요소의 텍스트 추출
    const elementText = await page.$eval('h1', el => el.textContent.trim());
    console.log('H1 텍스트:', elementText);

    // 스크린샷 저장
    await page.screenshot({ path: 'screenshot.png', fullPage: true });

    // 브라우저 종료
    await browser.close();
})();

```

## Puppeteer 주요 메서드

### 브라우저 시작

```javascript
const browser = await puppeteer.launch({ headless: true });
```

* `headless`: `true`일 경우 UI 없이 백그라운드에서 실행.

* `args`: 브라우저 실행 시 추가 명령줄 옵션.

### 페이지 열기

```
const page = await browser.newPage();
```

- 새로운 탭을 엽니다.

------

### 페이지 이동

```
await page.goto('https://example.com', { waitUntil: 'load' });
```

- 특정 URL로 이동.

- ```
  waitUntil
  ```

   옵션:

  - `'load'`: 페이지 로드 완료 시점.
  - `'domcontentloaded'`: DOMContentLoaded 이벤트 발생 시점.
  - `'networkidle2'`: 네트워크 요청이 2초간 유휴 상태.