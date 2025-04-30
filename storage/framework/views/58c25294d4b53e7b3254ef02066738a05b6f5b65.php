

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1><?php echo e($task->name); ?></h1>
    <p><?php echo e($task->description); ?></p>

    <a href="<?php echo e(url('/task')); ?>">Back To Task</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ASUS\smt4\resources\views/task/show.blade.php ENDPATH**/ ?>