
// function openReplyEditForm(){

//     var click = 1;
//     $('#review .edit-reply').each(function(){
// 	    $(this).click(function(e){
//     		e.preventDefault();
//     		var thisPane = $(this).closest('.reply-pane');
//     		var replyField = $(this).closest('.reply').find('.reply-edit-form-field');

// 	        if (!replyField.is('.active')) {
//             	var activeField = thisPane.find('.reply-edit-form-field.active');
// 		        if (activeField.length > 0) {
// 	            	activeField.toggleClass('active');
// 	            	activeField.closest('.reply').find('.edit-reply').children('i.closed, i.open').toggle();
// 	            	// activeField.closest('.reply').find('.edit-reply').children('i:open').toggle();
// 	            	activeField.slideUp(500);
// 	            	click = 1;
// 	        	}

//             }

// 	        if (click%2 == 1) {
// 	            replyField.slideDown(500);
// 	        } else {
// 	            replyField.slideUp(500);
// 	        }

//             $(this).children('i.closed, i.open').toggle();
//             replyField.toggleClass('active');
// 	        click++;

//             console.log(click);
// 	    });
//     });
// }

// openReplyEditForm();

$('.reply .edit-reply').each(function(){
// $('#replies .edit-reply').each(function(){
    $(this).click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var target = $(this).data('target');
	    $.ajax({
	        type: "GET",
	        url: url,
	        datType: 'json',
	        success: function(reply){
	        	var form = $('#reply-form .reply-form');
	        	form.slideUp();
	        	setTimeout(function(){
		        	form.parent().prev().html('Update your reply');
		        	form.attr('action', 'http://www.logicbag.com.bd/backend/reply/update')
		        	var replyIdField = '<input type="hidden" name="id" value="'+reply.id+'">';
		        	form.find('input[name="review_id"]').after(replyIdField);
		        	form.find('textarea[name=comment]').val(reply.comment).attr('autofocus', 'autofocus');
		        	form.find('button[type="submit"]').html('Update');
		        	form.slideDown(300);
                }, 300);

	        	$('html, body').animate({
		            scrollTop: $(target).offset().top - 120
		        }, 1250);

	        },
	        
	        error: function (response) {
	            console.log(response);
	        }
	    });
    });
});

function minimizeReplyPane(){

    var click = 1;
    $('#review .minimize').each(function(){
	    $(this).click(function(e){
    		e.preventDefault();
    		var thisPane = $(this).closest('.review').find('.reply-pane');

	        if (!thisPane.is('.minimized')) {
            	click = 1;
            } else {
            	click = 0;
            }

	        if (click % 2 == 1) {

	            $(this).children('i').css('transform', 'rotateX(180deg)')
	            thisPane.toggleClass('minimized');
	            thisPane.slideUp(500);

	        } else {

	        	$(this).children('i').css('transform', '');
	            thisPane.slideDown(500);
	            thisPane.toggleClass('minimized');
	            
	        }
	        
	        click++;
	    });
    });
}

minimizeReplyPane();

// function openReplyForm(){

//     var click = 1;
//     $('#review .reply-btn').each(function(){
// 	    $(this).click(function(e){
//     		e.preventDefault();
//     		var thisPane = $(this).closest('.review').find('.reply-pane');
//     		var replyField = $(this).closest('.review').find('.reply-form-field');

//     		if (thisPane.is('.minimized')) {
// 				$(this).closest('.review').find('.minimize').trigger('click');
//             }

// 	        if (!replyField.is('.active')) {

// 		        if ($(this).closest('.review-pane').find('.reply-form-field.active')) {
// 	            	var activeField = $(this).closest('.review-pane').find('.reply-form-field.active');
// 	            	activeField.closest('.review').find('.reply-btn').children('i').css('transform', '');
// 	            	activeField.toggleClass('active');
// 	            	activeField.slideUp(500);
// 	            	click = 1;
// 	        	}

//             }

// 	        if (click%2 == 1) {

// 	            $(this).children('i').css('transform', 'rotateX(180deg)')
// 	            replyField.toggleClass('active');
// 	            replyField.slideDown(500);

// 	        } else {

// 	            e.preventDefault();
// 	            $(this).children('i').css('transform', '');
// 	            replyField.slideUp(500);
// 	            replyField.toggleClass('active');
	            
// 	        }
	        
// 	        click++;
// 	    });
//     });
// }

// openReplyForm();