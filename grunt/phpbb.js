var pjs = require('../package.json')

module.exports = {
  symlink: {
    files: [

    ]
  },

  template: {
    options: {
      data: {
        cfg: pjs.chatbroConfig
      }
    },

    files: {
      'src/server/platforms/phpbb/composer.json': ['src/server/platforms/phpbb/composer.tmpl.json']
    }
  }
}
