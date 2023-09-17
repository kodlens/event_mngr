<?php $__env->startSection('content'); ?>

    <?php if($id > 0): ?>
        <question-create :prop-id="<?php echo e($id); ?>"
            :prop-data='<?php echo json_encode($data, 15, 512) ?>'></question-create>
    <?php else: ?>
        <question-create :prop-id="0"
            :prop-data='{}'></question-create>
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\event_mngr\resources\views/administrator/question/question-create.blade.php ENDPATH**/ ?>