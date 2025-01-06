---
layout: single
title:  "[linux] amazon 키페어 재등록 방법"
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

## 쉬운 방법을 너무 어렵게 생각하게 되면 겪는 일들

AWS amazon 의 키페어를 잘 못 등록했다. 그 키페어 교체를 너무 어렵게 생각해서 3시간을 허비했다. 왜 그런 실수가 잦은 것인가?



### 새로운 키페어의 공개 키를 가져오기

1. 다시 매핑할 새로운 키 페어의 공개 키를 추출해야 한다.

```bash
ssh-keygen -y -f /path/to/new-key.pem
```

2. 출력된 공개키를 복사해둔다( 예: ssh-rsa AAAABB3.....)

```js
ssh-rsa AAAABssss3NzaC1yc2EAAAADAQABsdfaQCw93eZ5CCTvtelAvQzLHbjLAeeSXK+zEogz3gMaUQGrl0D9ewlO1xc3iLY2ZZnvnTMphRFd1rtdkasdfasdfOjhJpVrrvvWrgiPqTsM81sssffffsKiFL0UIMP2fA3R2KPHBALhMP0FjrTq/2UTfeCbaO4Sv0a6FvXAdDCAwDY9mB2mn4ZMv7WfsdfasdfTolDZ6djkOQRVgjDzLeMJkNDXwKAWmWzFdNIo+noPVFXmBgJMQmgEc+W1nZ0edvxXfYxxnhpx7NBdsVORsp6/mHdEJO0VNBQiLfB8pmcllS4ZpKdrsoHyWer8xEyrESFwc9r4h/dBXhLSbolpCciiFzjS037y2LenuGh5S0XN
```

### 새로운 키페어 등록

적용하려는 E2 인스턴스에 접속해서, 복사한 공개 키를 EC2 인스턴스에 등록한다.

```js
cd /home/ec2-user/.ssh
vi authorized_keys
```

기존 키를 복사 붙이기 하고 저장한다.

### 새로운 키로 연결 테스트

로컬 또는 node2 에서 새로운 키 페어를 사용해 SSH로 접속 테스트 해 본다.

```js
cd /home/ec2-user
ssh -i ec2-user@<인스턴스의 퍼블릭 IP>
```

매우 간단한 이 사실을 너무 늦게 깨달아버렸다. 