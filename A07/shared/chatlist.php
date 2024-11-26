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
                if (mysqli_num_rows($gcResult)) {
                    while ($gcListItem = mysqli_fetch_assoc($gcResult)) {
                        ?>
                        <li class="p-2 border-bottom">
                            <a href="#!" class="d-flex justify-content-between" style="text-decoration:none;">
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
                                    $dateTime = new DateTime($gcListItem['dateTime']);
                                    $currentTime = new DateTime();
                                    $messageTimeStamp = strtotime($gcListItem['dateTime']);
                                    $currentTimeStamp = time();

                                    $timeDifference = $currentTimeStamp - $messageTimeStamp;

                                    $years = floor($timeDifference / (365 * 60 * 60 * 24));
                                    $months = floor(($timeDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                    $days = floor(($timeDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                    $hours = floor(($timeDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
                                    $minutes = floor(($timeDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
                                    $seconds = $timeDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60;

                                    if ($years > 0) {
                                        echo "<p class='time small text-muted mb-1'>" . $years . " year" . ($years > 1 ? "s" : "") . " ago</p>";
                                    } elseif ($months > 0) {
                                        echo "<p class='time small text-muted mb-1'>" . $months . " month" . ($months > 1 ? "s" : "") . " ago</p>";
                                    } elseif ($days > 0) {
                                        echo "<p class='time small text-muted mb-1'>" . $days . " day" . ($days > 1 ? "s" : "") . " ago</p>";
                                    } elseif ($hours > 0) {
                                        echo "<p class='time small text-muted mb-1'>" . $hours . " hour" . ($hours > 1 ? "s" : "") . " ago</p>";
                                    } elseif ($minutes > 0) {
                                        echo "<p class='time small text-muted mb-1'>" . $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago</p>";
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