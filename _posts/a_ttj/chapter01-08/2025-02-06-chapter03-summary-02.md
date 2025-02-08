---
layout: single
title:  "[linux] wordpress API 로 글 써보기"
categories: [ wordpress ]
tag: [ nodejs, wordpress, api ]
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

## auto_post.php

```php
<?php
// 워드프레스 코어 파일 로드
require_once( 'wp-load.php' );


$sample = '<div class="style1">
        <h1>큰제목 - 홍콩의 가성비 좋은 고급호텔 top5</h1>
        <p>인사말 안녕하세요. 날씨가 좋네요</p>
        <br><br><br>
        <div class="hotelbox">
            <h3>중제목 - 호텔명</h3>
            <img src="https://q-xx.bstatic.com/xdata/images/hotel/max1024x768/95628270.jpg?k=757503ac22849096d9d5c5a6f97fa897ac8c979e55197fa0c18f3d32f355382f&o=&s=1024x" alt="이미지의 설명">
            <p>호텔설명 좋은 호텔입니다. 진짜 좋은 호텔입니다.</p>
            <h5>소제목 - 주위 가볼만한 곳</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li> 
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>

            <h5>소제목 - 호텔 시설, 특징, 교통</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>
        </div>
        <div class="hotelbox">
            <h3>중제목 - 호텔명</h3>
            <img src="https://pix8.agoda.net/hotelImages/6362202/0/b79106a8152061339505252638b5b6c0.jpg?ca=9&ce=1&s=1024x" alt="이미지의 설명">
            <p>호텔설명 좋은 호텔입니다. 진짜 좋은 호텔입니다.</p>
            <h5>소제목 - 주위 가볼만한 곳</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>

            <h5>소제목 - 호텔 시설, 특징, 교통</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>
        </div>
        <div class="hotelbox">
            <h3>중제목 - 호텔명</h3>
            <img src="https://pix8.agoda.net/property/22879516/766855982/0d0ef4a797b8d0ff7289fd1f7c0490b9.jpeg?ce=0&s=1024x" alt="이미지의 설명">
            <p>호텔설명 좋은 호텔입니다. 진짜 좋은 호텔입니다.</p>
            <h5>소제목 - 주위 가볼만한 곳</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>

            <h5>소제목 - 호텔 시설, 특징, 교통</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>
        </div>
        <div class="hotelbox">
            <h3>중제목 - 호텔명</h3>
            <img src="https://pix8.agoda.net/property/22879516/766855982/0d0ef4a797b8d0ff7289fd1f7c0490b9.jpeg?ce=0&s=1024x" alt="이미지의 설명">
            <p>호텔설명 좋은 호텔입니다. 진짜 좋은 호텔입니다.</p>
            <h5>소제목 - 주위 가볼만한 곳</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>

            <h5>소제목 - 호텔 시설, 특징, 교통</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>
        </div>
        <div class="hotelbox">
            <h3>중제목 - 호텔명</h3>
            <img src="https://pix8.agoda.net/property/22879516/766855982/0d0ef4a797b8d0ff7289fd1f7c0490b9.jpeg?ce=0&s=1024x" alt="이미지의 설명">
            <p>호텔설명 좋은 호텔입니다. 진짜 좋은 호텔입니다.</p>
            <h5>소제목 - 주위 가볼만한 곳</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>

            <h5>소제목 - 호텔 시설, 특징, 교통</h5>
            <ul>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
                <li>항목 - 장소</li>
            </ul>
        </div>
    </div>';



// 글 정보
$new_post = array(
    'post_title'    => 'test', //제목
    'post_content'  => $sample, //본문
    'post_status'   => 'publish', //발행상태
    'post_author'   => 1, // 작성자 ID
    'post_type'     => 'post' //포스트타입
);

// 글 작성
$post_id = wp_insert_post( $new_post );

// 글이 성공적으로 작성되었는지 확인
if( $post_id ) {
    echo "포스트가 성공적으로 작성되었습니다. 포스트 ID: " . $post_id;
} else {
    echo "포스트 작성에 실패하였습니다.";
}
?>

```

