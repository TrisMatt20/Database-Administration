<?php
include("connect.php");

date_default_timezone_set('Asia/Manila');

if (isset($_POST['btnSendMessage'])) {
  $senderID = 1;
  $receiverID = 1;
  $gcID = 1;
  $message = $_POST['messageInput'];
  $timeStamp = date('Y-m-d H:i:s');

  $messageQuery = "INSERT INTO messages(senderID, receiverID, groupChatID, messages, dateTime)
                  VALUE('$senderID', '$receiverID', '$gcID', '$message', '$timeStamp')";
  executeQuery($messageQuery);

  header("Location: index.php");
}

$query = " SELECT 
    u.firstName AS senderFirstName,
    u.lastName AS senderLastName,
    m.messages,
    m.senderID,
    m.receiverID,
    gc.groupChatName
  FROM 
    messages m
  JOIN 
    users u ON m.senderID = u.userID
  JOIN 
    groupchat gc ON m.groupChatID = gc.groupChatID
  WHERE 
    m.groupChatID = gc.groupChatID
  ORDER BY 
    m.messageID DESC";

$result = executeQuery($query);

$gcQuery = "SELECT groupChat.groupChatName, messages.messages, messages.dateTime 
            FROM groupChat 
            JOIN messages ON groupChat.groupChatID = messages.groupChatID
            WHERE messages.dateTime = (
              SELECT MAX(m2.dateTime)
              FROM messages m2
              WHERE m2.groupChatID = messages.groupChatID
            )
            GROUP BY groupChat.groupChatID";
$gcResult = executeQuery($gcQuery);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/chat.css">
  <title>Talkster N' Friends | A05</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="assets/img/message.ico" type="image/svg+xml">
  <style>
    .input-group .btn {
      color: #007bff;
    }

    .input-group .btn:hover {
      color: white;
    }
  </style>
</head>


<body class="body d-flex flex-column">
  <nav class="navbar custom-navbar">
    <div class="container-fluid">
      <span class="navbar-brand mx-auto">
        TALKSTER N' <span class="highlight-friends">FRIENDS</span>
      </span>
    </div>
  </nav>

  <section style="background-color: #9B7EBD; font-family: Arial, sans-serif; flex-grow: 1;">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card" id="chat3" style="border-radius: 15px;">
            <div class="card-body">
              <div class="row">
                <!-- Chat Lists Section -->
                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0 d-none d-md-block">
                  <div class="p-3">
                    <div class="input-group rounded mb-3">
                      <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon">
                      <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                    <div class="chat-list-container" style="overflow-y: auto;">
                      <ul class="list-unstyled mb-0">

                        <?php
                        if(mysqli_num_rows($gcResult)) {
                          while ($gcListItem = mysqli_fetch_assoc($gcResult)) {
                            ?>
                            <li class="p-2 border-bottom">
                              <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                  <div>
                                    <img src="assets/img/groupChatPic.png" alt="avatar"
                                      class="d-flex align-self-center me-3" width="60">
                                    <span class="badge bg-danger badge-dot"></span>
                                  </div>
                                  <div class="pt-1">
                                    <p class="gc-name fw-bold mb-0"><?php echo $gcListItem['groupChatName'] ?></p>
                                    <p class="latest-message small text-muted"><?php echo $gcListItem['messages'] ?></p>
                                  </div>
                                </div>
                                <div class="pt-1">
                                  <?php
                                  $dateTime = $gcListItem['dateTime'];
                                  $currentTime = new DateTime();
                                  $messageTime = new DateTime($dateTime);
                                  $interval = $currentTime->diff($messageTime);

                                  if ($interval->y > 0) {
                                    echo "<p class='time small text-muted mb-1'>" . $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago</p>";
                                  } elseif ($interval->m > 0) {
                                    echo "<p class='time small text-muted mb-1'>" . $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago</p>";
                                  } elseif ($interval->d > 0) {
                                    echo "<p class='time small text-muted mb-1'>" . $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago</p>";
                                  } elseif ($interval->h > 0) {
                                    echo "<p class='time small text-muted mb-1'>" . $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago</p>";
                                  } elseif ($interval->i > 0) {
                                    echo "<p class='time small text-muted mb-1'>" . $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago</p>";
                                  } else {
                                    echo "<p class='time small text-muted mb-1'>Just now</p>";
                                  }
                                  ?>

                                </div>
                              </a>
                            </li>
                          <?php }
                        } ?>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Chat Messages -->
                <div class="col-md-6 col-lg-7 col-xl-8">
                  <div class="chat-messages-container" style="height: 400px; overflow-y: auto; padding-right: 15px;">
                    <?php

                    $messages = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                      $messages[] = $row;
                    }

                    $messages = array_reverse($messages);
                    foreach ($messages as $row) {
                      $isSender = $row['senderID'] == 1;
                      $profilePic = '';
                      if ($row['senderID'] == 1) {
                        $profilePic = "assets/img/TM.png";
                      } elseif ($row['senderID'] == 2) {
                        $profilePic = "assets/img/louie.png";
                      } elseif ($row['senderID'] == 3) {
                        $profilePic = "assets/img/jade.png";
                      }
                      ?>
                      <div class="d-flex <?php echo $isSender ? 'justify-content-end' : 'justify-content-start'; ?> mb-3">
                        <?php if (!$isSender): ?>
                          <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;"
                            class="me-2">
                        <?php endif; ?>
                        <div>
                          <p
                            class="small p-2 <?php echo $isSender ? 'text-white bg-primary' : 'bg-body-tertiary'; ?> rounded-3">
                            <?php echo htmlspecialchars($row['messages']); ?>
                          </p>

                        </div>
                        <?php if ($isSender): ?>
                          <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;"
                            class="ms-2">
                        <?php endif; ?>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="mt-3">
                    <form action="" method="post">
                      <div class="input-group">
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="Aa" name="messageInput">
                          <button class="btn btn-outline-secondary" type="submit" id="btnSendMessage"
                            name="btnSendMessage"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer text-center mt-auto">
    <h5>© All Rights reserved.</h5>
  </footer>
  <script src="https://kit.fontawesome.com/49a3347974.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>