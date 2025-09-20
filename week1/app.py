from flask import Flask, request, render_template  #Flask 모듈 임포트

app = Flask(__name__)       #Flask 앱 생성

@app.route('/')             #라우팅: URL과 함수 연결
def home():                 #함수 정의
    return render_template('index.html')  #응답 내용

@app.route('/search')  
def search():               #함수 정의
    query = request.args.get('q', '')  #쿼리 파라미터 가져오기
    return f"검색결과: {query}"  #응답 내용 -> 입력값을 검증하지 않음!! ->XSS 공격에 취약!!


@app.route('/user/<username>')  #동적 라우팅
def user_profile(username):      #함수 정의
    return f"사용자 프로필: {username}"  #응답 내용
#이러면!! http://127.0.0.1:5000/user/김태경 이라고 url을 입력하면 사용자 프로필: 김태경이라고 페이지가 새로 뜸!!


if __name__ == '__main__':
    app.run(debug=True)     #서버 실행




# from flask import Flask

# app = Flask(__name__)  # __name__은 현재 실행 중인 파이썬 파일의 이름

# @app.route('/') # 루트 경로(/)에 대해 이 함수가 실행되도록 지정
#                 # /는 웹사이트의 기본 주소 (예: http://localhost:5000/)를 의미
# def home(): # / 루트 경로에 접근했을 때 실행할 함수 정의 home
#     return "Hello, World!"
    
# if __name__ == '__main__':  # 이 파일이 직접 실행될 때만 아래 코드를 실행
#     app.run(debug=True) 
# '''Flask 개발 서버 실행
# app.run(): Flask 웹 서버를 시작하는 명령어
# debug=True: 1) 코드 수정 시 자동 재시작됨 (hot reload), 2)에러 발생 시 브라우저에 자세한 디버그 정보 표시됨'''