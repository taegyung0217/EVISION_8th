from flask import Flask, render_template, request

homework1 = Flask(__name__)
guest = []  #방명록을 저장할 임시 저장소

@homework1.route('/')
def home():
    return render_template('homework1.html')


@homework1.route('/search')
def search():
    query = request.args.get('q', '')
    return f"검색 결과: {query}"


@homework1.route('/write', methods=['POST'])
def wrtie():
    name = request.form.get('name', '익명') # 이름이 없으면 '익명'으로 설정
    message = request.form.get('message', '')
    # -> 위 search에서는 q로 받았고, write에서는 키값이 name, message인 거!
    ## 그래서 html에서 name='q'가 아니라 name='name', name='message'로 해야함

    guest.append({'name': name, 'message':message})    #딕셔너리 형태로 저장
    return render_template('homework1.html', guest=guest, show_guestbook=True)   #방명록을 저장하고, 메인 페이지에 리디렉션+방명록 전달하기


if __name__ == '__main__':
    homework1.run(debug=True)