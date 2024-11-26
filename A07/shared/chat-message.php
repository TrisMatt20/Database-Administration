<div class="col-md-6 col-lg-7 col-xl-8">
    <div class="chat-messages-container" style="height: 400px; overflow-y: auto; padding-right: 15px;"
        id="chatsContainer">
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
            <!-- Message Bubble -->
            <div
                class="message-bubble d-flex align-items-center <?php echo $isSender ? 'justify-content-end' : 'justify-content-start'; ?> mb-3">
                <!-- Receiver action buttons -->
                <?php if ($isSender): ?>
                    <div class="action-button">
                        <button type="button" class="btn-delete ms-auto" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-message-id="<?php echo $row['messageID']; ?>">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <div class="action-button me-2">
                        <button
                            onclick="openEditForm('<?php echo $row['messageID'] ?>', '<?php echo htmlspecialchars($row['messages']); ?>')"
                            id="btnEdit<?php echo $row['messageID'] ?>" type="button" class="btn-edit ms-auto"
                            data-message-id="<?php echo $row['messageID']; ?>">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                    </div>
                <?php endif; ?>
                <!-- Receiver profile pic -->
                <?php if (!$isSender): ?>
                    <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;" class="me-2">
                <?php endif; ?>
                <!-- Message content -->
                <div class="d-flex align-items-center">
                    <p
                        class="small p-2 my-auto <?php echo $isSender ? 'text-white bg-primary' : 'bg-body-tertiary'; ?> rounded-5">
                        <?php echo htmlspecialchars($row['messages']); ?>
                    </p>
                </div>
                <!-- Sender profile pic -->
                <?php if ($isSender): ?>
                    <img src="<?php echo $profilePic; ?>" alt="avatar" style="width: 45px; height: 45px;" class="ms-2">
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>
    <!-- Confirm Delete Alert -->
    <div class="modal fade" data-bs-theme="dark" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true" data-bs-theme="light" style="background: rgba(0, 0, 0, 0.1);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Unsend Message
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This message will be unsent for everyone in the chat.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="">
                        <input type="hidden" name="messageID" id="modalMessageID">
                        <button type="submit" name="btnDeleteMess" id="btnDeleteMess"
                            class="btn btn-danger">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <!-- Send message -->
        <form action="" method="post">
            <div class="input-group" id="inputMessContainer">
                <div class="input-group input-message p-2 d-flex justify-content-start flex-column">
                    <div class="input-container d-flex">
                        <input type="text" class="form-control me-2 rounded-5" placeholder="Aa" name="messageInput">
                        <button class="button-send btn btn-outline-secondary" type="submit" id="btnSendMessage"
                            name="btnSendMessage"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Edit message -->
        <form method="POST" action="">
            <div class="input-group d-none" id="editFormContainer">
                <div class="input-group input-message p-2 d-flex justify-content-start flex-column">
                    <div class="edit-message d-flex flex-row mb-2">
                        <p class="me-auto my-auto">Edit message</p>
                        <a class="dismiss-edit my-auto" onclick="dismissEditForm()">
                            <i class="edit-exit fa-solid fa-circle-xmark"></i>
                        </a>
                    </div>
                    <div class="input-container edit-form d-flex" id="editForm">
                        <input type="hidden" name="inputMessageID" id="editMessageID">
                        <input type="text" class="form-control me-2 rounded-5" placeholder="Aa" name="editInput"
                            id="editMessageInput">
                        <button class="button-update btn btn-outline-secondary" type="submit" name="btnEditMessage"><i
                                class="fa-solid fa-circle-check"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>