/*
 File: Main js
 */



 !function($) {
	"use strict";

	var MainApp = function() {};

	MainApp.prototype.initNavbar = function () {

		$('.navbar-toggle').on('click', function (event) {
			$(this).toggleClass('open');
			$('#navigation').slideToggle(400);
		});

		$('.navigation-menu>li').slice(-1).addClass('last-elements');

		$('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
			if ($(window).width() < 992) {
				e.preventDefault();
				$(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
			}
		});
	},
	MainApp.prototype.initScrollbar = function () {
		$('.slimscroll-noti').slimScroll({
			height: '208px',
			position: 'right',
			size: "5px",
			color: '#98a6ad',
			wheelStep: 10
		});
	}
	// === following js will activate the menu in left side bar based on url ====
	MainApp.prototype.initMenuItem = function () {
		$(".navigation-menu a").each(function () {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) { 
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().parent().addClass("active"); // add active class to an anchor
				$(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
			}
		});
	},
	MainApp.prototype.initComponents = function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
	},
	MainApp.prototype.initToggleSearch = function () {
		$('.toggle-search').on('click', function () {
			var targetId = $(this).data('target');
			var $searchBar;
			if (targetId) {
				$searchBar = $(targetId);
				$searchBar.toggleClass('open');
			}
		});
	},

	MainApp.prototype.init = function () {
		this.initNavbar();
		this.initScrollbar();
		this.initMenuItem();
		this.initComponents();
		this.initToggleSearch();
		this.initToggleSearch();
	},

	//init
	$.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
function ($) {
	"use strict";
	$.MainApp.init();
}(window.jQuery);

// AGE CALCULATOR
function getAge(dateString) {
	var today = new Date();
	var birthDate = new Date(dateString);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age--;
	}
	return age;
}
function calculate_age(thisobj) {
	var age = getAge(jQuery(thisobj).val());
	jQuery(thisobj).parent().find('.age_result').html('Around <span>' + age + ' years</span>')
}
function getHeight(heightString) {
	var inches = heightString;
	var feet = Math.floor(inches / 12);
	inches %= 12;
	var result = feet + '&#39;' + inches + '&#34;';
	return result;
}
function calculate_height(thisobj) {
	var height = getHeight(jQuery(thisobj).val());
	jQuery(thisobj).parent().find('.height_result').html("That's roughly <span>" + height + "</span>")
}

jQuery(document).ready(function($) {

	// AGE CALCULATOR
	$('.calculate_age').on('change', function() {
		calculate_age($(this));
	})
	// HEIGHT CALCULATOR
	$('.calculate_height').on('change', function() {
		calculate_height($(this));
	})
        
        //PROFILE PAGE HIDE VERIFY EMAIL BUTTONS
        if($('#alternate').length){
            if(!$('#alternate').attr('value').length){

                $('#emailAlternateVerifyButton').css({
                   display:'none',
                   visible:'hidden'
                });
            }
        }

});
