<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Voters</title>
</head>
<body>
    <h1>Daftar Pemilih</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th> <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $voters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $voter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td> <td><?php echo e($voter->name); ?></td>
                    <td><?php echo e($voter->email); ?></td>
                    <td><?php echo e($voter->address); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>
</html><?php /**PATH C:\Users\ASUS\smt4\resources\views/voters.blade.php ENDPATH**/ ?>