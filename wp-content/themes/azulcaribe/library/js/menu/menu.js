jQuery(document).ready(main);

var cont = 1;

function main() {
	jQuery('.menu-hamburger').click(function() {
		toggleMenu();
	});

	jQuery('.main-menu-dropdown').click(function() {
		toggleDropdown(jQuery(this));
		// jQuery(this).find('.main-menu-li-ul').css('display', 'block');
	});

	jQuery(window).resize(showMenuOnResize);

	var header = document.getElementById('header');
	var headroom = new Headroom(header);
	headroom.init();
}

function toggleDropdown(el) {
	if('block' === el.find('.main-menu-li-ul').css('display')) {
		el.find('.main-menu-li-ul').css('display', 'none');
	} else {
		el.find('.main-menu-li-ul').css('display', 'block');
	}
}

function closeMenu() {
	jQuery('.main-menu').animate({
		left: '-100%'
	});
	jQuery('body').css('overflow', 'auto');
	jQuery('.main-menu').attr('mobile-hidden', 'true');
	jQuery('#menu-hamburger-svg').removeClass('svg-menu-toggle-cross');
	jQuery('#menu-hamburger-svg').addClass('svg-menu-toggle');
}

function openMenu() {
	jQuery('.main-menu').animate({
		left:'0'
	});
	jQuery('body').css('overflow', 'hidden');
	jQuery('.main-menu').attr('mobile-hidden', 'false');
	jQuery('#menu-hamburger-svg').removeClass('svg-menu-toggle');
	jQuery('#menu-hamburger-svg').addClass('svg-menu-toggle-cross');
}

function toggleMenu() {
	let currentStatus = jQuery('.main-menu').attr('mobile-hidden');
	if('true' === currentStatus) { // means menu is shown
		openMenu();
	} else { // means menu is not shown
		closeMenu();
	}
}

function showMenuOnResize() {
	jQuery('.main-menu').attr('mobile-hidden', 'true');
	jQuery('#menu-hamburger-svg').removeClass('svg-menu-toggle-cross');
	jQuery('#menu-hamburger-svg').addClass('svg-menu-toggle');

	if(1033 <= jQuery(window).width()) {
		jQuery('.main-menu').css('left', '0');
	} else {
		jQuery('.main-menu').css('left', '-100%');
	}
}
