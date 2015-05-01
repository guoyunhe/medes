<?php

/* 
 * Copyright (C) 2015 Guo Yunhe <guoyunhebrave at gmail.com>
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

<div class="user-header" style="background-color: rgb(245, 170, 0);
     background-image: url('<?php echo $user->su_photo; ?>')">
    <div class="name">
        <?php echo $user->first_name; ?><br>
        <?php echo $user->last_name; ?>
    </div>
    <div class="school">
        <?php echo $user->first_school; ?>
        <?php echo $user->second_school?'/ '.$user->second_school:''; ?>
        <?php echo $user->third_school?'/ '.$user->third_school:''; ?>
    </div>
    <img class="avatar" src="<?php echo $user->su_avatar; ?>"/>
    <img class="photo" src="<?php echo $user->su_photo; ?>"/>
</div>

<div class="tags">
    
</div>