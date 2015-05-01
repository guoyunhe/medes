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
<p>
    <label for="first_name">First Name<br/>
        <input type="text" name="first_name" id="first_name" class="input"
               value="<?php echo esc_attr(wp_unslash($first_name)); ?>" size="25" />
    </label>
</p>
<p>
    <label for="last_name">Last Name<br/>
        <input type="text" name="last_name" id="last_name" class="input"
               value="<?php echo esc_attr(wp_unslash($last_name)); ?>" size="25" />
    </label>
</p>
<p>
    <label for="country">Living Country<br/>
        <input type="text" name="country" id="country" class="input" size="25" />
    </label>
</p>
<p>
    <label for="city">Living City<br/>
        <input type="text" name="city" id="city" class="input" size="25" />
    </label>
</p>
<table>

    <tr>
        <td>
            <label for="first-year">1st Year<br/>
                <input type="text" name="first-year" id="first-year" class="input" size="4" />
            </label>
        </td>
        <td style="padding-left: 5px;">
            <label for="first-school">1st School<br/>
                <select name="first-school" id="first-school" class="input">
                    <option>School A</option>
                    <option>School B</option>
                    <option>School C</option>
                    <option>School D</option>
                    <option>School E</option>
                    <option>School F</option>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label for="second-year">2nd Year<br/>
                <input type="text" name="second-year" id="second-year" class="input" size="4" />
            </label>
        </td>
        <td style="padding-left: 5px;">
            <label for="second-school">2nd School<br/>
                <select name="second-school" id="second-school" class="input">
                    <option>School A</option>
                    <option>School B</option>
                    <option>School C</option>
                    <option>School D</option>
                    <option>School E</option>
                    <option>School F</option>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <td>
            <label for="third-year">3rd Year<br/>
                <input type="text" name="third-year" id="third-year" class="input" size="4" />
            </label>
        </td>
        <td style="padding-left: 5px;">
            <label for="third-school">3rd School<br/>
                <select name="third-school" id="third-school" class="input">
                    <option>School A</option>
                    <option>School B</option>
                    <option>School C</option>
                    <option>School D</option>
                    <option>School E</option>
                    <option>School F</option>
                </select>
            </label>
        </td>
    </tr>
</table>
