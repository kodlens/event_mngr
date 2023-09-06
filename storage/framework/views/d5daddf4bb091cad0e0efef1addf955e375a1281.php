<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->



    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">


    



</head>
<body>
    <div id="app">

    <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img
                        src=""
                        alt=""
                    >
                </b-navbar-item>
            </template>
            <template #start>
                <b-navbar-item href="/dashboard">
                    Home
                </b-navbar-item>
                <b-navbar-item href="/events">
                    Events
                </b-navbar-item>
                <b-navbar-item href="/users">
                    User
                </b-navbar-item>
                <!-- <b-navbar-dropdown label="Info">
                    <b-navbar-item href="#">
                        About
                    </b-navbar-item>
                    <b-navbar-item href="#">
                        Contact
                    </b-navbar-item>
                </b-navbar-dropdown> -->
            </template>

            <template #end>
                <b-navbar-item tag="div">
                    <div class="buttons">
                        <b-button
                            onclick="document.getElementById('logout').submit()"
                            icon-left="logout"
                            class="button is-danger" outlined>
                        </b-button>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>

        <form action="/logout" method="post" id="logout">
            <?php echo csrf_field(); ?>
        </form>

    <div>
        <?php echo $__env->yieldContent('content'); ?>
    </div>


    </div>
</body>
</html>
<?php /**PATH C:\Users\eshen\Desktop\Github\event_mngr\resources\views/layouts/admin-layout.blade.php ENDPATH**/ ?>