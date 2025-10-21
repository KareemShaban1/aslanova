let mix = require('laravel-mix');
require('laravel-vue-i18n/mix');

mix.i18n()
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/router/index.js', 'public/js')
    .js('resources/js/driver.js', 'public/js')
    .js('resources/js/router/driver.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css') // تأكد من أنك تستخدم sass إذا كنت تستخدم sass-loader
    .postCss('resources/css/app.css', 'public/css')
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)$/, // أضف هنا تنسيقات الصوت والفيديو التي تريد دعمها
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[name].[ext]',
                                outputPath: 'videos/', // يمكنك تغيير هذا حسب مكان حفظ الفيديو
                                publicPath: 'videos/' // المسار العام للفيديو
                            }
                        }
                    ]
                }
            ]
        }
    });
