---
layout: single
title:  "[Summary-01] html, css 로 다양한 샘플 만들기 "
categories: [ wordpress ]
tag: [ wordpress ]
author_profile: false
typora-root-url: ../
toc: true
toc_sticky: true
toc_label: "목차"
toc_icon: "fas fa-utensils" 
remove_sidebar: true
##sidebar:
##nav: "counts"
search: true
---

## VSCODE 에서 설치하는 EXTENSIONS 



live Server 플러그인 설치



![image-20250205095716685](/../../images/2025-02-05-chapter03-summary-01/image-20250205095716685.png)



1. VSCODE 에서 NEW FILE 생성.

2. 본문.html 생성

3. ! 탭 처리 
   ```html
   <!DOCTYPE html>   // html5 생성
   ```

4.  하단 오른쪽 'GO LIVE'  클릭

5. ![image-20250205100545219](/../../images/2025-02-05-chapter03-summary-01/image-20250205100545219.png)

![image-20250205100528025](/../../images/2025-02-05-chapter03-summary-01/image-20250205100528025.png)



본문.html

```html
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>본문</title>
    <style>
        .style1 .hotelbox{border:solid #aaa 10px;padding:20px;margin-bottom:30px ;}
        .style1 img{width:600px;height:auto;}
        .style1 h1{text-align:center;font-size:35px;color:#3d02c9}
        .style1 p{text-align:center;}
        .style1 h3{color:rgb(2, 22, 201);font-size: 30px;}
        .style1 h5{font-size:16px;}
        .style1{font-size:14px;}

    </style>
</head>
<body>
    <div class="style1">
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
    </div>
</body>
</html>
```



### 이미지 html 에 익숙해 지기 위한 방법

#### 예제1

![image-20250205211922823](/../../images/2025-02-05-chapter03-summary-01/image-20250205211922823.png)

```html
    <div style="width:500px;height:400px;position:relative;overflow:idden;">
        <img style="width:49%;height:200px;bottom:0;right:0px;" src="https://pix8.agoda.net/hotelImages/686641/-1/f16ce90659bbdaac260cfbb759241021.png?ce=0&s=800x">
        <img style="width:49%;height:200px;top:100px;bottom:100px;right:100px;" src="https://pix8.agoda.net/property/24074586/452498572/f47c582061edc91538aea9c0ed996b74.jpg?ca=23&ce=0&s=1024x">
        <img style="width:49%;height:200px;bottom:0;right:0px;" src="https://pix8.agoda.net/hotelImages/686641/-1/f16ce90659bbdaac260cfbb759241021.png?ce=0&s=800x">
        <img style="width:49%;height:200px;top:100px;bottom:100px;right:100px;" src="https://pix8.agoda.net/property/24074586/452498572/f47c582061edc91538aea9c0ed996b74.jpg?ca=23&ce=0&s=1024x">
    </div>
```



#### 예제2

![image-20250205212039576](/../../images/2025-02-05-chapter03-summary-01/image-20250205212039576.png)

```html
    <div style="width:500px;height:400px;position:relative;">
        <img style="width:70%;height:auto;position:absolute;top:0;left:0px;" src="https://pix8.agoda.net/property/60959266/0/32eb716488b029fbb52a8382bc662b3c.jpeg?ce=0&s=600x">
        <img style="width:70%;height:auto;position:absolute;bottom:0;right:0px;" src="https://pix8.agoda.net/hotelImages/686641/-1/f16ce90659bbdaac260cfbb759241021.png?ce=0&s=800x">
        <img style="width:70%;height:auto;position:absolute;top:100px;bottom:100px;right:100px;" src="https://pix8.agoda.net/property/24074586/452498572/f47c582061edc91538aea9c0ed996b74.jpg?ca=23&ce=0&s=1024x">
    </div>
```



#### 예3

![image-20250205212108397](/../../images/2025-02-05-chapter03-summary-01/image-20250205212108397.png)

````html
    <div style="position:relative;width:100%;height:250px;
    background:url(https://pix8.agoda.net/property/24074586/452498572/f47c582061edc91538aea9c0ed996b74.jpg?ca=23&ce=0&s=1024x);
    background-size:cover;
    background-position: 50%;
    color: #fff;
    font-size:20px;
    font-weight:bold;
    ">
        <div style="position:absolute;
        z-index:2;
        color:#fff;
        width:100%;
        text-align:center;
        top:100px;
        font-size:20px;
        font-weight:bold;">
            럭셔리한 아름다운 콘래드 호텔 로비
        </div>
        
        <div style="position:absolute;
            z-index:1;
            top:0px;
            left:0px;
            width:100%;
            height:250px;
            background:rgba(0,0,0,0.5)">

        </div>
    </div>
````



#### 예4

![image-20250205212239694](/../../images/2025-02-05-chapter03-summary-01/image-20250205212239694.png)

````html
    <div class="img6" style="width:350px;height:350px;
        background:url(https://pix8.agoda.net/hotelImages/297968/-1/44236157a18c8243a66e557193355bd7.jpg?ce=0&s=1024x);
        border-radius:50%;
        background-position:50%;
        background-size:30cm;
        text-align:center;
        padding-top:150px;
        box-sizing:border-box;
        font-size:26px;
        color: #fff;
        font-weight: bold;
        text-shadow: 2px 2px 2px #000;">
        <div>
            럭셔리한 콘래드 마카오 후기2222
        </div>
    </div>   
````



#### 예5

![image-20250205212356893](/../../images/2025-02-05-chapter03-summary-01/image-20250205212356893.png)



```html
    <style>
        html{box-sizing: border-box;}
        .img5 {
    width: 300px;
    height: 300px; /* 원형을 유지하려면 width = height */
    background: url(https://pix8.agoda.net/hotelImages/297968/-1/44236157a18c8243a66e557193355bd7.jpg?ce=0&s=1024x);
    background-position: center;
    background-size: cover;
    border-radius: 50%;
    display: flex; /* flexbox 사용 */
    align-items: center; /* 세로 중앙 정렬 */
    justify-content: center; /* 가로 중앙 정렬 */
    text-align: center;
    color: white; /* 가독성을 위해 텍스트 색상 추가 */
    font-weight: bold;
    font-size: 16px;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.5); /* 텍스트 가독성 향상 */
}

    </style>


    <div class="img5">
        <div>
            럭셔리한 콘래드 마카오 후기 1111
        </div>
    </div>


```



> **이후, 유니크한 이미지 생성을 위해 "노드 스크린샷 캡쳐" 를 통해 .png 파일을 내려 받기 한 후, 해당 이미지를 사용한다.**
>
> 
> 



![image-20250205212425936](/../../images/2025-02-05-chapter03-summary-01/image-20250205212425936.png)[]()