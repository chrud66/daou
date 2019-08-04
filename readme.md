* * * 
기술면접 소스코드 
=
>  개요

* * * 

> 필수 조건
- Framework 사용 - Laravel
- 테이블 ERD
- 차별화된 기술
- 이미지 첨부 기능 및 상세 페이지 이미지 출력
- 계층형 댓글 기능

* * * 

> 개발 환경 정리
- Server OS - Ubuntu 18.04.1 LTS
- Language - PHP [Version 7.2.12]
- Framework - Laravel [Version 5.8]
- Database - Mysql [Version 5.7.24]
- NoSql - Redis [Version 4.0.9]

* * * 

> 설명

라라벨 프레임워크를 사용하여 기본적인 MVC 기반 게시판을 작업하였습니다.

모든 소스코드는 https://github.com/chrud66/daou 에서 확인 할 수 있습니다.

- 구현 기능 간략 정리
    - 게시판 CRUD
    - 게시판 파일 업로드
    - 댓글 CRUD (뎁스 무제한)
    - 간단한 Like 검색

필수 조건인 차별화된 기술을 사용하기 위해 오픈소스인 dropzone.js를 사용하여 드래그 앤 드랍 파일업로드 기능을 구현했습니다.

또 한가지 차별화된 기술로는 Redis를 이용한 캐싱을 구현하였습니다.
캐싱의 경우 Laravel 프레임 워크에서 기본적인 지원을 해주기때문에 매우 간편하게 캐싱 시스템을 구성하고 적용할 수 있습니다.
