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
 * Get an array of all countries in the world.
 * 
 * Result format:
 * ['US' => 'United States', 'FI' => 'Finland', ...]
 * 
 * @return array An array of all countries in the world
 */
function su_get_country_array() {
    $country_array = require __DIR__ . '/../data/country-array.php';
    return $country_array;
}

/**
 * Get HTML select element of all countries in the world
 * 
 * @param string $selected Selected country code, eg. 'US', 'FI', 'CN'
 */
function su_get_country_select($selected = false, $name='country', $class='', $id='') {
    $country_array = su_get_country_array();
    require __DIR__ . '/../view/country-select.php';
}

/**
 * Get an array of countries that have users
 * 
 * Result format:
 * ['US' => 'United States', 'FI' => 'Finland', ...]
 * 
 * @return array An array of countries that have users
 */
function su_get_exist_country_array() {
    return ['FI' => 'Finland'];
}

/**
 * Get HTML select element of all countries in the world
 * 
 * @param string $selected Selected country code, eg. 'US', 'FI', 'CN'
 */
function su_get_exist_country_select($selected = 0) {
    $country_array = su_get_exist_country_array();
    require __DIR__ . '/../view/country-select.php';
}