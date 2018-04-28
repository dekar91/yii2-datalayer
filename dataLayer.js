var DataLayer = {
  init: function (options) {
    window.dataLayer = window.dataLayer || [];

    if (typeof options['customEvents'] !== 'undefined') {
      var customEvents = options['customEvents'];

      customEvents.forEach(function (e) {
        if (typeof  e.bindAttribute !== 'undefined' && e.bindAttribute.length() > 0) {
          DataLayer.customHandler(e[0], e[1], $(e).data(e.bindAttribute));

        } else {
          DataLayer.customHandler(e[0], e[1], e[2]);
        }
      });
    }
  },

  customHandler: function (e, event, data) {
    $(document).on(event, e, data, function (event) {
      dataLayer.push(event.data);
    })
  },
  onClick: function (e, data) {
    $(e).on('click', data, function (event) {
      dataLayer.push(event.data);
    })
  },

};