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

<select name="<?php echo $name ?>" id="<?php echo $id ?>" class="<?php echo $class?>">
    <option <?= $selected? 'selected' : '' ?>></option>
    <?php foreach ($country_array as $key => $value): ?>
    <option value="<?= $key ?>" <?= $selected === $id ? 'selected' : '' ?>>
        <?php echo $value; ?>
    </option>
    <?php endforeach; ?>
</select>