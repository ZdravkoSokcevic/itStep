<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>arrival</title>
</head>
<body>
    <form action="/worker/arrival" method="post">
        <select name="worker_id" id="">
            <?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($worker->id); ?>"><?php echo e($worker->first_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <br>
        Datum dolaska: 
        <input type="datetime-local" name="arrival">
        <br>
        Pocetak rada:
        <input type="datetime-local" name="start_work">
        <br>
        Kraj rada:
        <input type="datetime-local" name="end_work">
        <br>
        Odlazak:
        <input type="datetime-local" name="leave">
        <br>
        Opis:
        <input type="text" name="description">
        <br>
        <input type="submit" value="Potvrdi">
        
    </form>
</body>
</html><?php /**PATH /home/zdravko/Documents/it_step/resources/views/arrival.blade.php ENDPATH**/ ?>