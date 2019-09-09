# 연구실 토이 프로젝트
본 프로젝트는 연구실에서 학부 연구생으로 있을 당시 진행했던 프로젝트입니다.

본 프로젝트의 목표는 수질 데이터를 저장하고 수정, 삭제할 수 있는 웹 애플리케이션과 해당 데이터를 조회할 수 있는 안드로이드 앱을 개발하는 것입니다.

본 프로젝트는 2인 1팀으로 진행하였으며, 저는 안드로이드-서버 간 API 규격을 정의하고 안드로이드 앱을 개발했습니다.

## Application
### 프로젝트 완성 당시와 바뀐 점
- 프로젝트 본질과 관련 없는 부분을 수정하거나 삭제하였습니다.
- 오픈소스 라이선스 고지를 추가했습니다.

### 개발 환경
- Android Studio 3.5
  - 당시에는 Android Studio 3.1.4 버전으로 개발하였으나 수정할 필요가 생겨 현재 최신 버전인 3.5 버전에서 다시 개발함
- minSdkVersion: 15 (Android 4.0.3)
- targetSdkVersion: 26 (Android 8.0)

### 테스트 환경
- Samsung Galaxy Note 4 (Android 6.0.1)
- Samsung Galaxy Note 8 (Android 9)

### 구현 상세
- [애플리케이션 구성 및 구현](./Application/Application.md)

### 외부 라이브러리
- MPAndroidChart  
<https://github.com/PhilJay/MPAndroidChart>

### 오픈소스 라이선스
MPAndroidChart  
<https://github.com/PhilJay/MPAndroidChart>
> Copyright 2019 Philipp Jahoda
> 
> Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
> 
> <http://www.apache.org/licenses/LICENSE-2.0>
> 
> Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

## Mock Server
프로젝트에서 제가 만든 부분인 API 부분만 가져왔습니다.  
또한 요청에 응답하기 위해 가짜 데이터를 채워 넣은 데이터베이스를 만들었습니다.

### 프로젝트 완성 당시와 바뀐 점
- 데이터베이스 접속에 사용하는 mysqli를 PDO로 변경하였습니다.
- SQL Injection 보안 취약점을 해결하였습니다.
- 일부 SQL문을 수정하였습니다.
- 테이블의 구조가 일부 변경되었습니다.
- 샘플 데이터를 새로 제작하였습니다.
  - 본 데이터는 기존의 샘플 데이터와 같은 형식을 유지하면서 위치는 임의의 실제 지명으로, `datapoint` 테이블은 랜덤 값과 몇몇 조작된 값으로, `criteria` 테이블은 실제 먹는 물 기준에 따라 만든 데이터입니다.


### 테스트 환경
- Windows 10 1809
- Bitnami WAMP Stack 7.1.27-1
   - Apache 2.4.38
   - PHP 7.1.27
   - MySQL 5.7.23

### 구현 상세
- [API 규격](./MockServer/API%20Format.md)
- [데이터베이스 구조](./MockServer/Database%20Structure.md)

## 사용법
1. 웹서버를 구축합니다.
   - PHP를 사용하고 관계형 데이터베이스가 있다면 어떤 웹서버도 상관없습니다. ([Bitnami WAMP Stack](https://bitnami.com/stack/wamp) 권장)
2. android.php를 웹서버의 DocumentRoot로 복사합니다.
3. android.php의 2~5라인에 있는 데이터베이스 연결 정보를 해당 웹서버에 맞게 수정합니다.
4. database_setup.sql 파일 내 SQL문을 데이터베이스에서 실행해줍니다.
   - phpmyadmin의 경우 메인 화면에서 `가져오기 > 가져올 파일 선택 > 실행`을 하면 됩니다.
5. NetworkUtil.java 의 `SERVER_URL`을 현재 서버에 맞게 수정한 뒤 빌드합니다.
6. 애플리케이션이 정상적으로 작동하는지 확인합니다.

## 느낀점
- 이렇게 네트워크를 이용하는 안드로이드 애플리케이션 개발은 처음이었는데 예상치 못한 제약사항 때문에 스레드를 사용해야 해서 많이 당황했던 기억이 있습니다. 덕분에 어떻게 구현하면 좋을지 여러모로 구상했고, 그 결과 만족할만한 결과를 얻은 것 같아서 성취감을 얻었습니다.
- 이 프로젝트에서 학교에서는 적당히 배우고 넘어갔던 상속과 인터페이스를 처음으로 사용해 보았는데 실제로 작동하는 것을 보고 상속과 인터페이스의 개념을 조금이나마 직접 체득하게 되었습니다.
- 이 프로젝트를 깃허브에 올리기 전에 외부 라이브러리를 사용한 점 때문에 라이선스 문제가 있지 않을까 고민을 했습니다. 그 때문에 오픈소스 라이선스에 대해서 찾아보게 되었고, 오픈소스에 사용되는 여러 종류의 라이선스를 알게 되었습니다. 그럼에도 불구하고 오픈소스 라이선스가 복잡해서 다 이해하지는 못했지만, 저 또한 한 명의 개발자로서 다른 개발자분들이 만든 저작물의 라이선스를 지키기 위해 좀 더 공부해야겠다고 생각하게 되었습니다.

## License
Copyright 2019 Jongmin Choe All Rights Reserved

This project has no open source license.  
All materials in this project are protected by copyright law in South Korea.  
Unauthorized use, redistribution, and modification are strictly prohibited.  
Personal use of SOURCE CODE without distribution is allowed.

본 프로젝트는 오픈소스 라이선스가 없습니다.  
다시 말하자면 이 프로젝트의 모든 자료는 대한민국의 저작권법에 의해 보호됩니다.  
따라서 원작자(Jongmin Choe)의 허가 없이 사용하거나 2차 가공 및 배포가 금지되어 있습니다.  
다만 개인적인 목적이라면 소스 코드에 한해서 배포하지 않는 한 자유롭게 이용하실 수 있습니다.