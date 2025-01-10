---
layout: single
title:  "[linux,bashrc] .bashrc 손상 후 amazon EC2 접속 실패시 해결방법"
categories: [ linux ]
tag: [ linux, bashrc, amazon ]
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

sddfasdfasd

## .bashrc 수정 후 ec2 인스턴스에 접속이 안될 때 해결 방법

Amazon EC2 인스턴스에서

alias 지정을 지정을 통해 좀 더 편의를 주기 위해 .bashrc 내 alias 수정을 했는데, 아예 어떤 방법으로도 접속이 안된다.

큰일났다!! :cry:



이때는 .bashrc 및 .bash__profile 을 우회해서 접속해야 한다.

1. keypair가 저장된 local 폴더에서 git bash 로 에뮬레이터로 접속한다.

![image-20250110113931347](/../images/2025-01-10-linux_amaon_bashrc_fixing/image-20250110113931347.png)

2. 아래와 같이,  .bashrc 나 .bash_profile 의 실행을 무시하는 옵션을 통해 bash  환경에 접속 한다.

```js
SAMSUNG@DESKTOP-innolifes MINGW64 /c/Utils/AWS-Keypair
$ ssh -i "my-keypair.pem" -t ec2-user@43.200.153.xxx bash --noprofile --norc
--> 의미 : 사용자 설정을 무시한 클린한 환경에서 bash 실행.
```

---

SSH 명령어의 **`-t` 옵션**은 **터미널 할당**을 의미해. 원격 서버에 접속할 때, 터미널 세션을 강제로 할당하여 명령어를 실행하거나 대화형 프로그램(예: `bash`, `top`, `htop`)을 실행할 수 있도록 해줘.

------

## **`-t` 옵션의 의미와 기능**

### 1️⃣ **터미널 강제 할당**

- 기본적으로 SSH는 **명령 실행**만을 위해 사용되며 터미널 세션이 필요하지 않은 경우도 있어.
- 하지만 `-t` 옵션을 사용하면, 터미널 세션을 강제로 생성하여 대화형 작업을 가능하게 해.

### 2️⃣ **터미널 세션이 필요한 상황**

다음과 같은 경우에 유용:

- 원격 서버에서 **대화형 쉘** 실행 (`bash`, `sh`, `zsh` 등).
- **대화형 프로그램** 실행 (`top`, `htop`, `vim`, `nano` 등).
- **sudo** 명령 실행 시, 암호 입력이 필요한 경우.

------

## **`-t` 옵션이 사용된 명령의 동작**

### 예시:

```
bash


코드 복사
ssh -t user@host bash
```

#### 동작:

1. 터미널 세션 강제 생성

   :

   - 원격 서버에서 **`bash` 쉘**이 실행되도록 터미널을 생성.

2. 대화형 작업 가능

   :

   - 쉘 환경에서 명령을 자유롭게 입력 가능.

------

## **`-t bash`의 추가 옵션과 조합**

### 1️⃣ **`-t`와 특정 쉘**

- `bash` 또는 다른 쉘을 명시적으로 실행할 때 사용:

  ```
  bash
  
  
  코드 복사
  ssh -t user@host bash
  ```

- 기본 쉘이 아닌 특정 쉘을 실행할 때:

  ```
  bash
  
  
  코드 복사
  ssh -t user@host zsh
  ```

### 2️⃣ **`--noprofile --norc`와 함께 사용**

- `.bashrc`나 `.bash_profile`의 실행을 무시하고 기본 `bash` 환경을 열 때:

  ```
  bash
  
  
  코드 복사
  ssh -t user@host bash --noprofile --norc
  ```

- **의미**: 사용자 설정을 무시한 클린한 환경에서 `bash` 실행.

------

# 기타.

## **`-t` 옵션이 없는 경우**

### 동작 차이:

- 대화형 프로그램 실행이 불가능할 수 있음.

- 예를 들어, 아래 명령은 

  ```
  -t
  ```

  가 없어서 대화형 작업이 제한될 가능성이 있음:

  ```
  bash
  
  
  코드 복사
  ssh user@host bash
  ```

------

## **`-t`의 주의점**

- 여러 SSH를 중첩 연결하거나, 비대화형 명령을 실행할 때는 필요하지 않음.
- 필요하지 않은 경우 `-t` 옵션을 사용하면 터미널 할당으로 인해 불필요한 리소스가 소비될 수 있음.

