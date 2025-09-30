<?php 
//db 연결 
$db_host="localhost"; 
$db_user = "root"; 
$db_pass = ""; // db 비번 (지금은 비어있는 상태)
$db_name = "my_db"; // 사용할 데이터베이스 이름 (내가 php에서 만든 거)
$db_port = 3306; 

//MySQLi 객체로 DB 연결
//mysqli 클래스의 생성자 사용 -> DB서버에 연결
//위에서 만든 정보를 인자로 넘김
$conn=new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);


// 연결 오류 확인
//connect_error 속성: 객체 conn이 연결에 시래하면 오류 메시지를 반환함
//연결 실패하면 에러 메시지 출려가혹 프로그램 종료함
if($conn->connect_error){
    die("데이터베이스 연결 실패: " . $conn->connect_error); // connect_error로 수정
}

//login.html에서 POST 방식으로 보낸 데이터 받기 
$username=$_POST['username']; 
$password=$_POST['password'];

// 입력받은 username과 password가 일치하는 사용자를 찾아 만든 SQL 쿼리문을 문자열로 저장한 변수
// 여기서 $username, %password를 그대로 SQL 문자열에 삽입해서 ' OR '1' = '1 등을 입력하면 비번 없이도 로그인이 가능해짐
// $sql = "SELECT * FROM users WHERE username = '$username' AND password='$password'";


// 그래서 Prepared Statement로 입력값을 자동으로 escape 하기
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
// "ss"는 두 개의 문자열 매개변수(username이랑 password)를 의미함 (Prepared Statement쓸 때 같이 쓰임)
// (i는 정수, d는 실수, b는 blob(바이너리) 데이터)
// 이 두 값이 SQL문장의 ? 위치에 안전하게 바인딩됨!
$stmt->bind_param("ss", $username, $password); 
//execute(): Prepared Statement를 실제로 실행
$stmt->execute();
$result = $stmt->get_result(); // 쿼리 결과 가져오기


/*
// 쿼리 실행 
//query(): SQL쿼리를 실제로 데이터베이스에 실행하는 함수
$result=$conn->query($sql);
이 부분은 패치하고 나서 사라짐
*/

// 결과 확인 
if($result->num_rows > 0){ // num_rows로 수정
    //일치하는 사용자가 있으면(결과 행이 1개 이상이면)
    echo "<h1>로그인 성공!</h1>";
    echo "<p>'$username'님, 환영합니다.</p>";
}else{
    echo "<h1>로그인 실패</h1>";
    echo "<p>아이디 또는 비밀번호가 올바르지 않습니다.</p>";
    echo '<a href="login.html">다시 시도하기</a>';
}

//DB 연결 종료 
$stmt->close();
$conn->close(); 
?>