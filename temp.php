<?php
$url = 'https://api.openai.com/v1/chat/completions';
$apiKey = 'API키';


$instruction_a = '
- sms114 ,문자발송 전문업체, 치환문자, 단체문자, 관고문자, 선거문자, 엑셀로 주소록 간편등록, 예약발송, SMS, MMS, MMS, 대량문자, 치환문자, 주소록관리, 문자연동, 문자발송전문업체, 신년문자발송, 신년인사
- sms114.co.kr 라는 나의 문자발송사이트가 처음 문자를 보내려는 신규 고객들에게 좋은 이미지를 가지고 방문할 수 있는 인사말을 20줄 이상으로 만들어줘.
- 한국의 20~30대의 여자 블로거가 말하는 것으로 해야 함
- 네이버 블로거들의 말투를 사용해야 함
- 자주 이모지를 사용해야 함
- 나는 sms114.co.kr 이라는 문자발송 사이트를 운영하는 운영자야
- 문자사이트의 홍보이고, 문자종류는 감사/답례 인사, 부고/조문 , 동창회/모임 안내 , 이벤트/행사/초대장 , 선거문자 
- 단문문자, 장문문자의 가격은, 단문 10원, 장문 27원, 이것이 기본이야 ';

$instruction_b = '
- set high temperature.
- Write like a human with a lot of humanity with a chatty feeling.
- naver blog의 파워블로그처럼 상냥하고 발랄한 말투를 사용해줘.
- 글 사이 마다 다양한 이모지를 써줘.
- 글 안에서 최소 한 번 이상 "ㅋㅋㅋㅋ" 를 사용해줘.
- 글 안에서 최소 한 번 이상 재미있는 농담을 해줘.
- naver blog 의 파워블로그처럼 상냥하고 발랄한 말투를 사용해줘
- 어휴!, 정말~, 후아, 와우, 대박, 오예 등등, 최근 유행하는 감탄사, 표현 등을 썪어서 표현해주면 좋겠어
- 솔직히 말해서, 아, 그러니까, 으흠, 그...., 다시 말해서, 이제, 진짜진짜, 진짜로,하하하, 어휴!, 정말~, 후아, 와우, 대박, 오예 등의 다양한 접두사나 효과, 필러단어를 이용해서 문장을 이어줘.
- 웃을때는 ㅋㅋㅋㅋㅋㅋ, ㅎㅎㅎㅎ 을 사용해줘.
- ~~ 한다고 하네요~  이런식으로 들어봤던 정보라고 설명하는 문장도 사용해줘.

';


$message = '서울의 가성비 좋은 탑5 호텔이라는 글의 인사말 부분만 20줄 이상으로 적어줘. 호텔을 소개하지말고 앞부분 인사글만 적어줘.';


  $headers = [
	'Content-Type: application/json',
	'Authorization: Bearer ' . $apiKey
  ];
  $data = [
	"model" => "gpt-3.5-turbo",
	//"model" => "gpt-4",
	"messages" => [
	["role" => "assistant", "content" => $instruction_a],
	["role" => "system", "content" => $instruction_b],
	["role" => "user", "content" => $message],
  ],
	'max_tokens' => 1000, //최대 2048, 생성되는 텍스트 최대 길이
	"temperature" => 0.5, //0.5~1.0이 일반적, 값이 높을 수록 창의적 (창의적일수록 AI스러움)
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response  = curl_exec($ch);
  if (curl_errno($ch)) {
	$return = [
	  'error' => ['msg'=>'<span style="color:red">' . curl_error($ch) . '</span>']
	];
	curl_close($ch);
	return $return;
  }
  curl_close($ch);
  $arr = json_decode($response, 1);

  $return = [
	'message' => ''
  ];
  if(!empty($arr['error'])){
	$return['error'] = ['msg'=>'<span style="color:red">' . $arr['error']['message'] . '</span>'];
  }
  elseif(!empty($arr['choices'])){
	$return['message'] = trim($arr['choices'][0]['message']['content']);
  }
  
  //오류 발생시 아래 소스 주석 해제하고 실행
  //print_r($return);
  echo $return['message'];
?>