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
<div id="user-edit-popup" class="popup user edit">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container">
            <div id="user-edit-basic" class="edit-section">
                <div class="edit-section-title">Your data</div>
                <p>
                    <label>Username</label>
                    <input type="text" name="username" disabled="disabled"/>
                </p>
                <p>
                    <label>First name</label>
                    <input type="text" name="first_name"/>
                    <label>Last name</label>
                    <input type="text" name="last_name"/>
                </p>
                <p>
                    <label>Email</label>
                    <input type="email" name="user_email"/>
                </p>
                <p>Where are you living?</p>
                <p>
                    <label>Country</label> 
                    <?php su_get_country_select(null,'live_country'); ?>
                    <label>City</label>
                    <input type="text" name="live_city"/>
                </p>
            </div>
            
            <div id="user-edit-medes" class="edit-section">
                <div class="edit-section-title">MEDes Path</div>
                <p>
                    <label>Your role</label>
                    <select name="role">
                        <option value="student" selected>Student</option>
                        <option value="tutor">Tutor</option>
                    </select>
                </p>
                <div class="schools">
                    <p>
                        <label>Year</label>
                        <?php su_get_year_select(null, 'year_1'); ?>
                        <label class="school-label">Home School</label>
                        <?php su_get_school_select(null, 'school_1'); ?>
                    </p>
                    <p>
                        <label>Year</label>
                        <?php su_get_year_select(null, 'year_2'); ?>
                        <label class="school-label">1<sub>st</sub> Exchange</label>
                        <?php su_get_school_select(null, 'school_2'); ?>
                    </p>
                    <p>
                        <label>Year</label>
                        <?php su_get_year_select(null, 'year_3'); ?>
                        <label class="school-label">2<sub>nd</sub> Exchange</label>
                        <?php su_get_school_select(null, 'school_3'); ?>
                    </p>
                </div>
                <div class="school">
                    <p>
                        <label>School</label>
                        <?php su_get_school_select(null, 'school'); ?>
                    </p>
                </div>
            </div>
            
            <div class="edit-section">
                <div class="edit-section-title">Show your face!</div>
                
                <p>The time has come to show your face. Upload your profile picture</p>
                
                <div class="avatar">
                    <div class="spinner"><i class="fa fa-spinner fa-pulse"></i></div>
                    <input type="file" name="avatar"/>
                    <button><i class="fa fa-camera"></i> Add</button>
                </div>
            </div>
            
            <div id="user-edit-pictures" class="edit-section">
                <div class="edit-section-title">Your awesome work</div>
                
                <p>Upload your greatest project photos here.</p>
                
                <div class="pictures clearfix">
                    <div class="add-picture">
                        <div class="spinner"><i class="fa fa-spinner fa-pulse"></i></div>
                        <i class="fa fa-camera"></i>
                        <input type="file" name="picture"/>
                    </div>
                </div>
            </div>
            
            <div id="user-edit-links" class="edit-section">
                <div class="edit-section-title">More links more likes</div>
                
                <p>Give people the chance to connect with you. Then check the contacts that you want to be visible only to MEDes.</p>
                
                <p>
                    <label>Website</label>
                    <input type="text" name="website">
                    <label><input type="checkbox" name="website_private"> private</label>
                </p>
                <p>
                    <label>Email</label>
                    <input type="text" name="email">
                    <label><input type="checkbox" name="email_private"> private</label>
                </p>
                <p>
                    <label>Facebook</label>
                    <input type="text" name="facebook">
                    <label><input type="checkbox" name="facebook_private"> private</label>
                </p>
                <p>
                    <label>Twitter</label>
                    <input type="text" name="twitter">
                    <label><input type="checkbox" name="twitter_private"> private</label>
                </p>
                <p>
                    <label>LinkedIn</label>
                    <input type="text" name="linkedin">
                    <label><input type="checkbox" name="linkedin_private"> private</label>
                </p>
                <p>
                    <label>Google+</label>
                    <input type="text" name="google">
                    <label><input type="checkbox" name="google_private"> private</label>
                </p>
                <p>
                    <label>Instagram</label>
                    <input type="text" name="instagram">
                    <label><input type="checkbox" name="instagram_private"> private</label>
                </p>
                <p>
                    <label>Flickr</label>
                    <input type="text" name="flickr">
                    <label><input type="checkbox" name="flickr_private"> private</label>
                </p>
                <p>
                    <label>YouTube</label>
                    <input type="text" name="youtube">
                    <label><input type="checkbox" name="youtube_private"> private</label>
                </p>
                <p>
                    <label>Vimeo</label>
                    <input type="text" name="vimeo">
                    <label><input type="checkbox" name="vimeo_private"> private</label>
                </p>
                <p>
                    <label>Tumblr</label>
                    <input type="text" name="tumblr">
                    <label><input type="checkbox" name="tumblr_private"> private</label>
                </p>
                <p>
                    <label>Pinterest</label>
                    <input type="text" name="pinterest">
                    <label><input type="checkbox" name="pinterest_private"> private</label>
                </p>
            </div>
            
            <div id="user-edit-experience" class="edit-section">
                <div class="edit-section-title">Your timeline</div>
                
                <p>Every MEDes journey is unique. Share your experiences and where they led you.</p>
                
                <div class="experience"></div>
                
                <p>
                    <label>From</label>
                    <?php su_get_year_select(null, 'xp_start', 'year', 'add-xp-start-input'); ?>
                    <select name="xp_start_month" id="add-xp-start-month-input">
                        <option value="00">--</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </p>
                <p>
                    <label>To</label>
                    <?php su_get_year_select(null, 'xp_end', 'year', 'add-xp-end-input'); ?>
                    <select name="xp_end_month" id="add-xp-end-month-input">
                        <option value="00">--</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </p>
                <p>
                    <label class="blank"></label>
                    <textarea id="add-xp-desc-input" rows="3" cols="50" type="text" name="xp_desc"></textarea>
                </p>
                <p>
                    <label class="blank"></label>
                    <button id="add-xp-button">Add Experience</button>
                </p>
            </div>
            
            <div id="user-edit-skills" class="edit-section">
                <div class="edit-section-title">Show us what you got!</div>
                
                <p>List three areas of design that you worked within.</p>
                
                <div class="skills"></div>
                <p>
                    <input id="add-skill-input" type="text" name="skill"/>
                    <button id="add-skill-button">Add Skill</button>
                </p>
            </div>
            
            <div id="user-edit-description" class="edit-section">
                <div class="edit-section-title">One thought on design...</div>
                <p>Include a sentence that describes your design - your design philosophy.</p>
                <p>
                    <textarea name="tagline" cols="50" rows="3"></textarea>
                </p>
            </div>
            
            <button class="finish large">View Result</button>
        </div>
    </div>
</div>