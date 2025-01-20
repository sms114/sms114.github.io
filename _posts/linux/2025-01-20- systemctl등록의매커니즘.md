---
layout: single
title:  "[linux] sudo systemctl enable httpd 의 해부"
categories: [ linux ]
tag: [ linux, dnf, yum]
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

## sudo systemctl enable httpd  의 해부



`sudo systemctl enable httpd` 명령은 Linux 시스템에서 Apache 웹 서버(`httpd`)를 부팅 시 자동으로 시작되도록 등록하는 작업을 수행해. 이 과정에서 시스템의 **systemd** 메커니즘을 사용한다.

------

## 1. **명령 실행의 역할**

### 명령 설명:

```
sudo systemctl enable httpd
```

- **`systemctl`**: systemd의 컨트롤 유틸리티.
- **`enable`**: 지정된 서비스(`httpd`)를 부팅 시 자동으로 실행되도록 설정.
- **`httpd`**: Apache HTTP Server의 서비스 이름.

------

## 2. **내부 동작: 등록 과정**

### (1) **유닛 파일(Symbolic Link) 생성**

- `enable` 명령은 서비스의 **유닛 파일**을 특정 디렉토리에 심볼릭 링크로 등록해.

- 이 유닛 파일은 일반적으로 `/usr/lib/systemd/system/httpd.service`에 저장되어 있어.

- **작업 디렉토리**:

  - 심볼릭 링크가 생성되는 위치는 `/etc/systemd/system/multi-user.target.wants/`야.
  - 이 디렉토리는 시스템이 **multi-user.target**(텍스트 모드 또는 일반 서비스 실행 단계)에서 실행할 유닛을 지정해.

  ```
  ls -l /etc/systemd/system/multi-user.target.wants/httpd.service
  ```

  위 명령으로 심볼릭 링크를 확인할 수 있어. 이 링크가 `/usr/lib/systemd/system/httpd.service`를 가리키고 있을 거야.

------

### (2) **서비스 활성화 등록**

- 심볼릭 링크가 생성되면, systemd는 부팅 시 **multi-user.target**을 로드할 때 해당 디렉토리의 유닛 파일들을 실행하도록 예약해.
- 따라서, `httpd`는 시스템 부팅 시 자동으로 로드돼.

------

## 3. **자동 실행 확인**

`httpd`가 부팅 시 실행되도록 제대로 설정되었는지 확인하려면, 다음 명령어를 사용하면 돼:

### (1) **유닛 활성화 상태 확인**

```
systemctl is-enabled httpd
```

- 출력: `enabled`라면 정상적으로 등록된 거야.

### (2) **부팅 시 실행 목록 확인**

```
systemctl list-dependencies multi-user.target
```

- 이 명령을 사용하면 `multi-user.target`에 종속된 유닛 파일의 목록이 출력돼. 여기에서 `httpd.service`를 찾아봐.

### (3) **현재 상태 확인**

```
systemctl status httpd
```

- Apache 서비스의 현재 상태와 활성화 여부를 확인할 수 있어.

------

## 4. **부팅 시 자동 실행 확인**

시스템이 부팅된 후 실제로 `httpd`가 실행되는지 확인하려면 다음 방법을 사용해:

### (1) **서비스 상태 확인**

```
sudo systemctl status httpd
```

- 서비스가 활성 상태(active)인지 확인.

### (2) **포트 확인**

`httpd`가 제대로 실행되었으면 기본적으로 80번 포트를 사용하므로:

```
sudo netstat -tuln | grep 80
```

- 또는:

```
ss -tuln | grep 80
```

------

## 5. **추가 확인: 부팅 로그**

부팅 시 `httpd`가 로드되었는지 로그로도 확인할 수 있어:

```
journalctl -u httpd
```

- `journalctl`은 systemd 로그를 확인할 수 있는 명령어야.
- 여기서 `httpd` 서비스가 언제, 어떻게 시작되었는지 자세히 볼 수 있어.