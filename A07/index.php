<?php
include("connect.php");

date_default_timezone_set('Asia/Manila');

// Queries
include("shared/queries.php");
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

<body class="body d-flex flex-column" data-bs-theme="dark">
  <nav class="navbar custom-navbar">
    <div class="container-fluid">
      <span class="navbar-brand mx-auto">
        TALKSTER N' <span class="highlight-friends">FRIENDS</span>
      </span>
    </div>
  </nav>
  <section style="background-color: #9B7EBD; font-family: Arial, sans-serif; flex-grow: 1;">
    <div class="container-fluid pt-3">
      <div class="row">
        <div class="col-md-12">
          <div class="card" id="chat3" style="border-radius: 15px;">
            <div class="card-body">
              <div class="row">
                <!-- Chat Lists Section -->
                <?php include("shared/chatlist.php"); ?>
                <!-- Chat Messages -->
                <?php include("shared/chat-message.php"); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    function autoscroll() {
      var container = document.getElementById('chatsContainer');
      container.scrollTo({
        top: container.scrollHeight
      });
    }
    autoscroll();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/49a3347974.js" crossorigin="anonymous"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>