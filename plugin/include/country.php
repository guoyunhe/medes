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
function get_country_array() {
    require '../data/country-array.php';
}

/**
 * Get HTML select element of all countries in the world
 * 
 * @param string $selected Selected country code, eg. 'US', 'FI', 'CN'
 */
function get_country_select($selected = 0) {
    $country_array = get_country_array();
    require '../view/country-select.php';
}

/**
 * Get an array of countries that have users
 * 
 * Result format:
 * ['US' => 'United States', 'FI' => 'Finland', ...]
 * 
 * @return array An array of countries that have users
 */
function get_exist_country_array() {
    return ['FI' => 'Finland'];
}

/**
 * Get HTML select element of all countries in the world
 * 
 * @param string $selected Selected country code, eg. 'US', 'FI', 'CN'
 */
function get_exist_country_select($selected = 0) {
    $country_array = get_exist_country_array();
    require '../view/country-select.php';
}