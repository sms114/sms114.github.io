---
layout: single
title:  "[java] 객체 vs 인스턴스 이해"
categories: java
tag: [ java ]
author_profile: false
typora-root-url: ../
toc: true
toc_sticky: true
toc_label: "목차"
toc_icon: "fas fa-utensils" 
sidebar:
   nav: "counts"
search: true
---



## 클래스, 객체, 인스턴스 정리

### 클래스 - Class

클래스는 객체를 생성하기 위한 '틀' 또는 '설계도'이다. 클래스는 객체가 가져야 할 속성(변수)과 기능(메서드)를 정의한
다. 예를 들어 학생이라는 클래스는 속성으로 `name` , `age` , `grade` 를 가진다. 참고로 기능(메서드)은 뒤에서 설명한
다. 지금은 속성(변수)에 집중하자

* 틀: 붕어빵 틀을 생각해보자. 붕어빵 틀은 붕어빵이 아니다! 이렇게 생긴 붕어빵이 나왔으면 좋겠다고 만드는 틀일
  뿐이다. 실제 먹을 수 있는 것이 아니다. 실제 먹을 수 있는 팥 붕어빵을 객체 또는 인스턴스라 한다.
* 설계도: 자동차 설계도를 생각해보자. 자동차 설계도는 자동차가 아니다! 설계도는 실제 존재하는 것이 아니라 개
  념으로만 있는 것이다. 설계도를 통해 생산한 실제 존재하는 흰색 테슬라 모델 Y 자동차를 객체 또는 인스턴스라
  한다.



### 객체 - Object

객체는 클래스에서 정의한 속성과 기능을 가진 실체이다. 객체는 서로 독립적인 상태를 가진다.
예를 들어 위 코드에서 `student1` 은 학생1의 속성을 가지는 객체이고, `student2` 는 학생2의 속성을 가지는 객체이
다. `student1` 과 `student2` 는 같은 클래스에서 만들어졌지만, 서로 다른 객체이다.



### 인스턴스 - Instance

인스턴스는 특정 클래스로부터 생성된 객체를 의미한다. 그래서 객체와 인스턴스라는 용어는 자주 혼용된다. 인스턴스
는 주로 객체가 어떤 클래스에 속해 있는지 강조할 때 사용한다. 예를 들어서 `student1` 객체는 `Student` 클래스의
인스턴스다. 라고 표현한다.



### 객체 vs 인스턴스

둘다 클래스에서 나온 실체라는 의미에서 비슷하게 사용되지만, 용어상 인스턴스는 객체보다 좀 더 관계에 초점을 맞춘
단어이다. 보통 `student1` 은 `Student` 의 객체이다. 라고 말하는 대신 `student1` 은 `Student` 의 인스턴스이다.
라고 특정 클래스와의 관계를 명확히 할 때 인스턴스라는 용어를 주로 사용한다.

좀 더 쉽게 풀어보자면, 모든 인스턴스는 객체이지만, 우리가 인스턴스라고 부르는 순간은 특정 클래스로부터 그 객체가
생성되었음을 강조하고 싶을 때이다. 예를 들어 `student1` 은 객체이지만, 이 객체가 `Student` 클래스로부터 생성된
다는 점을 명확히 하기 위해 `student1` 을 `Student` 의 인스턴스라고 부른다.

하지만 둘다 클래스에서 나온 실체라는 핵심 의미는 같기 때문에 보통 둘을 구분하지 않고 사용한다.
