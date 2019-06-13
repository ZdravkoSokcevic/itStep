<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <form action="/request/insert" method="post">
        <input type="text" name="type" value="refund" id="" hidden>
        <br>
        Treca osoba:
        <input type="text" name="thirdPerson" value="3">
        <br>
        Id radnika:
        <input type="text" name="worker_id" value="4">
        <br>
        Description:
        <input type="text" name="description" id="">
        <br>
        Attachment:
        <input type="file" name="attachment" id="">
        <br>
        Razlog:
        <input type="text" name="reason" id="">
        <br>
        Kolicina:
        <input type="text" name="quantity">
        <br>
        <input type="submit" name="submit" id="" value="Potvrdi">
    </form>
</body>
</html>