---
layout: single
title:  "[puppeteer] puppeteer, 아고다 호텔정보가 있을 경우 포스트 문서가 잘 작성되는 js script"
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

## [puppeteer] 특정 호텔 id 만 가져오는 script  

```js
const puppeteer = require('puppeteer');
const mysql = require('mysql');
const { exec } = require('child_process');
const fs = require('fs');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'Phs()2024',
  database: '????'
});

let city_url, city_name;

connection.connect((error) => {
  if (error) throw error;
  //connection.query('SELECT * FROM city ORDER BY RAND() LIMIT 1', async (error, results) => {
    connection.query('SELECT * FROM city WHERE id = 17', async (error, results) => {
    if (error) throw error;

    city_url = results[0].url;
    city_name = results[0].cityname;

    const browser = await puppeteer.launch({
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage', '--disable-accelerated-2d-canvas', '--disable-gpu']
    });
    const page = await browser.newPage();

    // User-Agent 및 헤더 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    await page.setExtraHTTPHeaders({
      'Accept-Language': 'en-US,en;q=0.9',
    });

    console.log("잠시 기다리세요. ", city_name, "을/를 추출중입니다.", city_url);

    let attempt = 0;
    const maxAttempts = 3;
    let hotels = [];

    while (attempt < maxAttempts) {
      try {
        // 페이지 이동 및 네비게이션 타임아웃 확장
        await page.goto(city_url, { waitUntil: 'networkidle2', timeout: 60000 });

        // 특정 요소가 로드될 때까지 대기
        await page.waitForSelector('.DatelessPropertyCard__Content', { timeout: 30000 });

        // 비동기 로드된 데이터 확인
        await page.waitForFunction(
          () => document.querySelectorAll('.DatelessPropertyCard__Content').length > 0,
          { timeout: 10000 }
        );

        hotels = await page.evaluate(() => {
          const result = [];
          const elements = document.querySelectorAll('.DatelessPropertyCard__Content');

          elements.forEach((element, index) => {
            if (index < 5) {
              const name = element.querySelector('.DatelessPropertyCard__ContentHeader')?.innerText || "";
              const link = element.querySelector('a')?.href || "";
              const details = element.querySelector('.DatelessPropertyCard__ContentDetail')?.innerText || "";
              const rating = element.parentElement.querySelector('.Box-sc-kv6pi1-0')?.innerText || "";
              const facilities = Array.from(element.querySelectorAll('.Pills li'))
                                      .slice(0, -1)
                                      .map(li => li.innerText || "")
                                      .join(", ");
              const image = element.parentElement.querySelector('.DatelessPropertyCard__Gallery img')?.src || "";

              result.push({ name, link, details, rating, facilities, image });
            }
          });

          return result;
        });

        console.log("추출된 호텔 데이터:", hotels);
        break;
      } catch (error) {
        attempt++;
        console.error(`오류 발생 (시도 ${attempt}/${maxAttempts}):`, error.message);
        if (attempt === maxAttempts) {
          await page.screenshot({ path: `error_screenshot_${attempt}.png` });
          console.error("최대 시도 횟수를 초과했습니다. 로그를 확인하세요.");
        }
      }
    }

    fs.writeFileSync('city_hotels.json', JSON.stringify(hotels));

    await browser.close();

    // PHP 스크립트 실행
    exec(`php ap2_ttj.php ${city_name}`, (error, stdout, stderr) => {
      if (error) {
        console.log(`Error executing PHP script: ${error}`);
        return;
      }
      console.log(`PHP Output: ${stdout}`);
      
      // MySQL 연결 종료
      connection.end((err) => {
        if (err) {
          console.log(`Error ending the connection: ${err}`);
        }
        process.exit();
      });
    });
  });
});

```



## [puppeteer] attempt 가 1일 경우 다른 추출 방법을 통한 데이터 추출 로직을 구현하는 코드

