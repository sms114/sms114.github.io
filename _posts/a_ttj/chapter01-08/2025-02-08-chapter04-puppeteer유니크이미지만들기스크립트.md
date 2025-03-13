---
layout: single
title:  "[ puppeteer] puppeteer유니크이미지만들기스크립트"
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



# puppeteer유니크 이미지 만들기 script

결국, 이미지에 포함된 한글은 추출해내지 못했다. 하지만 class 요소를 지정해서 해당 유니크 이미지를 가져오는 것은 큰 문제없이 가져온다. 오랜 시간이 걸리며 학습한 퍼페티어의 라인별 지식은 큰 도움이 될 것이다. 답을 찾아나가는 것이 중요하다는 믿음을 가지자. 결국 눈에 익어야 한 줄 한 줄 검증이 가능한 것. 조바심을 내지 말고, 천천히 온전하게 나아가면 된다. 그것뿐이다.

```js
const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

(async () => {    // 비동기 실행 함수 ( async IIFE )
    const browser = await puppeteer.launch({
        headless: 'new',
        executablePath: '/usr/bin/google-chrome',
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-web-security',
            '--disable-features=IsolateOrigins,site-per-process',
            '--disable-extensions',
            '--disable-features=BlockInsecurePrivateNetworkRequests'
        ]
    });

    const page = await browser.newPage();  //새로운 브라우저 탭(페이지)를 생성.

    // 최신 User-Agent 설정 //봇 감지를 방지하기 위해 일반 브라우저처럼 속임. Chrome/120.0.0.0 → 최신 크롬 브라우저로 위장.
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

    // 요청 차단 방지 
req.continue(); → Puppeteer가 특정 요청을 차단하지 않고 계속 진행하도록 설정.
    await page.setRequestInterception(true);  //웹사이트가 광고 또는 크롤러 차단을 시도할 경우 모든 요청을 수동으로 처리.
    page.on('request', (req) => {
        if (['image', 'stylesheet', 'font', 'script', 'xhr', 'fetch', 'eventsource'].includes(req.resourceType())) {
            req.continue();  // 모든 요청 허용 , Puppeteer가 특정 요청을 차단하지 않고 계속 진행하도록 설정.
        } else {
            req.continue();
        }
    });

    // 추가적인 헤더 설정 , Accept-Language → 웹사이트가 한국어 페이지를 제공하도록 유도.
    // Referer: https://www.google.com/ → 구글에서 방문한 것처럼 속이기 (크롤링 탐지 방지).
    await page.setExtraHTTPHeaders({
        'Accept-Language': 'ko-KR,ko;q=0.9,en-US,en;q=0.8',
        'Referer': 'https://www.google.com/',
    });

    // 페이지 이동
    // URL에 한글이 포함될 경우 올바르게 인코딩하여 요청.
    // waitUntil: 'networkidle2' → 네트워크 요청이 거의 없는 상태일 때 페이지가 완전히 로드되었다고 판단.
    // timeout: 60000 → 최대 60초 동안 응답 대기
    const url = encodeURI('http://tripworldgo.net/이미지.html');
    await page.goto(url, {
        waitUntil: 'networkidle2',
        timeout: 60000
    });

    // ✅ .img99 요소가 로드될 때까지 기다림
    await page.waitForSelector('.img99', { timeout: 10000 });

    // ✅ `.img99` 요소의 HTML 코드 가져오기
    const extractedHtml = await page.evaluate(() => {
        const img99Element = document.querySelector('.img99');
        return img99Element ? img99Element.outerHTML : "❌ .img99 요소를 찾을 수 없음";
    });

    console.log("📌 추출된 HTML 코드:\n", extractedHtml);

    // ✅ HTML 파일로 저장 .img99 요소의 HTML을 img99_preview.html 파일로 저장.
    const htmlFilePath = path.join(__dirname, 'img99_preview.html');
    const finalHtml = `<!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>img99 Preview</title>
            <style>
                body { margin: 0; padding: 20px; background-color: #f5f5f5; text-align: center; }
                .container { display: flex; justify-content: center; align-items: center; height: 100vh; }
            </style>
        </head>
        <body>
            <div class="container">
                ${extractedHtml}
            </div>
        </body>
        </html>`;

    fs.writeFileSync(htmlFilePath, finalHtml, 'utf8');
    console.log("✅ HTML 파일 저장 완료:", htmlFilePath);

    // ✅ 새 페이지에서 저장된 HTML 열기
    const newPage = await browser.newPage();
    await newPage.goto(`file://${htmlFilePath}`, { waitUntil: 'networkidle2' });

    const element =await newPage.$('.img99'); // .img99 요소선택
    const boundingBox = await element.boundingBox(); // 요소의 위치 및 크기 가져오기

    // .img99 요소의 크기와 위치를 기준으로 요소만 캡처하여 element.png로 저장.
    await newPage.screenshot({
        path: 'element.png',
        clip: {
            x: boundingBox.x,
            y: boundingBox.y,
            width: Math.min(boundingBox.width, newPage.viewport().width),
            height: Math.min(boundingBox.height, newPage.viewport().height)
        }
    }) // clip 옵션을 사용하여 요소의 위치 및 크기로 스크린샷 캡처

    await browser.close();
})();

