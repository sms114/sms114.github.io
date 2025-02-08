---
layout: single
title:  "[linux] chromium또는google-chrome을설치해야하는이유"
categories: [ linux ]
tag: [ linux, chromium, google-chrome]
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

# Puppeteer , google-chrome 또는 chromium 설치 이유



Puppeteer는 기본적으로 **Chromium을 자동으로 다운로드**하지만,
✅ **EC2 환경에서는 기본 Chromium 다운로드가 실패하는 경우가 많아!**
✅ 따라서, **시스템에 직접 Chromium 또는 Google Chrome을 설치**해서 사용해야 해.

**Puppeeer 실행 시 기본적으로 사용하는 명령어:**

```javascript
const browser = await puppeteer.launch();
```

이 코드가 실행되면 Puppeteer가 자체적으로 Chromium을 다운로드하려고 시도해.
하지만 **EC2에서는 권한 문제나 네트워크 제한으로 다운로드가 실패할 가능성이 높아**.

🔹 해결 방법 → **시스템에 직접 Chromium 또는 Google Chrome을 설치한 후, `executablePath`를 명시적으로 지정**하면 돼.

위와 같은 이유로 google-chrome 또는 chromium 을 설치해야만 하는 거다.



## **✅ 2. Chromium vs Google Chrome 비교**

| 항목                     | Chromium                 | Google Chrome          |
| ------------------------ | ------------------------ | ---------------------- |
| 🏗 **개발사**             | Google (오픈소스)        | Google (상용)          |
| 🌐 **사용 목적**          | Headless 브라우저 테스트 | 일반 사용자용 브라우저 |
| ⚡ **성능**               | 가벼움, 빠름             | 확장 기능 및 DRM 지원  |
| 📦 **패키지 크기**        | 작음 (~80MB)             | 큼 (~100MB 이상)       |
| 🔧 **EC2에서 사용 가능?** | 🟡 (설치가 까다로움)      | 🟢 (더 안정적)          |

✅ **결론:**

- **Chromium**은 더 가볍지만, **Amazon Linux 2023에서 설치가 어렵거나 패키지 충돌이 발생할 수 있음**

* **Google Chrome은 설치가 더 쉽고 안정적** → EC2에서는 **Google Chrome 추천!** 🚀