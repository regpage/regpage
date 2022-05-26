<?php
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$info = $_POST['info']; //
	$value1 = $_POST['value1']; //
	$value2 = $_POST['value2']; // Комментарий
	$value3 = $_POST['value3']; // country
	$value4 = $_POST['value4']; // Область
	$value5 = $_POST['value5']; // Район
	$value6 = $_POST['value6']; // Населённый пункт
	$value7 = $_POST['value7']; // Адрес
	$value8 = $_POST['value8']; // Индекс

if ($value3 == 'Канада' || $value3 == 'США' || $value3 == 'Украина' || $value3 == 'Израиль') {
	if ($value3 == 'Канада' || $value3 == 'США') {
		$emailTo = '7689966@gmail.com';
	} else if ($value3 == 'Украина') {
		$emailTo = 'n.tolstous@gmail.com';
	} else if ($value3 == 'Израиль') {
		$emailTo = 'bibles4israel@gmail.com';
	}
	$messageText = join("\r\n", array("ФИО: ".$name, "Телефон: ".$phone, "Email: ".$email, "Страна: ".$value3, "Область/край/республика: ".$value4, "Район: ".$value5, "Населённый пункт: ".$value6, "Адрес: ".$value7, "Индекс: ".$value8, "Комментарий: ".$value2));
	$result = mail(
		$emailTo, # To
		'Заявка с сайта Билия для всех', # Subject
		$messageText, # Text of the message
		join("\r\n", array( # другие заголовки
			'From: info@new-constellation.ru',
			'Reply-To: info@new-constellation.ru',
			'X-Mailer: PHP/'.phpversion()
		))
	);
	if ($result) {

	} else {

	}
} else {
	$result = mail(
		'zhicha@qip.ru', # To
		'Test Тест', # Subject
		'ФИО: '.$name.'\r\n Телефон: '.$phone.'\r\n Email: '.$name.'\r\n Страна: '.$value3.'\r\n Область/край/республика: '.$value4.'\r\n Район: '.$value5.'\r\n Населённый пункт: '.$value6.'\r\n Адрес: '.$value7.'\r\n Индекс: '.$value8.'\r\n Комментарий: '.$value2,
		join("\r\n", array( # другие заголовки
			'From: info@new-constellation.ru',
			'Reply-To: info@new-constellation.ru',
			'X-Mailer: PHP/'.phpversion()
		))
	);
	if ($result) {

	} else {

	}
}
?>
