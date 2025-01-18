---
layout: single
title:  "[linux] 심볼릭 링크 설정"
categories: [ linux ]
tag: [ linux, symbolic ]
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

## 심볼릭 링크 확인

아래 symbolic 링크 처리시 오류 메시지 확인

```bash
sudo ln -s /opt/certbot/bin/certbot /usr/bin/certbot
ln: failed to create symbolic link '/usr/bin/certbot': File exists
```



**_How should i do?_** 



1. 일단, 해당 /usr/bin/certbot 을 ls 로 조회해 본다.

![image-20250118130834274](/../images/2025-01-18-symbolicLink_knowlege/image-20250118130834274.png)



이미  symbolic link 가 설정되어 있었기에, fail 난 것. 문제없음.



### 1️⃣ **기존 링크나 파일 확인**

우선 `/usr/bin/certbot`이 어떤 상태인지 확인해 봐야 해.

```
ls -l /usr/bin/certbot
```

출력 결과로 **심볼릭 링크**인지, 아니면 **일반 파일**인지 확인할 수 있어:

- **심볼릭 링크:** 출력에 `->`가 포함되어 있다면 심볼릭 링크임.
- **일반 파일:** 출력에 `->`가 없고 그냥 파일 정보만 나옴.



### 2️⃣ **기존 링크 삭제 또는 덮어쓰기**

- 심볼릭 링크인 경우:

   기존 심볼릭 링크를 삭제하고 새로 만들어!

  ```
  sudo rm /usr/bin/certbot
  sudo ln -s /opt/certbot/bin/certbot /usr/bin/certbot
  ```

- 일반 파일인 경우:

   먼저 기존 파일을 백업하고, 심볼릭 링크를 생성해!

  ```
  sudo mv /usr/bin/certbot /usr/bin/certbot.bak
  sudo ln -s /opt/certbot/bin/certbot /usr/bin/certbot
  ```



### 3️⃣ **작동 확인**

새로운 링크가 잘 작동하는지 확인하려면 아래 명령어를 실행해 봐:

```
certbot --version
```

정상적으로 버전 정보가 출력되면 성공! 🎉