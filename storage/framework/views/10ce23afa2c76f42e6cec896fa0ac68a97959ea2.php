

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Task List</h1>

        <a href="<?php echo e(route('task.create')); ?>" class="btn btn-primary">Tambah Task</a>

        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="task-item">
                <strong>Name: <?php echo e($task->name); ?></strong>
                <p>Description: <?php echo e($task->description); ?></p>
                
                <a href="<?php echo e(route('task.show', $task->id)); ?>" class="view-link">View</a>
                <a href="<?php echo e(route('task.edit', $task->id)); ?>" class="edit-link">Edit</a>

                <form action="<?php echo e(route('task.delete', $task->id)); ?>" method="POST" class="delete-form">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" onclick="return confirm('Yakin ingin menghapus task ini?')">Delete</button>
</form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Tidak ada task yang tersedia.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ASUS\smt4\resources\views/task/index.blade.php ENDPATH**/ ?>