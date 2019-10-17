module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        browserify: {
            forBucketJS: {
                src: [],
                dest: 'public/js/buckets-js-browserified.js',
                options: {
                    require: ['buckets-js']
                }
            }
        },
        concat: {
            'public/js/mr-potato-head-public.js': ['public/js/buckets-js-browserified.js', 'public/js/mph-main.js']
        },
        sass: {
            dist: {
                options: {                       // Target options
                    /* loadPath: '../pad/sass/' */
                },
                files: {
                    'public/css/mr-potato-head-public.css': 'sass/mr-potato-head.scss'
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass']
            },
            js: {
                files: 'public/js/mph-main.js',
                tasks: ['browserify', 'concat']
            }
        },
        copy: {
            vendor: {
                files: []
            }


        }
    });
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.registerTask('default', ['watch']);
}