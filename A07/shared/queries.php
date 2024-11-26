<!-- Queries for messaging (C.R.U.D) -->

<?php

// Create/insert message query
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

// Read message query
$query = " SELECT 
    u.firstName AS senderFirstName,
    u.lastName AS senderLastName,
    m.messages,
    m.messageID, 
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

// Edit message query
if (isset($_POST['btnEditMessage'])) {
    $messageID = $_POST['inputMessageID'];
    $newMessage = $_POST['editInput'];
    $timeStamp = date('Y-m-d H:i:s');
    $editMessQuery =
        "UPDATE messages SET messages = '$newMessage', 
    dateTime = '$timeStamp' 
    WHERE messageID = '$messageID'";
    executeQuery($editMessQuery);
    header("location: index.php");
}

// Delete message query
if (isset($_POST['btnDeleteMess'])) {
    $messageID = $_POST['messageID'];
    $deleteMessQuery = "DELETE FROM messages WHERE messageID = '$messageID'";
    executeQuery($deleteMessQuery);
    header("Location: index.php");
}

?>