window.$ = jQuery;

$(f=>{
  $('.eventAccordionToggle').on('click', e => {
    if ($(e.currentTarget).parents('.results__event').hasClass('open')) {
      $(e.currentTarget).parent().siblings('#eventBody').slideUp();
      $(e.currentTarget).parents('.results__event').removeClass('open');
      $(e.currentTarget).removeClass('active');
    } else {
      $(e.currentTarget).parent().siblings('#eventBody').slideDown();
      $(e.currentTarget).parents('.results__event').addClass('open');
      $(e.currentTarget).addClass('active');
    }
  });
});
