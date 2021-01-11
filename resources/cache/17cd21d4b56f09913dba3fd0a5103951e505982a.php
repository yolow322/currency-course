<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div class="container" style="width:1000px;">
        <h2 align="center">Курсы валют</h2>
        <h3 align="center">Список валют по календарю</h3>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <input type="text" name="date" id="date" class="form-control" placeholder="Введите дату">
            </div>
            <div class="p-2">
                <button id="find" class="btn btn-info">Найти</button>
            </div>
            <div class="p-2">
                <button id="refresh" class="btn btn-info">Обновить курсы на выбранный в календаре день
                </button>
            </div>
        </div>
        <div class="text-center" id="submission-status"></div>
        <div style="clear:both"></div>
        <div id="currency_table">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th width="15%">Дата</th>
                    <th width="15%">Дата курса</th>
                    <th width="10%">Идентификатор валюты</th>
                    <th width="30%">Название</th>
                    <th width="28%">Курс</th>
                    <th width="12%">Номинал</th>
                    <th width="12%">Код</th>
                </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
        <h3 align="center">График курса валют</h3><br/>
        <div class="row justify-content-center">
            <div class="col-4 col-sm-4">
                <input type="text" name="date" id="date_from" class="form-control" placeholder="Введите начальную дату">
            </div>
            <div class="col-4 col-sm-4">
                <input type="text" name="date" id="date_to" class="form-control" placeholder="Введите конечную дату">
            </div>
            <div class="col-4 col-sm-4">
                <select class="form-control" id="currency_code">
                    <?php $__currentLoopData = $charCodeAndNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-4 col-sm-3 mt-5 ml-5">
                <button id="create_chart" class="btn btn-info">Построить график</button>
            </div>
            <div>
                <div id="chart_div" style="width: 1300px; height: 500px;"></div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/public/js/main.js"></script>
</html>
<?php /**PATH D:\server\Apache24\htdocs\resources\views/home.blade.php ENDPATH**/ ?>