---
layout: single
title:  "[git] git summary"
categories: git
tag: [ git]
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

# git summary

## 1. git 최신 내용 로컬로 가져오기

```bash
git pull origin main --rebase
```

변경 사항을 다시 푸시하기

```bash 
git push origin main
```

그래도 안 될 경우, 강제 푸시( -- force  사용은 신중하게 해야 함.)

```bash
git push origin main --force
```



## 이 오류는 **GitHub 원격 저장소(GitHub)에 있는 내용과 내 로컬 저장소가 동기화되지 않아서 발생하는 문제 해결**

>오류 분석: "Updates were rejected because the remote contains work that you do not have locally"

```git
$ git push -u origin main
To https://github.com/sms114/0bsidian-public-repository-2025-01-31.git
 ! [rejected]        main -> main (fetch first)
error: failed to push some refs to 'https://github.com/sms114/0bsidian-public-repository-2025-01-31.git'
hint: Updates were rejected because the remote contains work that you do
hint: not have locally. This is usually caused by another repository pushing
hint: to the same ref. You may want to first integrate the remote changes
hint: (e.g., 'git pull ...') before pushing again.
hint: See the 'Note about fast-forwards' in 'git push --help' for details
```

위 경우, 

```bash
git pull origin main --rebase
```

`--rebase` 옵션은 **내 로컬 변경 사항을 최신 원격 변경 사항 뒤에 추가하는 방식**이라 충돌을 최소화할 수 있어.



# GitHub 원격 저장소 추가

1. 먼저 git 을 사용할 폴더로 이동

   ```bash
   cd "C:\Tool\firstVault"
   ```

2. git status

3. git init

4. git remote add origin https://github.com/sms114/0bsidian-public-repository-2025-01-31.git

5. git remote -v  // 정상적으로 연결되었는지 확인
   ```bash
   origin  https://github.com/sms114/0bsidian-public-repository-2025-01-31.git (fetch)
   origin  https://github.com/sms114/0bsidian-public-repository-2025-01-31.git (push)
   ```

6. GitHub에 처음으로 파일 업로드
   ```git
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git push -u origin main
   ```

7. GitHub에서 변경 사항을 로컬로 가져오기 (pull)
   $ git pull origin main

8. 이후 변경된 파일을 GitHub에 업로드하는 방법
   ```git
   git add .
   git commit -m "Updated files"
   git push origin main
   ```

   

   