<?php
include("connect.php"); 

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
    m.messageID DESC
  LIMIT 6";

$result = executeQuery($query);
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/chat.css">
    <title>Talkster N' Friends | A05</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="assets/img/message.ico" type="image/svg+xml">
    
  </head>
  <body class = "body">
  <nav class="navbar custom-navbar">
        <div class="nav container-fluid">
            <span class="navbar-brand mb-0 mx-auto">
                TALKSTER N' <span class="highlight-friends">FRIENDS</span>
            </span>
        </div>
  </nav>

  <section style="background-color: #9B7EBD; font-family: Arial, sans-serif;">
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card" id="chat3" style="border-radius: 15px;">
          <div class="card-body">
            <div class="row">
              <!-- Chat Lists Section -->
              <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                <div class="p-3">
                  <div class="input-group rounded mb-3">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                      aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>

                  <div data-mdb-perfect-scrollbar-init style="position: relative; height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                      <!-- Chat Item-1 -->
                      <li class="p-2 border-bottom">
                        <a href="#!" class="d-flex justify-content-between">
                          <div class="d-flex flex-row">
                            <div>
                              <img src="assets/img/groupChatPic.png" alt="avatar" class="d-flex align-self-center me-3" width="60">
                              <span class="badge bg-success badge-dot"></span>
                            </div>
                            <div class="pt-1">
                              <p class="fw-bold mb-0">KPBP</p>
                              <p class="small text-muted">Emz</p>
                            </div>
                          </div>
                          <div class="pt-1">
                            <p class="small text-muted mb-1">Just now</p>
                            <span class="badge bg-danger rounded-pill float-end">1</span>
                          </div>
                        </a>
                      </li>
                      <!-- Chat Item-2 -->
                      <li class="p-2 border-bottom">
                        <a href="#!" class="d-flex justify-content-between">
                          <div class="d-flex flex-row">
                            <div>
                              <img src="assets/img/louie.png" alt="avatar" class="d-flex align-self-center me-3" width="60">
                              <span class="badge bg-warning badge-dot"></span>
                            </div>
                            <div class="pt-1">
                              <p class="fw-bold mb-0">Mark Louie Villanueva</p>
                              <p class="small text-muted">San ka na</p>
                            </div>
                          </div>
                          <div class="pt-1">
                            <p class="small text-muted mb-1">5 mins ago</p>
                            <span class="badge bg-danger rounded-pill float-end">2</span>
                          </div>
                        </a>
                      </li>
                      <!-- Chat Item-3 -->
                      <li class="p-2 border-bottom">
                        <a href="#!" class="d-flex justify-content-between">
                          <div class="d-flex flex-row">
                            <div>
                              <img src="assets/img/jade.png" alt="avatar" class="d-flex align-self-center me-3" width="60">
                              <span class="badge bg-danger badge-dot"></span>
                            </div>
                            <div class="pt-1">
                              <p class="fw-bold mb-0">Jade Bernardo</p>
                              <p class="small text-muted">Utas</p>
                            </div>
                          </div>
                          <div class="pt-1">
                            <p class="small text-muted mb-1">Yesterday</p>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Chat Messages Section -->
              <div class="col-md-6 col-lg-7 col-xl-8">
                <!-- Scrollable message container -->
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
                        <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;" class="me-2">
                      <?php endif; ?>

                      <div>
                        <p class="small p-2 <?php echo $isSender ? 'text-white bg-primary' : 'bg-body-tertiary'; ?> rounded-3">
                          <?php echo htmlspecialchars($row['messages']); ?>
                        </p>
                        <p class="small text-muted <?php echo $isSender ? 'text-end' : ''; ?>">
                          9:45 AM | Oct 30
                        </p>
                      </div>

                      <?php if ($isSender): ?>
                        <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;" class="ms-2">
                      <?php endif; ?>
                    </div>
                  <?php } ?>
                </div>

                <div class="mt-3">
                  <div class="input-group">
                    <input type="text" class="form-control form-control-lg" id="exampleFormControlInput2" placeholder="Type message">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




    <footer class="footer">
      <h5 style="Text-align: center;">© All Rights reserved.</h5>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>