![image-20250206122709124](/../../images/2025-02-06-chapter03-summary-02/image-20250206122709124.png)

![image-20250206122748925](/../../images/2025-02-06-chapter03-summary-02/image-20250206122748925.png)





처리된 wordpress 화면을 확인할 수 있다. 이렇게 워드프레스에 자동 글쓰기의 기본 php를 작성하고, 만들어 보았다.



## 2. Amazon linux EC2 에 nodejs 부터 peppeteer 설치 방법



### 1. Node.js 설치

```bash
# 1️⃣ Node.js 18 (권장 버전) 설치
sudo dnf install -y nodejs18

# 2️⃣ 설치 확인
node -v
npm -v
```

### 2. Puppeteer 설치

퍼펫티어는 Chrome 브라우저를 자동화하는 Node.js 라이브러리다. 설치하려면 아래 방법으로 설치하자.

```bash
# 1️⃣ 프로젝트 폴더 생성 및 이동 (선택사항)
mkdir my-project && cd my-project

# 2️⃣ Puppeteer 설치
npm install puppeteer

```

Amazon Linux 2023에서 **Node.js 및 Puppeteer**를 설치하는 방법을 단계별로 알려줄게! 🚀

------

## ✅ **1. Node.js 설치**

Amazon Linux 2023에서는 최신 Node.js를 설치하려면 **NodeSource 저장소**를 사용해야 해!

```
sh복사편집# 1️⃣ Node.js 18 (권장 버전) 설치
sudo dnf install -y nodejs18

# 2️⃣ 설치 확인
node -v
npm -v
```

**출력 예시:**

```
복사편집v18.17.0
9.6.7  // npm 은 node package Manager 도구이다. node 기반의 프로그램 설치 manager 임., yum 이랑 비슷.
```

nodejs 기반의 프로그램을 설치하기 위해 반드시 npm 도구가 설치되어 있어야한다. 이후 퍼펫티어 설치를 위해 반드시 설치해야 하는 도구 메니져이다.

✅ Node.js와 npm이 정상적으로 설치되었으면 다음 단계로!

------

## ✅ **2. Puppeteer 설치**

Puppeteer는 **Chrome 브라우저를 자동화**하는 Node.js 라이브러리야! 설치하려면:

```
sh복사편집# 1️⃣ 프로젝트 폴더 생성 및 이동 (선택사항)
mkdir my-project && cd my-project

# 2️⃣ Puppeteer 설치
npm install puppeteer
```

📌 Puppeteer는 기본적으로 **헤드리스(Headless) Chrome**을 함께 설치하기 때문에 용량이 크다.
(💡 **EC2에서 용량이 부족하면 `--no-bin-links` 옵션 사용 가능**)

```bash
npm install puppeteer --no-bin-links
```

### ✅ **3. Puppeteer 실행 테스트**

설치 후 Puppeteer 가 제대로 작동하는지 테스트  해 보기 바람.

```bash
echo 'const puppeteer = require("puppeteer");
(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto("https://example.com");
    console.log("Page loaded!");
    await browser.close();
})();' > test.js

node test.js
```

### ✅ **4. 추가 패키지 설치 (필요 시)**

```bash
Error: Failed to launch the browser process!
```

위와 같은 오류가 발생한다면, 아래 필요한 라이브러리를 설치해줘야 한다.

```bash
sudo dnf install -y \
    libXcomposite libXcursor libXdamage libXext libXi \
    libXtst cups-libs libXScrnSaver libXrandr GConf2 \
    alsa-lib gtk3 libdrm libgbm pango at-spi2-atk \
    xorg-x11-fonts-100dpi xorg-x11-fonts-75dpi \
    xorg-x11-utils xorg-x11-fonts-Type1 xorg-x11-server-Xvfb

```

📌 **Amazon Linux 2023에서는 `xorg-x11-fonts-100dpi`가 기본 패키지가 아니라 추가 설치 필요할 수 있음!**

✅ 이후 다시 `node test.js` 실행하면 제대로 작동할 것. 혹시 또 오류가 생긴다면, 다시 필요한 라이브러리 설치 진행.

