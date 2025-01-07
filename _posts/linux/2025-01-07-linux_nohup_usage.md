---
layout: single
title:  "[linux | nohup] nohup 과 &(백그라운드) 명령어 격파"
categories: [ linux ]
tag: [ linux, nohup ]
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

리눅스를 사용하다 보면 프로그램을 백그라운드에서 세션과의 연결이 끊어져도 돌려야할 일이 많이 발생합니다. 

그럴때 주로 사용하는 명령어가 바로 nohup 과 & 명령어 입니다.

---

### 1. nohup 명령어란?



nohup은 no hang up 의 약자 입니다. 해석 그대로 **"끊지마!"** 입니다.

내가 세션과 연결을 종료해도 지금 실행시킨 프로그램을 종료하지 마! 라는 것이죠. 



### 2. nohup 은 어떻게 사용하나요?

```
$ nohup ./my_shellscript.sh
```

이렇게 실행시키면 " nohup: appending output to `nohup.out` " 메세지와 함께 해당 프로그램의 표준출력이, nohup 을 실행시킨 경로에 nohup.out으로 출력됩니다

__**주의사항!! nohup으로 실행시킬 파일은 반드시 755 퍼미션을 가지고 있어야 합니다.**__

### 3. nohup의 표준출력을 다른파일에 쓰고 싶다면?

```
$ nohup ./my_shellscript.sh > nohup_script.out
```

' > ' 또는 ' >> ' 와 같은 리다이렉션을 이용해서 다른 파일에 출력할 수 있습니다.

 

만약 어디에도 표준출력을 기록하고 싶지 않다면, 다음과 같이 실행하면 됩니다.

```
$ nohup ./my_shellscript.sh > /dev/null
```

 

### 4. & 은 어디에 쓰는거야?

& 를 프로그램 실행시에 명령어 맨 끝에 붙여주면 해당 프로그램이 백그라운드로 실행됩니다.

```
$ ./my_shellscript.sh &
```

이렇게 사용하면 my_shellscript가 Foreground가 아니라 백그라운드에서 실행되게 되죠.

 

```
$ ps -ef | grep my_shellscript.sh
```

다음 명령어를 통해서 백그라운드로 돌고 있는 것을 확인 할 수 있습니다.

 

### 5. nohup과 &(백그라운드) 차이가 뭐야?

 **nohup은** 프로그램을 데몬의 형태로 실행시키는 것이기 때문에 앞서 설명드린데로 로그아웃으로 세션이 종료되더라도 프로그램이 종료되지 않습니다.

 그러나 **&(백그라운드)** 실행은 단지 프로그램을 사용자 눈에 보이지 않는 백그라운드 형태로 돌리고 있는 것이기 때문에 로그아웃으로 세션과 연결이 끊어지면 실행되고 있던 프로그램도 함께 종료됩니다. 그런데 언젠가부터 &(백그라운드)로 돌리더라도 nohup과 동일하게 세션이 끊어져도 프로그램이 종료되지 않는 옵션이 디폴트로 적용되었기 때문에, 두 명령어의 동작이 유사하게 보이는 것입니다.

 

```
$ shopt | grep huponexit
```

shopt는 쉘옵션을 조회해볼 수 있는 명령어로, 위의 명령어를 실행해서 " huponexit off " 라고 나오면 &만으로만 프로그램을 실행해도 세션 연결 종료시에 프로그램이 종료되지 않습니다.

 

### 6. nohup과 &(백그라운드) 어떻게 쓰면 좋은거야?

아마 대부분의 리눅스 유저분들이 "nohup + &" 조합으로 외우고 계실 것입니다. 

네! **어떤 프로그램을 종료 없이 백그라운드에서 실행시키고 싶으시다면** 그냥 저렇게 조합해서 쓰는게 제일 확실하고 안전한 방법 인것 같습니다.

```
$ nohup ./my_shellscript.sh &
```

 

### 7. Log를 내가 원하는 곳에 쌓고 싶어!

nohup을 사용하면 기본적으로 nohup.out에 표준출력이 쌓이지만, 때때로 표준출력과 표준에러를 각각 다른 파일에 쓰고 싶을 때도 있을 것입니다. 또 때로는 한 파일에 표준출력과 표준에러를 같이 쌓고 싶은 경우도 있을 것입니다. 이럴 경우에 대해 각각 알아 보겠습니다.

 

> 0 : 표준 입력
> 1 : 표준 출력
> 2 : 표준 에러

 

#### 1) 표준출력과 표준에러를 다른 파일에 쓰고 싶어!

```
$ nohup ./my_shellscript.sh 1 > my_shellscript.out 2 > my_shellscript.err &
```

표준 출력(1)은 my_shellscript.out 파일로 리다이렉션하고, 표준 에러(2)는 my_shellscript.err 파일로 리다이렉션 하겠다는 뜻입니다.

 

 

#### 2) 표준출력과 표준에러를 같은 파일에 쓰고 싶어!

```
$ nohup ./my_shellscript.sh > my_shellscript.log 2>&1 &
```

nohup 표준출력을 my_shellscript.log에 쓰고 표준 에러(2)도 표준출력(1)이 쓰여지는 파일에 리다이렉션 하겠다는 뜻입니다.

 

### 8. 그럼 프로세스 종료는 어떻게 하지?

자! 이제 백그라운드로 세션 종료시에도 프로그램 종료 없이 실행시키는 법은 잘 알겠습니다. 그럼 이제 그만 실행시키고 싶을 때는 어떻게 할까요?

ps 명령어를 통해서 프로세스 아이디를 알아내고, kill 명령어로 프로세스를 종료시키면 됩니다.

 

```
### 프로세스 아이디 알아내기
$ ps -ef | grep my_shellscript.sh
### 프로세스 종료
$ kill -9 <프로세스 아이디>
```

 

여기까지 nohup과 &(백그라운드)에 대해 알아보았습니다.

