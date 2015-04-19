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

jQuery(function () {

    /* Basic UI Elements
     * 
     * Click, dropdown, popup...
     */

    // Click element events
    jQuery('.click').click(function (event) {
        event.stopPropagation();
        if (jQuery(this).hasClass('button')) {
            jQuery('.click:not(.tab)').removeClass('active');
            return;
        }
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
            return;
        } else {
            jQuery('.click:not(.tab)').removeClass('active');
            jQuery(this).addClass('active');
            return;
        }
    });
    jQuery(document).click(function () {
        jQuery('.click:not(.tab)').removeClass('active');
    });

    // Dropdown use the active status of click by default, so no event

    // Popup
    jQuery('.popup').each(function () {
        var popup = jQuery(this);
        popup.find('.popup-close').click(function () {
            popup.hide();
        });

    });


    /* Page Layout and Responsive Design
     * 
     * Top bar...
     */

    // Top bar fusion effect
    topbarFusion();
    jQuery(window).scroll(topbarFusion);
    jQuery(window).resize(topbarFusion);
    
    // Search
    jQuery('#top-search-click .dropdown').click(function (event) {
        event.stopPropagation();
    });

    
});

/* Top Bar Fusion Effect
 *
 * Detect scroll length of page
 */
function topbarFusion() {
    if (jQuery(document).scrollTop() < jQuery('#site-header').height()) {
        jQuery('#site-header').addClass('fusion');
    } else {
        jQuery('#site-header').removeClass('fusion');
    }
}

jQuery(function(){
    PeopleDatamap.init();
    DotCloud.init();
});

