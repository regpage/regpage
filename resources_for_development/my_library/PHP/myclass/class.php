<?php
# Модуль
# Класс с конструктором
class My_class {
	private $ressum;
	private $resmult;
	private $resdeff;
	private $resdvsn;
	# Конструктор класса
	function __construct($a = "error", $b = "error"){
		# Проверяем переданные аргументы на наличие и корректность (должно быть число)
		if ($this->check_argument($a) !== "error" && $this->check_argument($b) !== "error") {
			$ressum = $a + $b;
			$resmult = $a * $b;
			$resdeff = $a - $b;;
			$resdvsn = $a / $b;;
		} else {
			$ressum "error";
		}
		/*Второй вариант конструктора записывать принятые аргументы в приватные 
		  переменные и вызывать проверки при непосредственном вызови метода*/
	}
	# Проверка аргумента
	private function check_argument($c) {
		if (is_numeric($c)) {
			return $c;
		} else {
			return "error";
		}
	}
	
	# Получаем результат сумму
	public function sum() {
		return $this->$ressum;
	}
	# Получаем результат 
	public function multiply() {
		return $this->$resmult;
	}
	# Получаем результат 
	public function defference() {
		return $this->$resdeff;
	}
	# Получаем результат 
	public function division() {
		return $this->$resdvsn;
	}
}
?>
