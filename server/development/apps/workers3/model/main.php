<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE->model
 * @package Model\Main
 * @throws \Exception
 */
namespace Model;
class Main
{
	use \Library\Shared;

	public function formsubmitAmbassador(array $data):?array {
		// Тут модель повинна бути допрацьована, щоб використовувати бази даних, тощо
		$key = '1858934382:AAEUNC7fUB6kJzASBvWSNdoPbolWFdf1Tdk'; // Ключ API телеграм
		if(!isset($key) || empty($key)){
			throw new \Exception('API key does not settled!',4);
		}
		$result = null;
		$chat = 323011366;
		$text = "Нова заявка в *Цифрові Амбасадори*:\n" . $data['firstname'] . ' '. $data['secondname']. ', '. $data['position'] . "\n*Контакти*: " . $data['phone'].', '.$data['email'];
		if(isset($data['IBAN']) && !empty($data['IBAN'])){
			$text = $text."\n*IBAN*: ".$data['IBAN'];
		}
		$text = urlencode($text);
		$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chat&text=$text");
		$answer = json_decode($answer, true);
		$result = ['message' => $answer['result']];
		return $result;
	}

	public function __construct() {

	}
}