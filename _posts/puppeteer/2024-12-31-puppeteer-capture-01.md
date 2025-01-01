---
layout: single
title:  "[puppeteer] puppeteer 캡쳐 유니크 이미지 Making"
categories: puppeteer
tag: [ java ]
author_profile: false
typora-root-url: ../
toc: true
toc_sticky: true
toc_label: "목차"
toc_icon: "fas fa-utensils" 
sidebar:
   nav: "counts"
search: true
---

### puppeteer 로 캡쳐화면하고 유니크한 이미지 만들기

Puppeteer를 사용하여 웹 페이지의 스크린샷을 찍는 간단한 JavaScript 스크립트이다. 이 스크립트는 Puppeteer 라이브러리를 활용하여 웹 페이지를 열고, 페이지를 캡처한 후 이미지 파일로 저장하는 과정이다.

아래의 코드는 `screenshot.js`라는 파일로 저장 후 사용할 수 있습니다:

```js
const puppeteer = require('puppeteer');

(async () => {
    // Puppeteer 브라우저 인스턴스 생성
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    // 접근하려는 웹 페이지 URL
    await page.goto('https://example.com');

    // 스크린샷 옵션 설정
    await page.screenshot({ path: 'screenshot.png' });

    // 브라우저 종료
    await browser.close();
})();

```

### 코드 실행 방법:

1. 위 코드를 `screenshot.js` 파일로 저장합니다.

2. 터미널에서 다음 명령어를 실행하여 Puppeteer를 설치합니다 (아직 설치하지 않았다면):

   ```
   npm install puppeteer
   ```

3. 스크립트를 실행하기 위해 터미널에서 다음 명령어를 입력합니다:

   ```
   node screenshot.js
   ```



**특정 class 이미지만 캡쳐하고 싶을 경우의 puppeteer 코드  **

```bash
const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--font-render-hinting=none']
    });
    const page = await browser.newPage();

    // 사용자 에이전트 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36');

    await page.goto('http://tripworldgo.net/이미지.html', { waitUntil: 'networkidle0' });

    // 폰트 로드를 위해 추가 대기
    await new Promise(resolve => setTimeout(resolve, 3000));  // 3초 대기

    // 특정 요소 캡쳐
    const element = await page.$('.img4');  // 실제 캡쳐하고자 하는 요소의 클래스를 '.some-class'로 지정
    if (element) {
        await element.screenshot({ path: 'naver.png' });
    } else {
        console.log('The element was not found.');
    }

    await browser.close();
})();

```

## 아래 코드는 그나마 pupeteer 에서 작동되는, 즉 타임아웃 발생하지 않고 결과값 가져오는 퍼펫 코드임.

```js
const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-gpu',
            '--single-process',
            '--no-zygote'
        ]
    });

    const page = await browser.newPage();

    // 사용자 에이전트 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

    const url = 'https://www.agoda.com/destination/city/seoul-kr.html?cid=1844104&ds=X2QnafKJAH9KDAAk';

    try {
        // 페이지 이동
        await page.goto(url, { waitUntil: 'load', timeout: 120000 });

        // 첫 10개의 호텔 이름과 URL 추출
        const hotelData = await page.evaluate(() => {
            const hotels = Array.from(document.querySelectorAll('h3[data-selenium="hotel-name"]')).slice(0, 10); // 첫 10개만 선택
            return hotels.map(hotel => {
                const hotelName = hotel.textContent.trim(); // 호텔 이름
                const parentLink = hotel.closest('a'); // h3 요소의 가장 가까운 부모 a 태그
                const href = parentLink ? parentLink.href : null; // href 속성 추출
                return [hotelName, href];
            });
        });

        console.log(`총 ${hotelData.length}개의 호텔 데이터를 가져왔습니다:`);
        console.log(hotelData);
    } catch (error) {
        console.error('스크립트 실행 중 오류가 발생했습니다:', error.message);
    } finally {
        await browser.close();
    }
})();

```

### 결과값

```
[ec2-user@ip-172-31-5-86 html]$ node list.js
총 3개의 호텔 데이터를 가져왔습니다:
[
  [
    'Dream Single House',
    'https://www.agoda.com/dream-single-house/hotel/seoul-kr.html?finalPriceView=1&isShowMobileAppPrice=false&cid=1922887&numberOfBedrooms=&familyMode=false&adults=1&children=0&rooms=1&maxRooms=0&checkIn=2025-01-9&isCalendarCallout=false&childAges=&numberOfGuest=0&missingChildAges=false&travellerType=0&showReviewSubmissionEntry=false&currencyCode=KRW&isFreeOccSearch=false&tspTypes=-1&los=9&searchrequestid=56d83bb4-779f-4d9a-95e1-e82c65e3bf92'
  ],
  [
    'Rodem house',
    'https://www.agoda.com/rodem-house/hotel/seoul-kr.html?finalPriceView=1&isShowMobileAppPrice=false&cid=1922887&numberOfBedrooms=&familyMode=false&adults=1&children=0&rooms=1&maxRooms=0&checkIn=2025-01-9&isCalendarCallout=false&childAges=&numberOfGuest=0&missingChildAges=false&travellerType=0&showReviewSubmissionEntry=false&currencyCode=KRW&isFreeOccSearch=false&los=9&searchrequestid=56d83bb4-779f-4d9a-95e1-e82c65e3bf92'
  ],
  [
    'E Livingtel',
    'https://www.agoda.com/e-livingtel_3/hotel/seoul-kr.html?finalPriceView=1&isShowMobileAppPrice=false&cid=1922887&numberOfBedrooms=&familyMode=false&adults=1&children=0&rooms=1&maxRooms=0&checkIn=2025-01-9&isCalendarCallout=false&childAges=&numberOfGuest=0&missingChildAges=false&travellerType=0&showReviewSubmissionEntry=false&currencyCode=KRW&isFreeOccSearch=false&los=9&searchrequestid=56d83bb4-779f-4d9a-95e1-e82c65e3bf92'
  ]
]
```

