'use strict';

module.exports = function (grunt) {

	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	require('time-grunt')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		nette: {
			temp: 'temp',
			basePath: 'www'
		},
		bower: {
			install: {
				options: {
					//bowerDir: 'www/bower_components',
					targetDir: 'www/assets',
					layout: 'byType',
					verbose: true,
					install: true,
					copy: false,
					cleanTargetDir: true,
					cleanBowerDir: false,
					bowerOptions: {
						forceLatest: true,
						production: false
					}
				}
			}
		},
		wiredep: {
			target: {
				src: ['app/templates/**/*.latte'],
				cwd: '.',
				//bowerJson: '../bower.json',
				//directory: 'bower_components',
				dependencies: true,
				devDependencies: false,
				exclude: [],
				fileTypes: {},
				ignorePath: '',
				overrides: {}
			}
		},
		replace: {
			server: {
				options: {
					patterns: [
						{
							match: /(\.\.\/)*www\//g,
							replacement: '{$basePath}/'
						}
					]
				},
				files: [
					{
						expand: true,
						flatten: true,
						src: ['app/templates/@layout.latte'],
						dest: 'app/templates/'
					}
				]
			}
		},
		useminPrepare: {
			html: ['app/templates/@layout.latte'],
			options: {
				dest: '.',
				staging: '<%= nette.temp %>'
			}
		},
		usemin: {
			html: ['<%= nette.basePath %>/{,*/}*.html'],
			css: ['<%= nette.basePath %>/css/{,*/}*.css'],
			options: {
				dirs: ['<%= nette.basePath %>']
			}
		},
		netteBasePath: {
			basePath: '<%= nette.basePath %>',
			options: {
				removeFromPath: ['app/templates/', '../../www/']
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> v<%= pkg.version %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			}
		},
		nette_tester: {
			options: {
				bin: 'vendor/bin/tester',
				jobs: 30,
				quiet: false,
				skipped: true
			},
			src: ['vendor/nette/tester/tests']
		},
		copy: {
			server: {
				files: [{
					expand: true,
					dot: true,
					cwd: '<%= nette.basePath %>/bower_components/bootstrap/dist',
					src: ['fonts/{,*/}*.*'],
					dest: '<%= nette.basePath %>'
				}]
			}
		},
		bump: {
			options: {
				files: ['package.json', 'bower.json', 'app/config/config.neon'],
				updateConfigs: ['pkg'],
				commit: true,
				commitMessage: 'chore: Release v%VERSION%',
				commitFiles: ['package.json', 'bower.json', 'app/config/config.neon', 'CHANGELOG.md'],
				createTag: true,
				tagName: 'v%VERSION%',
				tagMessage: 'Version %VERSION%',
				push: false,
				pushTo: 'origin',
				gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d',
				globalReplace: false
			}
		},
		changelog: {
			options: {
				//editor: 'sublime -w'
			}
		},
		notify: {
			default: {
				options: {
					message: 'Build finished!'
				}
			},
			bump: {
				options: {
					message: 'Released v<%= pkg.version %>!'
				}
			}
		}
	});

	grunt.registerTask('default', [
		'bower',
		'wiredep',
		'replace:server',
		'useminPrepare',
		//'usemin',
		'netteBasePath',
		'concat:generated',
		'uglify:generated',
		'cssmin:generated',
		'copy:server',
		'notify:default'
	]);

	grunt.registerTask('release', [
		'bump-only',
		'changelog',
		'bump-commit'
	]);

	grunt.registerTask('show-paths', [
		'useminPrepare',
		'usemin',
		'netteBasePath'
	]);

};
