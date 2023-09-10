<?php $__env->startSection('content'); ?>

    <?php if($id > 0): ?>
        <event-page-create-edit :prop-id="<?php echo e($id); ?>"
                                :prop-data='<?php echo json_encode($data, 15, 512) ?>'></event-page-create-edit>
    <?php else: ?>
        <event-page-create-edit :prop-id="0"
                                :prop-data='{}'></event-page-create-edit>
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\event_mngr\resources\views/administrator/event/event-page-create-edit.blade.php ENDPATH**/ ?>