```js
const puppeteer = require('puppeteer');
const mysql = require('mysql');
const { exec } = require('child_process');
const fs = require('fs');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'Phs()2024',
  database: 'tripworldgo'
});

let city_url, city_name;

connection.connect((error) => {
  if (error) throw error;
  connection.query('SELECT * FROM city WHERE id = 27', async (error, results) => {
    if (error) throw error;

    city_url = results[0].url;
    city_name = results[0].cityname;

    const browser = await puppeteer.launch({
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage', '--disable-accelerated-2d-canvas', '--disable-gpu']
    });
    const page = await browser.newPage();

    // User-Agent 및 헤더 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    await page.setExtraHTTPHeaders({
      'Accept-Language': 'en-US,en;q=0.9',
    });

    console.log("잠시 기다리세요. ", city_name, "을/를 추출중입니다.", city_url);

    let attempt = 0;
    const maxAttempts = 3;
    let hotels = [];

    while (attempt < maxAttempts) {
      try {
        // 페이지 이동 및 네비게이션 타임아웃 확장
        await page.goto(city_url, { waitUntil: 'networkidle2', timeout: 60000 });

        // 특정 요소가 로드될 때까지 대기
        await page.waitForSelector('.DatelessPropertyCard__Content', { timeout: 30000 });

        // 비동기 로드된 데이터 확인
        await page.waitForFunction(
          () => document.querySelectorAll('.DatelessPropertyCard__Content').length > 0,
          { timeout: 10000 }
        );

        hotels = await page.evaluate(() => {
          const result = [];
          const elements = document.querySelectorAll('.DatelessPropertyCard__Content');

          elements.forEach((element, index) => {
            if (index < 5) {
              const name = element.querySelector('.DatelessPropertyCard__ContentHeader')?.innerText || "";
              const link = element.querySelector('a')?.href || "";
              const details = element.querySelector('.DatelessPropertyCard__ContentDetail')?.innerText || "";
              const rating = element.parentElement.querySelector('.Box-sc-kv6pi1-0')?.innerText || "";
              const facilities = Array.from(element.querySelectorAll('.Pills li'))
                                      .slice(0, -1)
                                      .map(li => li.innerText || "")
                                      .join(", ");
              const image = element.parentElement.querySelector('.DatelessPropertyCard__Gallery img')?.src || "";

              result.push({ name, link, details, rating, facilities, image });
            }
          });

          return result;
        });

        console.log("추출된 호텔 데이터:", hotels);
        break;
      } catch (error) {
        attempt++;
        console.error(`오류 발생 (시도 ${attempt}/${maxAttempts}):`, error.message);

        if (attempt === 1) {
          console.log("다른 방법으로 데이터를 추출 시도합니다.");
          try {
            hotels = await page.evaluate(() => {
              const result = [];
              const elements = document.querySelectorAll('.property-details.best-properties');

              elements.forEach((element, index) => {
                if (index < 5) {
                  const name = element?.innerText || "";
                  const link = element.querySelector('a')?.href || "";
                  const details = document.querySelectorAll('.hotel-card-property-review-score')[0]?.innerText || "";
                  const facilities = ""; // 빈란으로 채움
                  const image = document.querySelector('.property-img img')?.src || "";

                  result.push({ name, link, details, facilities, image });
                }
              });

              return result;
            });

            console.log("대체 로직으로 추출된 호텔 데이터:", hotels);
            break;
          } catch (newError) {
            console.error("대체 로직 실패:", newError.message);
          }
        }

        if (attempt === maxAttempts) {
          await page.screenshot({ path: `error_screenshot_${attempt}.png` });
          console.error("최대 시도 횟수를 초과했습니다. 로그를 확인하세요.");
        }
      }
    }

    fs.writeFileSync('city_hotels.json', JSON.stringify(hotels));

    await browser.close();

    // PHP 스크립트 실행
    exec(`php ap2_ttj.php ${city_name}`, (error, stdout, stderr) => {
      if (error) {
        console.log(`Error executing PHP script: ${error}`);
        return;
      }
      console.log(`PHP Output: ${stdout}`);
      
      // MySQL 연결 종료
      connection.end((err) => {
        if (err) {
          console.log(`Error ending the connection: ${err}`);
        }
        process.exit();
      });
    });
  });
});


```



## 아고라 중국호텔 정보 fetch 시, 1차 시도 후 2차 시도 fetch 완벽 grep data js script

__몇 번에 걸쳐 가공된 호텔 정보 fetch script__

