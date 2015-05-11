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
?>
<!-- Popup box to create new user, step by step -->
<div id="create-user" class="popup">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div id="page-1" class="page active" data-page="1">
            <h3>Welcome to Join MEDes!</h3>
            <div class="error-message"></div>
            <input type="hidden" name="secret_key"
                   value="<?= filter_input(INPUT_GET, 'secret_key'); ?>">
            <input type="text" name="username" class="block large"
                   placeholder="Choose a cool username"/>
            <input type="password" name="password" class="block large"
                   placeholder="Set password"/>
            <input type="password" name="password_repeat" class="block large"
                   placeholder="Confirm password"/>
            <input type="email" name="email" class="block large"
                   placeholder="Email address"/>
            <br><br>
            <button class="next large">NEXT</button>
        </div>
        <div id="page-2" class="page active" data-page="2">
            <h3>Your Data</h3>
            <input type="text" name="first_name" class="block large"
                   placeholder="First name"/>
            <input type="text" name="last_name" class="block large"
                   placeholder="Last name"/>
                   <?php su_get_country_select(); ?>
            <input type="text" name="city" class="block large"
                   placeholder="City you are living"/>
            <h3>MEDes Path</h3>
            <select name="role" class="block large">
                <option value="student" selected>Student</option>
                <option value="teacher">Teacher</option>
                <option value="tutor">Tutor</option>
            </select>
            <?php su_get_year_select(null, 'year_1', 'large'); ?>
            <input type="text" name="school_1" class="large"
                   placeholder="First school"/><br>
                   <?php su_get_year_select(null, 'year_2', 'large'); ?>
            <input type="text" name="school_2" class="large"
                   placeholder="Second school"/><br>
                   <?php su_get_year_select(null, 'year_3', 'large'); ?>
            <input type="text" name="school_3" class="large"
                   placeholder="Third school"/><br><br>
            <button class="next large">NEXT</button>
        </div>

        <div id="page-3" class="page active" data-page="3">
            <div class="container">
                <div class="user-page">
                    <div class="header">
                        <div class="name">
                            <span></span>
                            <button><i class="fa fa-edit"></i> Edit</button>
                        </div>
                        <div class="school">
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
                    </div>
                    <div class="experience"></div>
                    <div class="pictures">
                        <div class="add-picture">
                            <i class="fa fa-camera"></i>
                            <input type="file" name="picture"/>
                        </div>
                    </div>
                </div>

            </div>
            <button class="next large">FINISH</button>
        </div>
    </div>
</div>