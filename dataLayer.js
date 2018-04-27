var DataLayer = {
  init: function (options) {
    console.log('test', options);

    if(typeof options['customEvents'] !== 'undefined')
    {
      for (var e in options['customEvents']) {
        if(typeof  e.bindAttribute !== 'undefined' && e.bindAttribute.length() > 0)
        {
          DataLayer.customHandler(e[0], e[1], $(e).data(e.bindAttribute));

        } else {
          DataLayer.customHandler(e[0], e[1], e[2]);
        }
      }
    }
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

};