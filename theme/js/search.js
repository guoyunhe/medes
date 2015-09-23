jQuery(function () {
    jQuery('#site-search').click(function () {
        openPopup(jQuery('#search-popup'));
    });
    
    jQuery('#search-popup input[type="search"]').keypress(function (e){
        if (e.which == 13) {
            search();
        }
    });
    
    jQuery('#search-popup a').click(function(){
        search();
    });
    
    function search() {
        var request = {
            'action': 'search_all',
            'keywords': jQuery('#search-popup input[type="search"]').val()
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function(response){
            jQuery('#search-popup .card').remove(); // Empty old search results
            
            var userNum = 0, schoolNum = 0, workshopNum = 0;
            if (response.users !== undefined) {
                userNum = response.users.length;
            }
            jQuery('#people-search-tab .number').text(userNum);
            if (response.schools !== undefined) {
                schoolNum = response.schools.length;
            }
            jQuery('#school-search-tab .number').text(schoolNum);
            if (response.workshops !== undefined) {
                workshopNum = response.workshops.length;
            }
            jQuery('#workshop-search-tab .number').text(workshopNum);
            
            if (userNum > schoolNum && userNum > workshopNum) {
                jQuery('#people-search-tab').click();
            } else if (schoolNum > userNum && schoolNum > workshopNum) {
                jQuery('#school-search-tab').click();
            } else if (workshopNum > schoolNum && workshopNum > userNum) {
                jQuery('#workshop-search-tab').click();
            }
            
            var peopleSearchContainer = jQuery('#people-search-pane');
            for (var i in response.users) {
                addUser(response.users[i]);
            }
            
            function addUser(user) {
                var userElement = jQuery('<person></person>');
                userElement.addClass('card');
                peopleSearchContainer.append(userElement);
                userElement.data('userid', user.ID);
                userElement.css('background-color', user.color);
                userElement.css('background-image', 'url("' + user.avatar + '")');
                userElement.text(user.name);
                userElement.click(function(){
                    closePopup(jQuery('#search-popup'));
                    viewUserPopup(user.ID);
                });
            }
            
            var schoolSearchContainer = jQuery('#school-search-pane');
            for (var i in response.schools) {
                addSchool(response.schools[i]);
            }
            
            function addSchool(school) {
                var schoolElement = jQuery('<school></school>');
                schoolElement.addClass('card');
                schoolSearchContainer.append(schoolElement);
                schoolElement.data('schoolid', school.ID);
                schoolElement.css('background-color', school.color);
                schoolElement.css('background-image', 'url("' + school.main_picture.url + '")');
                schoolElement.text(school.title);
                schoolElement.click(function(){
                    closePopup(jQuery('#search-popup'));
                    viewSchoolPopup(school.ID);
                });
            }
            
            var workshopSearchContainer = jQuery('#workshop-search-pane');
            for (var i in response.workshops) {
                addWorkshop(response.workshops[i]);
            }
            
            function addWorkshop(workshop) {
                var workshopElement = jQuery('<workshop></workshop>');
                workshopElement.addClass('card');
                workshopSearchContainer.append(workshopElement);
                workshopElement.data('workshopid', workshop.ID);
                workshopElement.css('background-color', workshop.color);
                workshopElement.css('background-image', 'url("' + workshop.main_picture.url + '")');
                workshopElement.text(workshop.title);
                workshopElement.click(function(){
                    closePopup(jQuery('#search-popup'));
                    viewWorkshopPopup(workshop.ID);
                });
            }
        });
    }
});