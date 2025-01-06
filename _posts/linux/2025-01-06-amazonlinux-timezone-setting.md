---
layout: single
title:  "[linux] 타임존 설정 변경 및 확인해보기"
categories: linux
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

```bash
# 🕰️ Linux에서 UTC를 KST로 바꾸기! (한 번에 실행 가능)

# 1. 현재 설정된 타임존 심볼릭 링크 삭제
sudo rm /etc/localtime

# 2. 새로운 타임존으로 심볼릭 링크 생성 (Asia/Seoul)
sudo ln -s /usr/share/zoneinfo/Asia/Seoul /etc/localtime

# 3. 변경된 타임존 확인
date

```

### 💡 실행 방법

1. 위의 **코드 블록 전체**를 복사해서 터미널에 붙여넣기.
2. 실행 후, 시간이 **KST (Korea Standard Time)**로 바뀌었는지 확인하세요! 🎉



## 💡 결과 확인하기

명령어 실행 후, 결과가 이렇게 나오면 성공! 🎉

```bash
2023. 02. 28. (화) 14:50:41 KST
```

