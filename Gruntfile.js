var pjs = require('./package.json')
var compressExcluded = ['!**/*.po', '!**/*.pot', '!**/*~', '!**/~*', '!**/*.orig', '!**/*.tmpl.*']
var commonCssFiles = ['_build/common/css/common.css', '_build/common/css/chatbro.css', '_build/common/css/chatbro-bootstrap.css']
var commonJsFiles = ['_build/common/js/common.js', 'src/browser/common/js/*.js']
var joomlaJsFiles = commonJsFiles.concat(['src/browser/platforms/joomla/js/*.js'])
var joomlaCssFiles = commonCssFiles.concat(['_build/common/css/joomla.css'])
var wordpressJsFiles = commonJsFiles
var wordpressCssFiles = commonCssFiles.concat(['_build/common/css/wordpress.css'])

var phpbb = require('./grunt/phpbb')
var drupal = require('./grunt/drupal')

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
      },

      wordpress: {
        files: {
          '_build/common/css/wordpress.css': 'src/browser/platforms/wordpress/scss/wordpress.scss'
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

      wordpress_devcss: {
        src: wordpressCssFiles,
        dest: '_build/wordpress/css/chatbro.css'
      },

      joomla_devjs: {
        src: joomlaJsFiles,
        dest: '_build/joomla/js/chatbro.js'
      },

      wordpress_devjs: {
        src: wordpressJsFiles,
        dest: '_build/wordpress/js/chatbro.js'
      }
    },

    uglify: {
      joomla: {
        files: {
          '_build/joomla/js/chatbro.js': joomlaJsFiles
        }
      },

      wordpress: {
        files: {
          '_build/wordpress/js/chatbro.js': wordpressJsFiles
        }
      }
    },

    cssmin: {
      joomla: {
        files: {
          '_build/joomla/css/chatbro.css': joomlaCssFiles
        }
      },

      wordpress: {
        files: {
          '_build/wordpress/css/chatbro.css': wordpressCssFiles
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
        flatten: true,
        timestamp: true
      },
      wp_build: {
        files: [
          { expand: true,
            cwd: 'src/server',
            src: ['common/**', '!common/languages/**/*.po*'],
            dest: '_build/wordpress/'
          },
          { expand: true,
            cwd: '_build/common',
            src: 'fonts/**',
            dest: '_build/wordpress/'
          },
          { expand: true,
            cwd: 'src/server/platforms/wordpress',
            filter: 'isFile',
            src: ['**', '!**/*tmpl.php', '!common/**/*', '!css/**/*', '!fonts/**/*', '!js/**/*'],
            dest: '_build/wordpress'
          }
        ],
        options: {
          timestamp: true,
          mode: true
        }
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
      },

      wordpress: {
        files: [
          { src: 'src/server/common',
            dest: 'src/server/platforms/wordpress/common' },
          { src: '_build/wordpress/js',
            dest: 'src/server/platforms/wordpress/js' },
          { src: '_build/wordpress/css',
            dest: 'src/server/platforms/wordpress/css' },
          { src: '_build/common/fonts',
            dest: 'src/server/platforms/wordpress/fonts' },
          { src: 'src/browser/common/images/favicon_small.png',
            dest: 'src/server/platforms/wordpress/favicon_small.png' }
        ]
      },

      drupal: drupal.symlink
    },

    po2mo: {
      files: {
        src: 'src/server/common/languages/*.po',
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
      joomla_lib_chatbro: {
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

      joomla_com_chatbro: {
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

      joomla_mod_chatbro: {
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

      joomla_plg_chatbro: {
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

      joomla_pkg_chatbro: {
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
      common: {
        options: {
          data: {
            cfg: pjs.chatbroConfig
          }
        },

        files: {
          'src/server/common/core/version.php': ['src/server/common/core/version.tmpl.php']
        }
      },

      joomla: {
        options: {
          data: {
            cfg: pjs.chatbroConfig
          }
        },

        files: {
          'src/server/platforms/joomla/lib_chatbro/backends/version.php': ['src/server/platforms/joomla/lib_chatbro/backends/version.tmpl.php'],
          'src/server/platforms/joomla/com_chatbro/chatbro.xml': ['src/server/platforms/joomla/com_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/lib_chatbro/chatbro.xml': ['src/server/platforms/joomla/lib_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/mod_chatbro/mod_chatbro.xml': ['src/server/platforms/joomla/mod_chatbro/mod_chatbro.tmpl.xml'],
          'src/server/platforms/joomla/plg_chatbro/chatbro.xml': ['src/server/platforms/joomla/plg_chatbro/chatbro.tmpl.xml'],
          'src/server/platforms/joomla/pkg_chatbro.xml': ['src/server/platforms/joomla/pkg_chatbro.tmpl.xml'],
          'src/server/platforms/joomla/chatbro_update.xml': ['src/server/platforms/joomla/chatbro_update.tmpl.xml']
        }
      },

      wordpress: {
        options: {
          data: {
            cfg: pjs.chatbroConfig
          }
        },

        files: {
          'src/server/platforms/wordpress/backends/version.php': ['src/server/platforms/wordpress/backends/version.tmpl.php'],
          'src/server/platforms/wordpress/index.php': ['src/server/platforms/wordpress/index.tmpl.php'],
          'src/server/platforms/wordpress/readme.txt': ['src/server/platforms/wordpress/readme.tmpl.txt']
        }
      },

      phpbb: phpbb.template,
      drupal: drupal.template
    },

    clean: {
      wp: ['./dist/wordpress', '_build/wordpress']
    },

    svn_fetch: {
      options: {
        repository: 'https://plugins.svn.wordpress.org/chatbro/',
        path: './'
      },
      wp: {
        map: { 'dist/wordpress': 'trunk' }
      }
    },

    sync: {
      wp: {
        files: [{
          cwd: '_build/wordpress',
          src: [
            '**/*.php',
            'js/**/*.js',
            'css/**/*.css',
            'common/languages/**/*.mo',
            'favicon_small.png',
            'fonts/**/*',
            'readme.txt',
            'index.html',
            '!.svn/**'
          ],
          dest: 'dist/wordpress'
        }],
        verbose: true,
        failOnError: true,
        updateAndDelete: true,
        compareUsing: 'md5',
        ignoreInDest: ['LICENCE.txt', '.svn/**']
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
  grunt.loadNpmTasks('grunt-svn-fetch')
  grunt.loadNpmTasks('grunt-sync')

  grunt.registerTask('prepare', ['bower:install', 'patch:bootstrap'])

  grunt.registerTask('build:joomla:css:dev', ['bower_concat:common_css', 'sass:common', 'sass:joomla', 'less:bootstrap', 'concat:joomla_devcss'])
  grunt.registerTask('build:joomla:js:dev', ['bower_concat:common_js', 'eslint', 'concat:joomla_devjs'])
  grunt.registerTask('build:joomla:dev', ['build:joomla:css:dev', 'build:joomla:js:dev', 'copy:fonts', 'symlink:joomla', 'template:joomla'])

  grunt.registerTask('build:wp:css:dev', ['bower_concat:common_css', 'sass:common', 'sass:wordpress', 'less:bootstrap', 'concat:wordpress_devcss'])
  grunt.registerTask('build:wp:js:dev', ['bower_concat:common_js', 'eslint', 'concat:wordpress_devjs'])
  grunt.registerTask('build:wp:dev', ['build:wp:css:dev', 'build:wp:js:dev', 'copy:fonts', 'symlink:wordpress', 'template:wordpress'])

  grunt.registerTask('build:joomla:css:prod', ['bower_concat:common_css', 'sass:common', 'sass:joomla', 'less:bootstrap', 'cssmin:joomla'])
  grunt.registerTask('build:joomla:js:prod', ['bower_concat:common_js', 'eslint', 'uglify:joomla'])
  grunt.registerTask('build:joomla:prod', ['build:joomla:css:prod', 'build:joomla:js:prod', 'copy:fonts', 'template:joomla', 'po2mo'])

  grunt.registerTask('build:wp:css:prod', ['bower_concat:common_css', 'sass:common', 'sass:wordpress', 'less:bootstrap', 'cssmin:wordpress'])
  grunt.registerTask('build:wp:js:prod', ['bower_concat:common_js', 'eslint', 'uglify:wordpress'])
  grunt.registerTask('build:wp:prod', ['build:wp:css:prod', 'build:wp:js:prod', 'copy:fonts', 'template:wordpress', 'po2mo'])

  grunt.registerTask('pack:joomla', ['compress:joomla_mod_chatbro', 'compress:joomla_com_chatbro', 'compress:joomla_lib_chatbro', 'compress:joomla_plg_chatbro', 'compress:joomla_pkg_chatbro'])
  grunt.registerTask('package:joomla', ['build:joomla:prod', 'template:common', 'template:joomla', 'pack:joomla'])

  grunt.registerTask('package:wordpress', ['clean:wp', 'build:wp:prod', 'template:common', 'template:wordpress', 'po2mo', 'copy:wp_build', 'svn_fetch:wp', 'sync:wp'])
}
