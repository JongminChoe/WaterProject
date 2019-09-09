# 데이터베이스 구조
## Disclaimer
**데이터베이스 구조는 제가 만들지 않았습니다.**  
**이를 적어놓은 것은 단지 데이터베이스의 구조를 조금이나마 보기 쉽게 하기 위함입니다.**  
**프로젝트 진행 당시와 바뀐 부분이 있긴 하지만 큰 틀에선 바뀌지 않았습니다.**  

## 전체 구조
water  
├─ location  
├─ criteria  
└─ datapoint  

## 테이블별 구조
- location

|이름|종류|설명|예시|
|---|---|---|---|
|idlocation|VARCHAR(45)|지역 ID|서울-동작-흑석-3|
|location1|VARCHAR(10)|최상위 지역 이름|서울|
|location2|VARCHAR(10)|location1의 하위 지역 이름|동작구|
|location3|VARCHAR(10)|location2의 하위 지역 이름|흑석동|
|location4|VARCHAR(10)|location3의 하위 지역 이름|3|

- criteria

|이름|종류|설명|예시|
|---|---|---|---|
|idcriteria|VARCHAR(10)|종류 ID|PHI|
|maxval|DOUBLE|최대 기준치|8.5|
|minval|DOUBLE|최소 기준치|5.8|
|desc|VARCHAR(45)|종류에 대한 설명|수소이온농도|
|unit|VARCHAR(10)|값의 단위|pH|

- datapoint

|이름|종류|설명|예시|
|---|---|---|---|
|iddatapoint|INT(11)|데이터 ID|289|
|timestamp|VARCHAR(20)|데이터가 기록된 시각|180101-12:34|
|value|DOUBLE|데이터 값|7.02|
|flag|BIT(1)|데이터가 기준치를 만족하는지 여부|1|
|idlocation|VARCHAR(45)|데이터가 수집된 위치 ID |서울-동작-흑석-3|
|idcriteria|VARCHAR(10)|데이터의 종류 ID|PHI|