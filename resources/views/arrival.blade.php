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
        <select name="worker_id">
            @foreach ($workers as $worker)
                <option value="{{$worker->id}}">{{$worker->first_name}}</option>
            @endforeach
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
</html>