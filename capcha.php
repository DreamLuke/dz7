<?php

$status = true;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (empty($_POST['title'])) {
			$status = false;
			$errors['title'] = 'title error empty';
	}
	if (mb_strlen($_POST['title']) > 255) {
        $status = false;
		$errors['title'] = 'title error too long (no more 255 characters)';
    }
    if (mb_strlen($_POST['title']) < 3) {
        $status = false;
		$errors['title'] = 'title error too short (3 characters at least)';
    }

    if (mb_strlen($_POST['annotation']) > 500) {
        $status = false;
		$errors['annotation'] = 'annotation error too long (no more 500 characters)';
    }

    if (mb_strlen($_POST['content']) > 30000) {
        $status = false;
        $errors['content'] = 'content error too long (no more 30000 characters)';
    }

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  {
        $status = false;
        $errors['email'] = 'email error wrong format or data';
    }

    if (!filter_var($_POST['views'], FILTER_VALIDATE_INT) ||
        $_POST['views'] < 0 || $_POST['views'] > PHP_INT_MAX*2) {
        $status = false;
        $errors['views'] = 'views error wrong format or number';
    }

    $today = date('Y-m-d');
    $publicationDate = $_POST['date'];
    if($publicationDate < $today) {
        $status = false;
        $errors['date'] = 'date error wrong date (publication date can not be earlier than today)';
    }

    if(!$_POST['publish_in_index'] == 'yes' || !$_POST['publish_in_index'] == 'no') {
        $status = false;
        $errors['publish_in_index'] = 'publish_in_index error no choosen position';
    }

    
    if($_POST['category'] == '') {
        $status = false;
        $errors['category'] = 'category error no choosen category';
    }
}

echo json_encode(compact(['status'], ['errors']));

?>
