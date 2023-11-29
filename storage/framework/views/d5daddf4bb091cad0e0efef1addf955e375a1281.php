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
            

            <?php if(auth()->user()->role === 'ADMINISTRATOR'): ?>
                <b-navbar-item href="/dashboard">
                    Home
                </b-navbar-item>
                <b-navbar-dropdown label="Setting">
                    <b-navbar-item href="academic-years">
                        Academic Years
                    </b-navbar-item>
                    <b-navbar-item href="/questions">
                        Questions
                    </b-navbar-item>
                    <b-navbar-item href="/departments">
                        Departments
                    </b-navbar-item>
                    <b-navbar-item href="/event-types">
                        Event Types
                    </b-navbar-item>
                    <b-navbar-item href="/event-venues">
                        Event Venues
                    </b-navbar-item>
                </b-navbar-dropdown>
            
            
                <b-navbar-dropdown label="Events">
                    <b-navbar-item href="/events">
                        Events
                    </b-navbar-item>
                    <b-navbar-item href="/event-attendances">
                        Event Attendances
                    </b-navbar-item>
                </b-navbar-dropdown>

                
                <b-navbar-dropdown label="Evaluation">
                    <b-navbar-item href="/evaluations">
                        Evaluations
                    </b-navbar-item>
                    <b-navbar-item href="/student-evaluated">
                        Participant Evaluated
                    </b-navbar-item>
                </b-navbar-dropdown>
               

                <b-navbar-dropdown label="Report">
                    <b-navbar-item href="/report-event-list">
                        Report Event List
                    </b-navbar-item>
                </b-navbar-dropdown>


                <b-navbar-item href="/users">
                    User
                </b-navbar-item>



            <?php else: ?>
                <b-navbar-item href="/dashboard">
                        Home
                </b-navbar-item>

                <b-navbar-dropdown label="Events">
                    <b-navbar-item href="/events">
                        Events
                    </b-navbar-item>
                    <b-navbar-item href="/event-attendances">
                        Event Attendances
                    </b-navbar-item>
                </b-navbar-dropdown>

                
                <b-navbar-dropdown label="Evaluation">
                    <b-navbar-item href="/evaluations">
                        Evaluations
                    </b-navbar-item>
                    <b-navbar-item href="/student-evaluated">
                        Participant Evaluated
                    </b-navbar-item>
                </b-navbar-dropdown>
             
            <?php endif; ?>
           
        </template>

        <template #end>
            <b-navbar-item href="#">
                <?php echo e(strtoupper(Auth::user()->fname)); ?>

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