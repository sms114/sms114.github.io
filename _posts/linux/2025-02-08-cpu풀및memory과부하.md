---
layout: single
title:  "[linux] linux 서버 OOM 상황에 대한 메모"
categories: [ linux ]
tag: [ linux, swap, memory, cpu, 과부하]
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

# 메모리 과부하 상태에 대한 메모랜다

![화면 캡처 2025-02-08 084707](/../images/2025-02-08-cpu풀및memory과부하/화면 캡처 2025-02-08 084707.png)

## > 위에서처럼 swap 이라는 process가 생겼다는 것의 의미에 대한 고찰

**kswapd0 는 리눅스 커널의 가상 메모리 관리 프로세스로, 시스템 메모리의 부족을 감지하면 스왑(Swap) 영역을 적극적으로 활용하여 페이지를 디스크로 내보내는 역할을 한다. 위 상태에서 kswap0 가 CPU를 99.9% 사용하고 있다는 것은 메모리 부족(Out of Memory, OOM) 상태이거나 페이지 스왑이 과도하게 발생하고 있다는 신호로 여겨도 좋다.**

---

### 🔍 `kswapd0` 과부하 원인

1. **물리 메모리 부족**
   - `free -m` 명령어로 메모리 상태 확인 (`available` 값이 거의 0에 가까우면 위험)
   - `top` 또는 `htop`으로 메모리를 많이 사용하는 프로세스 찾기
2. **스왑 과다 사용**
   - `swapon -s` 또는 `free -m`에서 Swap 사용량 확인
   - `vmstat 1`을 실행하여 `si`(Swap-in) 및 `so`(Swap-out) 값이 높으면 스왑 과부하
3. **Page Cache 또는 Buffer 과다 사용**
   - `cat /proc/meminfo | grep -E 'Dirty|Writeback|Mapped'` 확인
   - 캐시된 데이터가 많아 swap이 증가했을 가능성
4. **swappiness 값이 너무 높음**
   - `cat /proc/sys/vm/swappiness` 확인
   - 기본값(60)이 높아 swap을 너무 적극적으로 사용하고 있을 가능성

### 🛠 해결 방법

✅ **메모리 사용량 줄이기**

- `ps aux --sort=-%mem | head -10` 으로 메모리 많이 쓰는 프로세스 정리
- 불필요한 서비스 종료 (`systemctl stop {service_name}`)

✅ **스왑 최적화**

- `sysctl -w vm.swappiness=10` 로 swappiness 값 낮추기
- 필요하면 `/etc/sysctl.conf`에 `vm.swappiness=10` 추가

✅ **캐시 메모리 정리 (일시적 해결)**

```
bash


복사편집
sync; echo 3 > /proc/sys/vm/drop_caches
```

✅ **RAM 증설 또는 OOM Killer 설정**

- 물리 RAM이 부족하면 증설 고려
- OOM Killer가 적절히 동작하는지 확인 (`dmesg | grep -i oom`)

---

## Amazon EC2 2023 에서 인스턴의 메모리 증설 및 CPU 확인

