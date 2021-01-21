document.body.addEventListener('click', e => {
  if (e.target.className !== 'button') return;

  var input = e.target.parentNode.querySelector('input');

  if (e.target.getAttribute('data-camera')) {
    input.setAttribute('capture', 'environment');
    input.setAttribute('accept', 'image/*');
  } else {
    input.removeAttribute('capture');
    input.setAttribute('accept', 'image/*,application/pdf');
  }

  input.click();
});

window.onload = function() {
  //menu left toggle

  $('.toggle-nav').click(function() {
    // alert('done');
    $this = $(this);
    $nav = $('.nice-nav');
    //$nav.fadeToggle("fast", function() {
    //  $nav.slideLeft('250');
    //  });

    $nav.toggleClass('open');

  });
  $('.body-part').click(function() {
    $nav.addClass('open');
  });
  //  $nav.addClass('open');

  //drop down menu
  $submenu = $('.child-menu-ul');
  $('.child-menu .toggle-right').on('click', function(e) {
    e.preventDefault();
    $this = $(this);
    $parent = $this.parent().next();
    // $parent.addClass('active');
    $tar = $('.child-menu-ul');
    if (!$parent.hasClass('active')) {
      $tar.removeClass('active').slideUp('fast');
      $parent.addClass('active').slideDown('fast');

    } else {
      $parent.removeClass('active').slideUp('fast');
    }
  });
};
