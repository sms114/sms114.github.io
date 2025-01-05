---
layout: single
title:  "[puppeteer] puppeteer, get agoda and insert phpmyadmin database insert"
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

## 이미지 제외, 5개 크롤링 된 ap2.js 코드.

* __json 으로 파일 생성됨__
* ap2.js -> ap2.php 로 연계예정

```js
const puppeteer = require('puppeteer');
const fs = require('fs');

// 무한 스크롤 함수
async function autoScroll(page) {
  let previousHeight = await page.evaluate(() => document.body.scrollHeight);
  while (true) {
    await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
    await new Promise(resolve => setTimeout(resolve, 3000)); // 대기
    let newHeight = await page.evaluate(() => document.body.scrollHeight);
    if (newHeight === previousHeight) break;
    previousHeight = newHeight;
  }
}

// SEO-friendly 슬러그 생성
function makeSlug(title) {
  return title
    .toLowerCase()
    .replace(/[^a-zA-Z0-9가-힣]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

// Puppeteer로 호텔 데이터 크롤링
async function scrapeSeoulHotels() {
  const url = 'https://www.agoda.com/ko-kr/city/seoul-kr.html';
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  // 유저 에이전트 설정
  await page.setUserAgent(
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36'
  );

  await page.goto(url, { waitUntil: 'networkidle2' });
  await autoScroll(page);

  const hotelsData = await page.evaluate(() => {
    const hotelCards = document.querySelectorAll('.DatelessPropertyCard__Content');
    const results = [];

    hotelCards.forEach(card => {
      const hotelName = card.querySelector('.DatelessPropertyCard__ContentHeader')?.innerText.trim() || '';
      const hotelLink = card.querySelector('a')?.href || '';
      const facilities = Array.from(card.querySelectorAll('.GeoBenefitPill li'))
        .slice(0, -1)
        .map(el => el.innerText.trim());
      const detail = card.querySelector('.DatelessPropertyCard__ContentDetail')?.innerText.trim() || '';
      const rating = card.querySelector('.Box-sc-kv6pi1-0.fRaEGH')?.innerText.trim() || '';
      const imageSrc = card.querySelector('.DatelessGallery img')?.src || '';

      if (hotelName) {
        results.push({ hotelName, hotelLink, facilities, detail, rating, imageSrc });
      }
    });

    return results;
  });

  await browser.close();
  return hotelsData;
}

// Main
(async () => {
  try {
    const allHotels = await scrapeSeoulHotels();

    // 랜덤 제목 생성
    const possibleTitles = [
      '서울의 아름다운 호텔 Top5',
      '서울의 가성비 호텔 Top5',
      '서울의 럭셔리 호텔 Top5',
      '서울의 가족 여행 추천 호텔 Top5',
      '서울의 뷰가 멋진 호텔 Top5'
    ];
    const titleIndex = Math.floor(Math.random() * possibleTitles.length);
    const randomTitle = possibleTitles[titleIndex];
    const slug = makeSlug(randomTitle);

    // 상위 5개 호텔 추출
    const top5Hotels = allHotels.slice(0, 5);
    const finalData = { title: randomTitle, slug, hotels: top5Hotels };

    // JSON 파일로 저장
    const jsonFilePath = 'hotels_top5.json';
    fs.writeFileSync(jsonFilePath, JSON.stringify(finalData, null, 2), 'utf-8');
    console.log(`JSON 파일 생성 완료: ${jsonFilePath}`);

    // JSON 내용 출력
    console.log('생성된 JSON 데이터:', JSON.stringify(finalData, null, 2));
  } catch (error) {
    console.error('오류 발생:', error);
  }
})();

```

