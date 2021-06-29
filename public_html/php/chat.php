<?php

$receiver = 0;
$flag = false;

if(isset($_GET['open'])) {
	$receiver = $_GET['open'];
	$flag = true;
}

$chatCreator = new \Twig\TwigFunction('showContacts', function() use ($dbh) {

	$stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
	$stmt->execute(['email' => $_SESSION['email']]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	$splitted_contacts = explode(",", $result['added_ids']);

	if($result['added_ids'] != null) {
		foreach($splitted_contacts as &$contact) {
			$stmt = $dbh->prepare('SELECT * FROM users WHERE id = :id');
			$stmt->execute(['id' => $contact]);
			$whole = $stmt->fetch(PDO::FETCH_ASSOC);

			$nick = $whole['nickname'];

			echo '<a class="nav-link text" href="/chat/open/' . $contact . '">' . $nick . '</a>';
		}
	}

	
});

$showChat = new \Twig\TwigFunction('showChat', function() use ($dbh) {
	$id2 = intval($_SESSION['id']);

	$stmt = $dbh->prepare('SELECT * FROM users WHERE id = :id');
	$stmt->execute(['id' => $id2]);
	$nick2 = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if(isset($_POST['message']) && isset($_GET['open'])) {

		$message = $_POST['message'];
		$id1 = intval($_GET['open']);

		$stmt = $dbh->prepare('INSERT INTO userMessages (id, from_id, receiver_id, message, created, creator) VALUES (null, :from_id, :receiver_id, :message, NOW(), :creator)');
        $stmt->execute([':from_id' => $id2, ':receiver_id' => $id1, ':message' => $message, ':creator' => $nick2['nickname']]);
	}

	if(isset($_GET['open'])) {
		$id1 = intval($_GET['open']);

		$stmt = $dbh->prepare('SELECT nickname FROM users WHERE id = :id');
		$stmt->execute(['id' => $id1]);
		$nick1 = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $dbh->prepare('SELECT message, creator FROM userMessages WHERE (from_id = :id1 AND receiver_id = :id2) OR (from_id = :id2 AND receiver_id = :id1) ORDER BY created DESC');
		$stmt->execute([':id1' => $id1, ':id2' => $id2]);
		$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($messages as &$message) {
			if($message['creator'] == $nick2) {
				$sender = "You";
			} else {
				$sender = $message['creator'];
			}
			echo '
				<div class="row text-bottom" style="position: relative; bottom: 0;">
					<div class="col-3">
						<b><p style="margin: 5px 0px 5px 0px;">' . $sender . '</p></b>
				  	</div>
				 	<div class="col-9 text-left">
				  		<p style="margin: 5px 10px 5px 10px; padding: 0px 5px 0px 5px; border: 2px solid #110703; outline: none; border-radius: 5px;">' . $message['message'] . '</p>
				  	</div>
				</div>';
		}
	}
});

$twig->addFunction($showChat);
$twig->addFunction($chatCreator);

echo $twig->render('chat.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'receiver' => $receiver, 'flag' => $flag]); 