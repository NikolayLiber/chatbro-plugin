var pjs = require('../package.json')

module.exports = {
  template: {
    options: {
      data: {
        cfg: pjs.chatbroConfig
      }
    },

    files: {
      'src/server/platforms/drupal/chatbro.info.yml': ['src/server/platforms/drupal/chatbro.info.tmpl.yml']
    }
  },

  symlink: {
    files: [
      {
        src: 'src/server/common',
        dest: 'src/server/platforms/drupal/src/common'
      }
    ]
  }
}