DotCloud = {
    width: 0,
    height: 0,
    largeHeader: {},
    canvas: {},
    ctx: {},
    points: [],
    target: {},
    animateHeader: true,
    init: function() {
        this.initHeader();
        this.initAnimation();
        requestAnimationFrame(this.animate);
        this.addListeners();
        this.numberChange();
    },

    initHeader: function () {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.largeHeader = document.getElementById('dot-cloud');
        this.canvas = document.getElementById('demo-canvas');
        this.target = {x: this.width/2, y: this.height/2};

        this.largeHeader.style.height = this.height+'px';

        this.canvas.width = this.width;
        this.canvas.height = this.height;
        this.ctx = this.canvas.getContext('2d');

        // create points
        for(var x = 0; x < this.width; x = x + 80) {
            for(var y = 0; y < this.height; y = y + 80) {
                var px = x + Math.random()*80;
                var py = y + Math.random()*80;
                var p = {x: px, originX: px, y: py, originY: py };
                this.points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < this.points.length; i++) {
            var closest = [];
            var p1 = this.points[i];
            for(var j = 0; j < this.points.length; j++) {
                var p2 = this.points[j];
                if(!(p1 === p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] === undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(this.getDistance(p1, p2) < this.getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in this.points) {
            var c = new this.Circle(this.points[i], 2 + Math.random() * 2, 'rgba(255,255,255,0.3)');
            this.points[i].circle = c;
        }
    },

    // Event handling
    addListeners: function () {
        window.addEventListener('mousemove', this.mouseMove);
        window.addEventListener('scroll', this.scrollCheck);
        window.addEventListener('resize', this.resize);
    },

    mouseMove: function (e) {
        var posx = 0;
        var posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        DotCloud.target.x = posx;
        DotCloud.target.y = posy;
    },

    scrollCheck: function() {
        if(document.body.scrollTop > DotCloud.height) {
            DotCloud.animateHeader = false;
        } else {
            DotCloud.animateHeader = true;
        }
    },

    resize: function() {
        DotCloud.width = window.innerWidth;
        DotCloud.height = window.innerHeight;
        DotCloud.largeHeader.style.height = DotCloud.height+'px';
        DotCloud.canvas.width = DotCloud.width;
        DotCloud.canvas.height = DotCloud.height;
    },

    // animation
    initAnimation: function() {
        this.animate();
        for(var i in this.points) {
            this.shiftPoint(this.points[i]);
        }
    },

    animate: function() {
        if(DotCloud.animateHeader) {
            DotCloud.ctx.clearRect(0, 0, DotCloud.width, DotCloud.height);
            for(var i in DotCloud.points) {
                // detect points in range
                var distance = DotCloud.getDistance(DotCloud.target, DotCloud.points[i]);
                if( distance < 70) {
                    DotCloud.points[i].active = 0.3;
                    DotCloud.points[i].circle.active = 0.6;
                } else if(distance < 150) {
                    DotCloud.points[i].active = 0.1;
                    DotCloud.points[i].circle.active = 0.3;
                } else if(distance < 200) {
                    DotCloud.points[i].active = 0.02;
                    DotCloud.points[i].circle.active = 0.1;
                } else {
                    DotCloud.points[i].active = 0;
                    DotCloud.points[i].circle.active = 0;
                }

                DotCloud.drawLines(DotCloud.points[i]);
                DotCloud.points[i].circle.draw();
            }
        }
        requestAnimationFrame(DotCloud.animate);
    },

    shiftPoint: function(p) {
        _this = this;
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                _this.shiftPoint(p);
            }});
    },

    // Canvas manipulation
    drawLines: function (p) {
        if(!p.active) return;
        for(var i in p.closest) {
            this.ctx.beginPath();
            this.ctx.moveTo(p.x, p.y);
            this.ctx.lineTo(p.closest[i].x, p.closest[i].y);
            this.ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
            this.ctx.stroke();
        }
    },
    // TODO move this Class out of DotCloud object
    Circle: function(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            DotCloud.ctx.beginPath();
            DotCloud.ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            DotCloud.ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
            DotCloud.ctx.fill();
        };
    },

    // Util
    getDistance: function(p1, p2) {
        return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
    },
    
    // Numbers change
    numberChange: function() {
        var $statisticsList = jQuery('.statistics');
        var statisticsIndex = 0;

        jQuery($statisticsList[statisticsIndex]).fadeIn('fast');

        setInterval(function(){
            if(statisticsIndex >= $statisticsList.length - 1) {
                statisticsIndex = 0;
            } else {
                statisticsIndex++;
            }

            $statisticsList.hide();
            jQuery($statisticsList[statisticsIndex]).fadeIn('fast');
        }, 1500);
    }
};


PeopleDatamap = {
    datamapObj: {},

    init: function() {
        jQuery('#datamap').height(jQuery('#datamap').width() * 2 / 3);
        this.datamapObj = new Datamap({
            element: document.getElementById("datamap"),
            scope: 'world',
            fills: {
                defaultFill: "#eeeeee",
                activeFill: "#99ddee",
                CHN: '#ff0000'
            },
            geographyConfig: {
                borderWidth: 0.2,
                borderColor: '#000000',
                popupTemplate: function(geography, data) { //this function should just return a string
                    return '<div class="hoverinfo"><strong>' + geography.properties.name + '</strong></div>';
                },
                popupOnHover: true, //disable the popup while hovering
                highlightOnHover: true,
                highlightFillColor: '#FC8D59',
                highlightBorderColor: 'rgba(250, 15, 160, 0.2)',
                highlightBorderWidth: 2
            },
            data: {
                CHN: {fillKey: 'activeFill'},
                FIN: {fillKey: 'activeFill'},
                JPN: {fillKey: 'activeFill'},
                DEU: {fillKey: 'activeFill'},
                FRA: {fillKey: 'activeFill'},
                ITA: {fillKey: 'activeFill'},
                USA: {fillKey: 'activeFill'}
            }
        });
        
        this.bindUIEvents();
    },

    bindUIEvents: function() {
        jQuery('.datamaps-subunit').click(function(){
            jQuery('#city-list').show();
        });
    }
};