```



## 1. 해석 

```javascript
const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');
```

- **`puppeteer`**: 웹 자동화를 위한 Puppeteer 모듈을 불러옴.
- **`fs`**: HTML 파일을 생성하고 저장하기 위해 Node.js의 파일 시스템 모듈 사용.
- **`path`**: 파일 경로를 다루기 위해 Node.js의 `path` 모듈 사용.



## 2. 해석

```javascript
const browser = await puppeteer.launch({
    headless: 'new',
    executablePath: '/usr/bin/google-chrome',
    args: [
        '--no-sandbox',
        '--disable-setuid-sandbox',
        '--disable-web-security',
        '--disable-features=IsolateOrigins,site-per-process',
        '--disable-extensions',
        '--disable-features=BlockInsecurePrivateNetworkRequests'
    ]
});
```

**Puppeteer를 실행하여 크롬 브라우저를 띄움.**

`headless: 'new'` → 최신 Puppeteer의 **헤드리스 모드 사용** (GUI 없이 실행).

`executablePath: '/usr/bin/google-chrome'` → **리눅스/EC2 환경에서 크롬 실행 경로 지정**.

`args` 옵션 설명:

- `--no-sandbox`, `--disable-setuid-sandbox` → **보안 샌드박스를 비활성화** (EC2 등 서버 환경에서 필요).
- `--disable-web-security` → **CORS 문제를 무시하고 모든 리소스를 로드**.
- `--disable-features=IsolateOrigins,site-per-process` → **사이트 간 격리 기능을 비활성화**.
- `--disable-extensions` → **브라우저 확장 프로그램을 비활성화**.
- `--disable-features=BlockInsecurePrivateNetworkRequests` → **보안 정책에 의해 차단되는 요청을 허용**.

## 결과물

[img99_preview.html](/../../images/2025-02-08-chapter04-puppeteer유니크이미지만들기스크립트/image-20250208214354015.png)

![element.png](/../../images/2025-02-08-chapter04-puppeteer유니크이미지만들기스크립트/image-20250208214428618.png)





# 최종적, 한글까지 포함된 이미지가 나오는 코드 메모

대상 타킷 이미지>

![image-20250208222712263](/../../images/2025-02-08-chapter04-puppeteer유니크이미지만들기스크립트/image-20250208222712263.png)

위에서 처럼 잘 가지고 왔다.

그래서, 최종 코드는 다음과 같다.

```js
const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        executablePath: '/usr/bin/google-chrome',
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-web-security',
            '--disable-features=IsolateOrigins,site-per-process',
            '--disable-extensions',
            '--disable-features=BlockInsecurePrivateNetworkRequests'
        ]
    });

    const page = await browser.newPage();

    // 최신 User-Agent 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

    // 요청 차단 방지
    await page.setRequestInterception(true);
    page.on('request', (req) => {
        req.continue();  // 모든 요청 허용
    });

    // 추가적인 헤더 설정
    await page.setExtraHTTPHeaders({
        'Accept-Language': 'ko-KR,ko;q=0.9,en-US,en;q=0.8',
        'Referer': 'https://www.google.com/',
    });

    // 페이지 이동
    const url = encodeURI('http://tripworldgo.net/이미지.html');
    await page.goto(url, {
        waitUntil: 'networkidle2',
        timeout: 60000
    });

    // 모든 폰트가 로드될 때까지 대기
    await page.evaluate(async () => {
        await document.fonts.ready;
        document.body.style.visibility = 'visible';
    });

    // 전체 페이지 스크린샷 찍기
    const fullScreenshotPath = path.join(__dirname, 'full_page.png');
    await page.screenshot({ path: fullScreenshotPath, fullPage: true });
    console.log(`✅ 전체 페이지 캡처 완료: ${fullScreenshotPath}`);

    // 특정 요소가 로드될 때까지 기다림
    await page.waitForSelector('.img2', { timeout: 10000 });

    // 특정 요소의 위치 가져오기 및 스크린샷 캡처
    const element = await page.$('.img2');
    if (element) {
        const box = await element.boundingBox();
        if (box) {
            const elementScreenshotPath = path.join(__dirname, 'img2_capture.png');
            await page.screenshot({
                path: elementScreenshotPath,
                clip: {
                    x: box.x,
                    y: box.y,
                    width: box.width,
                    height: box.height
                }
            });
            console.log(`✅ 특정 요소 캡처 완료: ${elementScreenshotPath}`);
        }
    } else {
        console.log("❌ 요소를 찾을 수 없음: .img2");
    }

    await browser.close();
})();

