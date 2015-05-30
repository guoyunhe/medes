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
 * Popup box to edit user profile
 */
?>
<div id="user-edit-popup" class="popup user-page">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container">
            <div class="header">
                <div class="name">
                    <span></span>
                    <button><i class="fa fa-edit"></i></button>
                    <div class="edit-box">
                        <input type="text" name="first_name" placeholder="First name">
                        <input type="text" name="last_name" placeholder="Last name">
                        <button class="save">SAVE</button>
                    </div>
                </div>
                <div class="schools">
                    <span></span>
                    <button><i class="fa fa-edit"></i> Edit</button>
                </div>
                <div class="avatar">
                    <input type="file" name="avatar"/>
                    <button><i class="fa fa-camera"></i> Edit</button>
                </div>
            </div>
            <div class="links">
                <div class="link"><i class="fa fa-facebook"></i></div>
                <div class="link"><i class="fa fa-twitter"></i></div>
                <div class="link"><i class="fa fa-linkedin"></i></div>
                <div class="link"><i class="fa fa-google-plus"></i></div>
                <div class="link"><i class="fa fa-instagram"></i></div>
                <div class="link"><i class="fa fa-flickr"></i></div>
                <div class="link"><i class="fa fa-skype"></i></div>
                <div class="link"><i class="fa fa-email"></i></div>
                <button><i class="fa fa-edit"></i></button>
                <div class="edit-box">
                    <input type="text" name="facebook" placeholder="Facebook">
                    <input type="checkbox"> private<br>
                    <input type="text" name="twitter" placeholder="Twitter">
                    <input type="checkbox"> private<br>
                    <input type="text" name="linkedin" placeholder="LinkedIn">
                    <input type="checkbox"> private<br>
                    <input type="text" name="google_plus" placeholder="Google+">
                    <input type="checkbox"> private<br>
                    <input type="text" name="instagram" placeholder="Instagram">
                    <input type="checkbox"> private<br>
                    <input type="text" name="flickr" placeholder="Flickr">
                    <input type="checkbox"> private<br>
                    <input type="text" name="skype" placeholder="Skype">
                    <input type="checkbox"> private<br>
                    <input type="text" name="email" placeholder="Email">
                    <input type="checkbox"> private<br>
                    <button class="save">SAVE</button>
                </div>
            </div>
            <div class="experience"></div>
            <div class="pictures clearfix">
                <div class="add-picture">
                    <i class="fa fa-camera"></i>
                    <input type="file" name="picture"/>
                </div>
            </div>
            <button class="finish large">FINISH</button>
        </div>
    </div>
</div>