---
layout: single
title:  "[java] 생성자에 대한 기본적인 학습"
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

## 기본 생성자
생각해보면 생성자를 만들지 않았는데, 생성자를 호출한 적이 있다. 다음 코드들을 다시 확인해보자.

```java
public class MemberInit {
String name;
int age;
int grade;
}
```
```java
public class MethodInitMain1 {
public static void main(String[] args) {
MemberInit member1 = new MemberInit();
...
}
}
```
여기서 `new MemberInit()` 이 부분은 분명히 매개변수가 없는 다음과 같은 생성자가 필요할 것이다.
```java
public class MemberInit {
String name;
int age;
int grade;
MemberInit() { //생성자 필요
}
}
```
**기본 생성자**
매개변수가 없는 생성자를 기본 생성자라 한다.
클래스에 생성자가 하나도 없으면 자바 컴파일러는 매개변수가 없고, 작동하는 코드가 없는 기본 생성자를 자동으
로 만들어준다.
**생성자가 하나라도 있으면 자바는 기본 생성자를 만들지 않는다.**
`MemberInit` 클래스의 경우 생성자를 만들지 않았으므로 자바가 자동으로 기본 생성자를 만들어준 것이다.
예제를 통해서 기본 생성자를 확인해보자.
**MemberDefault**

```java
package construct;
public class MemberDefault {
String name;
}
```
**MemberDefaultMain**
```java
package construct;
public class MemberDefaultMain {
public static void main(String[] args) {
MemberDefault memberDefault = new MemberDefault();
}
}
```
`MemberDefault` 클래스에는 생성자가 하나도 없으므로 자바는 자동으로 다음과 같은 기본 생성자를 만들어준다.
(우리 눈에 보이지는 않는다.)
**MemberDefault - 기본 생성자**
```java
package construct;
public class MemberDefault {
String name;
//기본 생성자
public MemberDefault() {
}
}
```
**참고**: 자바가 자동으로 생성해주시는 기본 생성자는 클래스와 같은 접근 제어자를 가진다. `public` 은 뒤에 접근 제어
자에서 자세히 설명한다.
물론 다음과 같이 기본 생성자를 직접 정의해도 된다.
```java
package construct;
public class MemberDefault {
String name;
MemberDefault() {
System.out.println("생성자 호출");
}
}
```
**실행 결과**
```
생성자 호출
```
**기본 생성자를 왜 자동으로 만들어줄까?**
만약 자바에서 기본 생성자를 만들어주지 않는다면 생성자 기능이 필요하지 않은 경우에도 모든 클래스에 개발자가 직
접 기본 생성자를 정의해야 한다. 생성자 기능을 사용하지 않는 경우도 많기 때문에 이런 편의 기능을 제공한다.
**정리**
생성자는 반드시 호출되어야 한다.
생성자가 없으면 기본 생성자가 제공된다.
**생성자가 하나라도 있으면 기본 생성자가 제공되지 않는다.** 이 경우 개발자가 정의한 생성자를 직접 호출해야 한
다.



## 생성자 - 오버로딩과 this()
생성자도 메서드 오버로딩처럼 매개변수만 다르게 해서 여러 생성자를 제공할 수 있다.
**MemberConstruct - 생성자 추가**

```java
package construct;
public class MemberConstruct {
String name;
int age;
int grade;
//추가
MemberConstruct(String name, int age) {
this.name = name;
this.age = age;
this.grade = 50;
}
MemberConstruct(String name, int age, int grade) {
System.out.println("생성자 호출 name=" + name + ",age=" + age + ",grade="
+ grade);
this.name = name;
this.age = age;
this.grade = grade;
}
}
```
기존 `MemberConstruct` 에 생성자를 하나 추가해서 생성자가 2개가 되었다.
```java
MemberConstruct(String name, int age)
MemberConstruct(String name, int age, int grade)
```
새로 추가한 생성자는 `grade` 를 받지 않는다. 대신에 `grade` 는 `50` 점이 된다.
```java
package construct;
public class ConstructMain2 {
public static void main(String[] args) {
MemberConstruct member1 = new MemberConstruct("user1", 15, 90);
MemberConstruct member2 = new MemberConstruct("user2", 16);
MemberConstruct[] members = {member1, member2};
for (MemberConstruct s : members) {
System.out.println("이름:" + s.name + " 나이:" + s.age + " 성적:" +
s.grade);
}
}
}
```
**실행 결과**
```
생성자 호출 name=user1,age=15,grade=90
이름:user1 나이:15 성적:90
이름:user2 나이:16 성적:50
```
생성자를 오버로딩 한 덕분에 성적 입력이 꼭 필요한 경우에는 `grade` 가 있는 생성자를 호출하면 되고, 그렇지 않은 경
우에는 `grade` 가 없는 생성자를 호출하면 된다. `grade` 가 없는 생성자를 호출하면 성적은 `50` 점이 된다.
this()
두 생성자를 비교해 보면 코드가 중복 되는 부분이 있다.
```java
public MemberConstruct(String name, int age) {
this.name = name;
this.age = age;
this.grade = 50;
}
public MemberConstruct(String name, int age, int grade) {
this.name = name;
this.age = age;
this.grade = grade;
}
```
바로 다음 부분이다.
```java
this.name = name;
this.age = age;
```
이때 `this()` 라는 기능을 사용하면 생성자 내부에서 자신의 생성자를 호출할 수 있다. 참고로 `this` 는 인스턴스 자신
의 참조값을 가리킨다. 그래서 자신의 생성자를 호출한다고 생각하면 된다.
코드를 다음과 같이 수정해보자.
**MemberConstruct - this() 사용**
```java
package construct;
public class MemberConstruct {
String name;
int age;
int grade;
MemberConstruct(String name, int age) {
this(name, age, 50); //변경
}
MemberConstruct(String name, int age, int grade) {
System.out.println("생성자 호출 name=" + name + ",age=" + age + ",grade="
+ grade);
this.name = name;
this.age = age;
this.grade = grade;
}
}
```
이 코드는 첫번째 생성자 내부에서 두번째 생성자를 호출한다.
```java
MemberConstruct(String name, int age) -> MemberConstruct(String name, int age,
int grade)
```
`this()` 를 사용하면 생성자 내부에서 다른 생성자를 호출할 수 있다. 이 부분을 잘 활용하면 지금과 같이 중복을 제거
할 수 있다. 물론 실행 결과는 기존과 같다.
**this() 규칙**
`this()` 는 생성자 코드의 첫줄에만 작성할 수 있다.
다음은 규칙 위반이다. 이 경우 컴파일 오류가 발생한다.
```java
public MemberConstruct(String name, int age) {
System.out.println("go");
this(name, age, 50);
}
```
`this()` 가 생성자 코드의 첫줄에 사용되지 않았다.