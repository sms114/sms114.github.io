---
layout: single
title:  "[puppeteer] puppeteer, 방콕의 호텔과 호텔링크를 가져오는 js script"
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

```javascript
Request-1 : puppeteer 를 이용해서 특정 url 페이지의 hotel 이름을 list 해서 가져오는 js 코드를 만들어줘. 아고라 페이지에서의 호텔이름을 가져와야 하는데, h3 요소의 'sc-dhKdcB sc-kpDqfm evKSHs hsuWhi' class 명의 호텔이름을 10개만 추출해서 리스팅해주는 코드를 만들어줘. 

Request-2: 위 js 스크립트를 실행해도 호텔이름을 가져오지 못해. 무엇을 잘못한거지? h3 요소의 호텔이름을 리스팅해서 가져오기 위해 해야할 다른 방법을 확인해서 다시 만들어줘. 
```

(최종) Response:

```js
const puppeteer = require('puppeteer');

(async () => {
  const url = 'https://www.agoda.com/destination/city/seoul-kr.html?cid=1844104&ds=X2QnafKJAH9KDAAk'; // 대상 URL
  const hotelSelector = 'h3'; // h3 요소 사용

  // Puppeteer 브라우저 실행
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  // URL로 이동
  await page.goto(url, { waitUntil: 'networkidle2' });

  // 렌더링 완료를 위한 대기
  await page.waitForSelector(hotelSelector);

  // 호텔 이름 가져오기
  const hotelNames = await page.evaluate(() => {
    const hotelElements = document.querySelectorAll('h3'); // h3 요소 선택
    const names = [];
    for (let i = 0; i < hotelElements.length && i < 10; i++) {
      names.push(hotelElements[i].textContent.trim());
    }
    return names;
  });

  // 호텔 이름 출력
  console.log('Hotel Names:', hotelNames);

  // 브라우저 종료
  await browser.close();
})();

```



## booking 사이트- 호텔명 list 20 개 제대로 가져오는 puppeteer 코드

```js
const puppeteer = require('puppeteer');

(async () => {
  const url =
    'https://www.booking.com/city/th/bangkok.ko.html?aid=318615;label=New_Korean_KO_KR_27026369545-UQbjSstHnKwwlFMLFe7WbAS634186708273:pl:ta:p1:p2:ac:ap:neg:fi55401412806:tidsa-303472601955:lp9209163:li:dec:dm:ag27026369545:cmp400536625;ws=&gad_source=1&gclid=Cj0KCQiAyc67BhDSARIsAM95Qzs2kFRjfUW6VHIjdKN1hzlmR24WzflLlR-sX7k_5rs5zCs_ClGZcI0aAnSXEALw_wcB';
  const hotelSelector = 'h3[itemprop="name"]'; // 호텔 이름 요소

  try {
    // Puppeteer 브라우저 실행
    const browser = await puppeteer.launch({
      headless: true,
      args: ['--disable-dev-shm-usage', '--no-sandbox', '--disable-setuid-sandbox'], // 안정성 개선
    });
    const page = await browser.newPage();

    // 네트워크 요청 디버깅
    page.on('requestfailed', (request) => {
      console.log(`Request failed: ${request.url()} - ${request.failure().errorText}`);
    });

    // 타임아웃 설정
    await page.setDefaultNavigationTimeout(120000); // 타임아웃 120초로 확장
    await page.setDefaultTimeout(120000);

    // URL로 이동
    console.log('Navigating to URL...');
    await page.goto(url, { waitUntil: 'domcontentloaded' });

    // 네트워크 상태가 안정될 때까지 대기
    console.log('Waiting for network stability...');
    await page.waitForFunction(
      () =>
        document.querySelectorAll('h3[itemprop="name"]').length > 0,
      { timeout: 120000 } // 최대 120초 대기
    );

    // 호텔 이름 가져오기
    const hotelNames = await page.evaluate((selector) => {
      const hotelElements = document.querySelectorAll(selector);
      const names = [];
      for (let i = 0; i < hotelElements.length && i < 20; i++) {
        names.push(hotelElements[i].textContent.trim());
      }
      return names;
    }, hotelSelector);

    // 호텔 이름 출력
    console.log('Hotel Names:', hotelNames);

    // 브라우저 종료
    await browser.close();
  } catch (error) {
    console.error('Error:', error.message);
  }
})();

```

## 방콕의 호텔과 호텔링크를 가져오는 js 스크립트

```js
/*
request: 아래는 a 요소에서 href 속성이 있는 호텔명만 추출하도록 변경된 Puppeteer 코드입니다. property-details 및 best-properties 클래스를 가진 요소 내부의 a 태그를 대상으로 합니다.
1. 아고다 방콕의 호텔과 호텔링크를 가져오는 js 스크립트
*/
const puppeteer = require('puppeteer');

(async () => {
  const url =
    'https://www.agoda.com/country/thailand.html?site_id=1922868&tag=ace3cc57-981f-4d08-bc59-aebb9884bcbd&gad_source=1&device=c&network=g&adid=720986192788&rand=11442983334857042408&expid=&adpos=&aud=dsa-2376233549988&gclid=Cj0KCQiAyc67BhDSARIsAM95QzvrYFEKeMAapOTPM10YuKP_Jry2S7WfILyPrJblFpPkO1d7jjSSZVIaArtnEALw_wcB&checkIn=2025-01-10&checkOut=2025-01-11&adults=2&rooms=1&pslc=1&ds=kDAbS%2FqSOIDVqvn7';
  const hotelSelector = '.property-details.best-properties a[href]'; // a 태그와 href 속성 필터링

  try {
    // Puppeteer 브라우저 실행
    const browser = await puppeteer.launch({
      headless: true,
      args: ['--disable-dev-shm-usage', '--no-sandbox', '--disable-setuid-sandbox'],
    });
    const page = await browser.newPage();

    // 타임아웃 설정
    await page.setDefaultNavigationTimeout(120000);
    await page.setDefaultTimeout(120000);

    // URL로 이동
    console.log('Navigating to URL...');
    await page.goto(url, { waitUntil: 'domcontentloaded' });

    // a[href] 요소가 로드될 때까지 대기
    console.log('Waiting for a[href] elements...');
    await page.waitForSelector(hotelSelector);

    // href 속성이 있는 a 태그에서 호텔명 가져오기
    const hotelNames = await page.evaluate((selector) => {
      const elements = document.querySelectorAll(selector);
      const names = [];
      elements.forEach((element) => {
        const hotelName = element.textContent.trim(); // 텍스트 내용 추출
        const href = element.getAttribute('href'); // href 속성 추출
        if (hotelName && href) {
          names.push({ name: hotelName, link: href });
        }
      });
      return names;
    }, hotelSelector);

    // 호텔 이름 및 링크 출력
    console.log('Hotels with Links:', hotelNames);

    // 브라우저 종료
    await browser.close();
  } catch (error) {
    console.error('Error:', error.message);
  }
})();

```