```



한글 코드를 맥이는 방법에서 좀 애를 먹었다.



1. **내가 쓰는 서버는 Amazon EC2 2023 이며, 그래서 해당 서버의 기본 패키지 저장소에 한글 폰트 패키지가 포함되어 있지 않을 수 있어 나눔 폰트를 수동으로 다운로드 설치해야 했다.**

   ```bash
   cd /usr/share/fonts
   sudo wget http://cdn.naver.com/naver/NanumFont/fontfiles/NanumFont_TTF_ALL.zip
   sudo unzip NanumFont_TTF_ALL.zip
   sudo rm NanumFont_TTF_ALL.zip
   ```

   결과 > 

   ![image-20250208223108538](/../../images/2025-02-08-chapter04-puppeteer유니크이미지만들기스크립트/image-20250208223108538.png)



2. 폰트 캐시 갱신: 
   ```bash
   sudo fc-cache -f -v
   ```

3. 최종 코드 수정 ( 파일명 : screen.js ) ( ✅ 특정 요소 캡처 완료: /var/www/html/img2_capture.png)
   ```js
   const puppeteer = require('puppeteer');
   const fs = require('fs');
   const path = require('path');
   
   (async () => {
       const browser = await puppeteer.launch({
           headless: true,
           executablePath: '/usr/bin/google-chrome',
           args: [
               '--no-sandbox',
               '--disable-setuid-sandbox',
               '--disable-web-security',
               '--disable-features=IsolateOrigins,site-per-process',
               '--disable-extensions',
               '--disable-features=BlockInsecurePrivateNetworkRequests'
           ]
       });
   
       const page = await browser.newPage();
   
       // 최신 User-Agent 설정
       await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
   
       // 요청 차단 방지
       await page.setRequestInterception(true);
       page.on('request', (req) => {
           req.continue();  // 모든 요청 허용
       });
   
       // 추가적인 헤더 설정
       await page.setExtraHTTPHeaders({
           'Accept-Language': 'ko-KR,ko;q=0.9,en-US,en;q=0.8',
           'Referer': 'https://www.google.com/',
       });
   
       // 페이지 이동
       const url = encodeURI('http://tripworldgo.net/이미지.html');
       await page.goto(url, {
           waitUntil: 'networkidle2',
           timeout: 60000
       });
   
       // 모든 폰트가 로드될 때까지 대기
       await page.evaluate(async () => {
           await document.fonts.ready;
           document.body.style.visibility = 'visible';
       });
   
       // 특정 요소가 로드될 때까지 기다림
       await page.waitForSelector('.img2', { timeout: 10000 });
   
       // 특정 요소의 위치 가져오기 및 스크린샷 캡처
       const element = await page.$('.img2');
       if (element) {
           const box = await element.boundingBox();
           if (box) {
               const elementScreenshotPath = path.join(__dirname, 'img2_capture.png');
               await page.screenshot({
                   path: elementScreenshotPath,
                   clip: {
                       x: box.x,
                       y: box.y,
                       width: box.width,
                       height: box.height
                   }
               });
               console.log(`✅ 특정 요소 캡처 완료: ${elementScreenshotPath}`);
           }
       } else {
           console.log("❌ 요소를 찾을 수 없음: .img2");
       }
   
       await browser.close();
   })();
   
   ```

   

   