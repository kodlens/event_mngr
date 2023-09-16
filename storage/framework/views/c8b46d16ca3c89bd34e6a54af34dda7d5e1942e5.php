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

    <style>
        html body{
            font-family: 'Roboto Slab', serif;
            font-family: 'Ubuntu', sans-serif;
        }
    </style>

</head>
<body>
    <div id="app">

    <b-navbar>
        <template #brand>
            <b-navbar-item>
                <img
                    src="/img/logo.png"
                    alt="emapp logo"
                >
            </b-navbar-item>
        </template>
        <template #start>
           
          
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
            <b-navbar-item href="/event-feeds">
                HOME
            </b-navbar-item>

            <b-navbar-item href="/profile">
                <?php echo e(auth()->user()->fname); ?>

            </b-navbar-item>

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

    <form action="/logout" id="logout" method="post">
        <?php echo csrf_field(); ?>
    </form>
       


    <div>
        <?php echo $__env->yieldContent('content'); ?>
    </div>


    </div>
</body>
</html>
<?php /**PATH C:\Users\eshen\Desktop\Github\event_mngr\resources\views/layouts/user-layout.blade.php ENDPATH**/ ?>