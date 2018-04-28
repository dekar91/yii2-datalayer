var DataLayer = {
  cssClass: 'datalayer',
  eventAttributeName: '.datalayer-event',
  dataAttributeName: 'datalayer-data',
  bindObjects: true,

  init: function (options) {
    window.dataLayer = window.dataLayer || []

    if (typeof options['customEvents'] !== 'undefined') {
      var customEvents = options['customEvents']

      if (typeof options['bindObjects'] !== 'undefined')
        DataLayer.bindObjects = options['bindObjects']

      if (DataLayer.bindObjects)
        DataLayer.bindEvents()

      customEvents.forEach(function (e) {
        if (typeof  e.bindAttribute !== 'undefined' && e.bindAttribute.length() > 0) {
          DataLayer.attributeHandler(e[0], e[1], e.bindAttribute)

        } else {
          DataLayer.customHandler(e[0], e[1], e[2])
        }
      })
    }
  },
  bindEvents: function () {
    $(document).ready(function () {
      $(DataLayer.cssClass).each(function (index) {
        DataLayer.attributeHandler($(this), $(this).data(DataLayer.eventAttributeName), $(this).data(DataLayer.dataAttributeName))
      })
    })
  },
  customHandler: function (e, event, data) {
    $(document).on(event, e, data, function (event) {
      dataLayer.push(event.data)
    })
  },
  attributeHandler: function (e, event, attribute) {
    $(document).on(event, e, attribute, function (event) {
      dataLayer.push($(event.target).data(event.data))
    })
  },
  onClick: function (e, data) {
    $(e).on('click', data, function (event) {
      dataLayer.push(event.data)
    })
  },

}