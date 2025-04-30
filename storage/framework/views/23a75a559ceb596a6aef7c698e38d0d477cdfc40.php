

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Edit Tasks</h1>
    <form method="POST" action="<?php echo e(url("/task/{$task->id}")); ?>">
        <?php echo method_field("PUT"); ?>
        <?php echo csrf_field(); ?> <!-- Cross-site request forgery -->

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name', $task->name)); ?>">
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"><?php echo e(old('description', $task->description)); ?></textarea>
        <br>

        <button type="submit">Edit Task</button>
    </form>

    <a href="<?php echo e(url('/task')); ?>">Back To Task</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ASUS\smt4\resources\views/task/edit.blade.php ENDPATH**/ ?>