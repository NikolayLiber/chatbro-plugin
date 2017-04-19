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
          // bootstrap: 'dist/css/bootstrap.css',
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

    patch: {
      bootstrap: {
        options: {
          patch: 'patches/bootstrap.patch'
        },
        files: {
          'bower_components/bootstrap/dist/js/bootstrap.js': 'bower_components/bootstrap/dist/js/bootstrap.js'
        }
      }
    },

    sass: {
      common: {
        files: {
          '_build/common/css/chatbro.css': 'src/browser/common/scss/chatbro.scss'
        }
      },

      joomla: {
        files: {
          '_build/common/css/joomla.css': 'src/browser/platforms/joomla/scss/joomla.scss'
        }
      }
    },

    less: {
      bootstrap: {
        files: {
          '_build/common/css/chatbro-bootstrap.css': 'src/browser/common/less/cbro_bootstrap.less'
        }
      }
    },

    concat: {
      joomla_devcss: {
        src: ['_build/common/css/common.css', '_build/common/css/chatbro.css', '_build/common/css/chatbro-bootstrap.css', '_build/common/css/joomla.css'],
        dest: '_build/joomla/css/chatbro.css'
      },

      joomla_devjs: {
        src: ['_build/common/js/common.js', 'src/browser/common/js/*.js', 'src/browser/platforms/joomla/js/*.js'],
        dest: '_build/joomla/js/chatbro.js'
      }
    },

    eslint: {
      target: 'src/browser/**/*.js'
    },

    copy: {
      fonts: {
        expand: true,
        src: ['bower_components/font-awesome/fonts/*', 'bower_components/bootstrap/fonts/*'],
        dest: '_build/common/fonts/',
        filter: 'isFile',
        flatten: true
      }
    },

    symlink: {
      options: {
        overwrite: true
      },

      joomla: {
        files: [
          { src: '_build/common/fonts',
            dest: '_build/joomla/fonts' },
          { src: 'src/server/common',
            dest: 'src/server/platforms/joomla/lib_chatbro/common' },
          { src: '_build/joomla',
            dest: 'src/server/platforms/joomla/com_chatbro/media' }
        ]
      }
    },

    po2mo: {
      files: {
        src: [
          'src/server/common/languages/*.po',
          '!node_modules/**'
        ],
        expand: true
      }
    },

    pot: {
      options: {
        text_domain: 'chatbro', // Your text domain. Produces my-text-domain.pot
        dest: 'src/server/common/languages/', // directory to place the pot file
        keywords: [ // WordPress localisation functions
          '',
          '__:1',
          '_e:1',
          '_x:1,2c',
          'esc_html__:1',
          'esc_html_e:1',
          'esc_html_x:1,2c',
          'esc_attr__:1',
          'esc_attr_e:1',
          'esc_attr_x:1,2c',
          '_ex:1,2c',
          '_n:1,2',
          '_nx:1,2,4c',
          '_n_noop:1,2',
          '_nx_noop:1,2,3c'
        ],
        msgmerge: true,
        comment_tag: 'Translators:'
      },
      files: {
        src: [
          'src/**/*.php',
          '!node_modules/**',
          '!dist/**'
        ], // Parse all php files
        expand: true
      }
    }
  })

  grunt.loadNpmTasks('grunt-bower-task')
  grunt.loadNpmTasks('grunt-bower-concat')
  grunt.loadNpmTasks('grunt-sass')
  grunt.loadNpmTasks('grunt-contrib-concat')
  grunt.loadNpmTasks('grunt-contrib-copy')
  grunt.loadNpmTasks('grunt-eslint')
  grunt.loadNpmTasks('grunt-contrib-symlink')
  grunt.loadNpmTasks('grunt-contrib-less')
  grunt.loadNpmTasks('grunt-patch')
  grunt.loadNpmTasks('grunt-pot')
  grunt.loadNpmTasks('grunt-po2mo')

  grunt.registerTask('build:joomla:css:dev', ['bower_concat:common_css', 'sass:common', 'sass:joomla', 'less:bootstrap', 'concat:joomla_devcss'])
  grunt.registerTask('build:joomla:js:dev', ['bower_concat:common_js', 'eslint', 'concat:joomla_devjs'])
  grunt.registerTask('build:joomla:dev', ['build:joomla:css:dev', 'build:joomla:js:dev', 'copy:fonts', 'symlink:joomla'])
}
