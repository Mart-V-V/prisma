$(document).ready(function() {
    $('.mobile-burger').click(function() {
        $('.mobile').toggleClass('active');
    });
});


$(document).ready(function() {
    $('.accord').click(function() {
        $(this).toggleClass('act');
    });
});


const swiper = new Swiper('#swipe-1', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
});

const swiper2 = new Swiper('#swipe-2', {
    // Optional parameters
    direction: 'vertical',
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },

});

const swiper3 = new Swiper('#swipe-3', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
    slidesPerView: 3,
    spaceBetween: 10,
});



const swiper4 = new Swiper('#swipe-4', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: false,
  slidesPerView: 3,
  spaceBetween: 10,
});







// old script //
function banner(fl) {
	if(fl>0){
		document.getElementById("ban").style.display = "block";
	}
	else{
		document.getElementById("ban").style.display = "none";
	}
}

function menu(fl) {
	if(fl>0){
		document.getElementById("menumob").style.display = "block";
	}
	else{
		document.getElementById("menumob").style.display = "none";
	}
}
function submenu(fl) {
	if(fl>0){
		document.getElementById("sub2").style.display = "block";
		document.getElementById("submob").style.display = "block";
		document.getElementById("sub1").style.display = "none";
	}
	else{
		document.getElementById("sub2").style.display = "none";
		document.getElementById("submob").style.display = "none";
		document.getElementById("sub1").style.display = "block";
	}
}
