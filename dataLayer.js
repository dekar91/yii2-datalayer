DataLayer = {
  init: function (options) {
    console.log('test', options);
  },

  customHandler : function(e, event, data)
  {
    $(e).on(event, function(data)
    {
      dataLayer.push(data)
    });
  },
  onClick: function (e, data)
  {
    $(e).on('click', function(data)
    {
      dataLayer.push(data)
    });
  },
  onShow: function (e, data) {

  }

}