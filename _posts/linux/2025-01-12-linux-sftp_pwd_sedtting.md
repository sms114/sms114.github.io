---
layout: single
title:  "[linux] SFTP 비번 접속 및 VSCODE SETTING"
categories: [ linux ]
tag: [ linux, sshd, vscode, sftp ]
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

### 1. SFTP 비밀번호 설정

FTP 는 SSH 를 기반으로 동작하므로 SSH 계정의 비밀번호를 설정한다. 

#### 1-1. 비밀번호 설정

##### 1.  터미널을 열고, SFTP 사용 계정의 비밀번호를 설정한다.

```bash
$ sudo passwd ec2-user 
```

#### 2. sshd_config 파일 열기

```bash
$ sudo vi /etc/ssh/sshd_config
```

```bash
# Explicitly disable PasswordAuthentication. By presetting it, we
# avoid the cloud-init set_passwords module modifying sshd_config and
# restarting sshd in the default instance launch configuration.
#PasswordAuthentication no
PasswordAuthentication yes   // no 로 되어 있는 것을 yes 로 바꾼다.
PermitEmptyPasswords no
```

#### 3. SSH 서비스 재시작

위 설정을 저장한 후 SSH 서비스를 재시작한다.

```BASH
$ sudo systemctl restart ssh
```

---

---

SFTP 비밀번호 설정, `sshd_config` 수정, 그리고 Visual Studio Code로 연결하는 과정을 단계별로 쉽게 설명하겠습니다.

------

## 1. **SFTP 비밀번호 설정**

SFTP는 SSH를 기반으로 동작하므로 SSH 계정의 비밀번호를 설정합니다.

### 1-1. 비밀번호 설정

1. 터미널을 열고, SFTP 사용 계정의 비밀번호를 설정합니다:

   ```
   bash
   
   
   코드 복사
   sudo passwd [사용자명]
   ```

   예: 사용자명이 

   ```
   user
   ```

   라면:

   ```
   bash
   
   
   코드 복사
   sudo passwd user
   ```

2. 새 비밀번호를 입력하고 확인합니다.

------

## 2. **`sshd_config` 수정**

`sshd_config`는 SSH와 SFTP 설정을 제어하는 파일입니다.

### 2-1. `sshd_config` 파일 열기

```
bash


코드 복사
sudo nano /etc/ssh/sshd_config
```

### 2-2. 주요 설정 변경

파일에서 아래 내용을 확인하고 필요 시 수정합니다.

1. **SFTP 서브시스템 활성화 확인** 아래 내용이 포함되어 있는지 확인합니다.

   ```
   text
   
   
   코드 복사
   Subsystem sftp /usr/lib/openssh/sftp-server
   ```

   없다면 추가하거나 수정합니다.

2. **비밀번호 인증 활성화** 아래 두 줄이 포함되어 있는지 확인하고, `yes`로 설정합니다.

   ```
   text코드 복사PasswordAuthentication yes
   PermitRootLogin no
   ```

3. **SFTP 전용 계정 설정 (선택 사항)** 특정 사용자를 SFTP 전용으로 만들고 싶다면 아래를 추가합니다.

   ```
   text코드 복사Match User [사용자명]
       ChrootDirectory /home/[사용자명]
       ForceCommand internal-sftp
       AllowTcpForwarding no
       X11Forwarding no
   ```

   예: 사용자명이 `user`라면:

   ```
   text코드 복사Match User user
       ChrootDirectory /home/user
       ForceCommand internal-sftp
       AllowTcpForwarding no
       X11Forwarding no
   ```

### 2-3. SSH 서비스 재시작

설정을 저장한 후 SSH 서비스를 재시작합니다.

```
bash


코드 복사
sudo systemctl restart ssh
```

------

## 3. **Visual Studio Code로 연결**

VS Code에서 SFTP를 사용하려면 SSH 확장 프로그램이 필요합니다.

### 3-1. SSH 확장 설치

1. VS Code를 열고, **Extensions (확장)** 아이콘을 클릭합니다.
2. **"SFTP/FTP sync"**를 검색하고 설치합니다.
   --> 난  Natizyskunk 가 Owner 인 extension 을 깔았다.
   - sftp sync extension for VS Code 
   - Maintained and updated version by [@Natizyskunk](https://github.com/Natizyskunk/) 😀
   - VS Code marketplace : https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp
   - VSIX release : https://github.com/Natizyskunk/vscode-sftp/releases/

### 3-2. SSH 연결 설정

1. VS Code에서 **F1** 또는 **Ctrl+Shift+P**를 누르고, **SFTP:Config**를 선택합니다.

   - 이렇게 선택하면, .vscode > sftp.json 파일이 생성된다.

     ```js
     {
         "name": "My Server",
         "host": "43.200.153.xxx",
         "protocol": "sftp",
         "port": 22,
         "username": "ec2-user",
         "password": "xxxxxx",
         "remotePath": "/var/www/html",
         "uploadOnSave": true,   // upload 할 때, 자동으로 save 가 되는 옵션
         "useTempFile": false,
         "openSsh": false
     }
     ```

   - 위 sftp.json 파일을 저장하고, 다시 F1 Key를 누르면, 이전 보다 많은 명령어 리스트가 나온다
     

     ![250112_vscode](/../images/2025-01-12-linux-sftp_pwd_sedtting/250112_vscode.png)
     

   - sftp:List All 을 선택한다. 그리고 엔터, 그리고 또 엔터

   - 그러면 sftp 로 연결된 내 Amazon EC2 인스턴스 내, /var/www/html 폴더에 존재하는 파일 List 가 보일 것이다.
     아래는, sms114amazone 경로와 연결된 ec2 linux 원격 서버와 연결된 상태의 vscode 이다.

     ![image-20250112231845780](/../images/2025-01-12-linux-sftp_pwd_sedtting/image-20250112231845780.png)

     ### 기타 메모 

     * 왼쪽 Dashboard 에 파일또는 폴더를 삭제해도 로컬에 있는 것이 삭제될 뿐, 원격 서버에 있는 폴더 또는 파일이 삭제되는 것이 아니다.



