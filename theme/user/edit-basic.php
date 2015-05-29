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

<div id="user-edit-basic-popup" class="popup">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container small">
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
            <table>
                <tr>
                    <td>1st school</td>
                    <td><?php su_get_year_select(null, 'year_1', 'large'); ?></td>
                    <td><?php su_get_school_select(null, 'school_1', 'large'); ?></td>
                </tr>
                <tr>
                    <td>2nd school</td>
                    <td><?php su_get_year_select(null, 'year_2', 'large'); ?></td>
                    <td><?php su_get_school_select(null, 'school_2', 'large'); ?></td>
                </tr>
                <tr>
                    <td>3rd school</td>
                    <td><?php su_get_year_select(null, 'year_3', 'large'); ?></td>
                    <td><?php su_get_school_select(null, 'school_3', 'large'); ?></td>
                </tr>
            </table>
            <button class="next large">NEXT</button>
        </div>
    </div>
</div>