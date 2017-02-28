module.exports = function (grunt) {
  grunt.initConfig({
    bower: {
      install: {
        options: {
          copy: false
        }
      }
    },

    bower_concat: {
      common_css: {
        dest: {
          css: '_build/common/css/common.css'
        },

        mainFiles: {
          bootstrap: 'dist/css/bootstrap.css',
          'font-awesome': 'css/font-awesome.css'
        }
      },

      common_js: {
        dest: {
          js: '_build/common/js/common.js'
        },

        mainFiles: {
          bootstrap: 'dist/js/bootstrap.js'
        }
      }
    },

    sass: {
      common: {
        files: {
          '_build/common/css/chatbro.css': 'src/browser/scss/chatbro.scss'
        }
      }
    },

    concat: {
      joomla_devcss: {
        src: ['_build/common/css/common.css', '_build/common/css/chatbro.css'],
        dest: ['_build/joomla/css/chatbro.css']
      },

      joomla_devjs: {
        src: ['_build/common/js/common.js', 'src/browser/common/js/*.js'],
        dest: ['_build/joomla/js/chatbro.js']
      }
    },

    eslint: {
      target: 'src/browser/js/**.js'
    }
  })

  grunt.loadNpmTasks('grunt-bower-task')
  grunt.loadNpmTasks('grunt-bower-concat')
  grunt.loadNpmTasks('grunt-sass')
  grunt.loadNpmTasks('grunt-contrib-concat')
  grunt.loadNpmTasks('grunt-eslint')

  grunt.registerTask('build:joomla:css:dev', ['bower_concat:common_css', 'sass:common', 'concat:joomla_devcss'])
  grunt.registerTask('build:joomla:js:dev', ['bower_concat:common_js', 'eslint', 'concat:joomla_devjs'])
  grunt.registerTask('build:joomla:dev', ['build:joomla:css:dev', 'build:joomla:js:dev'])
}
