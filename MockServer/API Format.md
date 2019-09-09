# 요청 & 응답 포맷

- 요청 형식: GET (URL query string)
- 응답 형식: JSON (application/json; charset=utf-8)

## 예외 상황
- 응답할 데이터가 없는 경우
  - HTTP 응답 코드 404 (Not Found)
- 파라미터가 잘못 설정된 경우
  - HTTP 응답 코드 400 (Bad Request)

## 위치 리스트
### 요청
#### L1 위치 리스트
> 요청 예시
> 
>     android.php

- 파라미터
  - 없음

#### L2 위치 리스트
> 요청 예시
> 
>     android.php?L1=서울

- 파라미터
  - L1: 최상위 지역 이름

#### L3 위치 리스트
> 요청 예시
> 
>     android.php?L1=서울&L2=동작구

- 파라미터
  - L1: 최상위 지역 이름
  - L2: L1의 하위 지역 이름

#### L4 위치 리스트
> 요청 예시
> 
>     android.php?L1=서울&L2=동작구&L3=흑석동

- 파라미터
  - L1: 최상위 지역 이름
  - L2: L1의 하위 지역 이름
  - L3: L2의 하위 지역 이름

### 응답
> 응답 예시 (L1 위치 리스트)
> 
>     {
>         "data":
>         [
>             "서울",
>             "인천"
>         ]
>     }

- data: JSON List
  - String, 위치 이름

## 특정 위치의 최근 데이터
### 요청
> 요청 예시
> 
>     android.php?L1=서울&L2=동작구&L3=흑석동&L4=3

- 파라미터
  - L1: 최상위 지역 이름
  - L2: L1의 하위 지역 이름
  - L3: L2의 하위 지역 이름
  - L4: L3의 하위 지역 이름

### 응답
> 응답 예시
>
>     {
>         "idlocation": "서울-동작-흑석-3",
>         "data":
>         [
>             {
>                 "desc": "수소이온농도",
>                 "upperBound": 8.5,
>                 "lowerBound": 5.8,
>                 "value": 7.18,
>                 "unit": "pH",
>                 "flag": true
>             },
>             ...
>         ]
>     }

- idlocation: String, 해당 위치의 ID
- data: JSON List
  - JSON Object
    - desc: String, 데이터 종류
    - upperBound: Double, 값의 상한선
    - lowerBound: Double, 값의 하한선
    - value: Double, 값
    - unit: String, 값의 단위
    - flag: Boolean, 값이 범위 안에 있는지 여부

## 특정 위치의 데이터 종류
### 요청
> 요청 예시
> 
>     android.php?idlocation=서울-동작-흑석-3

- 파라미터
  - idlocation: 위치 ID

### 응답
> 응답 예시
> 
>     {
>         "data":
>         [
>             "수소이온농도",
>             "탁도",
>             "일반세균"
>         ]
>     }

- data: JSON List
  - String, 데이터 이름

## 특정 위치 & 종류의 데이터가 있는 기간
### 요청
> 요청 예시
> 
>     android.php?idlocation=서울-동작-흑석-3&criteria=수소이온농도


- 파라미터
  - idlocation: 위치 ID
  - criteria: 데이터 종류

### 응답
> 응답 예시
> 
>     {
>         "data":
>         {
>             "first_date": "180101-12:34",
>             "last_date": "180131-12:34"
>         }
>     }

- data: JSON Object
  - first_date: String, 가장 처음 데이터의 타임 스탬프
  - last_date: String, 가장 마지막 데이터의 타임 스탬프

## 특정 위치 & 종류 & 기간의 데이터
### 요청
> 요청 예시
> 
>     android.php?idlocation=서울-동작-흑석-3&criteria=수소이온농도&start=180101-00:00&end=180201-00:00

- 파라미터
  - idlocation: 위치 ID
  - criteria: 데이터 이름
  - start: 시작 날짜
  - end: 끝 날짜

### 응답
> 응답 예시
> 
>     {
>         "data":
>         [
>             {
>                 "timestamp": "180101-12:34",
>                 "value": 7.02
>             },
>             {
>                 "timestamp": "180102-12:34",
>                 "value": 6.97
>             },
>             ...
>         ]
>     }

- data: JSON List
  - JSON Object
    - timestamp: String, 데이터의 타임 스탬프
    - value: Double, 데이터