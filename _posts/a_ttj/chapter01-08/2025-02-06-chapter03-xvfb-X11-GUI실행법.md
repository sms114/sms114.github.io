---
layout: single
title:  "[ puppeteer, Xvfb ] X 서버(X11)란 그리고 GUI 기반 애플리케이션 실행 시스템의 이해"
categories: [ Xvfb ]
tag: [ puppeteer, node, Xvfb ]
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

> 기본적으로 X11은 **모니터, 키보드, 마우스 입력을 관리**하는 역할을 한다.
>
> 🔹 Linux 데스크톱 환경(GNOME, KDE 등)은 **X 서버 위에서 실행됨**
> 🔹 Google Chrome 같은 **GUI 기반 애플리케이션도 X 서버가 필요**
>
> 하지만 **서버 환경(Linux 서버)**에서는 X 서버가 없다. 따라서, GUI 기반 프로그램(예: Chrome, Firefox 등)이 실행되지 않는다.



## 1. 가상 X 서버(Xvfb)의 역할

**Xvfb(X Virtual Frame Buffer)**는 X 서버가 없는 환경에서도
**가상의 프레임 버퍼를 제공하여 GUI 기반 애플리케이션을 실행할 수 있도록 도와준다.**

즉, Xvfb는 **"눈에 보이지 않는 가짜 모니터"**라고 생각하자.
🔹 실제 화면이 없지만 **GUI 애플리케이션이 실행될 수 있도록 환경을 제공**
🔹 X 서버가 없어도 **Chrome(또는 Puppeteer)이 정상 실행되도록 해줌**
🔹 **서버 환경에서 X11이 없어도 Chrome을 사용할 수 있음**



## 2. Puppeteer와 Xvfb가 필요한 이유

🎯 **문제: Linux 서버에서 GUI 없는 환경**

```bash
Error: Failed to launch the browser process! 
Missing X server or $DISPLAY
```

위와 같은 **"Missing X server"** 오류가 발생하는 이유:

- Puppeteer는 Chrome을 실행하는데, Chrome은 기본적으로 **X 서버(X11)가 필요하다**
- 서버 환경에서는 **GUI가 없기 때문에 실행 불가능**
- **해결 방법:** Xvfb를 사용하여 **가상의 X 서버 환경을 제공**하면 Chrome 실행 가능

## 3. Xvfb 동작 방식

1. Xvfb는 **가상의 X 서버**를 생성 (실제 모니터 없음)

2. X 서버가 필요한 Chrome과 같은 프로그램을 **이 가상 환경에서 실행**

3. Puppeteer(또는 Chrome)가 이 가상의 X 서버를 사용하여 렌더링 수행4
4. Puppeteer는 정상적으로 **웹 페이지를 열고, 스크린샷을 찍을 수 있음**

## 4. Xvfb 설치 및 실행 방법

### 1️⃣ **Xvfb 설치**

🔹 Ubuntu / Debian:

```bash
sudo apt install -y xvfb
```

🔹 Amazon Linux / CentOS:

```bash
sudo dnf install -y xorg-x11-server-Xvfb
```

### 2️⃣ **Xvfb 실행**

```bash
Xvfb :99 -screen 0 1920x1080x24 & export DISPLAY=:99
```

🔹 `:99` → X 서버의 가상 디스플레이 번호
🔹 `1920x1080x24` → 해상도 및 색상 비트 설정
🔹 `export DISPLAY=:99` → Chrome이 이 가상 디스플레이를 사용하도록 설정

### 3️⃣ **Puppeteer 실행**

```bash
xvfb-run node screen3.js
```

🔹 `xvfb-run`을 사용하면 Xvfb를 백그라운드에서 실행한 후 Puppeteer 실행



### 🎯 **Xvfb가 필요한 이유**

- **GUI 기반 프로그램(Chrome, Puppeteer 등)을 실행하기 위해 X 서버(X11)가 필요**
- **Linux 서버 환경에는 X 서버가 없어서 실행 불가능**
- **Xvfb가 가상의 X 서버 역할을 해서 Chrome 실행 가능하게 해줌**

### 🎯 **Xvfb 없이 실행하는 방법**

- **Puppeteer에서 완전한 헤드리스 모드(`headless: 'new'` + `--disable-gpu`) 사용**
- **이렇게 하면 X 서버 없이도 Puppeteer 실행 가능**

✅ **서버 환경이라면?**
➡️ **Xvfb를 설치하고 사용 (`xvfb-run node screen3.js`)**
✅ **완전한 Headless 모드 실행?**
➡️ **Xvfb 없이 실행 (`headless: 'new'`)**