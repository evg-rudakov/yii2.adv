<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 20/01/2020
 * Time: 19:30
 */

?>

<div class="chat-popup form-container">
    <div class="js-chat-content">
        <h1>Chat</h1>
        <div class="js-messages-content"></div>

        <label for="msg"><b>Message</b></label>
        <textarea id="message" placeholder="Type message.." name="msg" required></textarea>

        <button type="button" id="send" class="btn">Send</button>
        <button type="button" class="btn cancel js-hide">Hide</button>
    </div>
    <button type="button" style="display: none;" class="btn btn-primary js-show">Show</button>
</div>

