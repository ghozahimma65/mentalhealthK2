<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <title>Task App</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="<?php echo e(url('/task')); ?>">Home</a></li>
            <li><a href="<?php echo e(url('/task/create')); ?>">Create Task</a></li>
        </ul>
    </nav>
</header>

    <main>
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo e(date('Y')); ?> Task App</p>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\ASUS\smt4\resources\views/layouts/app.blade.php ENDPATH**/ ?>