var pjs = require('./package.json')
var compressExcluded = ['!**/*.po', '!**/*.pot', '!**/*~', '!**/~*', '!**/*.orig', '!**/*.tmpl.*']
var joomlaJsFiles = ['_build/common/js/common.js', 'src/browser/common/js/*.js', 'src/browser/platforms/joomla/js/*.js']
var joomlaCssFiles = ['_build/common/css/common.css', '_build/common/css/chatbro.css', '_build/common/css/chatbro-bootstrap.css', '_build/common/css/joomla.css']

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
        src: joomlaCssFiles,
        dest: '_build/joomla/css/chatbro.css'
      },

      joomla_devjs: {
        src: joomlaJsFiles,
        dest: '_build/joomla/js/chatbro.js'
      }
    },

    uglify: {
      joomla: {
        files: {
          '_build/joomla/js/chatbro.js': joomlaJsFiles
        }
      }
    },

    cssmin: {
      joomla: {
        files: {
          '_build/joomla/css/chatbro.css': joomlaCssFiles
        }
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
    },

    compress: {
      lib_chatbro: {
        options: {
          archive: '_build/joomla/pkg_chatbro/packages/lib_chatbro.zip'
        },

        files: [
          { expand: true,
            cwd: 'src/server/common/',
            src: ['**'].concat(compressExcluded),
            dest: 'lib_chatbro/common'
          },

          { expand: true,
            cwd: 'src/server/platforms/joomla/lib_chatbro',
            src: ['**', '!common/**'].concat(compressExcluded),
            dest: 'lib_chatbro/'
          }
        ]
      },

      com_chatbro: {
        options: {
          archive: '_build/joomla/pkg_chatbro/packages/com_chatbro.zip'
        },

        files: [
          { expand: true,
            cwd: 'src/server/platforms/joomla/com_chatbro',
            src: ['**', '!media/**'].concat(compressExcluded),
            dest: 'com_chatbro'
          },

          { expand: true,
            cwd: '_build/joomla',
            src: ['css/**', 'fonts/**', 'js/**', 'images/**'].concat(compressExcluded),
            dest: 'com_chatbro/media'
          },

          { expand: true,
            cwd: 'src/server/platforms/joomla/com_chatbro',
            src: ['index.html'],
            dest: 'com_chatbro/media'
          }
        ]
      },

      mod_chatbro: {
        options: {
          archive: '_build/joomla/pkg_chatbro/packages/mod_chatbro.zip'
        },

        files: [
          { expand: true,
            cwd: 'src/server/platforms/joomla/mod_chatbro',
            src: ['**'].concat(compressExcluded),
            dest: 'mod_chatbro/'
          }
        ]
      },

      plg_chatbro: {
        options: {
          archive: '_build/joomla/pkg_chatbro/packages/plg_chatbro.zip'
        },

        files: [
          { expand: true,
            cwd: 'src/server/platforms/joomla/plg_chatbro',
            src: ['**'].concat(compressExcluded),
            dest: 'plg_chatbro/'
          }
        ]
      },

      pkg_chatbro: {
        options: {
          archive: 'dist/joomla/pkg_chatbro_' + pjs.chatbroConfig.common_version + '.' + pjs.chatbroConfig.joomla_plugin_minor_version + '.zip'
        },

        files: [
          { expand: true,
            cwd: '_build/joomla/pkg_chatbro',
            src: ['packages/*.zip', 'pkg_chatbro.xml'],
            dest: 'pkg_chatbro'
          },

          { expand: true,
            cwd: 'src/server/platforms/joomla',
            src: ['pkg_chatbro.xml'],
            dest: 'pkg_chatbro'
          }
        ]
      }
    },

    template: {
      versions: {
        options: {
          data: {
            cfg: pjs.chatbroConfig
          }
        },

        files: {
          'src/server/common/core/version.php': ['src/server/common/core/version.tmpl.php'],
          'src/server/platforms/joomla/lib_chatbro/backends/version.php': ['src/server/platforms/joomla/lib_chatbro/backends/version.tmpl.php'],
          'src/server/platforms/joomla/com_chatbro/chatbro.xml': ['src/server/platforms/joomla/com_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/lib_chatbro/chatbro.xml': ['src/server/platforms/joomla/lib_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/mod_chatbro/mod_chatbro.xml': ['src/server/platforms/joomla/mod_chatbro/mod_chatbro.tmpl.xml'],
          'src/server/platforms/joomla/plg_chatbro/chatbro.xml': ['src/server/platforms/joomla/plg_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/pkg_chatbro.xml': ['src/server/platforms/joomla/pkg_chatbro.tmpl.xml'],
          'src/server/platforms/joomla/chatbro_update.xml': ['src/server/platforms/joomla/chatbro_update.tmpl.xml']
        }
      }
    },

    clean: {
      build: {
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
  grunt.loadNpmTasks('grunt-contrib-compress')
  grunt.loadNpmTasks('grunt-template')
  grunt.loadNpmTasks('grunt-contrib-uglify')
  grunt.loadNpmTasks('grunt-contrib-cssmin')
  grunt.loadNpmTasks('grunt-contrib-clean')

  grunt.registerTask('prepare', ['bower:install', 'patch:bootstrap'])

  grunt.registerTask('build:joomla:css:dev', ['bower_concat:common_css', 'sass:common', 'sass:joomla', 'less:bootstrap', 'concat:joomla_devcss'])
  grunt.registerTask('build:joomla:js:dev', ['bower_concat:common_js', 'eslint', 'concat:joomla_devjs'])
  grunt.registerTask('build:joomla:dev', ['build:joomla:css:dev', 'build:joomla:js:dev', 'copy:fonts', 'symlink:joomla', 'template:versions'])

  grunt.registerTask('build:joomla:css:prod', ['bower_concat:common_css', 'sass:common', 'sass:joomla', 'less:bootstrap', 'cssmin:joomla'])
  grunt.registerTask('build:joomla:js:prod', ['bower_concat:common_js', 'eslint', 'uglify:joomla'])
  grunt.registerTask('build:joomla:prod', ['build:joomla:css:prod', 'build:joomla:js:prod', 'copy:fonts', 'template:versions', 'po2mo'])
}
