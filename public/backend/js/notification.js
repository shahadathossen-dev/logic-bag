
$("#notifications").DataTable();

$('#notification-board > li > a').click(function(e)
{
  $(this).siblings('.notification-list').toggle(300);
  return false;
});
  
$('#notification-board .notification-item').each(function()
{
  var defaultView = $(this).find('.time-count');
  var actionBtn = $(this).find('.btn-container');
  
  $(this).mouseover(function(){
    defaultView.stop( true, true ).hide(200);
    actionBtn.stop( true, true ).show(300);
  }).mouseleave(function()
  {
    actionBtn.stop( true, true ).hide(200);        
    defaultView.stop( true, true ).show(300);
  });

});

$('.read-notification').click(function readNotification(event)
{
  event.preventDefault();
    
  var id = $(this).attr('id');
  var targetHref = $(this).attr('href');
  var url = $(this).data('target');
  $.ajax({
    type: "GET",
    url: url,
    success: function(response){
      (window.location.href = targetHref);
    },
    error: function (error){
      responseError(error);
    }
  });
  return false;
});

$('.markasread').each(function()
{
  $(this).click(function markAsRead(event)
  {
    event.preventDefault();
      
    var classId = $(this).data('id'),
      readBtn = $('.'+classId).closest('.notification-item').find('.markasread'),
      unreadBtn = $('.'+classId).closest('.notification-item').find('.markasunread'),
      notificationItem = $('.'+classId).closest('.notification-item').find('.read-notification'),
      readAt = $('.'+classId).closest('.notification-item').find('.read_at'),
      dataParentId = $(this).data('category'),
      url = $(this).attr('href');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "GET",
      url: url,
      success: function(response){
        notificationItem.addClass('read text-muted');
        readBtn.fadeOut(100).toggle();
        readAt.html(response['readtime']);
        unreadBtn.slideDown(200);
        updateNotificationsHeader(response['count']);
        updateNotificationBoard(dataParentId, response['rest']);
      },
      error: function (error){
        responseError(error);
      }
    });
    return false;
  });
});

$('.markasunread').each(function()
{
  $(this).click(function markAsUnRead(event)
  {
    event.preventDefault();
      
    var classId = $(this).data('id'),
        unreadBtn = $('.'+classId).closest('.notification-item').find('.markasunread'),
        readBtn = $('.'+classId).closest('.notification-item').find('.markasread'),
        readAllBtn = $('.markallasread'),
        deleteAllBtn = $('#notification-board .markallasread').siblings('.deleteall'),
        notificationItem = $('.'+classId).closest('.notification-item').find('.read-notification'),
        readAt = $('.'+classId).closest('.notification-item').find('.read_at'),
        dataParentId = $(this).data('category'),
        url = $(this).attr('href'),
        read_at = "Not read yet";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "GET",
      url: url,
      success: function(response){
        notificationItem.removeClass('read text-muted');
        unreadBtn.fadeOut(100).toggle();
        readBtn.slideDown(200);
        readAt.html(read_at);

        if (readAllBtn.is('.isDisabled')) {
          readAllBtn.toggleClass('isDisabled');
          deleteAllBtn.hide();
        }

        updateNotificationsHeader(response['count']);
        updateNotificationBoard(dataParentId, response['rest']);
      },
      error: function(error){
        responseError(error);
      }
    });
    return false;
  });
});

$('.delete-notification').each(function()
{
  $(this).click(function deleteSingle(event)
  {
    event.preventDefault();
    var classId = $(this).data('id'),
        notificationItem = $('.'+classId).closest('.notification-item'),
        url = $(this).attr('href'),
        dataParentId = $(this).data('category');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "GET",
      url: url,
      success: function(response){
        notificationItem.toggle(300);
        updateNotificationsHeader(response['count']);
        updateNotificationBoard(dataParentId, response['rest']);
      },
      error: function(error){
        responseError(error);
      }
    });
    return false;
  });
});

$('.markallasread').click(function markAllAsRead (event)
{
  event.preventDefault();
  var readAllBtn = $('.markallasread'),
      readBtn = $('.markasread'),
      readAt = $('.read_at'),
      unreadBtn = $('.markasunread'),
      deleteAllBtn = $('#notification-board .markallasread').siblings('.deleteall'),
      url = $(this).attr('href');
  $.ajax({
    type: "GET",
    url: url,
    success: function(response){
      updateNotificationsHeader(response['count']);
      updateAllAsRead();
      readAllBtn.fadeOut(100).toggle();
      deleteAllBtn.slideDown(200);
      readBtn.fadeOut(100).toggle();
      unreadBtn.slideDown(200);
      readAt.html(response['readtime']);
    },
    error: function(error){
      responseError(error);
    }
  });
  return false;
});

$('.deleteall').click(function deleteAll (event)
{
  event.preventDefault();
  var notificationList = $('#notifications .notification-list'),
    deleteAllParent = $('.deleteall').parent(),
    notificationItems = $('.notification-item'),
    dropdownItems = $('.dropdown-item'),
    url = $(this).attr('href');

  $.ajax({
    type: "GET",
    url: url,
    success: function(response){
      updateNotificationsHeader(response['count']).done(function(data){
        notificationItems.toggle(300, dropdownItems.toggle(300));
        notificationList.html('<tr class="empty"><td colspan="4">You have no notification.</td></tr>');
        deleteAllParent.addClass('isDisabled');
      });
    },
    error: function(error){
      responseError(error);
    }
  });
  return false;
});

function updateNotificationsHeader(count)
{
  $('#notification-indicator').html(count);
  $('.notification-header > .notification-count').html(count);
}

function updateNotificationBoard(dataParentId, count)
{ var dataCategory = $(dataParentId),
      readAllBtn = $('.markallasread'),
      dataCategoryCounter = $(dataParentId).children('.notification-category').children('.notification-count');

  if (count !== 0) {
    dataCategoryCounter.html(count);
    dataCategory.show(300);
  } else {
    dataCategory.hide(300);
    readAllBtn.toggleClass('isDisabled');
  }
}

function updateAllAsRead()
{
  $('.notification-category > .notification-count').html(0);
  $('.read-notification').addClass('read text-muted');
}

function responseError(error){
    console.log(error);
    swal({
        title: error.status,
        text: error.statusText,
        type: "error",
        showCancelButton: true,
        confirmButtonColor: '#5EBA7D',
        confirmButtonText: "Home page",
        cancelButtonText : "Close",
    })
    .then((value) => {

        if (value.value) {
            window.location.replace("http://www.logicbag.com.bd");
            return false;
        }
    });
}