```js
const puppeteer = require('puppeteer');
const mysql = require('mysql');
const { exec } = require('child_process');
const fs = require('fs');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '???',
  database: 'tripworldgo'
});

let city_url, city_name;

connection.connect((error) => {
  if (error) throw error;
  //connection.query('SELECT * FROM city WHERE id = 3', async (error, results) => {
  //중국
  connection.query('SELECT * FROM city WHERE id = 62', async (error, results) => {
    if (error) throw error;

    city_url = results[0].url;
    city_name = results[0].cityname;

    const browser = await puppeteer.launch({
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage', '--disable-accelerated-2d-canvas', '--disable-gpu']
    });
    const page = await browser.newPage();

    // User-Agent 및 헤더 설정
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    await page.setExtraHTTPHeaders({
      'Accept-Language': 'en-US,en;q=0.9',
    });

    console.log("잠시 기다리세요. ", city_name, "을/를 추출중입니다.", city_url);

    let attempt = 0;
    const maxAttempts = 3;
    let hotels = [];

    while (attempt < maxAttempts) {
      try {
        // 페이지 이동 및 네비게이션 타임아웃 확장
        await page.goto(city_url, { waitUntil: 'networkidle2', timeout: 10000 });

        // 특정 요소가 로드될 때까지 대기
        await page.waitForSelector('.DatelessPropertyCard__Content', { timeout: 10000 });

        // 비동기 로드된 데이터 확인
        await page.waitForFunction(
          () => document.querySelectorAll('.DatelessPropertyCard__Content').length > 0,
          { timeout: 10000 }
        );

        hotels = await page.evaluate(() => {
          const result = [];
          const elements = document.querySelectorAll('.DatelessPropertyCard__Content');

          elements.forEach((element, index) => {
            if (index < 5) {
              const name = element.querySelector('.DatelessPropertyCard__ContentHeader')?.innerText || "";
              const link = element.querySelector('a')?.href || "";
              const details = element.querySelector('.DatelessPropertyCard__ContentDetail')?.innerText || "";
              const rating = element.parentElement.querySelector('.Box-sc-kv6pi1-0')?.innerText || "";
              const facilities = Array.from(element.querySelectorAll('.Pills li'))
                                      .slice(0, -1)
                                      .map(li => li.innerText || "")
                                      .join(", ");
              const image = element.parentElement.querySelector('.DatelessPropertyCard__Gallery img')?.src || "";

              result.push({ name, link, details, rating, facilities, image });
            }
          });

          return result;
        });

        console.log("추출된 호텔 데이터:", hotels);
        break;
      } catch (error) {
        attempt++;
        console.error(`오류 발생 (시도 ${attempt}/${maxAttempts}):`, error.message);

        if (attempt === 1) {
          console.log("다른 방법으로 데이터를 추출 시도합니다.");
          try {
            hotels = await page.evaluate(() => {
              const result = [];
              //const elements = document.querySelectorAll('.property-details.best-properties');
              //const elements = document.querySelectorAll('.base-card.base-card-0.property-details.best-properties');
              //const elements = document.querySelectorAll('.col-sm-4');
              const elements = document.querySelectorAll('.col-sm-4[data-element-name="geo-carousel-card"]');

              elements.forEach((element, index) => {
                //if (index < 5 && element.querySelector('a')?.innerText !== "") {
                if (index < 5) {


                  //const name = element.querySelector('.property-name a')?.innerText || "";
                  const name = element.querySelector('.property-details .property-top-details .property-name')?.innerText || "";
                  //const link = element.querySelector('.property-name a')?.getAttribute('href') || "";

                  const rawLink = element.querySelector('a')?.getAttribute('href') || "";
                  const link = rawLink.startsWith("/") ? `https://www.agoda.com${rawLink}` : rawLink; // 절대 경로 변환
                  //result.push({ link });

                  //const details = element.querySelector('.snippet .data p')?.innerText.trim() || ""; // 수정된 details 값
                  const details = element.querySelector('.property-details .snippet p')?.innerText.trim() || ""; // 수정된 details 값
                  const facilities = ""; // 빈란으로 채움
                  const imgSrc = element.querySelector('figure img')?.getAttribute('src') || "";
                  const image = imgSrc ? (imgSrc.startsWith("//") ? `https:${imgSrc}` : imgSrc) : ""; // 수정된 image 값
                  


                  result.push({ name, link, details, facilities, image });
                }
              });

              return result;
            });

            console.log("대체 로직으로 추출된 호텔 데이터:", hotels);
            break;
          } catch (newError) {
            console.error("대체 로직 실패:", newError.message);
          }
        }

        if (attempt === maxAttempts) {
          await page.screenshot({ path: `error_screenshot_${attempt}.png` });
          console.error("최대 시도 횟수를 초과했습니다. 로그를 확인하세요.");
        }
      }
    }

    fs.writeFileSync('city_hotels.json', JSON.stringify(hotels));

    await browser.close();

    // PHP 스크립트 실행
    exec(`php ap2_ttj.php ${city_name}`, (error, stdout, stderr) => {
      if (error) {
        console.log(`Error executing PHP script: ${error}`);
        return;
      }
      console.log(`PHP Output: ${stdout}`);
      
      // MySQL 연결 종료
      connection.end((err) => {
        if (err) {
          console.log(`Error ending the connection: ${err}`);
        }
        process.exit();
      });
    });
  });
});

```

### ap2_ttj2.js 연결된 ap2._ttj.php script 메모

```js
<?php
// 워드프레스 코어 파일 로드
require_once( 'wp-load.php' );


$json_data = file_get_contents('city_hotels.json');
$hotels = json_decode($json_data, true);

$city_name = $argv[1];

// 제목 템플릿 배열
$title_templates = array(
    "{$city_name} 아름다운 호텔 TOP 5",
    "{$city_name}의 가성비 호텔 TOP 5",
    "{$city_name}의 럭셔리 호텔 TOP 5",
    "내가 뽑은 {$city_name}의 인생호텔 5개",
    // 추가 가능
);



$random_index = array_rand($title_templates);
$chosen_template = $title_templates[$random_index];




// 포스트 내용 생성
$post_content = "";
foreach ($hotels as $hotel) {
    $post_content .= "<h2>{$hotel['name']}</h2>";
    $post_content .= "<img src='{$hotel['image']}' alt='{$hotel['name']}' />";
    $post_content .= "<p>상세정보: {$hotel['details']}</p>";
    $post_content .= "<p>부대시설: {$hotel['facilities']}</p>";
    $post_content .= "<p>평점: {$hotel['rating']}</p>";
    $post_content .= "<a href='{$hotel['link']}'>자세히 보기</a>";
}

// WordPress 포스트 데이터 배열
$post_data = array(
    'post_title'    => $chosen_template,
    'post_content'  => $post_content,
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_category' => array(1),
    'post_name'     => sanitize_title($chosen_template) // SEO-friendly URL 생성
);

// 포스트 추가
$post_id = wp_insert_post($post_data);
?>
```

