<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard()->check()): ?>
        <event-page :prop-user='<?php echo e(Auth::user()); ?>'></event-page>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\event_mngr\resources\views/administrator/event/event-page.blade.php ENDPATH**/ ?>