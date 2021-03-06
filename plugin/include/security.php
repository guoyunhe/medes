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
 * Check secret key, make sure this user can access create acount wizard
 * @return boolean If the secret key is valid
 */

function su_check_secret_key() {
    $secret_key = filter_input(INPUT_GET, 'secret_key');
    if($secret_key === su_get_secret_key_setting()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check secret key again when user submit the create account request to server.
 * Avoid attack from API.
 * @return boolean If the secret key is valid
 */

function su_check_secret_key_on_submit() {
    $secret_key = filter_input(INPUT_POST, 'secret_key');
    if($secret_key === su_get_secret_key_setting()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get secret key setting. This value should be saved in database
 * TODO move this secret key to database, not write in code.
 * @return string Secret key, a random string of letters and numbers
 */

function su_get_secret_key_setting(){
    return 'PVbEHF69AFwhIrkDdZ16';
}