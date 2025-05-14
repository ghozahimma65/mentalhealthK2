

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Create New Task</h1>

    <form method="POST" action="<?php echo e(route('task.store')); ?>">
        <?php echo csrf_field(); ?> <!-- Cross-Site Request Forgery protection -->

        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <br>

        <button type="submit">Create Task</button>
    </form>

    <a href="<?php echo e(url('/task')); ?>">Back To Task</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ASUS\smt4\resources\views/task/create.blade.php ENDPATH**/ ?>