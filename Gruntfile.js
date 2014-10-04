module.exports = function (grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		bower: {
			install: {
				options: {
					targetDir: './www/assets',
					layout: 'byComponent',
					verbose: 'true',
					install: true,
					bowerOptions: {
						forceLatest: true,
						production: false
					}
				}
			}
		},
		//nette_tester: {
		//	options: {
		//		bin: 'vendor/bin/tester',
		//		jobs: 30,
		//		quiet: false,
		//		skipped: true
		//	},
		//	src: ['vendor/nette/tester/tests']
		//},
		//netteBasePath: {
		//	basePath: 'www',
		//	options: {
		//		removeFromPath: ['app/templates/']
		//	}
		//},
		//uglify: {
		//	options: {
		//		banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
		//	},
		//	build: {
		//		src: 'src/<%= pkg.name %>.js',
		//		dest: 'build/<%= pkg.name %>.min.js'
		//	}
		//},
		notify: {
			//task_name: {
			//	options: {
			//		// Task-specific options go here.
			//	}
			//},
			//watch: {
			//	options: {
			//		title: 'Task Complete',  // optional
			//		message: 'SASS and Uglify finished running', //required
			//	}
			//},
			default: {
				options: {
					message: 'Grunt job for <%= pkg.name %> finished!'
				}
			},
			bower: {
				options: {
					message: 'Bower installed all packages for <%= pkg.name %>'
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-bower-task');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-nette-tester');
	grunt.loadNpmTasks('grunt-nette-basepath');
	grunt.loadNpmTasks('grunt-notify');

	grunt.registerTask('default', ['notify:default']);
	grunt.registerTask('bowerInstall', ['bower', 'notify:bower']);

};