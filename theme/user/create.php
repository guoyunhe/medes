<?php

/* 
 * Copyright (C) 2015 Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Popup box to create new user
 */

?>
<div id="user-create-popup" class="popup">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container small">
            <h2>Join MEDes Network</h2>
            <div class="error-message"></div>
            <p>
                <input type="text" name="username" placeholder="Choose a cool username"/>
            </p>
            <p>
                <input type="password" name="password" placeholder="Set password"/>
            </p>
            <p>
                <input type="password" name="password_repeat" placeholder="Confirm password"/>
            </p>
            <p>
                <input type="email" name="email" placeholder="Email address"/>
            </p>
            <input type="hidden" name="secret_key" value="<?php echo filter_input(INPUT_GET, 'secret_key'); ?>">
            <p>
                <button class="next large">Next</button>
            </p>
        </div>
    </div>
</div>
<script>
jQuery(function () {
    createUserPopup();
});
</script>