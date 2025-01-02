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

### 아고다에서 호텔명 가져와서 insert js script

#### from url : https://www.agoda.com/ko-kr/?cid=1748498&ds=x7rkeq5hT2NCGS33

```js
/*
투더제이가 제공한 getcity.js 에서 약간 수정된 코드임.
1. targetDiv = document.querySelector('footer [data-selenium="top-destinations-div"]'); 라는 부분, 즉
   어떤 요소 어떤 element 이름에서 무엇을 가져오는지를 수정하여 최종 get & inset 코드를 완성함.
*/
const puppeteer = require('puppeteer');
const mysql = require('mysql');

// MySQL 연결 설정
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'xxxxx',
  database: 'tripworldgo',
});

connection.connect((error) => {
  if (error) {
    console.error('Database connection failed:', error.stack);
    return;
  }
  console.log('Database connected.');
});

(async () => {
  try {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto('https://www.agoda.com/ko-kr/?cid=1748498&ds=x7rkeq5hT2NCGS33', { waitUntil: 'networkidle2' });

    // 정보 가져오기
    const result = await page.evaluate(() => {
      const targetDiv = document.querySelector('footer [data-selenium="top-destinations-div"]');
      if (!targetDiv) return [];

      const aElements = Array.from(targetDiv.querySelectorAll('a[href]'));
      const data = [];

      aElements.forEach((anchor) => {
        const textContent = anchor.textContent.trim();
        const url = anchor.href;

        if (textContent.includes('호텔')) {
          const cleanedText = textContent.replace('호텔', '').trim(); // "호텔" 제거
          data.push([cleanedText, url]);
        }
      });

      return data;
    });

    if (result.length === 0) {
      console.log('No matching data found.');
      return;
    }

    // MariaDB에 저장
    const currentTime = new Date().toISOString().slice(0, 19).replace('T', ' ');

    for (let [cityName, cityUrl] of result) {
      const query = 'INSERT INTO city (cityname, url, regdate) VALUES (?, ?, ?)';
      connection.query(query, [cityName, cityUrl, currentTime], (error) => {
        if (error) throw error;
        console.log(`Inserted: ${cityName} - ${cityUrl}`);
      });
    }

    await browser.close();
  } catch (error) {
    console.error('An error occurred:', error);
  } finally {
    connection.end();
  }
})();

```



